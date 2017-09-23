<?php 
  require_once dirname(__DIR__)."/main.php";
  
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
    <div id="home" class="row panel panel-primary">
     
        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tabledata">
          <thead>
            <tr>
                <th><em class="fa fa-cog"></em> Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Quota</th>
                <th>Granted</th>
                <th>Permisstion</th>
               
            </tr> 
          </thead>
          <tbody> 
          <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Quota</th>
                <th>Granted</th>
                <th>Permission</th>
            </tr> 
          </tbody>
        </table>          
    </div>
</div>