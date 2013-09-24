<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        //loading helper file for our Results table:
		$this->load->helper('custom_html');
    }

	public function index()
	{
		$this->load->model('Poll_model');
		$data['polls'] = $this->Poll_model->get_all_polls();

		$option = Array();

		foreach($data['polls'] as $poll)
		{
			$data['options'][$poll->id] = $this->Poll_model->get_poll_options($poll->id);

			//
			//this is for the percentage of votes for each option:
			//
			$total_votes = $this->total_votes($data['options'][$poll->id]);

			foreach($data['options'][$poll->id] as $option)
			{
				$option->percentage = $this->get_option_percentage($option, $total_votes);
			}
		}

		//NOTE: Question for John. I am assuming that only the controller should
		// make calls to functions in the model, and all data should be set before
		// loading the view page. Is that true, or can I call functions in the
		// model directly from the view?

		$this->load->view('polls_index', $data);
	}

	// public function add()
	// {
	// 	$this->load->view('add_poll');
	// }

	public function process_poll_form()
	{	// the data from our form is in $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('options[0]', 'first Option', 'required');

		if($this->form_validation->run() === FALSE)
		{
			//$this->session->set_userdata('error_messages', $error_messages);
			$this->session->set_flashdata('error_messages', validation_errors());
			//redirect(base_url('poll/add'));
			redirect(base_url());
		}
		else
		{	//add poll to database
			$this->load->model('Poll_model');

			//We need to separate things out because the input key 'options'
			// is not part of the poll table:
			$poll['title'] = $this->input->post('title');
			$poll['description'] = $this->input->post('description');
			$poll['id'] = $this->Poll_model->create_poll($poll, $this->input->post('options'));
			//The create_poll function will return the poll's assigned id
			// If this gets assigned as a number, it will be 'true'
			
			if ($poll['id'])
			{
				//because $this->input->post('options') is an array of STRINGS,
				// we need to query the database again to get the options as arrays
				// with an 'id':
				$options = $this->Poll_model->get_poll_options($poll['id']);
				foreach($options as $option)
				{
					$option->percentage = 0; //We're creating the options, so no votes at all yet!
				}
				// echo "<pre>";
				// var_dump($poll);
				// echo "<br />";
				// var_dump($options);
				// echo "</pre>";
				// die();

				//send the poll/options back to the page
				$data = Array();
				$data['html'] = print_poll_display($poll, $options);
				echo json_encode($data);
			}
			else
			{
				$this->session->set_flashdata('error_messages', "There was a problem adding your poll to the database.");
				//redirect(base_url('poll/add'));
				redirect(base_url());
			}
		}
	}

	public function process_vote()
	{
		//Remember that our form data is in $this->input->post()!
		$this->load->model('Poll_model');

		$options = $this->Poll_model->get_poll_options($this->input->post('poll_id'));

		$voted_id = $this->input->post('option_id');
		// We need to get the key that points to the option we voted for
		// This way, we can update that option in the database, and also
		// update our options array for redisplaying to the webpage
		$voted_option_key = $this->get_key_for_voted_option($options, $voted_id);
		$voted_option = $options[$voted_option_key];

		//There must be a way to find our option in the options array!
		// Something like this?
		// $id = $this->input->post('id')
		// $key = array_search($id, $options)
		// $voted_option = $options[$key];

		$voted_option->votes = ($voted_option->votes) + 1; //update the vote count
		$update_vote_action = $this->Poll_model->update_option($voted_option);

		if ($update_vote_action)
		{
			//First, update $options array
			$options[$voted_option_key] = $voted_option;
			//Next, get total votes
			$total_votes = $this->total_votes($options);
			//Next, add percentages to each option
			foreach($options as $option)
			{
				$option->percentage = $this->get_option_percentage($option, $total_votes);
			}
			//Now put the options in a table and send back to the page
			$data = Array();
			$data['html'] = print_results_table($options);
			echo json_encode($data);
		}
		else
		{
			//Note that if this fails, it's no longer AJAX: we reload the page to display 
			// an error
			$this->session->set_flashdata('error_messages', "There was a problem adding your vote to the poll.");
			redirect(base_url());
		}
	}

	//NOTE: question for John: Should these functions be in the model, or is it OK 
	// for them to be in the controller?
	// I am assuming it is ok in the controller, since it does not interact with the
	// the database or manipulate the model in any way
	function total_votes($options)
	{
		$total_votes = 0;

		foreach ($options as $option)
		{
			$total_votes += $option->votes;
		}

		return $total_votes;
	}

	function get_option_percentage($option, $total_votes)
	{
		if ($option->votes == NULL)
			return 0;
		else
			return 100 * ($option->votes / $total_votes);
	}

	function get_key_for_voted_option($options, $id)
	{
		foreach($options as $key=>$option)
		{
			if ($option->id == $id)
				return $key;
		}

		return FALSE; 	//shouldn't happen, since the option itself is used to 
						// find the options fetched from the database, right?
	}
}

// end of file