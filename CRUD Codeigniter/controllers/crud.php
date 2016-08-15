<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hospitalwatch
 *
 * @author sani
 */
class Crud extends CI_Controller 
{
	/*****************************************************
	 *
	 *              COMMON FUNCTIONS
	 *                                      By: SANI HYNE
	 ****************************************************/
	 
	//SANI: Construction
	function __construct() 
	{
	   parent::__construct();
	   $this->load->helper(array('form', 'url'));
       $this->load->library('form_validation');
	   $this->load->helper('global');
	   $this->load->model('crud_model');
	   $this->load->database();
	   $this->load->library('grocery_CRUD');
	   $this->load->model('grocery_crud_model');
	}
	
         //SANI: Template
	function template($data, $sections = false)
	  { 
	  	if($sections)
		{
			$sections = array_filter($sections);
			if (!empty($sections)) 
			{
				foreach($sections as $sec)
				{
					switch($sec)
					{
						case 'header':     $data['header']      =	'common/header';      break;
						case 'navigation': $data['navigation']  =	'common/navigation';  break;
						case 'left':       $data['left']        =	'common/left';        break;
						case 'right':      $data['right']       =	'common/right';       break;
						case 'footer':     $data['footer']      =	'common/footer';      break;
					}
				}
			}
		}
		return $data; 
	  }
	  
        //SANI: Call any view
        function callView($Title, $view, $template, $other = false, $ViewColumns = false)
        {
              $data['Title']	  =	$Title." | Restaurant Invoice Monitoring System";
              $data 		  =    array_merge($data,$this->template($data, $ViewColumns));
              $data['View']	  =	$view;
              if($other)
              $data 		  =    array_merge($data, $other); 
              $this->load->view($template, $data);
        }
   
        //SANI: Logout
 	function logout()
	{
	   $this->session->unset_userdata('loginid');
	   $this->session->sess_destroy();
	   redirect();
	}
        
        //SANI: Check if user is loged-In or Not
        function checklogin()
        { 
                if(!$this->session->userdata("loginid"))
                {
                redirect();    
                }
        }
        
    /*****************************************************
	 *
	 *              VIEWS
	 *                                      By: SANI HYNE
	 ****************************************************/
	 
  //SANI: Default function to be called on object called. (Login Page)
  function index() 
  {
	$this->callView('Login', 'index', 'template_login');  //SANI: callView(Page Title, View Name, Template Name); 
  } 
  
     
	 /*******************************************************
	 *
	 *           List
	 *                                        By: SANI HYNE
	 ******************************************************/
	  //SANI: List 	
	  function crud_list() 
	  { 
		$this->checklogin();
		$data['userrights']        	  = $this->usermanagement_model->userrights($this->session->userdata("loginid"), 3);
		$data['coreClass']     = "active";
		$data['title']         = "List | Companies | RIMS";
		
		
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('table', 'Table', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			
		}else{
		        //SANI: get all table feild
				$getColumn 	= $this->crud_model->get_all_table_columns($this->input->post("table"));
				$primaryKey = 0;			
				
				//SANI: get primary key
				foreach($getColumn as $rec)
				{
					if($rec->prikey == "PRI") 
					{
						$primaryKey =$rec->allcolumns;
						continue;
					}
				}
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////
				//
				//
				//                                   MODEL
				//
				//                                                                                          BY: SANI HYNE
				//                                                                       http://linkedin.com/in/delickate
				/////////////////////////////////////////////////////////////////////////////////////////////////////////
				
		        //SANI: Creating Model content
				$create_model   = $this->create_model($this->input->post("table"), $this->input->post());
				
				//SANI: model file path
				$modelFile = './application/models/'.$this->input->post("model_name").'.php';
				
				//SANI: Creating Model file
				$this->create_file($modelFile, $create_model);
				
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////
				//
				//
				//                                   CONTROLLER
				//
				//                                                                                          BY: SANI HYNE
				//                                                                       http://linkedin.com/in/delickate
				/////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//SANI: Creating Controller content
				$create_controller   = $this->create_controller($this->input->post("table"), $this->input->post(), $primaryKey);
				
				//SANI: model file path
				$controllerFile = './application/controllers/'.$this->input->post("controller_name").'.php';
				
				//SANI: Creating Model file
				$this->create_file($controllerFile, $create_controller);
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////
				//
				//
				//                                   view
				//
				//                                                                                          BY: SANI HYNE
				//                                                                       http://linkedin.com/in/delickate
				/////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				$viewFolder = "./application/views/".$this->input->post('controller_name'); //SANI: Create directory
				$this->delete_folder($viewFolder);   //SANI: Delete if already exist 
				mkdir($viewFolder);     //SANI: Create directory
				
				$create_list_view   = $this->create_list_view($this->input->post("table"), $this->input->post());  //SANI: Creating View content
				$this->create_file(($viewFolder.'/'.$this->input->post("list_name").'.php'), $create_list_view);   //SANI: Creating list view file
				
				
				//SANI: Creating View content
				$create_add_view   = $this->create_add_view($this->input->post("table"), $this->input->post());
				$this->create_file(($viewFolder.'/'.$this->input->post("add_name").'.php'), $create_add_view);   //SANI: Creating add view file
				
				//SANI: Creating View content
				$create_edit_view   = $this->create_edit_view($this->input->post("table"), $this->input->post(), $primaryKey);
				$this->create_file(($viewFolder.'/'.$this->input->post("edit_name").'.php'), $create_edit_view);   //SANI: Creating add view file
				
				
			 }
		
		
		$data['get_all_databasetables']  = $this->crud_model->get_all_databasetables();
		$this->callView('Company list', 'crud/crud_list', 'template_list', $data, array('header', 'navigation','footer'));
		//redirect('company/company_list');
	  }
  
  
  //SANI: Creating model
  function create_model($tableName, $formData)
  {
  	$getColumn 	= $this->crud_model->get_all_table_columns($tableName);
	$primaryKey = 0;			
				
				foreach($getColumn as $rec)
				{
					if($rec->prikey == "PRI") 
					{
						$primaryKey =$rec->allcolumns;
						continue;
					}
				}
				 
  	$string = '<?php
					class '.ucfirst($formData["model_name"]).' extends CI_Model 
					{
						function __construct() { parent::__construct(); }
							
						function '.$formData["list_name"].'($id = false)
						{
							
								
								$query = "SELECT * 
										  FROM '.$tableName.'
										  WHERE 1=1 ";
								
								if($id)     $query .= " AND '.$primaryKey.'  = \'".$id."\' ";
								
								$Executed = $this->db->query($query); 
							    $this->db->close();
								return $Executed->result();
						}
					}
				';
		return $string;		
  }
  
  //SANI: Creating controller
  function create_controller($tableName, $formData, $primaryKey)
  {
  	$getColumn 	= $this->crud_model->get_all_table_columns($tableName);
	$primaryKey = 0;			
	$validation = "";
	$record     = "array(";	
			
				foreach($getColumn as $rec)
				{
					if($rec->prikey == "PRI") 
					{
						$primaryKey =$rec->allcolumns;
						continue;
					}else{
							$record     .= '"'.$rec->allcolumns.'" => $this->input->post("'.$formData["feild_".$rec->allcolumns].'"),
							               ';
							$validation .= '$this->form_validation->set_rules("'.$formData["feild_".$rec->allcolumns].'", "'.ucfirst($formData["feild_".$rec->allcolumns]).'", "required");
							               ';
					     }
				}
				
				
							
  	$record     .= ")";						
							
							
							
							
  	$string = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');
					class '.ucfirst($formData["controller_name"]).' extends CI_Controller  
					{
						function __construct() 
						{
						   parent::__construct();
						   $this->load->helper(array(\'form\', \'url\'));
						   $this->load->library(\'form_validation\');
						   $this->load->helper(\'global\');
						   $this->load->model(\''.$formData["model_name"].'\');
						  
						}
							
						function '.$formData["list_name"].'() 
						{ 
							$data["title"]         = "List";
							$data["record"]  = $this->'.$formData["model_name"].'->'.$formData["list_name"].'();
							$this->load->view("'.$formData["controller_name"].'/'.$formData["list_name"].'", $data);
						}
						
						  function '.$formData["add_name"].'() 
						  { 
							$data["title"]         = "Add";
								
							$this->load->helper(array("form", "url"));
							'.$validation.'
							   
							   if($this->form_validation->run() == FALSE)
								{
									
								}else{
										$db = '.$record.';
										$this->db->insert("'.$tableName.'", $db);
										$data["message"] = "Data saved successfully";
										$this->session->set_flashdata("message", "Data saved successfully");
										redirect("'.$formData["controller_name"].'/'.$formData["list_name"].'");
									 }
							
							
							$this->load->view("'.$formData["controller_name"].'/'.$formData["add_name"].'", $data);
						  }
						  
						  function '.$formData["edit_name"].'($id) 
						  { 
							$data["title"]         = "Edit";
							$data["record"]  = $this->'.$formData["model_name"].'->'.$formData["list_name"].'($id);	
							$this->load->helper(array("form", "url"));
							'.$validation.'
							   
							   if($this->form_validation->run() == FALSE)
								{
									
								}else{
										$db = '.$record.';
										$this->db->update("'.$tableName.'", $db, array("'.$primaryKey.'" => $id));
										$data["message"] = "Data update successfully";
										$this->session->set_flashdata("message", "Data update successfully");
										redirect("'.$formData["controller_name"].'/'.$formData["list_name"].'");
									 }
							
							
							$this->load->view("'.$formData["controller_name"].'/'.$formData["edit_name"].'", $data);
						  }
					
					
					function '.$formData["delete_name"].'($id) 
				    {
					   $this->db->delete("'.$tableName.'", array("'.$primaryKey.'" => $id));
					   $this->session->set_flashdata("message", "Data deleted successfully");
					   redirect("'.$formData["controller_name"].'/'.$formData["list_name"].'");
					}
					
				}	
				';
		return $string;		
  }
  
  
  //SANI: Creating model
  function create_list_view($tableName, $formData)
  {
  	$getColumn 	= $this->crud_model->get_all_table_columns($tableName);
	$primaryKey = 0;			
	
	$Titles     = '';
	$Values     = '';
	$primary    = '';
			
				foreach($getColumn as $rec)
				{
					if($rec->prikey == "PRI") 
					{
						$primaryKey = $rec->allcolumns;
						$primary    = ''.$rec->allcolumns.'';
						continue;
					}
					
					$Titles     .= '<th>'.$formData['feild_'.$rec->allcolumns.''].'</th>
					               ';
					$Values     .= '<td><?php echo $rec->'.$rec->allcolumns.'; ?></td>
					              ';
				}
	
	$string     = '<table id="example1" class="table table-bordered table-striped"><tr>
	              ';	
				 
  	$string    .= $Titles.'<th>Action</th>
	               </tr>
<?php foreach($record as $rec) { ?>                    
                      <tr>'.$Values.'
                        
                        <td>
                        <a href="<?php echo base_url().\''.$formData['controller_name'].'/'.$formData['edit_name'].'/\'.$rec->'.$primary.'; ?>">Edit</a> / 
                        <a href="<?php echo base_url().\''.$formData['controller_name'].'/'.$formData['delete_name'].'/\'.$rec->'.$primary.'; ?>" onclick="return confirm(\'Are you sure?\')">Delete</a>
                          
                        </td>
                        
                      </tr>
<?php } ?>                      
                    </tbody>
                    
                  </table>
<p align="center"><input type="button" value="Add Item" onclick="window.location=\'<?php echo base_url().\''.$formData['controller_name'].'/'.$formData['add_name'].'\'; ?>\'" class="btn btn-primary" /></p>';
                  
					
		return $string;		
  }
  
  //SANI: Creating model
  function create_add_view($tableName, $formData)
  {
  	$getColumn 	= $this->crud_model->get_all_table_columns($tableName);
	$primaryKey = 0;			
	
	$Titles     = '';
	$Values     = '';
	$feild      = '';
			
				foreach($getColumn as $rec)
				{
					if($rec->prikey == "PRI") 
					{
						$primaryKey =$rec->allcolumns;
						continue;
					}
					
					$Titles     .= '<tr>
					                    <td>'.$formData['feild_'.$rec->allcolumns.''].'</td>
					                    <td>'.$this->inputType($formData['type_'.$rec->allcolumns.''], $formData['feild_'.$rec->allcolumns]).'</td>
								    </tr>';			   
				}
	
	$string     = '<form method="POST" action="" >
	               <p><?php echo validation_errors(); ?></p>
	                <table  class="table table-bordered table-striped">
	              ';	
   $string .= $Titles;              
$string    .= '</tbody>
</table>
<p align="center"><input type="submit" value="Save" class="btn btn-primary" /></p>';
                  
					
		return $string;		
  }
  
  //SANI: Creating model
  function create_edit_view($tableName, $formData, $primaryKey)
  {
  	$getColumn 	= $this->crud_model->get_all_table_columns($tableName);
	$primaryKey = 0;			
	
	$Titles     = '';
	$Values     = '';
	$primary    = '';
	$feild      = '';
	$primary    = '';
			
				foreach($getColumn as $rec)
				{
					if($rec->prikey == "PRI") 
					{
						$primaryKey = $rec->allcolumns;
						$primary   .= '<input type="hidden" value="<?php echo $rec->'.$rec->allcolumns.'; ?>" name="feild_'.$rec->allcolumns.'" />';
						continue;
					}
					
					$Titles     .= '<tr>
					                    <td>'.$formData['feild_'.$rec->allcolumns.''].'</td>
					                    <td>'.$this->inputType($formData['type_'.$rec->allcolumns.''], $formData['feild_'.$rec->allcolumns], ('$rec->'.$rec->allcolumns)).'</td>
								    </tr>';			   
				}
	
	$string     = '<form method="POST" action="" >
	                <p><?php echo validation_errors(); ?></p>
	                <table  class="table table-bordered table-striped">
	              ';
    $string     .= '<?php foreach($record as $rec) { ?> ';			  	
   $string      .= ''.$primary.' '.$Titles;     
   $string      .= '<?php } ?>';	         
$string    .= '                     
</tbody>
</table>
<p align="center"><input type="submit" value="Save" class="btn btn-primary" /></p>';
                  
					
		return $string;		
  }
  
  				////////////////////////////////////////////////////////////////////////////////////////////////////////
				//
				//
				//                                   GENERAL FUNCTION
				//
				//                                                                                          BY: SANI HYNE
				//                                                                       http://linkedin.com/in/delickate
				/////////////////////////////////////////////////////////////////////////////////////////////////////////
				
  //SANI: Getting table feilds
  function get_database_table_feilds()
  {
  	 $tableName    = $this->input->post('TableName');                       //SANI: Getting table name from form
	 $getFeildName = $this->crud_model->get_all_table_columns($tableName);  //SANI: Getting all feilds of table
	 
	 $string       = "<table width='100%' cellpading='10' cellspacing='10'>
	                    <tr>
							<th>Feilds</th>
							<th>Alias for input name</th>
							<th>Type</th>
						</tr>
	                 ";
	 
	 foreach($getFeildName as $rec)
	 {
	 	if($rec->prikey == "PRI") continue;
		
	 	$string .= '<tr>
							<th>'.$rec->allcolumns.'</th>
							<th><input type="text" name="feild_'.$rec->allcolumns.'"></th>
							<th>
								<input type="radio" name="type_'.$rec->allcolumns.'" value="text" checked="checked"> Textbox &nbsp;&nbsp;
								<input type="radio" name="type_'.$rec->allcolumns.'" value="textarea"> Textarea &nbsp;&nbsp;
								<input type="radio" name="type_'.$rec->allcolumns.'" value="radio"> Radio &nbsp;&nbsp;
								<input type="radio" name="type_'.$rec->allcolumns.'" value="checkbox"> Checkbox &nbsp;&nbsp;
								<input type="radio" name="type_'.$rec->allcolumns.'" value="select"> Dropdown &nbsp;&nbsp;
							</th>
				   </tr>';
	 	
	 } 
	 
	 $string .= '</table>';
	 
	 echo $string;
	 
  }  

   //SANI: Creating Input Feild
   function inputType($input, $name, $editMode = false)
   {
   		if($editMode)
		{
			$editMode = '<?php echo '.$editMode.'; ?>';
		}else{
				$editMode = '';
		     }
		
   		$return = "";
   		switch($input)
		{
			case 'text':    $return .= '<input type="text" name="'.$name.'" value="'.$editMode.'">';break;
			case 'textarea':$return .= '<textarea name="'.$name.'">'.$editMode.'</a>';break;
			case 'radio':   $return .= '<input type="radio" name="'.$name.'" value="'.$editMode.'" checked="checked"> '.$name.'';break;
			case 'checkbox':$return .= '<input type="checkbox" name="'.$name.'" value="'.$editMode.'" checked="checked"> '.$name.'';break;
			case 'select':  $return .= '<select name="'.$name.'"><option value="">-- Select --</option></select>';break;
			
		}
		return $return;
   } 
   
   //SANI:create file
   function create_file($file, $content)
   {
   		if(file_exists ($file))
		{
				unlink($file);
		}

		if (!write_file($file, $content)) { echo 'Unable to write the file'; }
			
   }
   
   //SANI: Delete folder if exist
   function delete_folder($path)
	{
		if (is_dir($path) === true)
		{
			$files = array_diff(scandir($path), array('.', '..'));
	
			foreach ($files as $file)
			{
				$this->delete_folder(realpath($path) . '/' . $file);
			}
	
			return rmdir($path);
		}
	
		else if (is_file($path) === true)
		{
			return unlink($path);
		}
	
		return false;
	}

}
