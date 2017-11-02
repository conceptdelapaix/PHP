# String into Table/Div

# How to use it?
$obj = new Arrayinto();

# Examples

<pre>
$obj->array_object = array("AAA" => "1111",
                      "BBB" => "2222",
					  "CCC" => array("CCC-1" => "123",
					                 "CCC-2" => array("CCC-2222-A" => "CA2",
									                  "CCC-2222=B" => "CB2"
													 )
									)
					 
					 );

# Array into table					 
$result = $obj->process_table();
print_r($result);

# Array into div				 
$result = $obj->process_div();
print_r($result);

# JSON into div/table
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
print_r($result);
$result = $obj->process_json('div');
print_r($result);

