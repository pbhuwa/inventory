<?php 
$this->locationid = $this->session->userdata(LOCATION_ID);
$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
?>
<style type="text/css">

  .table>tbody>tr>td:not(:last-child), .table>tbody>tr>th {

    vertical-align: middle !important;

    white-space: normal !important;

}

</style>

<?php  $this->load->view('assets/v_assets_common');?> 



<div class="white-box"> 

  <label class="dttable_ttl box-title"><center><?php echo $this->lang->line('assets_list'); ?> </center></label></div>



  <h3 class="box-title"><center>  </center><a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>



  <div class="searchWrapper">



    <div class="">

      <form class="col-sm-12">



        <div class="col-md-2">

          <label><?php echo $this->lang->line('date_selection'); ?>:<span class="required">*</span>:</label>

          <select name="dateSearch" class="form-control required_field" id="dateSearch">

            <option value="">All</option>

            <option value="purchasedate">Purchase Date</option>

            <option value="inservicedate">Inservice Date</option>

            <option value="warrentydate">Warrenty Date</option>

          </select>

        </div>

        <div id="datediv" style="display:none">

          <div class="col-md-2">

            <label><?php echo $this->lang->line('from_date'); ?></label>

            <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>

          </div>

          

          <div class="col-md-2">

            <label><?php echo $this->lang->line('to_date'); ?></label>

            <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>

          </div>

        </div>

        <div class="col-md-2">

          <label><?php echo $this->lang->line('assets_type'); ?></label>

          <select name="asen_assettype" class="form-control select2" id="asen_assettype">

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

         <label><?php echo $this->lang->line('assets_status'); ?></label>

         <select name="asen_status" class="form-control select2" id="asen_status">

          <option value="">All</option>

          <?php

          if($status):

            foreach ($status as $ks => $stat):

              ?>

              <option value="<?php echo $stat->asst_asstid; ?>"><?php echo $stat->asst_statusname; ?></option>

              <?php

            endforeach;

          endif;

          ?>

        </select>

      </div>





      <div class="col-md-2">

       <label><?php echo $this->lang->line('assets_condition'); ?></label>

       <select name="asen_condition" class="form-control select2" id="asen_condition">

        <option value="">All</option>

        <?php

        if($condition):

          foreach ($condition as $ks => $cond):

            ?>

            <option value="<?php echo $cond->asco_ascoid; ?>"><?php echo $cond->asco_conditionname; ?></option>

            <?php

          endforeach;

        endif;

        ?>

      </select>

    </div>

        <div class="col-md-2">

       <label>Assets Description</label>

       <select name="asen_condition" class="form-control select2" id="asen_description">

        <option value="">All</option>

        <?php

        if($descriptuon):

          foreach ($descriptuon as $ks => $desc):

            ?>

            <option value="<?php echo $desc->itli_itemlistid; ?>"><?php echo $desc->itli_itemname; ?></option>

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
     <!-- <div class="col-md-2">

       <label>Department</label>

       <select name="asen_condition" class="form-control select2" id="depid">

        <option value="">All</option>

        <?php

        if($department_list):

          foreach ($department_list as $kd => $dept):

            ?>

            <option value="<?php echo $dept->dept_depid; ?>"><?php echo $dept->dept_depname; ?></option>

            <?php

          endforeach;

        endif;

        ?>

      </select>

    </div> -->



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

    <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>

  </div>

  

  <div class="sm-clear"></div>

</form>

</div>



<div style="margin: 10">

  <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/assets/list_of_assets" data-location="ams/assets/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>



  <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/assets/list_of_assets" data-location="ams/assets/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>

</div>

<div class="clearfix"></div>



</div>

<div class="pad-5">

  <div class="table-responsive">

    <table id="myTable" class="table table-striped">

      <thead>

        <tr>

          <th width="10%"><?php echo $this->lang->line('assets_code'); ?></th>
          <th width="10%"><?php echo $this->lang->line('assets_type'); ?></th>
           <th width="5%">Item Name</th>
          <th width="20%"><?php echo $this->lang->line('description'); ?></th>
          <th width="10%"><?php echo $this->lang->line('serial_no'); ?></th>
          <th width="5%"><?php echo $this->lang->line('condition'); ?></th>
          <th width="6%">Pur. Date</th>
          <th width="5%">Unit Price</th>
         <th width="10%">School</th>
         <th width="10%">Department</th>
         <th width="10%">Supplier</th>
         <th width="10%">Received By</th>

          <th width="5%"><?php echo $this->lang->line('action'); ?></th>

        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>





<script type="text/javascript">

 $(document).ready(function(){

  

  var frmDate=$('#frmDate').val();

  var toDate=$('#toDate').val(); 

  var dateSearch = $('#dateSearch').val();

  var asen_assettype=$('#asen_assettype').val();

  var asen_status=$('#asen_status').val();

  var asen_condition=$('#asen_condition').val();

   var asen_description=$('#asen_description').val();
   var asen_distributor=$('#asen_distributor').val();

   var schoolid=$('#schoolid').val();
   var depid=$('#departmentid').val();
   var subdepid=$('#subdepdiv').val();
   var asen_dispose=$('#asen_dispose').val();
   var staffid=$('#staffid').val();

  var srchtext=$('#id').val();

           // alert(srchtext);
    var dataurl = base_url+"ams/assets/get_assets_list";
    var message='';
    var dtablelist = $('#myTable').dataTable({

            "sPaginationType": "full_numbers"  ,

            

            "bSearchable": false,

            "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],

            'iDisplayLength': 10,

            "sDom": 'ltipr',

            "bAutoWidth":false,

            

            "autoWidth": true,

            "aaSorting": [[0,'desc']],

            "bProcessing":true,

            "bServerSide":true,    

            "sAjaxSource":dataurl,

            "oLanguage": {

             "sEmptyTable":message   

           }, 

           "aoColumnDefs": [

           {

            "bSortable": false,

            "aTargets": [ 0,10 ]

          }

          ],      

          "aoColumns": [
          { "data": "assets_code"},
          { "data": "assets_type"},
          { "data": "itemname"},
          { "data": "description"},
          { "data": "serial_no" },
          { "data": "condition" },
          { "data": "purchase_date" },
          { "data": "rate" },
          { "data": "school" },
          { "data": "depname" },
          { "data": "supplier" },
          { "data": "receiver_name" },
           { "data": "action" }

          

          

          ],

          "fnServerParams": function (aoData) {

            aoData.push({ "name": "frmDate", "value": frmDate });

            aoData.push({ "name": "toDate", "value": toDate });

            aoData.push({ "name": "dateSearch", "value": dateSearch });

            aoData.push({ "name": "asen_assettype", "value": asen_assettype });

            aoData.push({ "name": "asen_status", "value": asen_status });

            aoData.push({ "name": "asen_condition", "value": asen_condition });

            aoData.push({ "name": "asen_description", "value": asen_description });
            aoData.push({ "name": "schoolid", "value": schoolid });
            aoData.push({ "name": "depid", "value": depid });
            aoData.push({ "name": "subdepid", "value": subdepid });
            aoData.push({ "name": "asen_distributor", "value": asen_distributor });
            aoData.push({ "name": "asen_dispose", "value": asen_dispose });
            aoData.push({ "name": "staffid", "value": staffid });

            aoData.push({ "name": "searchtext", "value": srchtext });



          },





      // "fnRowCallback" : function(nRow, aData, iDisplayIndex){

      //        var oSettings = dtablelist.fnSettings();

      //       $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);

      //       return nRow;

      //   },

      "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {

       var oSettings = dtablelist.fnSettings();

       var tblid = oSettings._iDisplayStart+iDisplayIndex +1



       $(nRow).attr('id', 'listid_'+tblid);

     },

   }).columnFilter(

   {

    sPlaceHolder: "head:after",

    aoColumns: [ 

    { type: "text" },

    { type: "text" },

    { type: "text" },

    { type: "text" },

    { type: "text" },

    { type: "text" },

    { type: "text" },

    { type: "text" },

    { type: null },

    { type: null },

    

    ]

  });



   $(document).on('click', '#searchByDate', function() {

    frmDate = $('#frmDate').val();

    toDate = $('#toDate').val();

   dateSearch = $('#dateSearch').val(); 
   asen_assettype = $('#asen_assettype').val();
   asen_status = $('#asen_status').val();
   asen_condition = $('#asen_condition').val(); 
   asen_description = $('#asen_description').val();
   schoolid=$('#schoolid').val();
   depid=$('#departmentid').val();
   subdepid=$('#subdepid').val();
   asen_distributor=$('#asen_distributor').val();
   

    asen_dispose=$('#asen_dispose').val();
    staffid=$('#staffid').val();

    srchtext = $('#srchtext').val();

    

    dtablelist.fnDraw();

  });



 });

</script>



<script type="text/javascript">

  $('.engdatepicker').datepicker({

    format: 'yyyy/mm/dd',

    autoclose: true

  });

  $('.nepdatepicker').nepaliDatePicker();

</script>

<script type="text/javascript">

  $(document).on('change', '#dateSearch', function() {

   var dateSearch = $('#dateSearch').val();

   if(dateSearch!=''){

    $('#datediv').show();



  }else{

    $('#datediv').hide();

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