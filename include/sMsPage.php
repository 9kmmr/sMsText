<?php
$cuid = get_current_user_id();

$permission = sMs_get_permission_id($cuid)[0];
$thisuser = get_user_by( 'id', $cuid)->data;

//GET ALL OTHER USER
if(!is_user_logged_in()) {
  get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main" style="text-align: center;">

    <div style="width: 300px;margin: 0 auto;text-align: left;">
	    <h1>Please login</h1>
	    <?php
	    wp_login_form();
	    ?>
    </div>
    </main><!-- .site-main -->
  </div><!-- .content-area -->

<?php 
  get_footer(); 
} else {
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SMS Sending Page</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=plugins_url( 'sMsText/assets/css/intlTelInput.css' );?>">
        <link rel="stylesheet" href="<?=plugins_url( 'sMsText/assets/css/main.css' );?>">
        <script src="<?=plugins_url( 'sMsText/assets/js/jquery-3.1.1.min.js' );?>"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?=plugins_url( 'sMsText/assets/js/sms_main.js' );?>"></script>
        <script src="<?=plugins_url( 'sMsText/assets/js/intlTelInput.min.js' );?>"></script>
    </head>

    <body>
        <h1 class="text-center">SMS Sending Page</h1>
        <label for=""></label>
        <?php if ($permission->granted=='1') { ?>
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="icon">
                            <span class="bold" id="profile"><?=$thisuser->display_name?></span>
                            </div>
                        </div>
                        <div class="col-md-offset-1 col-md-4">
                            <span class="bold">Today</span>
                            <div class="date">
                                <span id="time"></span>    
                            </div>
                        </div>
                        <div class="col-md-offset-2 col-md-2">
                            <div class="icon btn-lg"><a href="#" class="glyphicon glyphicon-cog"></a>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="panel-footer">
                    <form>
                        <div class="form-horizontal form-group">
                            <input type="tel" class="form-control" id="phoneto" placeholder="Phone Number Send To">
                            <span id="valid-msg" class="hide">✓ Valid</span>
                            <span id="error-msg" class="hide" style="color:red;">Invalid number</span>
                        </div>
                        <div class="form-horizontal form-group">                           
                            <textarea id="message-text" class="form-control" placeholder="Message" name=""  cols="28" rows="3"></textarea>
                                                  
                        </div>
                        <div class="form-group">                             
                           <input type="button" value="SEND" id="envoi" class="form-control btn btn-success btn-md btn-circle">

                        </div>
                    </form>
                </div>
            </div>

            

        </div>
        <script>
            var telInput = $("#phoneto"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");
            telInput.intlTelInput({
                // allowDropdown: false,
                // autoHideDialCode: false,
                // autoPlaceholder: "off",
                // dropdownContainer: "body",
                // excludeCountries: ["us"],
                // formatOnDisplay: false,
                // geoIpLookup: function(callback) {
                //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                //     var countryCode = (resp && resp.country) ? resp.country : "";
                //     callback(countryCode);
                //   });
                // },
                // hiddenInput: "full_number",
                // initialCountry: "auto",
                // nationalMode: false,
                <?php if ($permission->permission_sms=='0') { ?>
                 onlyCountries: ['lk'],
                <?php }?>
                // placeholderNumberType: "MOBILE",
                // preferredCountries: ['cn', 'jp'],
                // separateDialCode: true,
                utilsScript: "<?=plugins_url( 'sMsText/assets/js/utils.js' );?>"
                });
            var reset = function() {
                    telInput.removeClass("error");
                    errorMsg.addClass("hide");
                    validMsg.addClass("hide");
                  };
                  
                  // on blur: validate
             telInput.blur(function() {
                    reset();
                    if ($.trim(telInput.val())) {
                      if (telInput.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                      } else {
                        telInput.addClass("error");
                        errorMsg.removeClass("hide");
                      }
                    }
                  });
                  
            // on keyup / change flag: reset
            telInput.on("keyup change", reset);
            console.log($("#phoneto").intlTelInput("getNumber"));
            setInterval(function(){
                
                $("#time").text( new Date().toLocaleString());
                }, 
                 1000
                );
        </script>
        <?php  } ?>
    </body>
</html>
<?php } ?>