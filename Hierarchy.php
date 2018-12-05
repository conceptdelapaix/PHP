<?php
class Hierarchy
{
	public $database_table;
	public $primary_key;
	public $parent_key;
	public $field_title;
	
	
	function _construct()
	{
		
	}
	
	public function sitemap($parent = 0, $string = "")
    {
			global $string;
			
            $ci			= & get_instance();
			
			$query 		= "SELECT * FROM ".$this->database_table." 
						   WHERE ".$this->parent_key." = ".$parent."
						   ORDER BY ".$this->primary_key." 
						  ";
			
			$execution  = $ci->db->query($query);
			
			if($execution->num_rows() > 0)
			{
				$string .=  "<ul>";
				foreach($execution->result() as $rec)
				{
					$string .=  "<li>".$rec->{$this->field_title};
						$this->sitemap($rec->{$this->primary_key}, $string);
					$string .=  "</li>";
				}
				$string .=  "</ul>";
			}
			
			return $string;
             
     }
	 
	public function top_navigation($parent = 0, $top_navigation = "")
    {
			global $top_navigation;
			
            $ci			= & get_instance();
			
			$query 		= "SELECT * FROM ".$this->database_table." 
						   WHERE ".$this->parent_key." = ".$parent."
						   ORDER BY ".$this->primary_key." 
						  ";
			
			$execution  = $ci->db->query($query);
			
			if($execution->num_rows() > 0)
			{
				$top_navigation .=  '<ul class="'.(($parent > 0)?"dropdown-menu":"dropdown-submenu").'" >';
				foreach($execution->result() as $rec)
				{
					$top_navigation .=  "<li>".$rec->{$this->field_title};
						$this->top_navigation($rec->{$this->primary_key}, $top_navigation);
					$top_navigation .=  "</li>";
				}
				$top_navigation .=  "</ul>";
			}
			
			return $top_navigation;
             
     }
	 
	 public function left_navigation($parent = 0, $left_navigation = "")
    {
			global $left_navigation;
			
            $ci			= & get_instance();
			
			$query 		= "SELECT * FROM ".$this->database_table." 
						   WHERE ".$this->parent_key." = ".$parent."
						   ORDER BY ".$this->primary_key." 
						  ";
			
			$execution  = $ci->db->query($query);
			
			if($execution->num_rows() > 0)
			{
				$left_navigation .=  '<ul  >';
				foreach($execution->result() as $rec)
				{
					$left_navigation .=  "<li>".$rec->{$this->field_title};
						$this->left_navigation($rec->{$this->primary_key}, $top_navigation);
					$left_navigation .=  "</li>";
				}
				$left_navigation .=  "</ul>";
			}
			
			return $left_navigation;
             
     } 
	 
	private function select_box($parent = 0, $select_box = "", $inc_dec = "+")
    {
			global $select_box;
			global $inc_dec;
			
			$inc_dec   .= '+'; 
			
            $ci			= & get_instance();
			
			$query 		= "SELECT * FROM ".$this->database_table." 
						   WHERE ".$this->parent_key." = ".$parent."
						   ORDER BY ".$this->primary_key." 
						  ";
			
			$execution  = $ci->db->query($query);
			
			if($execution->num_rows() > 0)
			{
				foreach($execution->result() as $rec)
				{
					$select_box .=  '<option value="'.$rec->{$this->primary_key}.'" >'.$inc_dec.' '.$rec->{$this->field_title}."</option>";
					$this->select_box($rec->{$this->primary_key}, $select_box);
					$inc_dec = "+";
					
				}
				
			}
			
			return $select_box;
             
     } 
	 
	public function dropdown()
	{
		$string  = "<select>";
		$string .= $this->select_box(0);
		$string .= "</select>";
		
		return $string;
	} 
	
	
}

/*
//SANI: Lets suppose we have following database table
CREATE TABLE IF NOT EXISTS `tbl_sections` 
(
  `sec_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_parent_id` int(11) NOT NULL,
  `sec_name` varchar(255) NOT NULL,
  `sec_controller` varchar(255) NOT NULL,
  `sec_icon` varchar(255) NOT NULL,
  `sec_sortid` int(11) NOT NULL,
  `sec_status` enum('Active','Deactive') NOT NULL,
  `sec_date` datetime NOT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
*/

//SANI: How to use it.

//SANI: Create an object
$obj = new Hierarchy();

//SANI: Initialize database table name, primary key, parent key and field name to show
$obj->database_table 	= "tbl_sections";
$obj->primary_key 		= "sec_id";
$obj->parent_key 		= "sec_parent_id";
$obj->field_title 		= "sec_name";

//SANI: Show sitemap
//echo $obj->sitemap(0);

//SANI: Show top navigation
//echo $obj->top_navigation(0);

//SANI: Show left navigation
echo $obj->left_navigation(0);

//SANI: Show dropdown
//echo $obj->dropdown();

?>