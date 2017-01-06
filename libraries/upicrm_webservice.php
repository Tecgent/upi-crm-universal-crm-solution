<?php
class UpiCRMWebServiceLib {
   
    function get_status_arr() {
        return array(
            0 => __('Manual', 'upicrm'),
            1 => __('Always On', 'upicrm'),
            2 => __('On By Auto Lead', 'upicrm'),
        );
    }
    
    function get_charset_arr() {
        return array(
            'UTF-8' => 'UTF-8',
            'ISO-8859-1' => 'ISO-8859-1',
            'Windows-1251' => 'Windows-1251',
            'Windows-1255' => 'Windows-1255',
            'GB2312' => 'GB2312',
        );
    }
    
    function send($lead_id,$webservice_status) {
        $UpiCRMWebService = new UpiCRMWebService();
        $UpiCRMLeads = new UpiCRMLeads();
        $UpiCRMFieldsMapping = new UpiCRMFieldsMapping();
        $UpiCRMUIBuilder = new UpiCRMUIBuilder();
        $UpiCRMWebServiceParameters = new UpiCRMWebServiceParameters();
        
        $ws_OBJ = $UpiCRMWebService->get_by_status($webservice_status);
        $ws_parameter_OBJ = $UpiCRMWebServiceParameters->get();
        $getLeads = $UpiCRMLeads->get_by_id($lead_id);
        $listOption = $UpiCRMUIBuilder->get_list_option(); //get UI options & existing fields
        $getNamesMap = $UpiCRMFieldsMapping->get_all_by($getLeads->source_id, $getLeads->source_type); //get lead fields mapping
        foreach ($ws_OBJ as $webservice) {
            $content_ARR = array();
            foreach ($listOption as $key => $list_option) {
                foreach ($list_option as $key2 => $field_name) {
                    $value = $UpiCRMUIBuilder->lead_routing($getLeads, $key, $key2, $getNamesMap, true);
                    foreach ($ws_parameter_OBJ as $parameter) {
                        if ($parameter->webservice_id == $webservice->webservice_id && $value != "" &&  $key2 == $parameter->field_id && $key == $parameter->webservice_parameter_option) {
                           $content_ARR[$parameter->webservice_parameter_value] = $value;
                        }
                    }
                }
            }
        }
        $this->do_routing($webservice,$content_ARR,$lead_id);
    }
                     
    
    function do_routing($webservice,$content_ARR,$lead_id) {
        switch ($webservice->webservice_method) {
            case 1:
                $this->send_post($webservice->webservice_url,$content_ARR,$webservice->webservice_charset,$webservice,$lead_id);
            break;
        }
    }
    
    function send_post($url,$post=false,$charset='UTF-8',$webservice,$lead_id) {
        header('Content-type: text/html; charset='.$charset);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($post) {
            //$post = array_map('urlencode', $post);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_REFERER, get_site_url());
        $result = curl_exec($ch);
        curl_close($ch);
        if ($webservice->webservice_log == 1) {
            $fileName = '/webservice-'.$webservice->webservice_id.'.txt';
            $dirName = WP_CONTENT_DIR."/uploads/upicrm/log"; 
            if (!file_exists($dirName)) {
                mkdir($dirName, 0777, true);
            }
            $handle = fopen($dirName.$fileName, 'w');
            $write = $result;
            fwrite($handle, $write);
        }
        
        $UpiCRMLeads = new UpiCRMLeads();
        $updateArr['lead_webservice_transmission'] = substr(strip_tags($result), 0, 299);
        $UpiCRMLeads->update_by_id($lead_id,$updateArr);
        
        return $result;
    }

   
}

?>