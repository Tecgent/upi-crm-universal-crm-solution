<?php 
class UpiCRMOptions extends WP_Widget {
    var $wpdb;
    
    public function __construct() {
	global $wpdb;
	$this->wpdb = &$wpdb;
    }
    
    function get($name) {
	$name = esc_sql ($name);
        return $this->wpdb->get_var("SELECT value FROM ".upicrm_db()."options WHERE name = '$name'");
    }
    
    function add($name, $value) { 
	if (!$this->exists($name)) {
        	$this->wpdb->insert(upicrm_db()."options", array('name' => $name, 'value'=> $value));
        } else {
		$this->update($name, $value);
	}

    }

    function exists($name) {
	$name = esc_sql ($name);
        return ($this->wpdb->get_var("SELECT COUNT(*) FROM ".upicrm_db()."options WHERE name = '$name'") > 0);

    }

    function update($name, $value) { 
        //update webservice
        $this->wpdb->update(upicrm_db()."options", array('value' => $value) , array("name" => $name));
    }
    
    
}
?>
