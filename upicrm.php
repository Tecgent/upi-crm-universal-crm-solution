<?php
/*
Plugin Name: UpiCRM - Universal WordPress CRM Solution
Text Domain: upicrm
Domain Path: /languages
Plugin URI: http://www.upicrm.com?utm_source=plpage
Description: UpiCRM is a universal WordPress CRM solution can interface and extend the most popular WordPress contact forms plugins, and provide a complete CRM solution

Version: 2.1.7.8
Author URI: http://www.upicrm.com

Copyright 2014  UpiCRM.com, Inc.    (email : info@upicrm.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 3 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software.
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
@session_start();
//error_reporting(E_NOTICE);
/** Plugin Version */
define('UPICRM_VERSION', '2.1.7.7');
define('UPICRM_PATH', trailingslashit(dirname(__FILE__)) );
define('UPICRM_DIR', trailingslashit(dirname(plugin_basename(__FILE__))) );
define('UPICRM_URL', plugin_dir_url(dirname(__FILE__)) . UPICRM_DIR );

$upicrm_db_version = 62;

/* Source type name:  */
$SourceTypeName[1] = "Gravity Forms";
$SourceTypeName[2] = "Contact Form 7";
$SourceTypeName[3] = "Ninja Forms";
$SourceTypeName[4] = "UpiCRM Integrations"; //use it for excel import as well
$SourceTypeName[5] = "Caldera Forms";

/* Source type IDs:  */
$SourceTypeID['gform'] = 1;
$SourceTypeID['wpcf7'] = 2;
$SourceTypeID['ninja'] = 3;
$SourceTypeID['upi_integration'] = 4;
$SourceTypeID['caldera'] = 5;

set_include_path('./resources/includes'); 

require_once( plugin_dir_path( __FILE__ ) . 'upicrm_setup.php' );

function upicrm_db() {
	global $wpdb; 
	return $wpdb->prefix."upicrm_";
}

add_action('plugins_loaded', 'upicrm_load_textdomain' );
function upicrm_load_textdomain() {
    load_plugin_textdomain( 'upicrm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

/* Setup */
register_activation_hook(__FILE__,'upicrm_setup_plugin');
add_action( 'plugins_loaded', 'upicrm_update_db_check' );
//register_deactivation_hook(__FILE__,'upicrm_remove_plugin'); //delete this line!

/*function upicrm_add_to_head_tag() {
    echo '<script>var $j = jQuery.noConflict();alert(1);</script>';
}
add_action('wp_head', 'upicrm_add_to_head_tag');*/

require_once( plugin_dir_path( __FILE__ ) . 'functions.php' ); 

/* Classes */
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_leads.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_fields.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_fields_mapping.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_leads_status.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_users.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_ui_builder.php');
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_mails.php');
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_statistics.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_leads_route.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_integrations.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_webservice.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_webservice_parameters.php' );
require_once( plugin_dir_path( __FILE__ ) . 'classes/upicrm_options.php' ); 

/* Libraries */
require_once( plugin_dir_path( __FILE__ ) . 'libraries/upicrm_gravity_forms.php' );
require_once( plugin_dir_path( __FILE__ ) . 'libraries/upicrm_contact_form_7.php' );
require_once( plugin_dir_path( __FILE__ ) . 'libraries/upicrm_ninja_forms.php' );
require_once( plugin_dir_path( __FILE__ ) . 'libraries/upicrm_integrations.php' );
require_once( plugin_dir_path( __FILE__ ) . 'libraries/upicrm_caldera_form.php' );
require_once( plugin_dir_path( __FILE__ ) . 'libraries/upicrm_webservice.php' );

if ( is_admin() ) {  
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_admin.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/dashboard_admin.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_admin_lists.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_settings.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_existing_fields.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_existing_statuses.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_email_notifications.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_edit_lead.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_api.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_lead_route.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_integrations.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_googleauth.php' );

     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_webservices.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_admin_users.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/import_export.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_admin_warp.php' );
     require_once( plugin_dir_path( __FILE__ ) . 'admin/upicrm_wsp.php' );
     
     $UpiCRMAdmin = new UpiCRMAdmin();
}

if (!isset($_SESSION['upicrm_referer']))
    $_SESSION['upicrm_referer'] = upicrm_get_referer();

if (!isset($_SESSION['utm_source']) && isset($_GET['utm_source']))
    $_SESSION['utm_source'] = $_GET['utm_source'];

if (!isset($_SESSION['utm_medium']) && isset($_GET['utm_medium']))
    $_SESSION['utm_medium'] = $_GET['utm_medium'];

if (!isset($_SESSION['utm_term']) && isset($_GET['utm_term']))
    $_SESSION['utm_term'] = $_GET['utm_term'];

if (!isset($_SESSION['utm_content']) && isset($_GET['utm_content']))
    $_SESSION['utm_content'] = $_GET['utm_content'];

if (!isset($_SESSION['utm_campaign']) && isset($_GET['utm_campaign']))
    $_SESSION['utm_campaign'] = $_GET['utm_campaign'];

if (isset($_GET['upicrm_integration_action']) && isset($_GET['upicrm_integration_key'])) {
    $UpiCRMIntegrationsLib = new UpiCRMIntegrationsLib();
    $UpiCRMIntegrationsLib->route($_GET['upicrm_integration_action'],$_GET['upicrm_integration_key']);
}


if (@substr($_GET['page'],0,6) == "upicrm") {
    /*function upicrm_remove_script_fix() {
        // Print all loaded Scripts
        global $wp_scripts;
        foreach ($wp_scripts->queue as $key => $value) {
            //echo $value."<br />";
            $unset = false;
            switch ($value) {
                case "icl-admin-notifier":
                    $unset = true;
                break;
                case "wp-color-picker-alpha":
                    $unset = true;
                break;
            
            }
            if ($unset) {
                unset($wp_scripts->queue[$key]); 
            }
        }
        
        //unset($wp_scripts->queue[22]);
    }
    add_action( 'wp_print_scripts', 'upicrm_remove_script_fix' );*/
    
    function  upicrm_script_white_list() {
        global $wp_scripts;
        $save_script[] = "common";
        $save_script[] = "upicrm_jquery";
        $save_script[] = "upicrm_jquery_ui";
        $save_script[] = "jquery-ui-widget";
        $save_script[] = "jquery-ui-tabs";
        $save_script[] = "upicrm_js_sparkline";
        $save_script[] = "upicrm_js_app";
        $save_script[] = "upicrm_js_bootstrap";
        $save_script[] = "upicrm_js_bootstrap_multiselect";
        $save_script[] = "upicrm_js_jarvis";
        $save_script[] = "upicrm_js_dataTable";
        $save_script[] = "upicrm_js_colVis";
        $save_script[] = "upicrm_js_tableTools";
        $save_script[] = "upicrm_js_tablebootstrap";
        $save_script[] = "upicrm_js_responsive";
        $save_script[] = "upicrm_js_main";
        $save_script[] = "upicrm_googleapi";

      	$save_script[] = "upicrm_js_admin";
        $save_script[] = "admin-bar";
        $save_script[] = "utils";
        $save_script[] = "svg-painter";
        $save_script[] = "wp-auth-check";
        foreach ($wp_scripts->queue as $key => $value) {
            $save_bol = false;
            foreach ($save_script as $save) {
                if ($save == $value) {
                    $save_bol = true;
                }
            }
            if (!$save_bol) {
                unset($wp_scripts->queue[$key]); 
            }
            
        }
    }

    add_action( 'wp_print_scripts', 'upicrm_script_white_list' );
 }
 
$UpiCRMFields = new UpiCRMFields();
define('UPICRM_FIELDS_ARR', serialize($UpiCRMFields->get_as_array()) );
