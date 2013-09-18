<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller {

	public function index()
	{
		$this->load->model('Poll_model','',TRUE);
		$data["polls"] = $this->Poll_model->get_all_polls();

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
		echo "you made it to process_poll_form!";
	}
}

// end of file