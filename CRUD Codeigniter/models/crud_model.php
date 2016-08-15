<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crud_model
 *
 * @author Sani
 */
class Crud_model extends CI_Model 
{
	function __construct() 
	{
		parent::__construct();
	}
       
        
     /////////////////////////////////////////////////////////////////
     //
     //
     //                         GET ALL TABLES OF DATABASE
     //
     //                                                 BY: SANI HYNE
     //                              http://linkedin.com/in/delickate
     ////////////////////////////////////////////////////////////////
        function get_all_databasetables($id = false)
        {
			
			$result = $this->db->query("SHOW TABLES");
			$return = array();
			if($result->num_rows() > 0) 
			{
				foreach($result->result_array() as $row) 
				{
					$return[$row['Tables_in_'.$this->db->database]] = $row['Tables_in_'.$this->db->database];
				}
			}
	
			return $return;
        }
		
     /////////////////////////////////////////////////////////////////
     //
     //
     //                         GET ALL TABLES OF DATABASE
     //
     //                                                 BY: SANI HYNE
     //                              http://linkedin.com/in/delickate
     ////////////////////////////////////////////////////////////////
	 
		function get_all_table_columns($table = false)
        {
			
			$result = $this->db->query("SELECT COLUMN_NAME as allcolumns, COLUMN_KEY as prikey
										FROM INFORMATION_SCHEMA.COLUMNS 
										WHERE TABLE_SCHEMA ='".$this->db->database."' 
										AND TABLE_NAME='".$table."'");
			$return = array();
			if($result->num_rows() > 0) 
			{
				 $return = $result->result();
			}
	
			return $return;
        }
		
		
		
}
