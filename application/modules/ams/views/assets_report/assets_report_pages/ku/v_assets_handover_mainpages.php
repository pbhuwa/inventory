<?php 
$this->locationid = $this->session->userdata(LOCATION_ID);
$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
?>

<div class="searchWrapper">
    <div class="pad-5">
        <form id="asset_search_form"  action="<?php echo base_url('/ams/assets_handover/save_handover_assets') ?>" method="post" data-reloadurl='<?php echo base_url('ams/assets_handover/index/reload') ?>'>
            <div class="form-group">
             <div class="row"> 
                
                <div class="col-md-2">
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
                    <select class="form-control " name="schoolid" id="schoolid">
                      <?php  if($this->location_ismain=='Y'): ?>
                       <option value="">All</option>
                     <?php endif; ?>
                        <?php 
                        if(!empty($locationlist)):
                            foreach ($locationlist as $kl => $loc) {
                             ?>
                             <option value="<?php echo $loc->loca_locationid; ?>" <?php if($school==$loc->loca_locationid) echo "selected=selected"; ?>><?php echo $loc->loca_name; ?></option>
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
                ?>
                <label for="example-text">Department <span class="required">*</span>:</label>
                <div class="dis_tab">
                <select name="depid" id="depid" class="form-control  " >
                    <option value="">--All--</option>
                    <?php if(!empty($department)): 
                        foreach ($department as $kd => $dep):
                        ?>
                        <option value="<?php echo $dep->dept_depid ?>"><?php echo $dep->dept_depname ?></option>

                    <?php endforeach; endif; ?>
                </select>
              </div>
            </div>
            <?php 
             $subdepid=''; 
             if(!empty($sub_department)):
                $displayblock='display:block';
             else:
                $displayblock='display:none';
             endif;
             ?>
            <div class="col-md-3" id="subdepdiv" style="<?php echo $displayblock; ?>" >
                 <label for="example-text">Sub Department:</label>
                  <select name="subdepid" id="subdepid" class="form-control" >
                    <?php if(!empty($sub_department)): ?>
                          <option value="">--All--</option>
                          <?php foreach ($sub_department as $ksd => $sdep):
                            ?>
                            <option value="<?php echo $sdep->dept_depid; ?>" <?php if($sdep->dept_depid==$subdepid) echo "selected=selected"; ?> ><?php echo $sdep->dept_depname; ?></option>
                    <?php endforeach; endif; ?>
                  </select>
            </div>

      <div class="col-md-2">

           <label>Received By</label>

           <select name="staffid" class="form-control select2" id="staffid">

             <option value="">--All--</option>
             <?php 
             if(!empty($receiver_list)):
                foreach($receiver_list as $recl ):
              ?>
              <option value="<?php echo $recl->stin_staffinfoid; ?>"><?php echo $recl->stin_fname.' '.$recl->stin_mname.' '.$recl->stin_lname ?></option>
              <?php
            endforeach;
             endif;
             ?>

           </select>

         </div>
        <div class="col-md-1">
            <label>Limit</label>
            <input type="text" class="form-control" name="limit" value="950" readonly="true">
        </div>

          <div class="col-md-1">
            <label>Operation</label>
            <select name="operation" id="operation" class="form-control">
            <option value="insert">Insert</option>    
            <option value="update">Update</option>    
            <option value="view">View</option>    

            </select>
            
          </div>
           <div class="col-md-1" id="refnodiv" style="display: none">
           <label>Ref.no</label>
           <input type="text" name="refno" id="refno"  class="form-control">
           </div>



     
        <div class="col-md-2">
            <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets_handover/search_assets_record_by_staff"><?php echo $this->lang->line('search'); ?></button>
        </div>
        </div>
        <div class="clearfix"></div> 

        <div id="displayReportDiv"></div>
       </div>
    </form>
  </div>
</div>

<div id="Printable" class="print_report_section printTable">
    <div id="FormDiv_Reprint"></div>  
 </div>
 



 


<script type="text/javascript">
    $(document).off('change','#schoolid');
    $(document).on('change','#schoolid',function(e){
        var schoolid=$(this).val();
        var submitdata = {schoolid:schoolid};
        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';
        // aletr(schoolid);
         $('#depid').html('');

       
         ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);
        function beforeSend(){
                    
                    
          };
         function onSuccess(jsons){
                    data = jQuery.parseJSON(jsons);
                    if(data.status=='success'){
                    $('#subdepdiv').hide();
                     $('#depid').html(data.dept_list);     
                    }
                    else{
                        $('#depid').html(' <option value="">--All--</option>');
                        $("#depid").select2("val", "");
                        $("#subdepid").select2("val", "");
                     
                             
                    }
                   
                }
    });

   $(document).off('change','#depid');
    $(document).on('change','#depid',function(e){
        var depid=$(this).val();
        var submitdata = {schoolid:depid};
        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';
        // aletr(schoolid);
         $("#subdepid").select2("val", "");
         $('#subdepid').html('');
         ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);
        function beforeSend(){
                    
                    
          };
         function onSuccess(jsons){
                    data = jQuery.parseJSON(jsons);
                     if(data.status=='success'){
                        $('#subdepdiv').show();
                         $('#subdepid').html(data.dept_list);
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


 <script type="text/javascript">
    $(document).off('change','#wise_type');
    $(document).on('change','#wise_type',function(e){
        var rpt_wise=$(this).val();
        // alert(rpt_wise);
        // return false;
        if(rpt_wise=='items' || rpt_wise=='category_items'){
            $('#itemdiv').show();
        }else{
            $('#itemdiv').hide();
        }
    });

$(document).off('click','.itemDetail');
$(document).on('click','.itemDetail',function(e){
    var itemid=$(this).data('itli_itemlistid');
    var itemname=$(this).data('itli_itemname');
    var itemcode=$(this).data('itli_itemcode');
    if(itemid){
      var item_marge=itemcode+'|'+itemname;
      $('#itemid').val(itemid);
      $('#itemname').val(item_marge);
      $('#myView').modal('hide');
    }
});

$(document).off('click','#clear');
$(document).on('click','#clear',function(e){
     $('#itemid').val('');
    $('#itemname').val('');
});
</script>


<?php 
if(!empty($loadselect2) && ($loadselect2=='Y')):
?>
<script type="text/javascript">
    $('.select2').select2();
</script>
<?php 
endif;
?>

<script type="text/javascript">
    $(document).off('change','#operation');
    $(document).on('change','#operation',function(e){
        var oper=$(this).val();
        if(oper=='view' || oper=='update'){
            $('#refnodiv').show();
            $('#refno').focus();
        }else{
            $('#refnodiv').hide();
        }
    });
</script>