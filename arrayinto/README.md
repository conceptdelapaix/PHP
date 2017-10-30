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
</pre>
