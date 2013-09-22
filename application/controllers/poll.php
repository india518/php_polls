<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller {

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
		    $total_votes = $this->Poll_model->total_votes($data['options'][$poll->id]);

		    foreach($data['options'][$poll->id] as $option)
		    {
		    	if ($option->votes == 0)
		    	{
		    		$option->percentage = 0;
		    	}
		    	else
		    	{
					$option->percentage = 100 * ($option->votes / $total_votes);
		    	}
		    }
		}

		//NOTE: Question for John. I am assuming that only the controller should
		// make calls to functions in the model, and all data should be set before
		// loading the view page. Is that true, or can I call functions in the
		// model directly from the view?

		$this->load->view('polls_all', $data);
	}

	public function add()
	{
		$this->load->view('add_poll');
	}

	public function process_poll_form()
	{	// the data from our form is in $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('options[0]', 'first Option', 'required');

		if($this->form_validation->run() === FALSE)
		{
			//$this->session->set_userdata('error_messages', $error_messages);
			$this->session->set_flashdata('error_messages', validation_errors());
			redirect(base_url('poll/add'));
		}
		else
		{	//add poll to database
			$this->load->model('Poll_model');
			$poll = $this->input->post();
			$poll_is_created = $this->Poll_model->create_poll($poll);
			
			if ($poll_is_created)
			{
				redirect(base_url());
			}
			else
			{
				$this->session->set_flashdata('error_messages', "There was a problem adding your poll to the database.");
				redirect(base_url('poll/add'));
			}
		}
	}

	public function process_vote()
    {
    	$this->load->model('Poll_model');
        $option = $this->Poll_model->get_option($_POST['option_id']);
        $option->votes = ($option->votes) + 1; //update the vote count
        $update_vote_count = $this->Poll_model->update_option($option);

        if ($update_vote_count)
		{
			redirect(base_url());
		}
		else
		{
			$this->session->set_flashdata('error_messages', "There was a problem adding your vote to the poll.");
			redirect(base_url());
		}
    }
}

// end of file