<?php

class Poll_model extends CI_model {

	function __construct()
    {
        parent::__construct();
    }

    function get_all_polls()
    {
        return $this->db->order_by('id', 'desc')->get('polls')->result();
    }

    // function get_poll($id)
    // {
    //     return $this->db->where('id', $id)->get('polls')->row();
    // }

    function get_poll_options($id)
    {
    	return $this->db->where('poll_id', $id)->get('options')->result();
    }

    function create_poll($poll, $options)
    {
    	//NOTE: $config['global_xss_filtering'] = TRUE;
        $poll['created_at'] = date("Y-m-d H:i:s");
        $add_poll = $this->db->insert('polls', $poll);
        $poll_id = $this->db->insert_id();

        if ($add_poll)
        {
        	$add_options = $this->create_poll_options($options, $poll_id);
            if ($add_options)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    function create_poll_options($options, $poll_id)
    {
    	$status = Array();

    	foreach($options as $option)
        {
        	if ((isset($option)) && (!empty($option)))
        		$status[$option] = $this->create_option($option, $poll_id);
        }

        if (in_array(FALSE, $status))
        	return FALSE;
        else
        	return TRUE;
    }

    function create_option($name, $poll_id)
    {
    	$new_option['poll_id'] = $poll_id;
    	$new_option['name'] = $name;
        //NOTE: leaving 'votes' blank will save space in the database, so we do not set it
        $new_option['created_at'] = date("Y-m-d H:i:s"); //alternate way to set date
        return $this->db->insert('options', $new_option);
        //return $this->db->set('created_at', 'NOW()', FALSE)->insert('options', $new_option);
    }

    //Voting functions!
    function get_option($id)
    {
    	//return $this->db->where('id', $id)->get('options')->result();
    	return $this->db->where('id', $id)->get('options')->row();
    }

    function update_option($option)
    {
        $option->updated_at = date("Y-m-d H:i:s");
    	return $this->db->where('id', $option->id)->update('options', $option);
    }

    // function total_votes($options)
    // {
    //     $total_votes = 0;

    //     foreach ($options as $option)
    //     {
    //         $total_votes += $option->votes;
    //     }

    //     return $total_votes;
    // }

}

//end of file