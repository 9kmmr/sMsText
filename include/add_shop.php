<?php 
  require_once dirname(__DIR__)."/main.php";
  $alert="";
  if (isset($_POST['submit'])){
      $name = $_POST['name'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      $location_shop = $_POST['loc'];
      $lat = $_POST['lat'];
      $long = $_POST['long'];
      $description = $_POST['description'];
      $data = array(
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'location_shop'=> $location_shop,
        'description' => $description 
        );
      if (check_exist_shop($data)!==""){
        $alert =check_exist_shop($data);
      }
      else
      {
  
        try {
          $res_add = add_shop($data);
          if($res_add){
            $alert = "Insert shop successfuly";
          }
          else {
            $alert = "Insert failed !";
          }
        } catch (Exception $e) {
          $alert = $e;
          }
        }
  }
  
?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<form class="form-horizontal" action="" method="POST">
    <fieldset>
    
    <!-- Form Name -->
    <legend>Add New Shop</legend>
    <h5><?php echo $alert; ?></h5>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="name">Shop</label>  
      <div class="col-md-5">
      <input id="name" name="name" type="text" placeholder="Name of  shop" class="form-control input-md" required>
        
      </div>
    </div>
    
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="phone">Phone</label>  
      <div class="col-md-5">
      <input id="phone" name="phone" type="number"  placeholder="Phone" class="form-control input-md " required >
        
      </div>
    </div>
    
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="email">Email</label>  
      <div class="col-md-5">
      <input id="email" name="email" type="email" placeholder="Email" class="form-control input-md">
        
      </div>
    </div>
    
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="textinput">Address</label>  
      <div class="col-md-5">
      <div id="locationField">
                <input id="autocomplete" class="form-control" placeholder="Enter your address"
                 onFocus="geolocate()" type="text" name="loc" required></input>
              </div>
              <input type="text" id="lat" name="lat" hidden="true"> 
              <input type="text" id="long" name="long" hidden="true"> 
      </div>
    </div>
    
    <!-- Textarea -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="description">Shop Description</label>
      <div class="col-md-4">                     
        <textarea class="form-control" id="description" name="description">Say something about this shop</textarea>
      </div>
    </div>
    <!-- submit -->
    <div class="form-group">
    	<label class="col-md-4 control-label" for="email"></label> 
      	<div class="col-md-5">   	                    
        	<input value="Add Shop" name="submit" type="submit"  class="btn btn-info">
      	</div>
    </div>
    </fieldset>
</form>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4inKl9EXT3wJTEroVKM_LjNQhsJGUGqQ&libraries=places&callback=initAutocomplete"
        async defer></script>


