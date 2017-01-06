<?php 
class UpiCRMWebService extends WP_Widget {
    var $wpdb;
    
    public function __construct() {
	global $wpdb;
	$this->wpdb = &$wpdb;
    }
    
    function get() { 
        //get all webservice
        $rows = $this->wpdb->get_results("SELECT * FROM ".upicrm_db()."webservice ORDER BY `webservice_id` DESC");
        return $rows;
    }
    
    function add($insertArr) { 
        //add webservice
        //$insertArr['external_key'] = sha1($insertArr['external_domain']."/".$_SERVER['HTTP_HOST']);
        $this->wpdb->insert(upicrm_db()."webservice", $insertArr);
    }
    
    function remove($webservice_id) {
        //delete webservice
        $this->wpdb->delete(upicrm_db()."webservice", array("webservice_id" => $webservice_id));
    }
    
    function get_by_id($webservice_id) {
        $rows = $this->wpdb->get_results("SELECT * FROM ".upicrm_db()."webservice WHERE `webservice_id`={$webservice_id}");
        return $rows[0];
    }

    function update($updateArr, $webservice_id) { 
        //update webservice
        $this->wpdb->update(upicrm_db()."webservice", $updateArr , array("webservice_id" => $webservice_id));
    }
    
    function get_by_status($webservice_status) {
        $rows = $this->wpdb->get_results("SELECT * FROM ".upicrm_db()."webservice WHERE `webservice_status`={$webservice_status}");
        return $rows;
    }
    
}
?>