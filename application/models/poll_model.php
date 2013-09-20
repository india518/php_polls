<?php

class Poll_model extends CI_model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all_polls()
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('polls');
        //var_dump($query);
        return $query->result();
    }

    //NOTE: We only really need the poll id!
    function get_poll_options($id)
    {
    	return $this->db->where('poll_id', $id)->get('options')->result();
    }

    function create_poll($poll)
    {
    	//NOTE: $config['global_xss_filtering'] = TRUE;
        $new_poll['title'] = $_POST['title'];
        $new_poll['description'] = $_POST['description'];
        //this is a way to get the datetime into SQL:
        $this->db->set('created_at', 'NOW()', FALSE);
        $status = $this->db->insert('polls', $new_poll);
        $poll_id = $this->db->insert_id();

        if ($status)
        {
        	$options_status = $this->create_poll_options($_POST['options'], $poll_id);
        }
        return ($status && $options_status);
    }

    function create_poll_options($options, $poll_id)
    {
    	$status = Array();

    	foreach($options as $option)
        {
        	if ((isset($option)) && (!empty($option)))
        	{
        		$status[$option] = $this->create_option($option, $poll_id);
        	}
        }

        if (in_array(FALSE, $status))
        {
        	return FALSE;
        }
        else
        {
        	return TRUE;
        }
    }

    function create_option($name, $poll_id)
    {
    	$new_option['poll_id'] = $poll_id;
    	$new_option['name'] = $name;
    	$new_option['votes'] = 0; //since we are creating, not updating
    	$this->db->set('created_at', 'NOW()', FALSE);
    	return $this->db->insert('options', $new_option);
    }

}

//end of file