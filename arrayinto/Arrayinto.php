<?php
class Arrayinto
{
	public $json_string;
	public $array_object;
	
	//SANI: Constructor
	function __construct() 
	{
       $this->json_string  = ""; 
	   $this->array_object = array(); 
	}
	
	//SANI: Processing Array to table
	public function process_table()
	{
		$response = $this->array_into_table($this->array_object);
		return $response;
	}
	
	
	//SANI: Processing Array to div
	public function process_div()
	{
		$response = $this->array_into_div($this->array_object);
		return $response;
	}
	
	
	//SANI: Processing Array to div
	public function process_json($type='table')
	{
		$string_array = "";
		$string_array = json_decode($this->json_string);
		
		switch($type)
		{
			case 'table': $response = $this->array_into_table($string_array);break;
			case 'div':   $response = $this->array_into_div($string_array);break;
		}
		
		return $response;
	}
	
	//SANI: Array into Table or div			
	function array_into_table($string_array)
	{   
		if((is_array($string_array) || is_object($string_array)) && !empty($string_array))
		{   
			echo '<table cellpadding="0" cellspacing="0" border="1">';
			
				//SANI: Loop for table heading
				echo '<tr>';
					foreach($string_array as $record=>$keyValue)
					{   
						echo '<th>';
						echo $record;
						echo '</th>';	 
					}
				echo '</tr>';
				
				//SANI: Loop for table values
				echo '<tr>';
					foreach($string_array as $record=>$keyValue)
					{   
						echo '<td>';
						if((is_array($keyValue) || is_object($keyValue)) && !empty($keyValue))	
						{   
							$this->array_into_table($keyValue);
						}else{ 
								echo $keyValue;
							 }
						echo '</td>';	 
					}
				echo '</tr>';
			echo '</table>';
			
		}else{
				echo 'Invalid Array/Object';
			 }
		
		
	}	
	
	
	//SANI: Array into div or div			
	function array_into_div($string_array)
	{   
		if((is_array($string_array) || is_object($string_array)) && !empty($string_array))
		{   
			echo '<div class="cls-md-12">';
			
				//SANI: Loop for div heading
				echo '<div class="cls-md-1">';
					foreach($string_array as $record=>$keyValue)
					{   
						echo '<div><b>';
						echo $record;
						echo '</b></div>';	 
					}
				echo '</div>';
				
				//SANI: Loop for div values
				echo '<div  class="cls-md-1">';
					foreach($string_array as $record=>$keyValue)
					{   
						echo '<div><span>';
						if((is_array($keyValue) || is_object($keyValue)) && !empty($keyValue))	
						{   
							$this->array_into_div($keyValue);
						}else{ 
								echo $keyValue;
							 }
						echo '</span></div>';	 
					}
				echo '</div>';
			echo '</div>';
			
		}else{
				echo 'Invalid Array/Object';
			 }
		
		
	}

	
	//SANI: Disctructor
	function __destruct() 
	{
       
    }
	
}


$obj = new Arrayinto();

$obj->array_object = array("AAA" => "1111",
                      "BBB" => "2222",
					  "CCC" => array("CCC-1" => "123",
					                 "CCC-2" => array("CCC-2222-A" => "CA2",
									                  "CCC-2222=B" => "CB2"
													 )
									)
					 
					 );

echo "<h1>Array into table</h1>";					 
$result = $obj->process_table();
echo "<pre>"; print_r($result); echo "<hr />";

echo "<h1>Array into div</h1>";					 
$result = $obj->process_div();
echo "<pre>"; print_r($result); echo "<hr />";

echo "<h1>JSON into div/table</h1>";	
$obj->json_string = '{
				"AAA":"11111",
				"BBB":"22222",
				"CCC":[
						{
							"CCC-1":"123"
						},
						{
							"CCC-2":"456"
						}
				      ]	
             }
            ';
$result = $obj->process_json();
echo "<pre>"; print_r($result); echo "<hr />";
$result = $obj->process_json('div');
echo "<pre>"; print_r($result); echo "<hr />";
					 
?>