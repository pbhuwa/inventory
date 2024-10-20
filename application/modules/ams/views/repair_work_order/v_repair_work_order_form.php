<form method="post" id="RepairWorkOrderForm" action="<?php echo base_url('ams/repair_work_order/save_repair_work_order'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('ams/repair_work_order/index/reload'); ?>" enctype="multipart/form-data"  accept-charset="utf-8" >
    <div id="orderData">
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="rerm_repairrequestmasterid" id="rerm_repairrequestmasterid" value="" />
        <div class="form-group">
            <div class="col-md-3 col-sm-3">
                <?php // $fiscalyear=!empty($order_details[0]->puor_fyear)?$order_details[0]->puor_fyear:''; ?>
                <label><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
                <select name="fiscalyear" class="form-control select2" id="fiscalyear" >
                        <?php
                            if(!empty($fiscal)):
                                foreach ($fiscal as $km => $fy):
                        ?>
                    <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                        <?php
                                endforeach;
                            endif;
                        ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-3">
            <?php $repair_request_no=''; ?>
            <label>Enter Repair Request No.<span class="required">*</span>:</label>
            <div class="dis_tab">
                <input type="hidden" name="rewm_repairrequestmasterid" value="" id="rewm_repairrequestmasterid">
                <input type="text" class="form-control required_field enterinput"  name="repair_request_no" value="<?php echo $repair_request_no; ?>" placeholder="Enter Repair Request No." id="repair_request_no" data-targetbtn='btnSearchRepairRequestno'>
                <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchRepairRequestno" ><i class="fa fa-search"></i></a>
                &nbsp;
              <!--   <a href="javascript:void(0)" data-id="0" data-displaydiv="Issue" data-viewurl="<?php //echo base_url('ams/repair_work_order/load_repair_request_list'); ?>" class="view table-cell width_30 btn btn-success" data-heading="Load Repair Request List" id="orderload"><i class="fa fa-upload"></i></a> -->
            </div>
            </div>

             <div class="col-md-3">
            <label>Date<span class="required">*</span>:</label>
            <input type="text" name="workorder_date" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="workorder_date" value=<?=DISPLAY_DATE?> />
            </div>

             <div class="col-md-3 col-sm-3">
                <label><?php echo $this->lang->line('supplier'); ?><span class="required">*</span>:</label>
                <select name="distributorid" class="form-control select2 required_field" id="distributorid" >
                    <option value="">--Select--</option>
                        <?php
                            if(!empty($distributors)):
                                foreach ($distributors as $km => $dist):
                        ?>
                    <option value="<?php echo $dist->dist_distributorid; ?>"><?php echo $dist->dist_distributor; ?></option>
                        <?php
                                endforeach;
                            endif;
                        ?>
                </select>
            </div>

            <div class="col-md-3">
              <label>Work Order No.<span class="required">*</span>:</label>
              <input type="text" name="rewm_orderno" class="form-control" placeholder="Repair Order No." value="<?php echo !empty($repair_orderno) ? $repair_orderno : ''; ?>" id="rewm_orderno" readonly>
                <span class="errmsg"></span>
            </div>

            <div class="col-md-3">
            <label>Department <span class="required">*</span>:</label>
            <select name="depid" class="form-control select2 required_field" id="depid">
               <option value="">---Select---</option>
               <?php
                  if($department_list):
                    foreach ($department_list as $ks => $dep):
                      ?>
               <option value="<?php echo $dep->dept_depid; ?>"><?php echo $dep->dept_depname; ?></option>
               <?php
                  endforeach;
                  endif;
                  ?>
            </select>
            </div>

            <div class="col-md-3">
            <label>Delivery Date<span class="required">*</span>:</label>
            <input type="text" name="delivery_date" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="delivery_date" value=<?=DISPLAY_DATE?> />
            </div>

            <div class="col-md-3">
            <label>Delivery Place<span class="required">*</span>:</label>
            <input type="text" name="delivery_place" class="form-control required_field" id="delivery_place" />
            </div>

            <div class="col-md-3">
            <label>Requested By<span class="required">*</span>:</label>
            <input type="text" name="requestby" class="form-control required_field" id="requestby" value="" />
            </div>

        </div>
        <div class="form-group">
        <div class="pad-5" id="displayDetailList">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                     <tr>
                      <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>.</th>
                      <th scope="col" width="15%">Assets Code </th>
                      <th scope="col" width="20%">Description</th>
                      <th scope="col" width="25%">Problem</th>
                      <th scope="col" width="5%">Estimated Cost</th>
                      <th scope="col" width="5%">Prev Repair Cnt</th>
                      <th scope="col" width="5%">Prev Repair Cost</th>
                      <th scope="col" width="5%">Prev Repair Date(B.S)</th>
                      <th scope="col" width="5%">Prev Repair Date(A.D)</th>
                      <th scope="col" width="20%">Remarks</th>
                     </tr>
                    </thead>
                    <tbody id="repairRequestDataBody">
                    </tbody>
                </table>    
                <div id="Printable" class="print_report_section printTable"></div>             
            </div>
        </div>

       <div class="col-md-4">
            <label>Remarks</label>
            <textarea name="work_order_remarks" id="" cols="30" rows="2" class="form-control"></textarea>
        </div>
    </div>
    </div>
     <div class="form-group mt-3">
      <div class="col-md-12">
         <button type="submit" class="btn btn-info  save" data-operation='save' id="btnSubmit" ><?php echo $this->lang->line('save');  ?></button>
            <button type="submit" class="btn btn-info savePrint" data-operation='save' id="btnSubmit" data-print="print"><?php echo $this->lang->line('save_and_print'); ?></button>
      </div>

      <div class="col-sm-12">
         <div  class="alert-success success"></div>
         <div class="alert-danger error"></div>
      </div>
   </div>

   <div class="clearfix"></div>
   <div class="clearfix"></div>
</form>

<script type="text/javascript">
    $(document).off('click','#btnSearchRepairRequestno');
    $(document).on('click','#btnSearchRepairRequestno',function(){
        var repair_request_no=$('#repair_request_no').val();
        var fiscalyear=$('#fiscalyear').val();
        var submitdata = {repair_request_no:repair_request_no,fiscalyear:fiscalyear};
        var submiturl = base_url+'ams/repair_work_order/repairlist_by_repair_request_no';
        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
      
        function onSuccess(jsons){
            data = jQuery.parseJSON(jsons);
            // console.log(data.order_data);
            var repair_data=data.repair_data;
           
            var defaultdatepicker='<?php echo DEFAULT_DATEPICKER ?>';

            if(repair_data)
            {
                var depid = repair_data[0].rerm_reqdepid;
                var requestby = repair_data[0].rerm_requestby;
                var repairmasterid=repair_data[0].rerm_repairrequestmasterid;
            // var supplierid=orderdata[0].puor_supplierid;
            // var purchaseordermasterid = orderdata[0].puor_purchaseordermasterid;
            //     if(defaultdatepicker=='NP')
            //     {
            //         $('#OrderDate').val(orderdatebs);
            //     }
            //     else{
            //         $('#OrderDate').val(orderdatead);
            //     }
                $("#depid").select2("val", depid).trigger('change');
                $("#requestby").val(requestby);
                $("#rewm_repairrequestmasterid").val(repairmasterid);
            //     $('#purchaseordermasterid').val(purchaseordermasterid);
            }
            // console.log(orderdata);
            if(data.status=='success')
            {
                $('#repairRequestDataBody').html(data.tempform);
            }
            else
            {   
                alert(data.message); 
                // $('#OrderDate').val('');
                $("#depid").select2("val", 0).trigger('change');
                $('#repairRequestDataBody').html('');
            }
            $('.overlay').modal('hide');
        }
   });
</script>