<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller {

	public function index()
	{
		$this->load->model('Poll_model');
		$data['polls'] = $this->Poll_model->get_all_polls();

		// I want to go through every poll in the $data['polls'] array,
		// fetch their associated options, and store them. Why can't I 
		// seem to do that?

		//NOTE: use foreach - (Never use for loop!)
		$option = Array();

		foreach($data['polls'] as $poll)
		{
		    $data['options'][$poll->id] = $this->Poll_model->get_poll_options($poll->id);
		}

		// for ($i=0; $i < count($data['polls']); $i++)
		// {
		// 	$data['polls'][$i]['options'] = $this->Poll_model->get_poll_options($data['polls'][$i]);
		// }

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
			$this->load->model('Poll_model','',TRUE);
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
        echo "This is the process_vote function!";
    }
}

// end of file