<!-- ////////////////////////////////////////////////////////////////
     //
     //
     //                         VIEW TO CREATE CRUD
     //
     //                                                 BY: SANI HYNE
     //                              http://linkedin.com/in/delickate
     ////////////////////////////////////////////////////////////////
-->     
<div class="content-wrapper">
        <div class="container-fluid">
         

          <section class="content">
           	<div class="row">
            <div class="col-md-12 col-xs-12" style="background-color:#fafafa; padding-top:20px;">
              <div class="box box-primary">
                <div class="box-header with-border btn-header">
                  <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                 <form method="post" action="">
                <table width="100%"  cellpadding="10" cellspacing="10" >
                    <tr>
                    	<td>Select Table</td>
                        <td><?php echo form_dropdown('table', $get_all_databasetables, '','class="form-control" onChange="get_table_feilds(this.value)"'); ?></td>
                        
                    </tr>
                     <tr>
                    	<td>Model Name</td>
                        <td><input type="text" value="xxxx_model" name="model_name" class="form-control" /></td>
                    </tr>
                    <tr>
                    	<td>Controller Name</td>
                        <td><input type="text" value="xxxx_controller" name="controller_name" class="form-control" /></td>
                    </tr>
                    <tr>
                    	<td>List Function Name</td>
                        <td><input type="text" value="xxxx_list" name="list_name" class="form-control" /></td>
                    </tr>
                     <tr>
                    	<td>Add Function Name</td>
                        <td><input type="text" value="xxxx_add" name="add_name" class="form-control" /></td>
                    </tr>
                    <tr>
                    	<td>Edit Function Name</td>
                        <td><input type="text" value="xxxx_edit" name="edit_name" class="form-control" /></td>
                    </tr>
                    <tr>
                    	<td>Delete Function Name</td>
                        <td><input type="text" value="xxxx_delete" name="delete_name" class="form-control" /></td>
                    </tr>
                    <tr>
                    	<td>Feilds</td>
                        <td>
                        	<div id="feildBox"></div>
                        </td>
                    </tr>
                    
                    
                   
                    
                  </table>
                  <p align="center"><input type="submit" value="Create CRUD" class="btn btn-primary" /></p>
                  </form>          
                </div>
                
              </div>
            </div>
          </div>
          </section>
        </div>
      </div>
      <script>
	  //SANI: Getting database table feilds on dropdown change
	  function get_table_feilds(TableName)
	  {
	  	$.ajax({
					url: "<?php echo base_url(); ?>crud/get_database_table_feilds",
					data: {"TableName" : TableName},
					type: "post",
					success: function(sani)
					{
						$("#feildBox").html(sani);
					}
            });
	  }
	  </script>