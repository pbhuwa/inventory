<style> 
    .table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
    .table_jo_header { width:100%; vertical-align: top; font-size:12px; }
    .table_jo_header td.text-center { text-align:center; }
    .table_jo_header td.text-right { text-align:right; }
    h4 { font-size:18px; margin:0; }
    .table_jo_header u { text-decoration:underline; padding-top:15px; }

    .jo_table { border-right:1px solid #333; margin-top:5px; }
    .jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

    .jo_table tr th { padding:5px 3px; background: #258967}
    .jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
    
    .jo_footer { border:1px solid #333; vertical-align: top; }
    .jo_footer td { padding:8px 8px;    }
    .alt_table { width:100%; border-collapse:collapse; border:1px solid #000;}
    .alt_table thead tr th, .alt_table tbody tr td { border:1px solid #e4e7ea; padding: 5px; font-size:13px; }
    .alt_table tbody tr td { padding:5px; font-size:12px; }
    .alt_table tbody tr.alter td { border:0; text-align:center; }
    .text-right{ text-align:right; }
    .alt_table thead tr th{background: #258967;color: #fff;}
    .jo_form h4{margin-bottom: 10px;margin-top: 5px;}
    .alt_table tbody tr:nth-of-type(odd){background: #f9f9f9;} 
    .modal-body .form-group{margin-bottom: 0px;padding-bottom: 0px;border-bottom: 0px;}
</style>
<div class="col-sm-12">
    <div class="white-box pad-5 mtop_10 ">
        <div class="jo_form organizationInfo" id="printrpt">
        <h4 class="text-center"><?php echo $this->lang->line('monthly_department_requisition'); ?> <?php echo $this->lang->line('items'); ?></h4>
                <?php

                 if(!empty($details_requisition_department)){  //echo"<pre>"; print_r($details_requisition_department);die;
                foreach ($details_requisition_department as $key => $value) {  
                    $stock_requisition_details=$this->stock_requisition_mdl->get_requisition_master_data(array('rm.rema_reqmasterid'=>$value->reqmasterid));
                    // echo "<pre>";
                    // print_r($stock_requisition_details);
                    ?>

                <div class="form-group white-box pad-5 bg-gray">
    <div class="row">
          <div class="col-sm-4 col-xs-6">
            <label><?php echo $this->lang->line('requisition_no'); ?></label>: 
           <span> <?php echo !empty($stock_requisition_details[0]->rema_reqno)?$stock_requisition_details[0]->rema_reqno:''; ?></span>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label>: 
            <span><?php echo !empty($stock_requisition_details[0]->rema_manualno)?$stock_requisition_details[0]->rema_manualno:''; ?></span>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('date'); ?></label>: 
            <span class="inline_block">
            <?php echo !empty($stock_requisition_details[0]->rema_reqdatebs)?$stock_requisition_details[0]->rema_reqdatebs:''; ?>(BS), <?php echo !empty($stock_requisition_details[0]->rema_reqdatead)?$stock_requisition_details[0]->rema_reqdatead:''; ?>(AD)
            </span>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('from_department'); ?></label>: 
            <span><?php 
              $isdep=!empty($stock_requisition_details[0]->rema_isdep)?$stock_requisition_details[0]->rema_isdep:'';
              if($isdep=='Y')
              {
                echo !empty($stock_requisition_details[0]->fromdepname)?$stock_requisition_details[0]->fromdepname:'';
              }
              else
              {
                 echo !empty($stock_requisition_details[0]->fromdep_transfer)?$stock_requisition_details[0]->fromdep_transfer:'';
              }
             ?>
           </span>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('to_department'); ?> </label> : 
           <span> <?php echo !empty($stock_requisition_details[0]->todepname)?$stock_requisition_details[0]->todepname:'';
              ?></span>
          </div>

          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('is_issue'); ?> </label>: 
            <span><?php echo $isdep=!empty($isdep)?$isdep:''; ?></span>
          </div>

          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label>: 
            <span><?php 
              $reqby=!empty($stock_requisition_details[0]->rema_reqby)?$stock_requisition_details[0]->rema_reqby:'';
              echo $reqby;
              ?></span>
          </div>

          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 
           
            <span><?php 
            $approved_status=!empty($stock_requisition_details[0]->rema_approved)?$stock_requisition_details[0]->rema_approved:'';
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
              $remafyear=!empty($stock_requisition_details[0]->rema_fyear)?$stock_requisition_details[0]->rema_fyear:'';
              echo $remafyear;
              ?>
          </div>
  </div>
     
    </div>
                <table class="alt_table">
                    <thead>
                        <tr>
                          <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>
                            <th width="25%"><?php echo $this->lang->line('item_code'); ?>   </th>
                            <th width="30%"><?php echo $this->lang->line('item_name'); ?>   </th>
                            <th width="10%"><?php echo $this->lang->line('unit'); ?>   </th>
                            <th width="10%" ><?php echo $this->lang->line('qty'); ?>   </th>
                            <th width="10%" ><?php echo $this->lang->line('rem_qty'); ?>  </th>
                            <th width="10%" ><?php echo $this->lang->line('stock_quantity'); ?> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $ndate= !empty($value->rema_reqdatebs)?$value->rema_reqdatebs:'';
                    //$yers = substr($ndate, 0, 7);
                    // echo $value->reqmasterid;

                $details = $this->stock_requisition_mdl->get_details_requisition(array('rede_reqmasterid'=>$value->reqmasterid));
               // echo"<pre>"; print_r($details);die;
                    $sum3 = 0;  
                    $sum1 = 0;  
                    $sum2 = 0;  
                if( $details):
                    foreach($details as $key=>$df): 
                      if(ITEM_DISPLAY_TYPE=='NP'){
                  $req_itemname = !empty($df->itli_itemnamenp)?$df->itli_itemnamenp:$df->itli_itemname;
                }else{ 
                    $req_itemname = !empty($df->itli_itemname)?$df->itli_itemname:'';
                }
                

                      
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $df->itli_itemcode ?></td>
                        <td><?php echo $req_itemname ?></td>
                        <td><?php echo $df->unit_unitname ?></td>
                        <td class="text-right"><?php echo $df->rede_qty ?></td>
                        <td class="text-right"><?php echo $df->rede_remqty ?></td>
                        <td class="text-right"><?php echo $df->rede_qtyinstock ?></td>
                        <?php $sum3+= $df->rede_qty;?>
                        <?php $sum1+= $df->rede_remqty;?>
                        <?php $sum2+= $df->rede_qtyinstock;?>
                    </tr>
                    <?php endforeach; 
                    endif; ?>
                    <tr>
                        <td colspan="4"  style="font-size:14px;" class="text-right"><b><?php echo $this->lang->line('grand_total'); ?> :</b>   </td>
                        <td class="text-right"  style="font-size:14px;" ><b><?php  echo round($sum3,2);?></b></td>
                        <td class="text-right"  style="font-size:14px;" ><b><?php  echo round($sum1,2);?></b></td>
                        <td class="text-right"  style="font-size:14px;" ><b><?php  echo round($sum2,2);?></b></td>
                    </tr>
                    </tbody>
                </table> <br>
             <?php } } ?>
        </div>
    </div>
</div>


