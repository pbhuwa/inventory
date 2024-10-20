<?php 
$this->locationid = $this->session->userdata(LOCATION_ID);
$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
?>

 <div class="assest-form">

     <form id="FormgeneralAssets" class="form-material" method="post"  action="<?php echo base_url('ams/assets/save_general_assets'); ?>" data-reloadurl='<?php echo base_url('ams/assets/assets_entry/reload'); ?>' >

    <div class="white-box pad-5 assets-title" style="border-color:silver">

        <h4>General Information</h4>

            <input type="hidden" name="id" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />


            <div class="row">

                <?php 

                $sel_locationid=!empty($assets_data[0]->asen_schoolid)?$assets_data[0]->asen_schoolid:'';
                // echo $this->general->location_option(3,'asen_locationid','asen_locationid',$sel_locationid); ?>

                <div class="col-md-3">

                <label>School<span class="required">*</span>:</label>

                <?php 
                if($this->location_ismain=='Y'){
                   $school='';
                  $arr_srch=array('loca_status'=>'O','loca_isactive'=>'Y');
                }else{
                   $school=$this->locationid;
                   $arr_srch=array('loca_status'=>'O','loca_isactive'=>'Y','loca_locationid'=>$this->locationid);
                }
                $locationlist=$this->general->get_tbl_data('*','loca_location',$arr_srch); 
               
                ?>

                    <select class="form-control required_field" name="asen_locationid" id="schoolid">

                       <?php  if($this->location_ismain=='Y'): ?>
                       <option value="">All</option>
                     <?php endif; ?>

                        <?php 

                        if(!empty($locationlist)):

                            foreach ($locationlist as $kl => $loc) {

                             ?>

                             <option value="<?php echo $loc->loca_locationid; ?>" <?php if($sel_locationid==$loc->loca_locationid) echo "selected=selected"; ?>><?php echo $loc->loca_name; ?></option>

                             <?php

                            }

                            ?>

                            <?php

                        endif;

                        ?>

                    </select>

                </div>

                <div class="col-md-3">

                <?php 

                    $db_asen_depid = $parent_dep_id ? $parent_dep_id : (!empty($assets_data[0]->asen_depid) ?$assets_data[0]->asen_depid:'');
                    // print_r($db_asen_depid);
                    // die();

                    ?>

                <label for="departmentid">Department <span class="required">*</span>:</label>

                <div class="dis_tab">

                <select name="asen_depid" id="departmentid" class="form-control required_field select2" style="
    width: 240px;" >

                    <option value="">--All--</option>

                    <?php if(!empty($department_list)): 

                        foreach ($department_list as $kd => $dep):

                    ?>

                    <option value="<?php echo $dep->dept_depid ?>" 
                    
                    <?php if($db_asen_depid==$dep->dept_depid) echo "selected=selected"; ?>
                    >
                            <?php echo $dep->dept_depname ?></option>

                    <?php endforeach; endif; ?>

                </select>

              </div>

            </div>

            <?php 

             $supdepid = !empty($assets_data[0]->asen_depid)?$assets_data[0]->asen_depid:'';

             if(!empty($sub_department)): 

                $displayblock='display:block';

             else:

                $displayblock='display:none';

             endif;

             ?>

            <div class="col-md-3" id="subdepdiv" style="<?php echo $displayblock; ?>" >

                 <label for="example-text">Sub Department:</label>

                  <select name="subdepid" id="subdepid" class="form-control select2" >

                    <?php if(!empty($sub_department)): ?>

                          <option value="">--Select--</option>

                          <?php foreach ($sub_department as $ksd => $sdep):

                            ?>

                            <option value="<?php echo $sdep->dept_depid; ?>" <?php if($sdep->dept_depid==$supdepid) echo "selected=selected"; ?> ><?php echo $sdep->dept_depname; ?></option>

                    <?php endforeach; endif; ?>

                  </select>

            </div>

                     <div class="col-md-3">

                        <label>Room<span class="required"></span>: </label>

                         <input type="text" name="asen_room" class="form-control" value="<?php echo !empty($assets_data[0]->asen_room)?$assets_data[0]->asen_room:''; ?>">
                    </div>


                 <div class="col-md-3">

                        <label><?php echo $this->lang->line('manufacture'); ?></label>

                        <?php 

                            $db_asen_manufacture=!empty($assets_data[0]->asen_manufacture)?$assets_data[0]->asen_manufacture:'';

                        ?>

                        <select class="form-control select2" name="asen_manufacture">

                            <option value="">---select---</option>

                            <?php 

                                if($manufacturers):

                                    foreach ($manufacturers as $kcl => $manu):

                            ?>

                            <option value="<?php echo $manu->manu_manlistid; ?>" <?php if($db_asen_manufacture==$manu->manu_manlistid) echo "selected=selected"; ?>> <?php echo $manu->manu_manlst; ?></option>

                            <?php

                                    endforeach;

                                endif;

                            ?>

                        </select>

                  

                </div>

                <div class="col-md-3">

                     <?php

                        if(DEFAULT_DATEPICKER == 'NP'){

                            $manufacture_date = !empty($assets_data[0]->asen_manufacture_datebs)?$assets_data[0]->asen_manufacture_datebs:DISPLAY_DATE;

                        }else{

                            $manufacture_date = !empty($assets_data[0]->asen_manufacture_datead)?$assets_data[0]->asen_manufacture_datead:DISPLAY_DATE;

                        }

                    ?>

                       



                    <label>Date of manufacture</label>

                    <input type="text" name="asen_manufacture_date" class="form-control <?php echo DATEPICKER_CLASS;?> date" id="asen_manufacture_date"  value="<?php echo $manufacture_date;?>">

                </div>



                <div class="col-md-3">

                   

                        <label><?php echo $this->lang->line('supplier'); ?></label>

                        <?php 

                            $db_asen_distributor=!empty($assets_data[0]->asen_distributor)?$assets_data[0]->asen_distributor:'';

                        ?>

                        <select class="form-control select2" name="asen_distributor">

                            <option value="">---select---</option>

                            <?php 

                                if($distributors):

                                    foreach ($distributors as $kcl => $dist):

                            ?>

                            <option value="<?php echo $dist->dist_distributorid; ?>" <?php if($db_asen_distributor==$dist->dist_distributorid) echo "selected=selected"; ?>> <?php echo $dist->dist_distributor; ?></option>

                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                </div>

                 <div class="col-md-3">

                   

                        <label>Received By</label>

                        <?php 

                            $staff_id=!empty($assets_data[0]->asen_staffid)?$assets_data[0]->asen_staffid:'';

                        ?>

                        <select class="form-control select2" id="received_by" name="received_by">

                            <option value="">---select---</option>

                            <?php 

                                if($staff_list):

                                    foreach ($staff_list as $kcl => $sta):

                            ?>

                            <option value='<?php echo "$sta->stin_staffinfoid@$sta->stin_fname $sta->stin_mname $sta->stin_lname"; ?>' <?php if($staff_id==$sta->stin_staffinfoid) echo "selected=selected"; ?>> <?php echo $sta->stin_fname; ?></option>

                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                </div>

                <div class="col-md-12">
                        <label><?php echo $this->lang->line('remarks'); ?></label>

                        <textarea class="form-control" name="asen_generalremarks" ><?php echo !empty($assets_data[0]->asen_generalremarks)?$assets_data[0]->asen_generalremarks:''; ?></textarea>

                </div>

                <div class="col-md-12">
                        <button type="submit" class="btn btn-info  save"  id="btnSubmitGeneralContinue" data-operation='continue' data-isactive='Y'><?php echo !empty($assets_data)?'Update & Continue':'Save & Continue'; ?></button>

                    </div>
            </div>
     </div>
 </form>
</div>

<script type="text/javascript">
    $('#locationid').addClass('required_field');
</script>

<script type="text/javascript">

    $(document).off('change','#schoolid');
    $(document).on('change','#schoolid',function(e){

        var schoolid=$(this).val();
        var submitdata = {schoolid:schoolid};
        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';


         $('#departmentid').html('');
         $('#subdepid').html('');

         ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);

        function beforeSend(){       

          };

         function onSuccess(jsons){

                    data = jQuery.parseJSON(jsons);

                    if(data.status=='success'){


                     $('#departmentid').html(data.dept_list);     

                    }

                    else{

                        $('#departmentid').html(' <option value="">--All--</option>');

                        $("#departmentid").select2("val", "");
                         $('#subdepdiv').hide();

                        // $("#subdepid").select2("val", "");                             

                    }
                }
    });



   $(document).off('change','#departmentid');
    $(document).on('change','#departmentid',function(e){

        var depid=$(this).val();
        var submitdata = {schoolid:depid};
        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';

       
         $('#subdepid').html('');


         ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);
        function beforeSend(){

          };

         function onSuccess(jsons){

        data = jQuery.parseJSON(jsons);

         if(data.status=='success'){
             // $("#subdepid").select2("val", "");
            $('#subdepdiv').show();

             $('#subdepid').html(data.dept_list);
             $("#subdepid").select2("val", "");

         }else{

             $('#subdepdiv').hide();

            $('#subdepid').html();

         }
        }
    });



</script>

<?php
if($this->location_ismain!='Y'):
 ?>
<script type="text/javascript">
   setTimeout(function () {
      $('#schoolid').change();
    }, 500);

</script>
 <?php 
endif;
 ?>