<?php 
	$alert="";
	$cat_list = get_cat();
	$product_list = array();
	$proc_all=null;
	$product_lists=null;
	$stac_time =null;
	$stac_day = null;
	$stac_all = null;
	if (isset($_GET['id'])){
		$shop_id = $_GET['id'];
	}
	if (isset($_POST['submit'])&& isset($_POST['proc'])){
		if (add_product_shop($shop_id,$_POST['proc'])){
			$alert = "add product successful!";
		}
		else {
			$alert = "add product failed!";
		}
	}
	if (isset($_POST['del'])&& isset($_POST['del_id']) ){
		$alert = delete_product_shop($shop_id,$_POST['del_id']);
	}

	foreach ($cat_list as $key => $value) {
		$product_list[$key] =  sm_get_product($value->term_id);
	}
	// get product by cate
	if (isset($_POST['filter_cat'])&&isset($_POST['cate'])){
		$cate_id = $_POST['cate'];
		$product_lists =  sm_get_product($cate_id);
	}
	// statistic by date
	if (isset($_POST['statistic_time'])){
		$start = $_POST['start'];
		$end = $_POST['end'];
		if (!$start&&!$end) {
			$alert= "Please chose atleast 1 day !";

		}else{
			$stac_time = statis_by_time($shop_id,$start,$end);	
		}

	}
	$stac_day = statis_day($shop_id);
	$stac_all = statis_all($shop_id);

	$all_product_shop = get_product_shop($shop_id);
	
	if (count($all_product_shop)>0){
		foreach ($all_product_shop as $key => $value) {
			$proc_all[$key] = sm_getproduct_id($value->product_id);
		}				
	}
	
	if (isset($_GET['link'])){
		$text = $_GET['link'];

		echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$text."&choe=UTF-8'/>";
		echo "<a href='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$text."&choe=UTF-8' target='_blank' >View Image In New Tab</a>";

		die();
	}
	
	$linkshop =  get_linktoshop()[0]->link;
	
 ?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="container">

	<h2>Manage Shop's Product</h2>
	<div class="form-group">
	    <label ><?php echo $alert; ?></label>
	    <a href="?page=Manager_Shop_Views" class="btn btn-info">Back </a>
	    <label></label>
	    <div class="form-group">
	    
	    <h5></h5>
	    	<i class="col-md-2">Link to Shop : </i>
	    	<input type="text" name="linkshop"  class="col-md-5" placeholder="place link to shop here !" value="<?=($linkshop!='') ? $linkshop.'?shop='.$shop_id : ''  ?>"> 
	    	<label></label>
	    	
	    </div>
	</div>
	<ul id="changetabs" class="nav nav-tabs">
    	<li class="active"><a data-toggle="tab" href="#home">All Product</a></li>
    	<li><a data-toggle="tab" href="#menu1">Add Product To Shop</a></li>
    	<li><a data-toggle="tab" href="#menu2">Statistic</a></li>
   
  	</ul>
  	<div class="tab-content">
    	<div id="home" class="tab-pane fade in active">
    		<div class="form-group">
    			<label ></label>
			</div>
			<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tabledata">
    		    <thead>
    		      	<tr>
    		      	  	<th>#</th>
    		          	<th><em class="fa fa-cog"></em>Name</th>
    		          	<th> Category</th>
    		          	<th>Price</th>
    		          	<th>Sold</th>
    		          	<th>Views</th>
    		         	<th>View QR Code</th>    		          
    		          	<th>Delete</th>
    		      	</tr> 
    		    </thead>
    		   
    		    <tbody>
    		    	
    		    	<?php 
    		    		if (count($proc_all)>=1){
    		    		foreach ($proc_all as $key => $value) {
    		    			$prod_id = $value->post->ID;
    		    			
    		    			$cates = sm_get_product_cat($prod_id);			
    		    			echo "<tr>";
    		    			echo " <form action='' method='POST'> ";
    		    			echo "<th>".$key."</th>";
    		    			echo "<th>".$value->post->post_title ."</th>";
    		    			echo "<th>".$cates->name  ."</th>";
    		    			echo "<th>".sm_getprice($prod_id) ."</th>";
    		    			echo "<th>".sm_getsold($prod_id,$shop_id  )."</th>";
    		    			echo "<th>".sm_get_views($prod_id,$shop_id )."</th>";
    		    			
    		    			/*echo "<th><a href='?page=add_product&id=$shop_id&link=". urlencode(sm_getlink($prod_id ))." '</a>View QR </th>";*/
    		    			echo "<th><button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal$key'>View QR</button>";
    		    			echo "<div id='myModal$key' class='modal fade' role='dialog'>";
    		    			echo "<div class='modal-dialog'>";							
							echo "<div class='modal-content'>";
							echo "<div class='modal-header'>";
							echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
							echo " <h4 class='modal-title'>Product QR Code</h4>";
							echo "<img src='https://chart.googleapis.com/chart?chs=180x180&cht=qr&chl=".urlencode(sm_getlink($prod_id ))."?shop_id=".$shop_id."&choe=UTF-8'/>";						
							echo "<img src='".sm_getimage($prod_id)[0]."' data-id=".$prod_id." height='320' width='320' />";
							echo "</div>";
							echo "<div class='modal-body'>";
							echo "<h5 >Product Name :".$value->post->post_title."  </h5>";				
							echo "<h5 >Product  Catebory : ".$cates->name ." </h5>";							
							echo "<h5 >Product  Price: ".sm_getprice($prod_id) ." </h5>";
							echo "<a href='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".urlencode(sm_getlink($prod_id ))."?shop_id=".$shop_id."&choe=UTF-8' target='_blank' >View Image In New Tab</a>";
							
							echo "</div>";
							echo "<div class='modal-footer'>";
							echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
							echo "</div>";
							echo "</div>";
							echo "</div>";
							echo "</div>";    		    			
    		    			echo "</th>";
    		    			echo "<th><input type='text' value='$prod_id' hidden='true' name='del_id'> <input type='submit' class='btn btn-default btn-xs' name='del' value='Delete'></th>";
    		    			echo "</form> ";
    		    			echo "</tr>";
    		    		}}
    		    	 ?>  
    		    	   		    	
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
	        		<legend>Add Product To Shop</legend>
	        		<h5></h5>
	        		<!-- Text input-->
	        		<div class="form-group">
	        		  <label class="col-md-4 control-label" for="name">Category</label>  
	        		  <div class="col-md-5">
	        		  	<select class="form-control" id="sel1" name="cate">
	        		  	<?php 

	        		  		foreach ($cat_list as $key => $value) {
	        		  			if ($value->term_id==$cate_id){
	        		  				echo "<option value=".$value->term_id." selected='selected'  > ". $value->name ."</option>";
	        		  			}
	        		  			else {
	        		  				echo "<option value=".$value->term_id."   > ". $value->name ."</option>";
	        		  			}
	        		  		}
	        		  		?>						   
						</select>
	        		  </div>
	        		  <input type="submit" name="filter_cat" value="Filter Category" class="btn btn-info ">
	        		</div>
	        		
	        		<!-- Text input-->
	        		<div class="form-group">
	        		  <label class="col-md-4 control-label" for="phone">Product</label>  
	        		  <div class="col-md-5">
		    		    <select class="form-control" id="sel1" name="proc">
						   <?php						  
							    if (count($product_lists)>0){
							    	foreach ($product_lists as $key => $value) {
							    		echo "<option value=".$value->ID."  > ". $value->post_title ."</option>";
							    	}
							    }
						    ?>
						</select>
	        		  </div>
	        		</div>
	        		
	        		
	        		<input type="text" name="id" id="id" hidden="true">
	        		<!-- submit -->
	        		<div class="form-group">
	        		  <label class="col-md-4 control-label" for="email"></label> 
	        		    <div class="col-md-5">                        
	        		      <input value="Add Product" name="submit" type="submit"  class="btn btn-info">
	        		    </div>
	        		</div>
	        	</fieldset>
	      	</form>
	      	
	    </div>
	    <div id="menu2" class="tab-pane fade">
	      	<div class="form-group">
	        	<label > </label>
	      	</div>
	      	<form class="form-horizontal" action="" method="POST">
	      		<fieldset>	      	
	      			<!-- Form Name -->
	        		<legend>Shop Statistic</legend>
	        		<h5></h5>
	        		<!-- Text input-->
	        		<div class="form-group">
	        			<label class="col-sm-1 control-label" for="email">Start Date</label>
	        			<div class='col-sm-3'>
			        	    <input type='text' class="form-control" id='datetimepicker4' name="start" />
			        	</div>
			        	<script type="text/javascript">
			        	    jQuery(function () {
			        	        jQuery('#datetimepicker4').datetimepicker();
			        	    });
			        	</script>

			        	<label class="col-sm-1 control-label" for="email">End Date</label>
	        			<div class='col-sm-3'>
			        	    <input type='text' class="form-control" id='datetimepicker5' name="end" />
			        	</div>
			        	<script type="text/javascript">
			        	    jQuery(function () {
			        	        jQuery('#datetimepicker5').datetimepicker();
			        	    });
			        	</script>
			        	<input type="submit" name="statistic_time" value="Statistic By Date" class="btn btn-info ">
			        </div>
			       
	        		<input type="text" name="id" id="id" hidden="true">
	        		<!-- submit -->
	        		<div class="form-group">
	        				<?php  
	        					if (count($stac_time)>0){
	        						echo "<div class='col-md-8'>";
	        					}
	        					else echo "<div class='col-md-6'>"; 
	        				?>
							<div class="heo">
							    <div class="box">
							        <div class="con">
							            <span class="nums"><?=$stac_day['num']?></span><span>Order Completed</span>
							            <br /> In last 30 days
							        </div>
							        <div class="fill speed1" style="background : #42e555; "></div>
							    </div>

							    <div class="box">
							        <div class="con">
							            <span class="nums"><?=$stac_all['num']?></span><span>Order Completed</span>
							            <br /> In Total
							        </div>
							        <div class="fill speed2" style="background : #f4722c;"></div>
							    </div>
							    <?php 
							    	if (count($stac_time)>0) {
							    		echo "<div class='box'>";
							        	echo "<div class='con'>";
							        	echo "<span class='nums'>".$stac_time['num']."</span><span>Order Completed</span>";
							        	echo "<br /> From ".$start." <span> To</span> <span>".$end."</span>";
							        	echo "</div>";
							        	echo "<div class='fill speed3' style='background : #2b6fdb;'></div>";
							    		echo "</div>";
							    	}
							     ?>
							    <div class="box">
							        <div class="con">
							            <span class="nums"><?=$stac_day['tot']?></span><span>$</span>
							            <br /> Earned
							        </div>
							        <div class="fill speed4" style="background : #42e555;"></div>
							    </div>
							    <div class="box">
							        <div class="con">
							            <span class="nums"><?=$stac_all['tot']?></span><span>$</span>
							            <br /> Earned
							        </div>
							        <div class="fill speed5" style="background : #f4722c;"></div>
							    </div>
							    <?php 
							    	if (count($stac_time)>0){
							    		echo "<div class='box'>";
							    		echo "<div class='con'>";
							    		echo "<span class='nums'>".$stac_time['tot']."</span><span>$</span>";
							    		echo "<br /> Earned";
							    		echo "</div>";
							    		echo "<div class='fill speed6' style='background : #2b6fdb;'></div>";
							    		echo "</div>";
							    	}
							    ?>
							</div>
	        			</div>

	        		</div>
	        	</fieldset>
	      	</form>
	      	
	    </div>
	</div>
</div>
<script type="text/javascript">
	jQuery(function() { 
    // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
    jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastTab', jQuery(this).attr('href'));
    });

    // go to the latest tab, if it exists:
    var lastTab = localStorage.getItem('lastTab');
    if (lastTab) {
        jQuery('[href="' + lastTab + '"]').tab('show');
    }
	});
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" ></script>
