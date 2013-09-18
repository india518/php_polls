<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends CI_Controller {

	public function index()
	{
		echo "Hello, this is the Poll controller index function";

		$this->load->model('Poll_model','',TRUE);
		$data["polls"] = $this->Poll_model->get_all_polls();

		// echo "<pre>";
		// var_dump($data);
		// echo "</pre>";
		// die();

		$this->load->view('polls_all', $data);
	}
}

// end of file