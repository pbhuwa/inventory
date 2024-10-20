<style type="text/css">

  .table>tbody>tr>td:not(:last-child), .table>tbody>tr>th {

    vertical-align: middle !important;

    white-space: normal !important;
  }
.table >tbody >tr >td, .table >tbody >tr >th, .table >tfoot >tr >td, .table >tfoot >tr >th, .table >thead >tr >td, .table >thead >tr >th {
    line-height: 1.11 !important;
}

</style>

      
     <h2>Assets Handover</h2>
 
           
                <input type="hidden" name="handoverfromstaffid" value="<?php echo $asen_staffid ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Fiscal Year</label>
                          <select name="ashm_fyear" class="form-control">
                    <?php 
                        if(!empty($fiscal)):
                            foreach ($fiscal as $kf => $fyrs) {
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
                        <input type="text" name="ashm_refno" class="form-control" value="<?php echo !empty($refno)?$refno:''; ?>" readonly>
                    </div>
                    <div class="col-md-3">
                          <label>Handover Date</label>
                          <input type="text" name="ashm_handoverdate"  class="form-control  <?php echo DATEPICKER_CLASS;?>" id="ashm_handoverdate" value="<?php echo DISPLAY_DATE; ?>">
                    </div>
                    <div class="col-md-3"></div>
               <div class="col-md-12">
                
              
            <table class="table table-striped format_pdf" style="
    margin-top: 13px;
    border-top: 1px solid #000b;
">
                <thead>
                    <tr style="
    background: radial-gradient(black, transparent);
    background: linear-gradient(to bottom, #f2f2f2 0%, #ebebeb 42%, #dddddd 47%, #cfcfcf 100%);
    font-size: 12px;
    box-shadow: 0 0 8px rgb(0 0 0 / 6%);
    padding: 4px;
    color: black !important;
    transition: all 0.1s ease-in;
    border: 1px solid #bdbdbd;
">
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
                                <input type="checkbox" name="asen_asenid[]" class="itemcheck" value="<?php echo $ass->asen_asenid ?>" data-id="<?php echo $ass->asen_asenid ?>">
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
                      <td colspan="4" style="
    border-right: 1px solid white;
">
                        
                             <label>Handover To <span class="required">*</span></label>:
                              <select name="handoverstaffid" class="required_field form-control" id="handoverstaffid">

                             <option value="">--Select--</option>
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
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary save" id="btnsaveandcolse" data-operation='<?php echo 'save'  ?>' >Save & Close</button>
                             <button type="submit" class="btn btn-warning savePrint" id="btnPrintSubmit" data-operation='<?php echo 'save'  ?>' data-print="print">Save & Print</button>
                        </td>
                        <td colspan="10">
                         <div class="alert-success success"></div>            
                         <div class="alert-danger error"></div>     
                        </td>
                    </tr>

                </tfoot>
               
            </table>
            </div>
        </div>
 

<script type="text/javascript">
    $('#handoverstaffid').select2();

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

</script>

