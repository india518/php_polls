<?php

class Poll_model extends CI_model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all_polls()
    {
        $query = $this->db->get('polls');
        return $query->result();
    }

    // function create_poll()
    // {
    //     $this->title		= $_POST['title'];
    //     $this->description	= $_POST['description'];
    //     $this->option1		= $_POST['option1'];
    //     $this->option2		= $_POST['option2'];
    //     $this->option3		= $_POST['option3'];
    //     $this->option4		= $_POST['option4'];
    //     $this->created_at	= time();

    //     $this->db->insert('polls', $this);
    // }

    // function update_entry()
    // {
    //     $this->title		= $_POST['title'];
    //     $this->description	= $_POST['description'];
    //     $this->option1		= $_POST['option1'];
    //     $this->option2		= $_POST['option2'];
    //     $this->option3		= $_POST['option3'];
    //     $this->option4		= $_POST['option4'];
    //     $this->updated_at	= time();

    //     $this->db->update('entries', $this, array('id' => $_POST['id']));
    // }

}

//end of file