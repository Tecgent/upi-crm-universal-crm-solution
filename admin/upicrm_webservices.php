<?php
if ( !class_exists('UpiCRMAdminWebServices') ):
    class UpiCRMAdminWebServices{
        public function Render() {
	    $UpiCRMOptions = new UpiCRMOptions();
            $UpiCRMUIBuilder = new UpiCRMUIBuilder();
            $UpiCRMWebServiceLib = new UpiCRMWebServiceLib();
            $UpiCRMWebService = NEW UpiCRMWebService();

            switch ($_POST['action']) {
                case 'save_webservice':
                    $this->saveWebService();
                    $msg = __('changes saved successfully','upicrm');
                    break;
                case 'update_webservice':
                    $this->updateWebService();
                    $msg = __('changes saved successfully','upicrm');
                    break;
		case 'post_service':
		    $this->updatePostService();
		    $msg = __('changes saved successfully','upicrm');
                    break;
            }
            
            $webs_OBJ = $UpiCRMWebService->get_by_id(1);
?>
<script type="text/javascript">
    $j(document).ready(function () {
        pageSetUp();
    })
</script>
    <?php
            if (isset($msg)) {
    ?>
    <div class="updated">
        <p><?php echo $msg; ?></p>
    </div>
    <?php
            }
    ?>

 
        
        <?php
        if ($webs_OBJ->webservice_id > 0) {
            $action = "update_webservice";
            $webservice_url = $webs_OBJ->webservice_url;
            $webservice_status = $webs_OBJ->webservice_status;
            $webservice_charset = $webs_OBJ->webservice_charset;
            $webservice_log = $webs_OBJ->webservice_log;
        }
        else {
            $action = "save_webservice";
        }
        $button_text =  __('Save', 'upicrm');
        ?>
        <h2><strong><?php _e('Outbound Web Service:'); ?> </strong> <?php _e('transmit leads to a remote web service, using POST method.','upicrm'); ?></h2>
	<p> <?php _e('UpiCRM can transmit leads to remote source using HTTP Post method, as shown below:'); ?>
	<ol> <li> <?php _e('URL: http://www.remoteserver.com/programname.php?username=user&password=pwd'); ?> </li>
	<li><?php _e('Status:'); ?></li>
		<ol>
			<li> <?php _e('manual : when choosing “Manually transmit lead to a remote web service” form the leads management table.');?></li>
			<li> <?php _e('Always on : all received leads are immediately transmitted to a remote server.');?> </li>

			<li> <?php _e('On by Auto lead: allows you to set rule for transmitting leads to a remote service by using the “Auto lead management” option on the UpiCRM menu.'); ?> </li>
		</ol>
</p>
        <form method="post" class="form-inline" action="admin.php?page=upicrm_webservices">
           <input type="hidden" name="action" value="<?php echo $action; ?>" />
           <input type="hidden" name="webservice_method" value="1" />
           <input type="hidden" name="webservice_id" value="1" />
           <div class="form-group">
               <label><?php _e('URL:','upicrm'); ?></label>
               <input type="text" name="webservice_url" value="<?php echo $webservice_url; ?>" placeholder="http://" style="margin-right: 10px; height: 29px;" />
           </div>
           <div class="form-group" style="margin-right: 10px;">
               <label><?php _e('Status:','upicrm'); ?></label>
               <?php 
               $UpiCRMUIBuilder->show_dropdown('webservice_status',$UpiCRMWebServiceLib->get_status_arr(),$webservice_status); 
               ?>
           </div>
           <div class="form-group" style="margin-right: 10px;">
               <label><?php _e('encoding:','upicrm'); ?></label>
               <?php 
               $UpiCRMUIBuilder->show_dropdown('webservice_charset',$UpiCRMWebServiceLib->get_charset_arr(),$webservice_charset); 
               ?>
           </div>
            <div class="form-group">
               <label><?php _e('Save Log:','upicrm'); ?></label>
               <?php 
               $saveLog[0] =  __('Not Active', 'upicrm');
               $saveLog[1] = __('Active', 'upicrm');
               $UpiCRMUIBuilder->show_dropdown('webservice_log',$saveLog,$webservice_log); 
               ?>
           </div>
           
           <!--<div class="form-group">
               <label><?php _e('Method:','upicrm'); ?></label>
               <?php 
               $UpiCRMUIBuilder->show_dropdown('webservice_method',$UpiCRMWebServiceLib->get_status_arr(),$selected); 
               ?>
           </div> -->
           <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo $button_text; ?>" style="margin-left: 10px;">  
            <a href="admin.php?page=upicrm_wsp&webservice_id=1" class="btn btn-default" style="margin-top: -1px; margin-left: 5px;">
            <i class="fa fa-cogs"></i> <?php _e('Map Upi Fields to web service parameters','upicrm'); ?> </a>
            <?php
            $logPath = WP_CONTENT_DIR."/uploads/upicrm/log/webservice-1.txt";
            if (file_exists($logPath)) { ?>
                <a href="<?php echo home_url(); ?>/wp-content/uploads/upicrm/log/webservice-1.txt" class="btn btn-default" style="margin-top: -1px; margin-left: 5px;">
                <i class="fa fa-file-o"></i> <?php _e('Show log','upicrm'); ?> </a>
            <?php } ?>
           
        </form>
	
	<?php
		$enable = $UpiCRMOptions->get('enable_post_service');
	?>


	<div style="margin-bottom:40px;"></div>
	<h2><strong> <?php _e('Inbound Web Service:'); ?> </strong><?php _e('Accept leads from remote sources using POST requests');?></h2>
        <form method="POST" class="post-service" style="margin-bottom:20px;" name="post-service" class="" action="admin.php?page=upicrm_webservices">
		<input type="hidden" name="action" value="post_service" />
		<div class="form-group">
			<input style="margin:0;" name="enable_post_service" type="checkbox" value="" <?php echo ($enable == 1? 'checked':'');?> 
			<label style="margin:0;">Enable Service</label>
		</div>
		<div class="form-group">
			<label style="margin:0;"><?php _e('API Key:'); ?></label>
			<input id="apikey" value="<?php echo $UpiCRMOptions->get('post_service_apikey'); ?>" maxlength="250" type="text" name="apikey" />
 		</div>

		           <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo $button_text; ?>" style="margin-left: 10px;"> 
	</form> 

	<p><?php _e('UpiCRM inbound web service allows you to receive leads from external sources using simple HTTP POST request.'); ?></p>
	<p><?php _e('In order to implement this capability, you should enable the inbound web service and set an API key in the “Web Services” section in the UpiCRM menu.'); ?></p>
	<p><?php _e('The POST request should be sent to your WordPress URL (i.e.: www.yourwebsite.com/) with the following query string parameters:'); ?></p>
	
	<ol>
	<li> <?php _e('upicrm_integration_action=save_lead');?></li>
	<li> <?php _e('upicrm_integration_key=your_selected_key'); ?> </li>
	</ol>
	<p><?php _e('The POST data should contain a single value called lead_content_arr, presumed to be a JSON object that contains the lead information, as shown below:');?></p>
	<div style="width:40%; margin-bottom:8px;">
		<code>curl -X POST --data 'lead_content_arr={"Name":"danid", "Email": "bb@cc.com"}' "www.domain.com/wordpress/?upicrm_integration_action=save_lead&upicrm_integration_key=7009381905138906895"</code>
	</div>
	<p><i>for more information or support contact us at <a href="http://www.upicrm.com/support">http://www.upicrm.com/support</a></i></p>
   
</div>

<?php
        }
        
  
        function saveWebService() {
            $UpiCRMWebService = new UpiCRMWebService();
            $insertArr['webservice_method'] = $_POST['webservice_method'];
            $insertArr['webservice_status'] = $_POST['webservice_status'];
            $insertArr['webservice_url'] = $_POST['webservice_url'];
            $insertArr['webservice_charset'] = $_POST['webservice_charset'];
            $insertArr['webservice_log'] = $_POST['webservice_log'];
            $UpiCRMWebService->add($insertArr);
        }
        
        function updateWebService() {
            $UpiCRMWebService = new UpiCRMWebService();
            $updateArr['webservice_method'] = $_POST['webservice_method'];
            $updateArr['webservice_status'] = $_POST['webservice_status'];
            $updateArr['webservice_url'] = $_POST['webservice_url'];
            $updateArr['webservice_charset'] = $_POST['webservice_charset'];
            $updateArr['webservice_log'] = $_POST['webservice_log'];
            $UpiCRMWebService->update($updateArr,$_POST['webservice_id']);
        }
        
	function updatePostService() {
	    $UpiCRMOptions = new UpiCRMOptions();
	    if (isset($_POST['enable_post_service']) && (isset($_POST['apikey']) && !empty($_POST['apikey']) )) {
		$UpiCRMOptions->add('enable_post_service', '1'); 
	    
	    } else {
		$UpiCRMOptions->add('enable_post_service', '0');
	    }

    	    $UpiCRMOptions->add('post_service_apikey', $_POST['apikey']);
	}

        function updateLeadRecieving () {
            
        }

        function wp_ajax_remove_integration_callback() {
            $UpiCRMIntegrations = new UpiCRMIntegrations();
            $UpiCRMIntegrations->remove($_POST['integration_id']);
            die();
        }
        
    }
    

endif;
?>
