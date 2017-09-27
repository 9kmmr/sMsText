<?php 
  require_once dirname(__DIR__)."/main.php";
    if (isset($_POST)&&isset($_POST['submit_grant'])){
        $value = $_POST['grant'] ;
        $id = $_POST['id_code'];
        sMs_update_granted($id, $value);
    }
    if (isset($_POST)&&isset($_POST['submit_quota'])){
        $value = $_POST['quota'] ;
        $id = $_POST['id_code'];
        sMs_update_quota($id, $value);
    }
    if (isset($_POST)&&isset($_POST['submit_permissionsms'])){
        $value = $_POST['permissionsms'] ;
        $id = $_POST['id_code'];
        sMs_update_smstype($id, $value);
    }
    /*settingsms('09fb50b9','b7ce2d3d8c328da7');
    sendsms('84942767161','841642531194','dmm thong dick');*/
  $alldata = sMs_get_all_permission();
?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

<div class="container">

  <h2>Manage SMS</h2>
  <div class="form-group">
    <label ><?php if (isset($alert)) echo $alert; ?></label>
    
  </div>
    <div class="form-group">

    </div>
    <div id="home" class="row  panel-primary">     
        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tabledata">
          <thead>
            <tr>
                <th><em class="fa fa-user-circle-o"></em> Name</th>
                <th><em class="fa fa-envelope-o"></em> Email</th> 
                <th><em class="fa fa-check-circle-o"></em> Granted</th>              
                <th><em class="fa fa-code"></em> Quota</th>               
                <th><em class="fa fa-cogs"></em>  Permisstion</th>               
            </tr> 
          </thead>
          <tbody>
            <?php if (alldata) {
                foreach ($alldata as $key => $value) {
                  
                ?> 
            <tr>
                <th><?=$value->display_name?></th>
                <th><?=$value->user_email?></th>
                <th>
                    <?=($value->granted!='0')?'Granted':'Deny' ?>

                    <a data-toggle='modal' class="pull-right" style="margin-right: 5px;" href='#edit_grant_<?php echo $value->id;?>'>
                      <span>Edit</span>
                    </a>
                        <form action="" method="POST">
				            <div class="modal" id="edit_grant_<?php echo $value->id;?>" role="dialog">
				                 <div class="modal-dialog">
				                            <!-- Modal content-->
				                    <div class="modal-content">
				                        <div class="modal-header">
				                            <button type="button" class="close" data-dismiss="modal">&times;</button>
				                            <h3 class="modal-title">Change Permission to user </h3>
				                        </div>
			                            <div class="modal-body" id='granted_<?php echo $value->id;?>'>
                                            <input type="radio" class="form-control" value="1" name="grant" <?=($value->granted!='0')?'checked':'' ?>  >
                                            <label for="">Granted</label>			                                
			                                		<br>
                                            <input type="radio" class="form-control" value="0" name="grant" <?=($value->granted=='0')?'checked':''?>  >
                                            <label for="">Deny</label>                                            
			                                		<br>			                                		
			                                <input type="hidden" name="id_code" value="<?php echo $value->UID;?>">
			                            </div>
				                        <div class="modal-footer">
				                            <input type="submit" name="submit_grant" value="Change" class="btn btn-info">
				                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                        </div>
				                    </div>
				                </div>
				            </div>
				        </form>
                </th>                
                <th>
                    <?=$value->quota  ?> &nbsp;
                    <a data-toggle='modal' class="pull-right" style="margin-right: 5px;" href='#edit_quota_<?php echo $value->id;?>'>
                      <span>Edit</span>
                    </a>
                    <form action="" method="POST">
				            <div class="modal" id="edit_quota_<?php echo $value->id;?>" role="dialog">
				                 <div class="modal-dialog">
				                            <!-- Modal content-->
				                    <div class="modal-content">
				                        <div class="modal-header">
				                            <button type="button" class="close" data-dismiss="modal">&times;</button>
				                            <h3 class="modal-title">Change Quota</h3>
				                        </div>
			                            <div class="modal-body" id='quota_<?php echo $value->id;?>'>
			                                <input type="number" class="form-control" min="0" name="quota" value="<?=$value->quota?>" placeholder="Change quota for this user " >
			                                		<br>
			                                		
			                                <input type="hidden" name="id_code" value="<?php echo $value->UID;?>">
			                            </div>
				                        <div class="modal-footer">
				                            <input type="submit" name="submit_quota" value="Change" class="btn btn-info">
				                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                        </div>
				                    </div>
				                </div>
				            </div>
				    </form>
                </th>
                
                <th>
                    <?php 
                        $per = $value->permission_sms; 
                        if ($per == 0) {
                            echo "Send sms to sri lanka. ";
                        } elseif ($per == 1) {
                            echo "Send sms to other country.";									
                        } 
                    ?>
                    <a data-toggle='modal' class="pull-right" style="margin-right: 5px;" href='#edit_permission_<?php echo $value->id;?>'>
                      <span>Edit</span>
                    </a>				
                    <form action="" method="POST">
				        <div class="modal" id="edit_permission_<?php echo $value->id;?>" role="dialog">
				            <div class="modal-dialog">
				                            <!-- Modal content-->
				                <div class="modal-content">
				                    <div class="modal-header">
				                         <button type="button" class="close" data-dismiss="modal">&times;</button>
				                         <h3 class="modal-title">Choose permission</h3>
				                    </div>
			                        <div class="modal-body" id='permission_<?php echo $value->id;?>'>
			                            <input type='radio' value ='0' name='permissionsms' <?php if ($per == 0): echo "checked";?>
			                                			
			                             <?php endif ?>> Send sms to sri lanka.
			                                		<br>
			                            <input type='radio' value ='1' name='permissionsms' <?php if ($per == 1): echo "checked";?>
			                                			
			                            <?php endif ?>> Send sms to other country.
			                                		<br>
			                            
			                             <input type="hidden" name="id_code" value="<?php echo $value->id;?>">
			                        </div>
				                    <div class="modal-footer">
				                        <input type="submit" name="submit_permissionsms" value="Done" class="btn btn-info">
				                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				                    </div>
				                </div>
				            </div>
				         </div>
				   </form>
                   <?php ?>
                </th>
            </tr>

            <?php }} ?> 
          </tbody>
        </table>          
    </div>
</div>