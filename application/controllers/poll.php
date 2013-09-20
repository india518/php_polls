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
		}
		// echo "<pre>";
		// var_dump($data);
		// echo "</pre>";
		// die();

		$this->load->view('polls_all', $data);
	}

	public function add()
	{
		$this->load->view('add_poll');
	}

	public function process_poll_form()
	{
		// echo "<pre>";
		// var_dump($_POST);
		// echo "</pre>";
		// the data from our form is in $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('option1', 'At least one option', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$error_messages["new_poll"] = validation_errors();
			$this->session->set_userdata('error_messages', $error_messages);
			redirect(base_url('poll/add'));
		}
		else
		{	//add poll to database
			$this->load->model('Poll_model');
			$poll = $this->input->post();
			$status = $this->Poll_model->create_poll($poll);
			
			if ($status)
			{
				redirect(base_url());
			}
			else
			{
				$error_messages["new_poll"] = "There was a problem adding your poll to the database.";
				$this->session->set_userdata('error_messages', $error_messages);
				redirect(base_url('poll/add'));
			}
		}
	}

	public function process_vote()
    {
    	echo "<pre>";
		var_dump($_POST);
		echo "</pre>";
        echo "This is the process_vote function!";
        echo "The poll id is: {$_POST['poll_id']}";
        echo "The vote was for {$_POST[vote]}";
    }
}

// end of file