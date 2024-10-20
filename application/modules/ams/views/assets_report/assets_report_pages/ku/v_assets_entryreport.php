<?php 
$this->locationid = $this->session->userdata(LOCATION_ID);
$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
?>

<div class="searchWrapper">
    <div class="pad-5">
        <form id="asset_search_form">
            <div class="form-group">
                <div class="row"> 
                <div class="col-md-2">
                    <label> Assets Category:</label>
                    <select name="asset_category" class="form-control" id="categoryid">
                    <option value="">All</option>
                    <?php
                    if($material):
                        foreach ($material as $ks => $mat):
                            ?>
                            <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>"><?php echo $mat->eqca_category; ?></option>
                            <?php
                        endforeach;  
                    endif;
                    ?>
                </select>
                </div>
            

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
                    <select class="form-control required_field" name="school" id="schoolid">
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
                <select name="departmentid" id="departmentid" class="form-control required_field " >
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
                    <label>Purchase Date</label>
                    <select class="form-control" name="purdatetype" id="purdatetype">
                        <option value="all">All</option>
                        <option value="range">Range</option>
                    </select>
                </div>
                <div class="col-md-1 purdatediv" style="display: none" >
                    <label>From</label>
                    <input type="text" name="fromdate" class="form-control  <?php echo DATEPICKER_CLASS; ?>" id="fromdate" value="<?php echo CURMONTH_DAY1; ?>" >
                </div>
                <div class="col-md-1 purdatediv" style="display: none">
                    <label>To</label>
                    <input type="text" name="todate" class="form-control  <?php echo DATEPICKER_CLASS; ?>" id="todate" value="<?php echo CURDATE_NP; ?>">
                </div>
             <div class="col-md-2">

       <label>Is Disposal ?</label>

       <select name="asen_dispose" class="form-control" id="asen_dispose">

         <option value="">All</option>

         <option value="N" selected="selected">No</option>

         <option value="Y">Yes</option>

       </select>

     </div>
     <div class="col-md-2">
      <label>Supplier</label>
      <select name="asen_distributor" id="asen_distributor" class="form-control select2">
        <option value="">---All---</option>
        <?php 
          if(!empty($distributors)): 
            foreach ($distributors as $kd => $dis) {
          ?>
          <option value="<?php echo $dis->dist_distributorid; ?>"><?php echo $dis->dist_distributor; ?></option>
          <?php
            }
        ?>
          
        <?php endif; ?>
      </select>
     </div>

      <div class="col-md-2">

           <label>Received By</label>

           <select name="asen_staffid" class="form-control select2" id="staffid">

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
            
            <div class="col-md-2">
            <label>Report Type</label>
            <select name="report_type" class="form-control">
                <option value="summary">Summary</option>
                <option value="detail">Detail</option>
            </select>
          </div>
        <div class="col-md-2">
            <label>Report Wise</label>
            <select name="wise_type" class="form-control" id="wise_type">
            <option value="default">Default</option>    
            <option value="items">Items</option>    
            <option value="school">School</option>
            <option value="department">Department</option>
            <option value="category">Category Wise</option>
              <option value="category_items">Category+Item Wise</option>
            <option value="department_category">Department+Category Wise</option>
            <option value="supplier">Supplier</option>
            <option value="purchase_date">Purchase Date</option>
            <option value="receiver">Receiver</option>

            </select>
        </div> 
           <div class="col-md-2" id="itemdiv" style="display: none;">
                    <label>Item</label>
                    <div class="dis_tab">   
                    <input type="text" class="form-control" name="itemname" id="itemname" value="">
                    <input type="hidden" name="itemid" id="itemid" value="">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item_life_cycle/list_of_item'); ?>"><strong>...</strong></a>
                     <a href="javascript:void(0)" class="table-cell width_30" style="font-size: 16px;font-weight: bold;color: #ea2d2d;" title="Clear" id="clear"> X </a>
                    </div>
                </div>

          <div class="col-md-2">
            <label>Print Orientation</label>
            <select name="page_orientation" class="form-control">
                <option value="P">Portrait </option>
                <option value="L">Landscape</option>
            </select>
          </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets_report/search_assets"><?php echo $this->lang->line('search'); ?></button>
        </div>
        </div>
       </div>
    </form>
  </div>
</div>
<div class="clearfix"></div> 
<div id="displayReportDiv"></div>

<script type="text/javascript">
$(document).off('change','#purdatetype');
$(document).on('change','#purdatetype',function(e){
var ptype=$(this).val();
if(ptype=='range'){
    $('.purdatediv').show();
}else{
    $('.purdatediv').hide();
}
});
</script>


<script type="text/javascript">
    $(document).off('change','#schoolid');
    $(document).on('change','#schoolid',function(e){
        var schoolid=$(this).val();
        var submitdata = {schoolid:schoolid};
        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';
        // aletr(schoolid);
         $('#departmentid').html('');

       
         ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);
        function beforeSend(){
                    
                    
          };
         function onSuccess(jsons){
                    data = jQuery.parseJSON(jsons);
                    if(data.status=='success'){
                    $('#subdepdiv').hide();
                     $('#departmentid').html(data.dept_list);     
                    }
                    else{
                        $('#departmentid').html(' <option value="">--All--</option>');
                        $("#departmentid").select2("val", "");
                        $("#subdepid").select2("val", "");
                     
                             
                    }
                   
                }
    });

   $(document).off('change','#departmentid');
    $(document).on('change','#departmentid',function(e){
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