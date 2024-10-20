<style>
    .mcolor{
        background: #FF8C00 !important;
    }
</style>
<div class="form-group white-box pad-5 bg-gray">
    <div class="row">
        <div class="col-sm-4 col-xs-6">
            <label>Work Order No</label>: 
            <span> <?php echo !empty($work_order_master[0]->woma_workorderno)?$work_order_master[0]->woma_workorderno:''; ?></span>
        </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label> : 
            <span><?php echo !empty($work_order_master[0]->woma_manualno)?$work_order_master[0]->woma_manualno:'0'; ?></span>
        </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text">W.Order Date</label>: 
            <span class="inline_block">
            <b><?php echo !empty($work_order_master[0]->woma_datebs)?$work_order_master[0]->woma_datebs:''; ?></b> BS -- <b><?php echo !empty($work_order_master[0]->woma_datead)?$work_order_master[0]->woma_datead:''; ?></b> AD
            </span>
        </div>

         <div class="col-sm-4 col-xs-6">
            <label for="example-text">Project Title</label>: 
            <span>
                <?php 
                    echo !empty($work_order_master[0]->projectname)?$work_order_master[0]->projectname:'';
                  
                ?>
            </span>
        </div>

        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text">Contractor</label>: 
            <span>
                <?php 
                    echo !empty($work_order_master[0]->contractor_name)?$work_order_master[0]->contractor_name:'';
                  
                ?>
            </span>
        </div>
        
       
        <div class="col-sm-4 col-xs-6">
            <label for="example-text">Notice No.</label>: 
            <span><?php 
              $noticeno=!empty($work_order_master[0]->woma_noticeno)?$work_order_master[0]->woma_noticeno:'';
              echo $noticeno;
              ?></span>
        </div>

        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 
            <span>
                <?php 
                    $approved_status=!empty($work_order_master[0]->woma_approved_status)?$work_order_master[0]->woma_approved_status:'';
                    if($approved_status==1)
                    {
                        echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 
                    }
                    else if($approved_status==2)
                    {
                        echo "<span class='n_approved badge badge-sm badge-info'>Unapproved</span>";
                    }
                    else if($approved_status==3)
                    {
                        echo "<span class='cancel badge badge-sm badge-danger'>Canceled</span>";
                    }
                    else if($approved_status==4)
                    {
                        echo "<span class='cancel badge badge-sm badge-info'>Verified</span>";
                    }
                    else
                    {
                        echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";
                    }
                ?>
            </span>
        </div> 
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> </label>:
            <?php 
                $fyear=!empty($work_order_master[0]->woma_fiscalyrs)?$work_order_master[0]->woma_fiscalyrs:'';
                echo $fyear;
            ?>
        </div>
         <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('location'); ?> </label>:
           <?php 
                $loca_name=!empty($work_order_master[0]->locationname)?$work_order_master[0]->locationname:'';
                echo $loca_name;
            ?>
        </div>
        
        <div class="btn-group pull-right">
            <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('ams/workorder/reprint_work_order') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($work_order_master[0]->woma_womasterid)?$work_order_master[0]->woma_womasterid:''; ?>">
               Reprint
            </button>
        </div>
    </div>
</div> 

<div class="form-group">
    <div class="row">
        <div class="table-responsive col-sm-12">
            <table style="width:100%;" class="table purs_table dataTable con_ttl">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>
                        <th width="8%">Description </th>
                        <th width="6%">Qty</th>
                        <th width="6%">Unit</th>
                        <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('total_amount'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('remarks'); ?></th>
                    </tr>
                </thead>
                
                <tbody id="purchaseDataBody">
                    <?php 
                    // echo "<pre>";
                    // print_r($distinct_dtype);
                    // die();
                    $grandtotal=0;
                    if(!empty($distinct_dtype)):
                        foreach ($distinct_dtype as $kdt => $data) {
                         if($data->wode_dtype=='CW'){
                            $display_cat='Civil Work';
                         }
                         if($data->wode_dtype=='SM'){
                            $display_cat='Supply of Material';
                         }
                         // echo $display_cat;

                          $data_detail_arr= $this->work_order_mdl->get_work_order_detail_data(array('wd.wode_womasterid'=>$id,'wd.wode_dtype'=>$data->wode_dtype));

                        if(!empty($data_detail_arr)) { 
                            ?>
                             <tr><td colspan="5"><strong><?php echo $display_cat; ?></td></strong></tr>
                            <?php
                            foreach ($data_detail_arr as $key => $odr) 
                            { 
                                $qty = $odr->wode_qty;
                                $unitprice = $odr->wode_rate;
                                $sub_total_amt = $qty * $unitprice;
                
                    ?>
                   
                    <tr class="orderrow" id="orderrow_<?php echo $key+1 ?>" data-id='<?php echo $key+1 ?>'>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $odr->wode_description ?></td>
                        <td><?php echo $odr->wode_qty ?></td>
                        <td><?php echo $odr->wode_unit ?></td>
                        <td align="right"><?php echo $odr->wode_rate ?></td>
                        <td align="right"><?php echo number_format($sub_total_amt,2) ?></td>
                        <td><?php echo $odr->wode_remarks; ?></td>
                    </tr>
                <?php
                    $grandtotal +=$sub_total_amt; } 
                    } 
                ?>
                 <?php 
                        }
                    endif;
                   ?>
                    <tfoot>
                        <tr>
                    <th  colspan="5">
                        <h5 align="right" colspan="8" style="color: #333; padding-top: 0px; font-size: 12px;"><strong>Estimated Cost:</strong></h5>
                        <td align="right" style="color: #333; padding-top: 22px; font-size: 13px;"><strong>
                            <?php echo number_format($grandtotal,2) ?></strong>
                        </td>
                    </th>
                </tr>
                <?php if($grandtotal >'0.00'): ?>
                <tr>
                    <td colspan="7"><strong><?php echo $this->lang->line('in_words'); ?>: <?php echo $this->general->number_to_word($grandtotal); ?></strong></td>
                </tr>
            <?php endif; ?>
          
            </tfoot>

                
            </table>
        </div>
    </div>
</div>
<div id="FormDiv_Reprint" class="printTable"></div>    