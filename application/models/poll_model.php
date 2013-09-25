<?php

class Poll_model extends CI_model {

	function __construct()
    {
        parent::__construct();
    }

    function get_all_polls()
    {
        return $this->db->order_by('id', 'desc')->get('polls')->result_array();
    }

    function get_poll_options($poll_id)
    {
    	return $this->db->where('poll_id', $poll_id)->get('options')->result_array();
    }

    function get_option($option_id)
    {
        return $this->db->where('id', $option_id)->get('options')->row_array();
    }

    function get_total_votes($poll_id)
    {
        $total_votes = $this->db->select_sum('votes')->where('poll_id', $poll_id)->get('options')->row_array();
        //this returns an associative array with a key of 'votes' and a value that is a number in a string
        //i.e.: array(1) { ["votes"]=> string(1) "5" }
        return $total_votes["votes"];
    }

    function create_poll($poll, $options)
    {
    	//NOTE: always make sure that you set this in config.php:
        // $config['global_xss_filtering'] = TRUE;
        $poll['created_at'] = date("Y-m-d H:i:s");
        $poll_created = $this->db->insert('polls', $poll);
        //$poll_created is a boolean flag that indicates if our SQL
        // transaction is successful

        $poll_id = $this->db->insert_id();

        if ($poll_created)
        {
        	$options_created = $this->create_poll_options($options, $poll_id);
            if ($options_created)
            {
                return $poll_id;
            }
        }

        return FALSE;
    }

    function create_poll_options($options, $poll_id)
    {
        //loop through each given option submitted with form, and create a
        // corresponding entry in the database
    	foreach($options as $option)
        {
        	if ((isset($option)) && (!empty($option)))
        		$option_created[$option] = $this->create_option($option, $poll_id);
                
        }

        // check the $options_created array: if any option was not stored in the
        // database correctly, then there will be a 'FALSE' in the array.
        if (in_array(FALSE, $option_created))
        	return FALSE;
        else
        	return TRUE;
    }

    function create_option($name, $poll_id)
    {
    	$new_option['poll_id'] = $poll_id;
    	$new_option['name'] = $name;
        //NOTE: leaving 'votes' blank will save space in the database, so we do not set it
        $new_option['created_at'] = date("Y-m-d H:i:s");
        return $this->db->insert('options', $new_option);
    }

    function update_option($option)
    {
        $option['updated_at'] = date("Y-m-d H:i:s");
    	return $this->db->where('id', $option['id'])->update('options', $option);
    }

    //This function is for calculating the percentage of votes that an option has,
    // for a given poll
    function calculate_percentage($option, $total_votes)
    {
        if ($option['votes'] == NULL)
            return 0;
        else
            return 100 * ($option['votes'] / $total_votes);
    }

}

//end of file