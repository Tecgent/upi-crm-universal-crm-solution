<?php
if ( !class_exists('UpiCRMAdminGoogleAuth') ):

    class UpiCRMAdminGoogleAuth {
        public function Render() {
	        $UpiCRMOptions = new UpiCRMOptions();
          $UpiCRMUIBuilder = new UpiCRMUIBuilder();
          $UpiCRMWebServiceLib = new UpiCRMWebServiceLib();
          $UpiCRMWebService = NEW UpiCRMWebService();
          $button_text = __('save');

          switch ($_POST['action']) {
              case 'update_googleauth':
                $this->update_googleauth_info();
                  break;
          }
          
          $webs_OBJ = $UpiCRMWebService->get_by_id(1);
?>
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
		$client_id = get_option('upicrm_google_client_id');
    $client_secret = get_option('upicrm_google_secret_id');
	?>

	<h2><?php _e('Google App	:'); ?></h2>
        <form method="POST" class="google_auth" style="margin-bottom:20px;" name="googleauth" class="" action="admin.php?page=upicrm_googleauth">
		<input type="hidden" name="action" value="update_googleauth" />
		<div class="form-group">

			<label style="margin:0;"><?php _e('Client ID:');?> </label>
			<input type="text" style="margin:0;" name="client_id" value="<?php echo $client_id; ?>" /> 
		</div>
		<div class="form-group">
			<label style="margin:0;"><?php _e('Client secret:');?></label>
			<input type="text" style="margin:0;" name="secret_id" value="<?php echo $client_secret; ?>" /> 
 		</div>

		           <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo $button_text; ?>" style="margin-left: 10px;"> 
	</form> 

   
</div>

<?php
        }
          
	function update_googleauth_info() {	
		$UpiCRMOptions = new UpiCRMOptions();
		if (isset($_POST['client_id'])) {
			update_option('upicrm_google_client_id', $_POST['client_id']);
		}

		if (isset($_POST['secret_id'])) {
			update_option('upicrm_google_secret_id', $_POST['secret_id']);
		}
	    

	}

}
    

endif;
?>
