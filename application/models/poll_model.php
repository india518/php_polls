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

    function create_poll($poll)
    {
    	//NOTE: $config['global_xss_filtering'] = TRUE;
        $this->title		= $_POST['title'];
        $this->description	= $_POST['description'];
        $this->option1		= $_POST['option1'];
        $this->option2		= $_POST['option2'];
        $this->option3		= $_POST['option3'];
        $this->option4		= $_POST['option4'];
        //this is a way to get the datetime into SQL:
        $this->db->set('created_at', 'NOW()', FALSE);

        return $this->db->insert('polls', $this);
    }

    function process_vote()
    {
        echo "This is the process_vote function!";
    }

}

//end of file