<?php 
	

	if (isset($_GET['shop'])){
		$shop_id = $_GET['shop'];

	}

	$all_product_shop = get_product_shop($shop_id);
	
	if (count($all_product_shop)>0){
		foreach ($all_product_shop as $key => $value) {
			$proc_all[$key] = sm_getproduct_id($value->product_id);
		}				
	}
	

	
 ?>

 <?php 
    if (count($proc_all)>=1){
    $count=1;	 
    foreach ($proc_all as $key => $value) {
    	
    	$prod_id = $value->post->ID;
    	$cates = sm_get_product_cat($prod_id);
    	if ($key==0) echo "<div class='number slide' style='width:100%;' id='fslide'>";
    	else if ($count>1&&$count%10==1) echo "<div class='number slide' style='width:100%;display:none'>";
    	?>
    	<div class='product_inf' style="width: 19.6%!important;display: inline-block; margin-bottom: 20px;">
    		<div>
				<img src='https://chart.googleapis.com/chart?chs=80x80&cht=qr&chl=<?=urlencode(		sm_getlink($prod_id ))?>?shop_id=<?=$shop_id?>&choe=UTF-8'/>							
				<img src='<?=sm_getimage($prod_id)[0]?>' data-id=<?=$prod_id?> height='90' width='130'  />
			</div>
			<div >
				<div >Product Name : <?=$value->post->post_title?> </div>				
				<div >Product  Catebory : <?=$cates->name?> </div>							
				<div >Product  Price: <?=sm_getprice($prod_id)?>  </div>
			</div>
		</div>

		
<?php 

		if ($count%10==0) {echo "</div>"; }

		$count++;

 } } ?>

 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
 <script type="text/javascript">
		function fadeDiv(e,callback){
			e.addClass("animated fadeOutRight");
			callback(e);	
		}

		jQuery(document).ready(function(){
			
			e = jQuery(".entry-content > :first-child" );
				
			setInterval(function(){ 

				e.removeClass();
				e.addClass("animated fadeOutLeft");		

				if(e.next().length !== 0 ){
					e.next().show();
					e.next().removeClass();
					e.next().addClass("animated fadeInRight");
					e = e.next();
				} else {
					e = jQuery(".entry-content > :first-child");
					e.removeClass();
					e.addClass("animated fadeInRight");
				}

				

				console.log(e);
			}, 5000);

		});
		

	</script>
	<style>
		
		.entry-content{
			width: auto;
			overflow: hidden;
			max-height: 600px!important;
			min-height: 420px!important;
		}
		
		.slide{
			top: 0px!important;
		}
		.fadeInRight{

			position: absolute!important;
			top: 0px!important;
			overflow: hidden;
			
		}
	</style>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slidesjs/3.0/jquery.slides.min.js"></script>
<script type="text/javascript">
	
	document.addEventListener("DOMContentLoaded",function(){
      document.getElementsByClassName("entry-content").slidesjs({
       
        play: {
          active: false,
          effect: "slide",
          interval: 2000,
          auto: true,
          swap: true,
          pauseOnHover: false,
          restartDelay: 2500
        }
      });
   
   });
</script> -->

