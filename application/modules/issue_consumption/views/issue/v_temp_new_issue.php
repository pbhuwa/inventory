<div class="form-group">
    <div class="col-md-3 col-sm-4">
        <label for="example-text">Department :<span class="required">*</span>:</label>
        <?php $department=!empty($depart)?$depart:'';?>
        <select id="depnme" name="sama_storeid"  class="form-control select2" id="depid" >
            <option value="">---select---</option>
            <?php 
                if($depatrment):
                    foreach ($depatrment as $km => $dep):
            ?>
             <option value="<?php echo $dep->dept_depid; ?>"  <?php if($department==$dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>
            <?php
                    endforeach;
                endif;
            ?>
        </select>
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_reqnodb = !empty($new_issue[0]->sama_requisitionno)?$new_issue[0]->sama_requisitionno:''; ?>
        <label for="example-text">Req No. <span class="required">*</span>:</label>
        <div class="dis_tab">
            <input type="text" class="form-control" name="sama_requisitionno"  value="<?php echo $sama_reqnodb; ?>" placeholder="Enter Req No." id="req_no">
      
            <a href="javascript:void(0)" data-id="" data-displaydiv="Distributer" data-viewurl="<?php echo base_url() ?>/stock_inventory/stock_requisition/load_requisition" class="view table-cell width_30 btn btn-success" data-heading="Load Requisition "><i class="fa fa-search"></i></a>
        </div>
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_fyear = !empty($new_issue[0]->sama_fyear)?$new_issue[0]->sama_fyear:CUR_FISCALYEAR; ?>
        <label for="example-text">Fiscal Year :</label>
        <input type="text" class="form-control" name="sama_fyear" id="fiscal_year" value="<?php echo $sama_fyear; ?>" placeholder="Fiscal Year" >
    </div>

    <div class="col-md-3 col-sm-4">
        <?php
            if(DEFAULT_DATEPICKER == 'NP'){
                $sama_billdate = !empty($new_issue[0]->sama_billdatebs)?$new_issue[0]->sama_billdatebs:DISPLAY_DATE;
                $sama_reqdate=!empty($new_issue[0]->sama_requisitiondatebs)?$new_issue[0]->sama_requisitiondatebs:''; 
            }else{
                $sama_billdate = !empty($new_issue[0]->sama_billdatead)?$new_issue[0]->sama_billdatead:DISPLAY_DATE;
                 $sama_reqdate=!empty($new_issue[0]->sama_requisitiondatead)?$new_issue[0]->sama_requisitiondatead:''; 
            } 
        ?>
        <label for="example-text">Issue Date :</label>
        <input type="text" class="form-control" name="issue_date" value="<?php echo $sama_billdate; ?>" placeholder="Enter Issue Date ">
    </div>
</div>

<div class="clearfix"></div> 

<div class="form-group">
    <div class="col-md-3 col-sm-4">
        <label for="example-text">Requisition Date :</label>
        <input type="text" class="form-control" name="requisition_date" value="<?php echo $sama_reqdate; ?>" placeholder="Enter Requisition Date" id="requisition_date">
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_manualbillno=!empty($new_issue[0]->sama_manualbillno)?$new_issue[0]->sama_manualbillno:''; ?>
        <label for="example-text">Issue Number :</label>
        <input type="text" class="form-control float" name="sama_manualbillno" id="issue_no"  value="<?php echo $sama_manualbillno; ?>" placeholder="Enter Issue Number">
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_depname=!empty($new_issue[0]->sama_depname)?$new_issue[0]->sama_depname:''; ?>
        <label for="example-text">Received By :</label>
        <input type="text" class="form-control" name="sama_depname" value="<?php echo $sama_depname; ?>" placeholder="Enter Received By" id="receive_by">
    </div>
</div>

<div class="clearfix"></div> 

<div class="form-group">
    <div class="pad-5" id="DisplayPendingList">
    <div class="table-responsive">
        <table style="width:100%;" class="table purs_table dt_alt dataTable">
            <thead>
                <tr>
                    <th width="5%"> S.No. </th>
                    <th width="10%"> Items Code  </th>
                    <th width="15%"> Items Name </th>
                    <th width="10%"> Unit  </th>
                    <th width="10%"> Volume </th>
                    <th width="10%"> Rem. Qty. </th>
                    <th width="10%"> Stock Qty.</th>
                    <th width="15%"> Remarks</th>
                </tr>
            </thead>
                <tbody id="orderBody">
                    <tr class="orderrow" id="orderrow_1" data-id='1'>
                        <?php $i=1; if($new_issue):
                        foreach ($new_issue as $key => $isu) { ?>
                            
                        <td><?php echo $i; ?></td>

                        <td> 
                            <input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="rede_code[]" value="<?php //echo $isu->rede_itemsid;?>" data-id='1' readonly> 
                        </td>
                        <td>                             
                             <input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="item[]" value="<?php echo $isu->rede_itemsid;?>" data-id='1' readonly> 
                        </td>
                        <td> 
                                <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="particular[]" value="<?php echo $isu->rede_itemsid;?>"  id="rede_unit_1" data-id='1' > 
                        </td>
                        <td> 
                                <input type="text" class="form-control float rede_qty rede_qty" name="unit[]" value="<?php echo $isu->rede_itemsid;?>"  id="rede_qty_1" data-id='1' > 
                        </td>
                        <td> 
                                <input type="text" class="form-control   " id="rede_remarks_1" name="qty[]" value="<?php echo $isu->rede_qty ?>"  data-id='1'> 
                        </td>
                        <td>
                            <input type="text" class="form-control  " id="rede_remarks_1" name="rede_remarks[]" value="<?php echo $isu->rede_total ?>"  data-id='1'>  
                        </td>

                    <?php $i++;
                        } endif;?>
                    </tr> 
                   
                </tbody>
        </table>
    </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="example-text">Remarks: </label>
        <input type="text" name="start_date" class="form-control "  placeholder="Enter Remarks" value="<?php echo !empty($equip_data[0]->rema_reqdatead)?$equip_data[0]->rema_reqdatead:''; ?>" id="ServiceStart">
        <span class="errmsg"></span>
    </div>
</div>

<div class="clearfix"></div>

<script type="text/javascript">
$.fn.pressEnter = function(fn) {  
  
    return this.each(function() {  
        $(this).bind('enterPress', fn);
        $(this).keyup(function(e){
            if(e.keyCode == 13)
            {
              $(this).trigger("enterPress");
            }
        })
    });  
 }; 


$('#req_no').pressEnter(function(){alert('here')})



</script>