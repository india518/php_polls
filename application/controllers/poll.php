<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        //loading helper file for our Results table:
		$this->load->helper('custom_html');
		//This cannot be used with Ajax, but if we disable Ajax it will
		// give us information about speeding up our queries:
		//$this->output->enable_profiler(TRUE);
    }

	public function index()
	{
		$this->load->model('Poll_model');
		$data['polls'] = $this->Poll_model->get_all_polls();

		$option = Array();

		foreach($data['polls'] as $poll)
		{
			$data['options'][$poll['id']] = $this->Poll_model->get_poll_options($poll['id']);

			//
			//this is for the percentage of votes for each option:
			//
			$total_votes = $this->Poll_model->get_total_votes($poll['id']);

			//NOTE: This is important and will be easy to overlook!
			// the foreach loop actually works on a copy of the array, so 
			// modifying it by adding an additional key/value pair will not
			// work, UNLESS we precede the 'value' designation with an '&'
			// The '&' indicates the value will be assigned by reference.
			//
			// Sources:
			//http://fr2.php.net/manual/en/control-structures.foreach.php
			//http://fr2.php.net/manual/en/language.references.php
			foreach($data['options'][$poll['id']] as &$option)
			{
				$option['percentage'] = $this->Poll_model->calculate_percentage($option, $total_votes);
			}
		}

		$this->load->view('polls_index', $data);
	}

	public function process_poll_form()
	{	// the data from our form is in $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('options[0]', 'first Option', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('error_messages', validation_errors());
			redirect(base_url());
		}
		else 	//add poll to database
		{
			$this->load->model('Poll_model');

			//We need to separate things out because the input key 'options'
			// is not part of the poll database table:
			$poll['title'] = $this->input->post('title');
			$poll['description'] = $this->input->post('description');
			$poll['id'] = $this->Poll_model->create_poll($poll, $this->input->post('options'));

			//The create_poll function will return the poll's assigned id
			// If this gets assigned as a number, it will be 'true'
			if ($poll['id'])
			{
				//because $this->input->post('options') is an array of STRINGS,
				// we need to query the database again to get the options as arrays
				$options = $this->Poll_model->get_poll_options($poll['id']);
				foreach($options as &$option)
				{
					$option['percentage'] = 0;
				}

				$data = Array();
				$data['html'] = print_poll_display($poll, $options);
				echo json_encode($data);
			}
			else
			{
				$this->session->set_flashdata('error_messages', "There was a problem adding your poll to the database.");
				redirect(base_url());
			}
		}
	}

	public function process_vote()
	{
		$this->load->model('Poll_model');

		//update the option for which the vote was cast:
		$voted_option = $this->Poll_model->get_option($this->input->post('option_id'));
		$voted_option['votes'] += 1;
		$option_updated = $this->Poll_model->update_option($voted_option);

		//not that it's updated, get all options and total vote count
		$options = $this->Poll_model->get_poll_options($this->input->post('poll_id'));
		$total_votes = $this->Poll_model->get_total_votes($this->input->post('poll_id'));
		foreach($options as &$option)
		{
			$option['percentage'] = $this->Poll_model->calculate_percentage($option, $total_votes);
		}

		//Now generate the options result table and send back
		$data = Array();
		$data['html'] = print_results_table($options);
		echo json_encode($data);
	}
	
}

// end of file