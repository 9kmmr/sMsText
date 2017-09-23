<?php
/*
Plugin Name: sMsText
Author: Vu Tung Lam
Description: This is a Plugin for texting to phone
Version: 1.0 
Author URI: www.vn.freelancer.com/u/nddungha.html

*/

//register bootstrap framework

/**
 * Register style sheet.
 */


function sMsT_register_plugin_styles() {
    
    //wp_register_style( 'bootstrap-theme', plugins_url('basic-pluginn/assets/vendor/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css' ) );
    wp_register_style( 'main-css', plugins_url('sMsText/assets/css/main.css' ) );

    wp_register_style( 'toggle-css', plugins_url('sMsText/assets/css/bootstrap-toggle.min.css' ) );

    wp_register_style( 'table-css', plugins_url('sMsText/assets/css/dataTables.bootstrap.min.css' ) );

    wp_enqueue_style( 'table-css' );

    
    wp_enqueue_style( 'bootstrap-theme' );
    wp_enqueue_style( 'main-css' );

    wp_enqueue_style( 'toggle-css' );
}
add_action( 'admin_enqueue_scripts', 'sMsT_register_plugin_styles' );

function sMsT_register_js_script() {
    //get some external script that is needed for this script
    wp_enqueue_script('jquery', plugins_url('sMsText/assets/js/jquery-3.1.1.min.js')) ; 
    
    wp_enqueue_script('bootstrap-js', plugins_url('sMsText/assets/vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js'));

    wp_enqueue_script('main-js', plugins_url('sMsText/assets/js/sms_main.js'));

    wp_enqueue_script('toggle-js', plugins_url('sMsText/assets/js/bootstrap-toggle.min.js'));

    wp_enqueue_script('jquery-table-js', plugins_url('sMsText/assets/js/jquery.dataTables.min.js'));

    wp_enqueue_script('datatable-js', plugins_url('sMsText/assets/js/dataTables.bootstrap.min.js'));  

    wp_enqueue_script('jquery-table-js');

    wp_enqueue_script('datatable-js');

    wp_enqueue_script('toggle-js');

    wp_enqueue_script('jquery');

    wp_enqueue_script('bootstrap-js');

    wp_enqueue_script('main-js');    
     
}
add_action("admin_enqueue_scripts", "sMsT_register_js_script");


function dm_load_dashicons_front_end() {
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'dm_load_dashicons_front_end' );

// register and set view

function sms_manager_View(){

    include  plugin_dir_path( __FILE__ ).'include/admin-setting.php';

}
function register_style_onload(){
    wp_register_style( 'bootstrapss', plugins_url('sMsText/assets/vendor/bootstrap-3.3.7-dist/css/bootstrap.css' ) );
    wp_enqueue_style( 'bootstrapss' );
}
//register plugin page to menu
function Register_sMsText_Page(){
    
    add_menu_page( 
        __( 'sMs Manager', 'sms_manager' ),
         __( 'sMs Manager', 'sms_manager' ),
        'manage_options',
        'sms_manager_Views',
        'sms_manager_View',
        'dashicons-format-status' ,
        25
    );
    
}

add_action( 'admin_menu', 'Register_sMsText_Page' );
/**
*/
// check db and install
global $jal_db_version;
$jal_db_version = '1.0';

function sMsT_db_install() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'sMsText';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id  INT NOT NULL AUTO_INCREMENT,
        UID  INT NOT NULL ,
        granted INT DEFAULT '0' NOT NULL,
        quota INT DEFAULT '0' NOT NULL,
        permission_sms INT DEFAULT '0' NOT NULL,
       
        PRIMARY KEY  (id)
        ) $charset_collate;       

    ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );    
    add_option( 'sMsT_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'sMsT_db_install' );

register_uninstall_hook( __FILE__, 'sMsT_prefix_uninstall' );

function sMsT_prefix_uninstall(){
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'sMsText';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "DROP TABLE IF EXISTS ".$table_name ." ; " ;     

    $wpdb->query( $sql );     

    delete_option('sMsT_db_version');
}

function sMsT_update_db_check() {
    global $jal_db_version;
    if ( get_site_option( 'sMsT_db_version' ) != $jal_db_version ) {
        sMsT_db_install();
    }
}
add_action( 'plugins_loaded', 'sMsT_update_db_check' );
//sesion
function session_init() {
    if (!session_id()) {
    session_start();
    }
}
add_action( 'init', 'session_init' );
// get post with shop id and hook view

/** first insert user to permission table when install plugin */
function check_status_all(){
	$alluser = get_users();
	$alldata = array();
	$olddata = sMs_get_permission();
	if (count($olddata)>0) {
		foreach ($olddata as $key => $value) {
			$alldata[count($alldata)] = $value->UID;			
		}
	}	
	foreach ($alluser as $key => $value) {
		//print_r($value);
		if (!in_array($value->ID, $alldata))  sMs_insert_permission($value->ID);
	}
}
add_action( 'wp_loaded', 'check_status_all' );

/** get all permission from smstext table */
function sMs_get_permission(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'sMsText';
    $sql = " SELECT * FROM " .$table_name. " ; ";     
    return $wpdb->get_results($sql);
}
/**   get all permission join with user table  */
function sMs_get_all_permission(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'users';
    $table_name2 = $wpdb->prefix . 'sMsText';
    $sql = " SELECT * FROM `" .$table_name. "` INNER JOIN `".$table_name2."` ON  `".$table_name."`.`ID` = `".$table_name2."`.`UID` ; ";     
    return $wpdb->get_results($sql);
}
/** get permission with user id*/
function sMs_get_permission_id($id){
    global $wpdb;
    $table_name = $wpdb->prefix . 'sMsText';
    $sql = " SELECT * FROM " .$table_name. " WHERE UID =  '".$uid."'; ";     
    return $wpdb->get_results($sql);
}
/** Insert first permission when user created */
function sMs_insert_permission($uid){
    global $wpdb;
	$table_name = $wpdb->prefix . 'sMsText';   
    $sql = "INSERT INTO $table_name(`UID`) VALUES ($uid); ";
    return $wpdb->query($sql);
}
/**update quota  */
function sMs_update_quota($id_permission, $quota){
    global $wpdb;
    $table_name = $wpdb->prefix . 'sMsText';
    $sql = " UPDATE " .$table_name. " SET  quota = '" .$quota. "' WHERE id = " .$id_permission. " ;";
    return $wpdb->query($sql);
}
/** update granted */
function sMs_update_granted($id_permission, $granted){
    global $wpdb;
    $table_name = $wpdb->prefix . 'sMsText';
    $sql = " UPDATE " .$table_name. " SET  granted = '" .$granted. "' WHERE id = " .$id_permission. " ;";
    return $wpdb->query($sql);
}
/** update  sms type*/
function sMs_update_smstype($id_permission, $permission_sms){
    global $wpdb;
    $table_name = $wpdb->prefix . 'sMsText';
    $sql = " UPDATE " .$table_name. " SET  permission_sms = '" .$permission_sms. "' WHERE id = " .$id_permission. " ;";
    return $wpdb->query($sql);
}
