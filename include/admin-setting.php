<?php 
  require_once dirname(__DIR__)."/main.php";
  
  $numpage=1;
  $alert="";
  if(isset($_GET['delete'])&&isset($_GET['id'])){
    $alert = delete_shop($_GET['id']);
    
  }
  if (isset($_GET)&&isset($_GET['num'])){
    $numpage = $_GET['num'];
  }
  if (isset($_POST['submit'])){
      $name = $_POST['name'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      $location_shop = $_POST['loc'];
      $lat = $_POST['lat'];
      $long = $_POST['long'];
      $description = $_POST['description'];
      $active = ($_POST['active']=='on')?'1':'0';
      $id = $_POST['id'];
      $data = array(
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'location_shop' => $location_shop,
        'description' => $description,
        'active'  => $active
        );
      
      try {
          $res_add = update_shop($data,$id);
          if($res_add){
            $alert = "Update shop successfuly";
          }
          else {
            $alert = "Update failed !";
          }
        } catch (Exception $e) {
          $alert = $e;
        }
      
  }

  $table_value =  get_shop();
  foreach ($table_value as $key => $value) {
    $dat[count($dat)] = $value->id;
  }
  if (isset($_POST['uplink'])&&isset($_POST['linkshop'])){
    update_linktoshop($_POST['linkshop']);
  }
  $linkshop =  get_linktoshop()[0]->link;
  
?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="container">

  <h2>Manage Shop</h2>
  <div class="form-group">
    <label ><?php echo $alert; ?></label>
    <p>Select page and use shortcode : [sm_getshop] to make a vitual shop page.</p>
  </div>
  <div class="form-group">

    <form action="" method="POST">
      
      <select name="linkshop">
        <option value="">
        <?php echo esc_attr( __( 'Select page' ) ); ?></option> 
         <?php 
          $pages = get_pages(); 
          foreach ( $pages as $page ) {
            if ($linkshop== get_page_link( $page->ID ) ) {
              $option = '<option value="' . get_page_link( $page->ID ) . '" selected >';
            }
            else {
              $option = '<option value="' . get_page_link( $page->ID ) . '">';
            }
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
          }
         ?>
      </select>
      <input type="submit" name="uplink" value="Select Page" class="btn btn-info btn-sm">
      <label></label>

    </form>    
  </div>
  <ul id="changetabs" class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">All Shop</a></li>
    <li><a data-toggle="tab" href="#menu1">Edit Shop</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="form-group">

      </div>
      <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tabledata">
        <thead>
          <tr>
              <th><em class="fa fa-cog"></em>Shop Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Location</th>
              <th>Description</th>
              <th>Shop's Product</th>
              <th>Edit</th>
              <th>Delete</th>
          </tr> 
        </thead>
        <tbody> 
          <?php 
           
             
              foreach ($table_value as $key => $value) {


                
                $active = ($value->active=='1')?'active':'inactive';
                echo "<tr>";

                echo "<td> <a href='?page=add_product&id=".$value->id."'> ".$value->name."</a> </td>";
                echo "<td> ".$value->email." </td>";
                echo "<td> ".$value->phone." </td>";
                echo "<td >".$value->location_shop." </td>";
                echo "<td> ".$value->description." </td>";
                echo "<td> <a href='?page=add_product&id=".$value->id."'>Product</a></td>";
                echo "<td  class='leuleu' id=".$value->id.">Edit</td>";
                echo "<td><a href='?page=Manager_Shop_Views&delete=1&id=".$value->id."'>Delete</a></td>";
                echo "</tr>";
              } ?>
        </tbody>
      </table>            

    </div>
    <div id="menu1" class="tab-pane fade">
      <div class="form-group">
        <label > </label>
      </div>
      <form class="form-horizontal" action="" method="POST">
      <fieldset>
      
      <!-- Form Name -->
        <legend>Edit Shop</legend>
        <h5></h5>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="name">Shop</label>  
          <div class="col-md-5">
          <input id="name" name="name" type="text" placeholder="Name of  shop" class="form-control    input-md" required="">
            
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="phone">Phone</label>  
          <div class="col-md-5">
          <input id="phone" name="phone" type="text" placeholder="Phone" class="form-control input-md"    required="">
            
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email">Email</label>  
          <div class="col-md-5">
          <input id="email" name="email" type="text" placeholder="Email" class="form-control input-md">
            
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
            <textarea class="form-control" id="description" name="description">Say something about  this   shop</textarea>
          </div>
        </div>
        <!-- checkbox-->
         <div class="form-group">
          <label class="col-md-4 control-label" for="active">Is Active ?</label>  
          <div class="col-md-5">
          <input id="active" name="active" type="checkbox" placeholder="active" class="form-control input-md" checked>
            
          </div>
        </div>
        <input type="text" name="id" id="id" hidden="true">
        <!-- submit -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email"></label> 
            <div class="col-md-5">                        
              <input value="Edit Shop" name="submit" type="submit"  class="btn btn-info">
            </div>
        </div>
        </fieldset>
      </form>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4inKl9EXT3wJTEroVKM_LjNQhsJGUGqQ&libraries=places&callback=initAutocomplete"
        async defer></script>

    </div>
  </div>
</div>