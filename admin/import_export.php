<?php
if ( !class_exists('UpiCRMAdminImportExport') ):
class UpiCRMAdminImportExport{
public function Render() {    
             
    switch ($_GET['action']) {
        case 'import_all':
            $this->importAll();
        break;
        case 'excel_output':
            upicrm_excel_output();
        break;
        case 'excel_fromat_output':
            $this->excel_fromat_output();
        break;
        case 'excel_fromat_upload':
            $this->excel_fromat_upload();
        break;
    }
    require_once get_upicrm_template_path('import_export');
}
    
   
    
    function excel_fromat_output() {
        upicrm_load('excel');
        $UpiCRMLeads = new UpiCRMLeads();
        $UpiCRMUIBuilder = new UpiCRMUIBuilder();
        $UpiCRMFieldsMapping = new UpiCRMFieldsMapping();
        $objPHPExcel = new PHPExcel();
        
        $list_option = $UpiCRMUIBuilder->get_list_option();
        $getLeads = $UpiCRMLeads->get();
        $getNamesMap = $UpiCRMFieldsMapping->get(); 
        $fileName = '/upicrm_format.xlsx';
        $dirName = WP_CONTENT_DIR."/uploads/upicrm"; 
        if (!file_exists($dirName)) {
            mkdir($dirName, 0777, true);
        }
        $t="A";
        foreach ($list_option as $key => $arr) { 
            if ($key == "content") {
                foreach ($arr as $key2 => $value) { 
                    $objPHPExcel->getActiveSheet()->getStyle($t.'1')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->setCellValue($t.'1', $value);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($t)->setWidth(25);
                    $t++;
                }
            } 
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($dirName.$fileName);

        echo '<script>window.onload = function (event) { window.location="'.home_url().'/wp-content/uploads/upicrm/upicrm_format.xlsx"; };</script>';
    }
    
    function importAll() {
        $UpiCRMgform = new UpiCRMgform();
        $UpiCRMwpcf7 = new UpiCRMwpcf7();
        $UpiCRMninja = new UpiCRMninja();
        if($UpiCRMgform->is_active()) {
            $UpiCRMgform->import_all();
        }
        if($UpiCRMwpcf7->is_db_active()) {
            $UpiCRMwpcf7->import_all();
        }
        if ($UpiCRMninja->is_active()) {
            $UpiCRMninja->import_all();
        }
    }
    
    function excel_fromat_upload() {
        $UpiCRMLeads = new UpiCRMLeads();
        $fileName = '/import.xlsx';
        $dirName = WP_CONTENT_DIR."/uploads/upicrm"; 
        
        $file_name = key($_FILES);
        if($_FILES[$file_name]['name']){
            if(!$_FILES[$file_name]['error']) {
                move_uploaded_file($_FILES[$file_name]['tmp_name'], $dirName.$fileName);
                
                upicrm_load('excel');
                $objPHPExcel = PHPExcel_IOFactory::load($dirName.$fileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $i=0;
                $new_records = 1;
                foreach ($sheetData as $sheet) {
                    if ($i == 0) {
                        $field = $sheet;
                    } else {
                        $content = array();
                        $is_empty_sheet = true;
                        foreach ($sheet as $key => $value) {
                            if ($value) {
                                $content[$field[$key]] = $value;
                                $is_empty_sheet = false;
                            }
                        }
                        if (!$is_empty_sheet) {
                            $UpiCRMLeads->add($content, 4, 0, false);
                            $new_records++;
                        }
                    }
                    $i++;
                }
                        ?>
                        <div class="updated">
                            <p>
                            <?php _e('Success!','upicrm'); ?>
                            <?php echo $new_records-1; ?>
                            <?php _e('new records imported into UpiCRM.','upicrm'); ?>
                            </p>
                        </div>
                        <br /><br />
                        <?php
            }
        }
        else {
?>
                        <div class="error">
                            <p>
                            <?php _e('Error occurred, could not import data','upicrm'); ?>
                            </p>
                        </div>
                        <br /><br />
                        <?php
        }

    }
}



endif;