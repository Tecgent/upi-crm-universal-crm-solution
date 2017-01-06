<?php
if ( !class_exists('UpiCRMAdminWebServiceParameters') ):
    class UpiCRMAdminWebServiceParameters{
        public function Render() {
            $UpiCRMFields = new UpiCRMFields();
            $UpiCRMWebServiceParameters = new UpiCRMWebServiceParameters();
            $UpiCRMUIBuilder = new UpiCRMUIBuilder();
            
            $list_option = $UpiCRMUIBuilder->get_list_option_minimum();
            $id = (int)$_GET['id'];
            $webservice_id = (int)$_GET['webservice_id'];
            if ($id > 0) {
                $GetParameterOBJ = $UpiCRMWebServiceParameters->get_by_id($id);
            }
            
            switch ($_POST['action']) {
                case 'save_parameter':
                    $this->saveParameter();
                    $msg = __('changes saved successfully','upicrm');
                    break;
                
                case 'update_parameter':
                    $this->updateParameter();
                    $msg = __('update saved successfully','upicrm');
                    break;
            }
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
<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">

            <form class="web-service-form" method="post" action="admin.php?page=upicrm_wsp&webservice_id=<?php echo $webservice_id; ?>"><div class="fields">
                <?php if($id > 0) { ?>
                    <input type="hidden" name="action" value="update_parameter" />
                    <input type="hidden" name="webservice_parameter_id" value="<?php echo $id; ?>" />
                <?php } else { ?>
                    <input type="hidden" name="action" value="save_parameter" />
                <?php } ?>
                   <input type="hidden" name="webservice_id" value="<?php echo $webservice_id; ?>" />
                    
                <div class="item"><label><?php _e('Upi Field Name','upicrm'); ?></label> <select name="field_id">
                                <?php
                                $i = 1;
                                foreach ($list_option as $key => $arr) {
                                    foreach ($arr as $key2 => $value) {
                                        $selected = "";
                                        if ($id > 0)
                                            $selected = selected($GetParameterOBJ->webservice_parameter_option.'||exp||'.$GetParameterOBJ->field_id,$key.'||exp||'.$key2, false);
                                        ?>
                                        <option value="<?php echo $key.'||exp||'.$key2; ?>" <?php echo $selected; ?> ><?php echo $value; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                </select>:</div>   <div class="item"><label><?php _e('Web Service Parameter Name');?></label><input type="text" name="webservice_parameter_value" value="<?php echo $id > 0 ?  $GetParameterOBJ->webservice_parameter_value : ""?>" style="height: 28px; position: relative; top: 2px;" /></div></div>
<div class="submit"><br/><br/>
<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e($id > 0 ? 'Update' : 'Save','upicrm'); ?>"></div>
           </form>
        </div>
    </div>
    <br /><br />
    <section id="widget-grid" class="">
    
    <!-- row -->
    <div id="LeadsRouteTable" class="row">
      <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
             <header>
                        <span class="widget-icon">
                          
                          <i class="fa fa-table">
                          </i>
                          
                        </span>
                        <h2>
                          <?php _e('Web Service Options Table','upicrm'); ?>
                        </h2>
                        
                      </header>
                      
                      <!-- widget div-->
                      <div>
                        
                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                          <!-- This area used as dropdown edit box -->
                          
                        </div>
                        <!-- end widget edit box -->
                        
                        <!-- widget content -->
                        <div class="widget-body no-padding">
                          
                          <table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
                            
                            <thead>
                              <tr>
                                <th data-class="expand">
                                     <?php _e('Upi Field name','upicrm'); ?>
                                </th>
                                <th data-class="expand">
                                     <?php _e('Web service parameter name','upicrm'); ?>
                                </th>
                                <th data-class="expand">
                                     <?php _e('Actions','upicrm'); ?>
                                </th>
                              </tr>
                            </thead>
                            
                            <tbody>
                                <?php 
                                $FieldsArr = $UpiCRMFields->get_as_array();
                                foreach ($UpiCRMWebServiceParameters->get_by_webservice_id($webservice_id) as $obj) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $list_option[$obj->webservice_parameter_option][$obj->field_id]; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj->webservice_parameter_value; ?>
                                        </td>
                                        <td data-belongs="" class="upicrm_lead_actions">
                                            <span class="glyphicon glyphicon-edit" data-callback="edit" data-webservice_parameter_id="<?php echo $obj->webservice_parameter_id; ?>" title="<?php _e('Edit','upicrm'); ?>"></span>
                                            <span class="glyphicon glyphicon-remove" data-callback="remove" data-webservice_parameter_id="<?php echo $obj->webservice_parameter_id; ?>" title="<?php _e('Remove','upicrm'); ?>"></span>
                                        </td>
                                    </tr>   
                               <?php } ?> 
                            </tbody>
							
                          </table>
                          
                        </div>
                        <!-- end widget content -->
                        
                      </div>
                      <!-- end widget div -->
                      
                  </div>
                  <!-- end widget -->
                  
              </article>    
    </div>
    
    
          
          <!-- end row -->
          
          <!-- end row -->
          
          
   </section>
</div>
<script type="text/javascript">
    $j(document).ready(function($) {
        $j("*[data-callback='remove']").click(function() {
                if (confirm("<?php _e('Remove this Options?','upicrm'); ?>")) {
                    GetSelect = $j(this);
                    var data = {
                        'action': 'remove_webservice_parameter',
                        'webservice_parameter_id': $j(this).attr("data-webservice_parameter_id"),
                    };
                    $j.post(ajaxurl, data , function(response) {
                        GetSelect.closest("tr").fadeOut();
                        console.log(response);
                    });
                }
            });
            
        $j("*[data-callback='edit']").click(function() {
            var webservice_parameter_id = $j(this).attr("data-webservice_parameter_id");
            window.location = "admin.php?page=upicrm_wsp&webservice_id=<?php echo $webservice_id; ?>&id="+webservice_parameter_id;
        });

    });
</script>
<?php
        }
        
        function saveParameter() {
            $UpiCRMWebServiceParameters = new UpiCRMWebServiceParameters();
            $field_id = explode('||exp||',$_POST['field_id']);
            $insertArr['webservice_parameter_option'] = $field_id[0];
            $insertArr['field_id'] = $field_id[1];
            
            $insertArr['webservice_id'] = $_POST['webservice_id'];
            $insertArr['webservice_parameter_value'] = $_POST['webservice_parameter_value'];
            $UpiCRMWebServiceParameters->add($insertArr);
        }
        
        function updateParameter() {
            $UpiCRMWebServiceParameters = new UpiCRMWebServiceParameters();
            $field_id = explode('||exp||',$_POST['field_id']);
            $updateArr['webservice_parameter_option'] = $field_id[0];
            $updateArr['field_id'] = $field_id[1];
            
            $updateArr['webservice_id'] = $_POST['webservice_id'];
            $updateArr['webservice_parameter_value'] = $_POST['webservice_parameter_value'];
            $UpiCRMWebServiceParameters->update($updateArr,$_POST['webservice_parameter_id']);
        }
        
        
        function wp_ajax_remove_webservice_parameter_callback() {
            $UpiCRMWebServiceParameters = new UpiCRMWebServiceParameters();
            $UpiCRMWebServiceParameters->remove($_POST['webservice_parameter_id']);
            die();
        }
    }
    
    add_action( 'wp_ajax_remove_webservice_parameter', array(new UpiCRMAdminWebServiceParameters,'wp_ajax_remove_webservice_parameter_callback'));
endif;
?>
