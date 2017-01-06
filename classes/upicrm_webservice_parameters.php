<?php 
class UpiCRMWebServiceParameters extends WP_Widget {
    var $wpdb;
    
    public function __construct() {
	global $wpdb;
	$this->wpdb = &$wpdb;
    }
    
    function get() { 
        //get all webservice
        $rows = $this->wpdb->get_results("SELECT * FROM ".upicrm_db()."webservice_parameters ORDER BY `webservice_parameter_id` DESC");
        return $rows;
    }
    
    function add($insertArr) { 
        //add webservice
        $this->wpdb->insert(upicrm_db()."webservice_parameters", $insertArr);
    }
    
    function remove($webservice_parameter_id) {
        //delete webservice
        $this->wpdb->delete(upicrm_db()."webservice_parameters", array("webservice_parameter_id" => $webservice_parameter_id));
    }
    
    function get_by_id($webservice_parameter_id) {
        $rows = $this->wpdb->get_results("SELECT * FROM ".upicrm_db()."webservice_parameters WHERE `webservice_parameter_id`={$webservice_parameter_id}");
        return $rows[0];
    }
    
    function get_by_webservice_id($webservice_id) {
        $rows = $this->wpdb->get_results("SELECT * FROM ".upicrm_db()."webservice_parameters WHERE `webservice_id`={$webservice_id}  ORDER BY `webservice_parameter_id` DESC");
        return $rows;
    }

    function update($updateArr, $webservice_parameter_id) { 
        //update webservice
        $this->wpdb->update(upicrm_db()."webservice_parameters", $updateArr , array("webservice_parameter_id" => $webservice_parameter_id));
    }
    
}
?>