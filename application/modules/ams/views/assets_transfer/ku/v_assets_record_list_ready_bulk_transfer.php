<div class="white-box pad-5 mtop_10 pdf-wrapper ">
<style type="text/css">

  .table>tbody>tr>td:not(:last-child), .table>tbody>tr>th {

    vertical-align: middle !important;

    white-space: normal !important;
  }
.table >tbody >tr >td, .table >tbody >tr >th, .table >tfoot >tr >td, .table >tfoot >tr >th, .table >thead >tr >td, .table >thead >tr >th {
    line-height: 1.11 !important;
}

</style>

      <form id="FormBulkTransferAssetsSave" action="<?php echo base_url('ams/assets_transfer/save_bulk_transfer'); ?>">
     <h2>Bulk Assets Transfer</h2>
    <input type="hidden" name="astm_transfertypeid" value="<?php echo $astm_transfertypeid; ?>">
    <input type="hidden" name="astm_fromschoolid" value="<?php echo $fromlocation; ?>">
    <input type="hidden" name="fromdepid" value="<?php echo $fromdepartment; ?>">
    <input type="hidden" name="fromsubdepid" value="<?php echo $fromsubdepid; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Fiscal Year</label>
                          <select name="astm_fiscalyrs" class="form-control">
                    <?php 
                        if(!empty($fiscal_year)):
                            foreach ($fiscal_year as $kf => $fyrs) {
                              ?>
                              <option value="<?php echo $fyrs->fiye_name; ?>"><?php echo $fyrs->fiye_name; ?></option>
                              <?php
                            }
                        ?>
                        <?php
                            endif; 
                        ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Refno</label>
                        <input type="text" name="astm_transferno" class="form-control" value="<?php echo !empty($transfer_code)?$transfer_code:''; ?>" readonly>
                    </div>
                    <div class="col-md-3">
                          <label>Transfer Date Date</label>
                          <input type="text" name="transferdate"  class="form-control  <?php echo DATEPICKER_CLASS;?>" id="transferdate" value="<?php echo DISPLAY_DATE; ?>">
                    </div>
                    <div class="col-md-3"></div>
               <div class="col-md-12">
                <table class="table table-striped format_pdf" style="margin-top: 13px;border-top: 1px solid #000b;">
                <thead>
                    <tr style="
                            background: radial-gradient(black, transparent);
                            background: linear-gradient(to bottom, #f2f2f2 0%, #ebebeb 42%, #dddddd 47%, #cfcfcf 100%);
                            font-size: 12px;
                            box-shadow: 0 0 8px rgb(0 0 0 / 6%);
                            padding: 4px;
                            color: black !important;
                            transition: all 0.1s ease-in;
                            border: 1px solid #bdbdbd;">
                        <td width="1%"><input type="checkbox" class="checkall"></td>
                        <th width="3%">S.n</th>
                        <th width="5%">System.ID</th>
                        <th width="8%">Assets Code</th>
                        <th width="8%" style="text-align: right;">Category</th>
                        <th width="10%" style="text-align: right;">Item Name</th>
                        <th width="10%" style="text-align: right;">Description</th>
                        <th width="5%" style="text-align: right;">Pur.Date</th>
                        <th width="5%" style="text-align: right;">Unit Price</th>
                        <th width="6%">School</th>
                        <th width="6%">Department</th>
                        <th width="6%">Supplier</th>
                        <th width="7%">Received By</th>
                        <th  width="2%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($staff_assets_record)):
                        $i=1;
                        foreach ($staff_assets_record as $ksr => $ass):
                     ?>
                        <tr id="tr_assets_<?php echo $ass->asen_asenid ?>">
                            <td>
                                <input type="checkbox" name="assetid[]" class="itemcheck" value="<?php echo $ass->asen_asenid ?>" data-id="<?php echo $ass->asen_asenid ?>">
                            </td>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $ass->asen_asenid ?></td>
                            <td><?php echo $ass->asen_assetcode ?></td>
                            <td><?php echo $ass->eqca_category ?></td>
                            <td><?php echo $ass->itli_itemname ?></td>
                            <td><?php echo $ass->asen_desc ?></td>
                            <td><?php echo $ass->asen_purchasedatebs ?></td>
                            <td><?php echo $ass->asen_purchaserate ?></td>
                            <td><?php echo $ass->schoolname ?></td>
                            <td>
                            <?php
                                $parentdep=!empty($ass->depparent)?$ass->depparent:'';
                                 if(!empty($parentdep)){
                                     $depname = $ass->depparent.'/'.$ass->dept_depname;    
                                    }else{
                                        $depname = $ass->dept_depname; 
                                    }
                                 
                               echo $depname;
                            ?>
                            </td>
                           
                            <td>
                                <?php echo $ass->dist_distributor ?>
                            </td>
                            <td>
                                <?php echo $ass->stin_fname.' '.$ass->stin_mname. ' '.$ass->stin_lname ?>
                            </td>
                            <td>
                              <a href="javascript:void(0)" class="btn btn-sm btn-danger btnremoveassets" title="Remove Assets" data-assetsid="<?php echo $ass->asen_asenid ?>">X</a>
                            </td>
                        </tr>
                    <?php
                     $i++;
                        endforeach; endif; ?>
                </tbody>
                <tfoot >
                    <tr id="remove_btntfoot" style="display: none" >
                        <td colspan="14">
                           <a href="javascript:void(0)" class="btn btn-sm btn-danger">Remove</a>
                        </td>
                      
                    </tr>
                    <tr>
                      <td colspan="14" style="border-right: 1px solid white;">
                        <label>Transfer To <span class="required">*</span></label>:
                        <div class="row">
                        <div class="col-md-1">
                      <label>To School</label>
                            <?php 
                            $locationlist=$this->general->get_tbl_data('*','loca_location',array('loca_status'=>'O')); 
                                ?>
                    <select name="to_schoolid" id="to_schoolid" class="form-control">

                    <?php
                    // echo "<pre>";
                    // print_r($locationlist);
                    // die();

                    if(!empty($locationlist)):
                      foreach($locationlist as $loc):
                      ?>
                      <option value="<?php echo $loc->loca_locationid; ?>" ><?php echo $loc->loca_name; ?></option>
                      <?php
                      endforeach;
                    endif;
                     ?>
                </select>
            </div>
            <div class="col-md-1">
                <label>Department To:</label>
                <select name="todepid" class="form-control select2 depselect" id="todepid">
            <option value="">--Select--</option>
            <?php 
            if(!empty($department_list)):
              foreach ($department_list as $ks => $dlist):
                ?>

                <option value="<?php echo $dlist->dept_depid; ?>"><?php echo $dlist->dept_depname; ?></option>
                <?php
              endforeach;
            endif;
            ?>

          </select>
        </div>

            <?php 
             $subdepid=''; 
             if(!empty($sub_department)):
                $displayblock='display:block';
             else:
                $displayblock='display:none';
             endif;
             ?>

            <div class="col-md-1" id="tosubdepdiv" style="<?php echo $displayblock; ?>" >

                 <label for="example-text">To Sub Department:</label>
                  <select name="to_subdepid" id="to_subdepid" class="form-control" >
                    <?php if(!empty($sub_department)): ?>
                          <option value="">--All--</option>
                          <?php foreach ($sub_department as $ksd => $sdep):
                            ?>

                            <option value="<?php echo $sdep->dept_depid; ?>" <?php if($sdep->dept_depid==$subdepid) echo "selected=selected"; ?> ><?php echo $sdep->dept_depname; ?></option>
                    <?php endforeach; endif; ?>
                  </select>
            </div>
            <div class="col-md-1">

       <label>To Received By:</label>
            <select name="astm_receivedstaffid" id="astm_receivedstaffid" class="form-control">
                  <?php if(!empty($staff_list)): ?>

                    <option value="">--All--</option>

                    <?php foreach ($staff_list as $ksd => $stl):

                      ?>

                      <option value="<?php echo $stl->stin_staffinfoid.'@'.$stl->stin_fname; ?>" ><?php echo $stl->stin_fname; ?></option>

                  <?php endforeach; endif; ?>

                </select>
                </div>

        </div>
         <div class="row">
            <div class="col-md-6">              
              <label>Full Remarks</label>
              <textarea name="fullremarks" class="form-control" width="100%" autocomplete="off"></textarea>            
            </div>
     
       <div class="col-md-6"> 
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary save" id="btnsaveandcolse">Save & Close</button>
            <button type="submit" class="btn btn-warning savePrint" id="btnPrintSubmit" data-print="print">Save & Print</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"> 
                <div class="alert-success success"></div>            
                <div class="alert-danger error"></div> 
            </div>
        </div>

        </td>
            </tr>
        </tfoot>
        </table>
    </div>
</div>
</form>
</div>
<div id="Printable" class="print_report_section printTable"> </div>

<script type="text/javascript">

$('.engdatepicker').datepicker({
format: 'yyyy/mm/dd',
  autoclose: true
});

$(document).ready(function(){
  $('.nepdatepicker').nepaliDatePicker({
  npdMonth: true,
  npdYear: true,
  npdYearCount: 10 // Options | Number of years to show
});
});

$(document).off('click','.btnremoveassets');
$(document).on('click','.btnremoveassets',function(e){
  var assetdid=$(this).data('assetsid');
  if(assetdid){
      var conf = confirm("Are you want to remove this assets ?");
    if (conf) {

      $('#tr_assets_'+assetdid).fadeOut(1000, function() {
            $(this).remove();
            });
    }
  }
});

  $(document).off('change','.checkall');
  $(document).on('change','.checkall',function(e){
   if (this.checked) {
            $(".itemcheck").each(function() {
                this.checked=true;
            });
            $('#remove_btntfoot').show();
        } else {
            $(".itemcheck").each(function() {
                this.checked=false;
            });
           $('#remove_btntfoot').hide();
       }
});

 $(document).off('change', '.itemcheck');
    $(document).on('change', '.itemcheck', function(e) {
        // console.log('test');
        var cnt_check = $(".itemcheck:checked").length;
        if (this.checked) {
            $('#remove_btntfoot').fadeIn(500, function() {
                $(this).show();
            });
        } else {
            if (cnt_check < 1) {
                $('#remove_btntfoot').fadeOut(500, function() {
                    $(this).hide();
                });
                $('#checkAll').prop('checked',false);
            }
        }
    });

 $(document).off('click', '#remove_btntfoot');
    $(document).on('click', '#remove_btntfoot', function(e) {
        var conf = confirm("Are you sure you want to remove?");
        if (conf) {
            $(".itemcheck:checked").each(function() {
                var rowid = $(this).data("id");
                console.log(rowid);
                $('#tr_assets_' + rowid).remove();
            });
            $('#remove_btntfoot').fadeOut(500, function() {
                $(this).hide();
            });

        }

    });

setTimeout(function() {
$('#astm_receivedstaffid').select2();
 }, 600);
</script>