<div>
<div class="form-group white-box pad-5 bg-gray clearfix">
    <div class="col-md-3">
        <label>Received Number : </label>
       <span> <?php echo !empty($direct_purchase_master[0]->recm_invoiceno)?$direct_purchase_master[0]->recm_invoiceno:'';  ?></span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('received_date'); ?> : </label>
         <span>
          <?php if(DEFAULT_DATEPICKER=='NP')
          {
             echo !empty($direct_purchase_master[0]->recm_receiveddatebs)?$direct_purchase_master[0]->recm_receiveddatebs:'';
          } 
          else 
          {
            echo !empty($direct_purchase_master[0]->recm_receiveddatead)?$direct_purchase_master[0]->recm_receiveddatead:'';
          } ?>
            
          </span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('order_date'); ?> : </label>
          <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo !empty($direct_purchase_master[0]->recm_purchaseorderdatebs)?$direct_purchase_master[0]->recm_purchaseorderdatebs:'';
         } else {
            echo !empty($direct_purchase_master[0]->recm_purchaseorderdatead)?$direct_purchase_master[0]->recm_purchaseorderdatead:'';
         } ?>
         </span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_bill_no'); ?> :</label>
         <span><?php echo  !empty($direct_purchase_master[0]->recm_supplierbillno)?$direct_purchase_master[0]->recm_supplierbillno:''; ?></span>
    </div>
    <div class="margin-top-25"></div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('fiscal_year'); ?>:</label>
       <span><?php 
          echo !empty($direct_purchase_master[0]->recm_fyear)?$direct_purchase_master[0]->recm_fyear:'';
         ?></span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('bill_date'); ?> : </label>
       <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo !empty($direct_purchase_master[0]->recm_supbilldatebs)?$direct_purchase_master[0]->recm_supbilldatebs:'';
         } else {
            echo !empty($direct_purchase_master[0]->recm_supbilldatead)?$direct_purchase_master[0]->recm_supbilldatead:'';
         } ?>
         </span>
    </div>
     <div class="col-md-3">
        <label><?php echo $this->lang->line('order_no'); ?> : </label>
         <span><?php echo  !empty($direct_purchase_master[0]->recm_purchaseorderno)?$direct_purchase_master[0]->recm_purchaseorderno:''; ?></span>
    </div>
     <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_name'); ?> : </label>
         <span><?php echo  !empty($direct_purchase_master[0]->dist_distributor)?$direct_purchase_master[0]->dist_distributor:''; ?></span>
    </div>
   
    
    <div class="col-sm-4 col-xs-3">
              <label>School</label>
              <?php
              $school_id=!empty($direct_purchase_master[0]->recm_school)?$direct_purchase_master[0]->recm_school:'';
               $school_result=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$school_id),'loca_name','ASC'); 
               if(!empty($school_result)){
                echo !empty($school_result[0]->loca_name)?$school_result[0]->loca_name:'';
               }
              ?>
            </div>

          <div class="col-sm-4 col-xs-3">

            <label for="example-text">Department</label>: 
            <?php 

            $reqdepartment=!empty($direct_purchase_master[0]->recm_departmentid)?$direct_purchase_master[0]->recm_departmentid:'';
            $check_parentid=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$reqdepartment),'dept_depname','ASC');
            $dep_parent_dep_name='';
            $sub_depname='';
            
            if(!empty($check_parentid)){
              $dep_parentid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
              $dep_parent_dep_name=!empty($check_parentid[0]->dept_depname)?$check_parentid[0]->dept_depname:'';

              if($dep_parentid!=0){
              $sub_department=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$dep_parentid),'dept_depname','ASC');
              if(!empty($sub_department)){
               $sub_depname=!empty($sub_department[0]->dept_depname)?$sub_department[0]->dept_depname:'';
              }
              }   
            }

            if(!empty($sub_depname)){
              echo $sub_depname.'('.$dep_parent_dep_name.')';
            }else{
              echo $dep_parent_dep_name;
            }

        ?>

          </div>
           <div class="col-md-3">
        <label><?php echo $this->lang->line('location'); ?> : </label>
         <span><?php echo  !empty($direct_purchase_master[0]->loca_name)?$direct_purchase_master[0]->loca_name:''; ?></span>
    </div>

     
     <?php
      if(ORGANIZATION_NAME == 'KUKL'){
    ?>
    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/receive_against_order/voucher_print') ?>" data-viewdiv="FormDiv_voucher_print" data-id="<?php echo !empty($req_detail_list[0]->recd_receivedmasterid)?$req_detail_list[0]->recd_receivedmasterid:''; ?>">Voucher</button>
    <?php
      }
     ?>

    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/receive_against_order/receive_aginst_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($req_detail_list[0]->recd_receivedmasterid)?$req_detail_list[0]->recd_receivedmasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>
</div>
</div>
<!-- <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/receive_against_order/receive_aginst_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($req_detail_list[0]->recd_receivedmasterid)?$req_detail_list[0]->recd_receivedmasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button> -->

<div class="clearfix"></div> 
<div class="data-table" style="margin-top: 10px;">
    <?php if($req_detail_list) { ?>
        <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">
            <thead>
                <tr>
                    <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('item_code'); ?> </th>
                    <th width="30%"> <?php echo $this->lang->line('item_name'); ?> </th>
                    <th width="20%">Description</th>
                    <th width="5%"> <?php echo $this->lang->line('unit'); ?></th>
                    <th width="5%"> <?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('discountamount'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('vat_amount'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('total_amount'); ?> </th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($req_detail_list as $key => $value) 
              { 
                if(ITEM_DISPLAY_TYPE=='NP'){
                  $req_itemname = !empty($value->itli_itemnamenp)?$value->itli_itemnamenp:$value->itli_itemname;
                }else{ 
                    $req_itemname = !empty($value->itli_itemname)?$value->itli_itemname:'';
                }
               ?>
              <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $value->itli_itemcode ?></td>
                <td><?php echo $req_itemname ?></td>
                <td><?php echo $value->recd_description; ?></td>

                <td><?php echo $value->unit_unitname ?></td>
                <td><?php echo $value->recd_purchasedqty ?></td>
                <td><?php echo $value->recd_unitprice ?></td>
                <td><?php echo $value->recd_discountamt ?></td>
                <td><?php echo $value->recd_vatamt ?></td>
                <td><?php echo $value->recd_amount ?></td>
              </tr>
              <?php } ?>
              
                <tr class="table-footer">
                <td colspan="2"><label>Insurance</label></td>
                <td colspan="2"><?php
                        $insurance = !empty($direct_purchase_master[0]->recm_insurance)?$direct_purchase_master[0]->recm_insurance:0;
                        echo number_format($insurance,2)
                        ?></td>
                <td colspan="2"></td>
                <td colspan="2">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('discount'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php
                        $discount = !empty($direct_purchase_master[0]->recm_discount)?$direct_purchase_master[0]->recm_discount:0;
                        echo number_format($discount,2)
                        ?>
                    </td>

              </tr>
                <tr class="table-footer">
              <td colspan="2"><label>Carriage Freight</label></td>
                <td colspan="2">
                  <?php
                        $carriagefreight = !empty($direct_purchase_master[0]->recm_carriagefreight)?$direct_purchase_master[0]->recm_carriagefreight:0;
                        echo number_format($carriagefreight,2)
                        ?>
                </td>
                <td colspan="2"></td>
                <td colspan="2">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('vat'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php 
                        $taxamount = !empty($direct_purchase_master[0]->recm_taxamount)?$direct_purchase_master[0]->recm_taxamount:0;
                        echo number_format($taxamount,2)?>
                    </td>

              </tr>
              <tr class="table-footer">
             
                <td colspan="2"><label>Packing</label></td>
                <td colspan="2">  
                  <?php
                        $packing = !empty($direct_purchase_master[0]->recm_packing)?$direct_purchase_master[0]->recm_packing:0;
                        echo number_format($packing,2)
                        ?>
                          
                        </td>
                <td colspan="2"></td>
                
                <td colspan="2">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('grand_total'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php
                      $clearanceamount = !empty($direct_purchase_master[0]->recm_clearanceamount)?$direct_purchase_master[0]->recm_clearanceamount:0; 
                        echo number_format($clearanceamount,2)?>
                    </td>

              </tr>
                   <tr class="table-footer">
             
                <td colspan="2"><label>Transport Courier</label></td>
                <td colspan="2">  
                  <?php
                        $transportcourier = !empty($direct_purchase_master[0]->recm_transportcourier)?$direct_purchase_master[0]->recm_transportcourier:0;
                        echo number_format($transportcourier,2)
                        ?>
                          
                        </td>
                <td colspan="2"></td>
                <td colspan="2">
                      
                    </td>
                    <td colspan="2">
                      
                    </td>

              </tr>
                   <tr class="table-footer">
             
                <td colspan="2"><label>Others <?php $other_desc= !empty($direct_purchase_master[0]->recm_othersdescription)?$direct_purchase_master[0]->recm_othersdescription:''; 
                        if(!empty($other_desc)){
                          echo '('.$other_desc.')';
                        }

                        ?></label></td>
                <td colspan="2">  
                  <?php
                        $others = !empty($direct_purchase_master[0]->recm_others)?$direct_purchase_master[0]->recm_others:0;
                        echo number_format($others,2)
                        ?>
                        
                          
                        </td>
                <td colspan="2"></td>
                <td colspan="2">
                        
                    </td>
                    <td colspan="2">
                      
                    </td>

              </tr>
            </tbody>
          </table>
          <div class="form-group">
            <form class="form-material form-horizontal form">
              <div class="col-md-3 col-sm-4">
                  <label for="quma_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
                 <span>
                   <?php echo !empty($direct_purchase_master[0]->recm_remarks)?$direct_purchase_master[0]->recm_remarks:''; ?>
                 </span>
              </div>
              </form>
          </div>
          <br/>
     
            <div class="addAttachmentRow">
               <div class="col-md-12 col-sm-12">
              <label>Download Bill Attachments: </label>
              <?php 

                $contractAttachments = !empty($direct_purchase_master[0]->recm_attachments)?$direct_purchase_master[0]->recm_attachments:'';
                if($contractAttachments):
                $attach = explode(', ',$contractAttachments);
                $download = "";
                if($attach):
                    foreach($attach as $key=>$value){
                        $download .= "<a href='".base_url().RECEIVED_BILL_ATTACHMENT_PATH.'/'.$value."' target='_blank'><img src='".base_url().RECEIVED_BILL_ATTACHMENT_PATH.'/'.$value."' style='width:100px;'/><a>&nbsp;&nbsp;&nbsp;";
                        }
                endif;
                echo $download;
            endif;
              ?>
            </div>
          </div>

          <div class="form-group">
           <form method="post" id="FormReceiveOrderItem" action="<?php echo base_url('purchase_receive/receive_against_order/upload_attachment'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('purchase_receive/receive_against_order/received_order_item_list'); ?>" enctype="multipart/form-data"  accept-charset="utf-8" >
              <input type="hidden" name="id" value="<?php echo $master_id  ?>" />
              <div class="col-md-3 col-sm-4">
                 <label>Attachments</label>
                      <div class="dis_tab">
                          <input type="file" id="recm_attachments" name="recm_attachments[]"/>
                          <input type="hidden" name="recm_attach[]">
                          <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
                      </div>
                      <div class="addAttachmentRow1">
                          <?php 

                          $contractAttachments = !empty($contract_data[0]->recm_attachments)?$contract_data[0]->recm_attachments:'';
                          if($contractAttachments):
                          $attach = explode(', ',$contractAttachments);
                          $download = "";
                          if($attach):
                              foreach($attach as $key=>$value){
                                  $download .= "<a href='".base_url().RECEIVED_BILL_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download<a>&nbsp;&nbsp;&nbsp;";
                                  }
                          endif;
                          echo $download;
                      endif;
                          ?>
                      </div>
                   </div>
                 <div class="col-md-12"> 
                    <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($order_item_details)?'update':'save' ?>' id="btnSubmit" >Save</button>
                 </div>

                <div class="col-sm-12">
                    <div  class="alert-success success"></div>
                    <div class="alert-danger error"></div>
               </div>
              </form>
          </div>
          <br/>
        </div>
   </div>
    
    <?php } ?>
    </div>
<div class="clearfix"></div>
<div id="FormDiv_Reprint" class="printTable"></div> 
<script type="text/javascript">
    $(document).ready(function(){
        
        $(document).off('click','#addAttachments');
        $(document).on('click','#addAttachments',function(){
            $(".addAttachmentRow1").append('<div class="dis_tab mtop_5"><input type="file" name="recm_attachments[]" "/><input type="hidden" name="recm_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="fa fa-trash"></span></a></div>');
        });
    
        $(document).off('click','.btnminus');
        $(document).on('click','.btnminus',function(){
            $(this).closest('div').remove();
        });
    });
</script>


<div id="FormDiv_voucher_print" class="printTable"></div> 
