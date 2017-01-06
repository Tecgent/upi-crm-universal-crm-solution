var $j = jQuery.noConflict();

$j(document).ready(function() {
    function upicrm_disableAPiKey() {
        if ($j(".post-service input[name='enable_post_service']:checked").length == 0) {
  	    $j("#apikey").prop('readonly', true);
       }
       else {
  	    $j("#apikey").removeAttr('readonly');
       }
    }

    upicrm_disableAPiKey();

    $j("input[name='enable_post_service']").click(function(e) { 
        upicrm_disableAPiKey();
    });

    $j('form#upi_settings_deletion').submit(function() { 
      if (!$j('#delete_upi').is(':checked')) {
        alert("Please confirm you're sure you're aware that this action is irreversible.");
        return false;
      }
      return confirm("You're about to delete upicrm settings, all data will be lost. Press OK If You're sure.");

    });
});
