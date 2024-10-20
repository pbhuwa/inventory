<div>
<div class="form-group white-box pad-5 bg-gray clearfix">
    <div class="col-md-3">
        <label>Received Number : </label>
       <span> <?php echo !empty($handover_master_data[0]->hrem_receivedno)?$handover_master_data[0]->hrem_receivedno:'';  ?></span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('received_date'); ?> : </label>
         <span>
          <?php if(DEFAULT_DATEPICKER=='NP')
          {
             echo !empty($handover_master_data[0]->hrem_receiveddatebs)?$handover_master_data[0]->hrem_receiveddatebs:'';
          } 
          else 
          {
            echo !empty($handover_master_data[0]->hrem_receiveddatead)?$handover_master_data[0]->hrem_receiveddatead:'';
          } ?>
            
          </span>
    </div>
  
    <div class="col-md-3">
        <label>Bill No :</label>
         <span><?php echo  !empty($handover_master_data[0]->hrem_billno)?$handover_master_data[0]->hrem_billno:''; ?></span>
    </div>
    <div class="margin-top-25"></div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('fiscal_year'); ?>:</label>
       <span><?php 
          echo !empty($handover_master_data[0]->hrem_fyear)?$handover_master_data[0]->hrem_fyear:'';
         ?></span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('bill_date'); ?> : </label>
       <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo !empty($handover_master_data[0]->hrem_billdatebs)?$handover_master_data[0]->hrem_billdatebs:'';
         } else {
            echo !empty($handover_master_data[0]->hrem_billdatead)?$handover_master_data[0]->hrem_billdatead:'';
         } ?>
         </span>
    </div>
     <div class="col-md-3">
        <label>Source : </label>
         <span><?php echo  !empty($handover_master_data[0]->hrem_source)?$handover_master_data[0]->hrem_source:''; ?></span>
    </div>
     <div class="col-md-3">
        <label>Received By : </label>
         <span><?php echo  !empty($handover_master_data[0]->hrem_receivedby)?$handover_master_data[0]->hrem_receivedby:''; ?></span>
    </div>
   
    
        <div class="col-md-3">
        <label><?php echo $this->lang->line('location'); ?> : </label>
         <span><?php echo  !empty($handover_master_data[0]->loca_name)?$handover_master_data[0]->loca_name:''; ?></span>
    </div>

     
   

</div>
</div>


<div class="clearfix"></div> 
<div class="data-table" style="margin-top: 10px;">
    <?php if(!empty($handover_detail_data)) { ?>
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
              <?php foreach ($handover_detail_data as $key => $value) 
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
                <td><?php echo $value->hred_description; ?></td>
                <td><?php echo $value->unit_unitname ?></td>
                <td><?php echo $value->hred_receivedqty ?></td>
                <td><?php echo $value->hred_unitprice ?></td>
                <td><?php echo $value->hred_discountamt ?></td>
                <td><?php echo $value->hred_vatamt ?></td>
                <td><?php echo $value->hred_amount ?></td>
              </tr>
              <?php } ?>
              
                <tr class="table-footer">
                <td colspan="2"><label>Insurance</label></td>
                <td colspan="2"><?php
                        $insurance = !empty($handover_master_data[0]->hrem_insurance)?$handover_master_data[0]->hrem_insurance:0;
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
                        $discount = !empty($handover_master_data[0]->hrem_discount)?$handover_master_data[0]->hrem_discount:0;
                        echo number_format($discount,2)
                        ?>
                    </td>

              </tr>
                <tr class="table-footer">
              <td colspan="2"><label>Carriage Freight</label></td>
                <td colspan="2">
                  <?php
                        $carriagefreight = !empty($handover_master_data[0]->hrem_carriagefreight)?$handover_master_data[0]->hrem_carriagefreight:0;
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
                        $taxamount = !empty($handover_master_data[0]->hrem_taxamount)?$handover_master_data[0]->hrem_taxamount:0;
                        echo number_format($taxamount,2)?>
                    </td>

              </tr>
              <tr class="table-footer">
             
                <td colspan="2"><label>Packing</label></td>
                <td colspan="2">  
                  <?php
                        $packing = !empty($handover_master_data[0]->hrem_packing)?$handover_master_data[0]->hrem_packing:0;
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
                      $clearanceamount = !empty($handover_master_data[0]->hrem_clearanceamount)?$handover_master_data[0]->hrem_clearanceamount:0; 
                        echo number_format($clearanceamount,2)?>
                    </td>

              </tr>
                   <tr class="table-footer">
             
                <td colspan="2"><label>Transport Courier</label></td>
                <td colspan="2">  
                  <?php
                        $transportcourier = !empty($handover_master_data[0]->hrem_transportcourier)?$handover_master_data[0]->hrem_transportcourier:0;
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
             
                <td colspan="2"><label>Others <?php $other_desc= !empty($handover_master_data[0]->hrem_othersdescription)?$handover_master_data[0]->hrem_othersdescription:''; 
                        if(!empty($other_desc)){
                          echo '('.$other_desc.')';
                        }

                        ?></label></td>
                <td colspan="2">  
                  <?php
                        $others = !empty($handover_master_data[0]->hrem_others)?$handover_master_data[0]->hrem_others:0;
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
                   <?php echo !empty($handover_master_data[0]->hrem_remarks)?$handover_master_data[0]->hrem_remarks:''; ?>
                 </span>
              </div>
              </form>
          </div>
          <br/>
      <br/>
        </div>
   </div>
    
    <?php } ?>
    </div>
<div class="clearfix"></div>
<div id="FormDiv_Reprint" class="printTable"></div> 


<div id="FormDiv_voucher_print" class="printTable"></div> 
