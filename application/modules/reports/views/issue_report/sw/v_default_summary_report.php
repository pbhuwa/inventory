<style>
    .table>tbody>tr>td, .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important; 

}
 @media print {
      @page {
        margin:8mm;
      }
    }
    .table>tbody>tr:last-child td {
        font-weight:bold;
    }
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
       <?php 
        if(!empty($report_result['default_summary'] )):
        $this->load->view('v_common_report_head');
            
       ?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="8%">Issue Date(B.S)</th>
                        <th width="8%">Issue Date(A.D)</th>
                        <th width="5%">Issue No.</th>
                        <th width="25%">Department</th>
                        <th width="10%">Total Amt.</th>
                        <th width="5%">Issued By</th>
                        <th width="5%">Received By</th>
                        <th width="5%">Req No.</th>
                        <th width="5%">Bill No.</th>
                        <th width="8%">Material Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tot_amt = 0;
                    
                    foreach ($report_result['default_summary'] as $key => $sum):
                        $department='';
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $sum->sama_billdatebs; ?></td>           
                        <td><?php echo $sum->sama_billdatead; ?></td>           
                        <td><?php echo $sum->sama_invoiceno; ?></td> 
                        <td style="word-wrap: normal;">          
                        <?php
                            if (!empty($sum->parent_dep)) {
                                $department = $sum->schoolname.' -'.$sum->parent_dep.'/'.$sum->dept_depname;
                            }else{
                                $department = $sum->schoolname.' -'.$sum->dept_depname;
                            }

                            echo ltrim($department,'-') ;
                        ?>  
                        </td>        
                        <td><?php echo number_format($sum->totalamt,2); ?></td>           
                        <td><?php echo $sum->sama_soldby; ?></td>           
                        <td><?php echo $sum->sama_receivedby; ?></td>           
                        <td><?php echo $sum->sama_requisitionno; ?></td>           
                        <td><?php echo $sum->sama_billno; ?></td>           
                        <td><?php echo $sum->maty_material; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($sum->totalamt) ? $sum->totalamt : 0;
                        // $tot_dis += !empty($sum->discount) ? $sum->discount : 0;
                        // $tot_tax += !empty($sum->taxamount) ? $sum->taxamount : 0;
                        // $tot_refund += !empty($sum->refund) ? $sum->refund : 0;
                        // $tot_gtotal += !empty($sum->recm_gtotal) ? $sum->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='5'>Total</td>
                        <td><?=number_format($tot_amt,2)?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?> 

    <?php 
        if(!empty($report_result['department'] )):
       ?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="25%">Department</th>
                        <th width="10%">Item Cnt.</th>
                        <th width="10%">Issued. Qty</th>
                        <th width="10%">Rate</th>
                        <th width="10%">Total Amt.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tot_amt = $tot_cnt = $tot_qty = $tot_rate =0;
                    
                    foreach ($report_result['department'] as $key => $sum):
                         $department='';
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td style="word-wrap: normal;">          
                        <?php
                            if (!empty($sum->parent_dep)) {
                                $department = $sum->loca_name.' -'.$sum->parent_dep.'/'.$sum->departmentname;
                            }else{
                                $department = $sum->loca_name.' -'.$sum->departmentname;
                            }

                            echo ltrim($department,'-') ;
                        ?>  
                        </td>        
                        <td><?php echo sprintf('%g',$sum->cnt); ?></td>           
                        <td><?php echo sprintf('%g',$sum->qty); ?></td>           
                        <td><?php echo $sum->rate; ?></td>           
                        <td><?php echo number_format($sum->amount,2); ?></td>           
                                
                    </tr>
                    <?php 
                        $tot_amt += !empty($sum->amount) ? $sum->amount : 0;
                        $tot_qty += !empty($sum->qty) ? $sum->qty : 0;
                        $tot_cnt += !empty($sum->cnt) ? $sum->cnt : 0;
                        $tot_rate += !empty($sum->rate) ? $sum->rate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_cnt?></td>
                        <td><?=number_format($tot_qty,2)?></td>
                        <td><?=number_format($tot_rate,2)?></td>
                        <td><?=number_format($tot_amt,2)?></td>
                       
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>

    <?php 
        if(!empty($report_result['material_type'] )):
       ?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="25%">Material Type</th>
                        <th width="10%">Item Cnt.</th>
                        <th width="10%">Qty</th>
                        <th width="10%">Rate</th>
                        <th width="10%">Total Amt.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                      $tot_amt = $tot_cnt = $tot_qty = $tot_rate =0;
                    
                    foreach ($report_result['material_type'] as $key => $sum):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?=$sum->maty_material?></td>        
                        <td><?php echo sprintf('%g',$sum->cnt); ?></td>           
                        <td><?php echo sprintf('%g',$sum->qty); ?></td>           
                        <td><?php echo $sum->rate; ?></td>           
                        <td><?php echo number_format($sum->amount,2); ?></td>           
                                
                    </tr>
                   <?php 
                        $tot_amt += !empty($sum->amount) ? $sum->amount : 0;
                        $tot_cnt += !empty($sum->cnt) ? $sum->cnt : 0;
                        $tot_qty += !empty($sum->qty) ? $sum->qty : 0;
                        $tot_rate += !empty($sum->rate) ? $sum->rate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_cnt?></td>
                        <td><?=number_format($tot_qty,2)?></td>
                        <td><?=number_format($tot_rate,2)?></td>
                        <td><?=number_format($tot_amt,2)?></td>
                       
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>

      <?php 
    if(!empty($report_result['item_wise'] )):
   ?>

    <div class="table-responsive">
        <table class="table table-striped alt_table">
            <thead>
                <tr>
                    <th width="5%">S.N</th>
                    <th width="15%">Item Code</th>
                    <th width="15%">Item Name</th>
                    <th width="10%">No.of Issued</th>
                    <th width="10%">Qty</th>
                    <th width="10%">Total Amt.</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                  $tot_amt = $tot_cnt = $tot_qty = $tot_rate =0;
                
                foreach ($report_result['item_wise'] as $key => $itm):
                ?>  
                <tr>
                    <td><?=$key+1?></td>
                    <td><?="$itm->itli_itemcode"?></td>        
                    <td><?php echo $itm->itli_itemname; ?></td>           
                    <td><?php echo sprintf('%g',$itm->cnt); ?></td>           
                    <td><?php echo sprintf('%g',$itm->qty); ?></td>           
                    <td><?php echo number_format($itm->amount,2); ?></td>           
                            
                </tr>
                <?php 
                        $tot_amt += !empty($itm->amount) ? $itm->amount : 0;
                        $tot_cnt += !empty($itm->cnt) ? $itm->cnt : 0;
                        $tot_qty += !empty($itm->qty) ? $itm->qty : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='3'>Total</td>
                        <td> </td>
                        <td><?=$tot_cnt?></td>
                        <td><?=number_format($tot_qty,2)?></td>
                        <td><?=number_format($tot_amt,2)?></td>
                       
                    </tr>
            </tbody>
        </table>
    </div>
   
        <?php endif;?>
         <br>

    <?php 
    if(!empty($report_result['demand_date'] )):
   ?>

    <div class="table-responsive">
        <table class="table table-striped alt_table">
            <thead>
                <tr>
                    <th width="5%">S.N</th>
                    <th width="25%">Demand Date</th>
                    <th width="10%">Item Cnt.</th>
                    <th width="10%">Qty</th>
                    <th width="10%">Rate</th>
                    <th width="10%">Total Amt.</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                  $tot_amt = $tot_cnt = $tot_qty = $tot_rate =0;
                
                foreach ($report_result['demand_date'] as $key => $sum):
                ?>  
                <tr>
                    <td><?=$key+1?></td>
                    <td><?="$sum->rema_reqdatebs (B.S) - $sum->rema_reqdatead (A.D)"?></td>        
                    <td><?php echo sprintf('%g',$sum->cnt); ?></td>           
                    <td><?php echo sprintf('%g',$sum->qty); ?></td>           
                    <td><?php echo $sum->rate; ?></td>           
                    <td><?php echo number_format($sum->amount,2); ?></td>           
                            
                </tr>
                <?php 
                        $tot_amt += !empty($sum->amount) ? $sum->amount : 0;
                        $tot_cnt += !empty($sum->cnt) ? $sum->cnt : 0;
                        $tot_qty += !empty($sum->qty) ? $sum->qty : 0;
                        $tot_rate += !empty($sum->rate) ? $sum->rate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_cnt?></td>
                        <td><?=number_format($tot_qty,2)?></td>
                        <td><?=number_format($tot_rate,2)?></td>
                        <td><?=number_format($tot_amt,2)?></td>
                       
                    </tr>
            </tbody>
        </table>
    </div>
   
        <?php endif;?>
         <br>
    <?php 
    // echo "<pre>";
    // print_r($report_result['issue_date']);
    // die();
    if(!empty($report_result['issue_date'] )):
   ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Issue Date</th>
                        <th>No. of.Issued</th>
                        <th>No. of.Issued Item</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['issue_date'] as $key => $value):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo "$value->sama_billdatebs (B.S) - $value->sama_billdatead (A.D)"; ?></td>           
                        <td><?php echo sprintf('%g',($value->qty)); ?></td>         
                        <td><?php echo sprintf('%g',($value->cnt)); ?></td>           
                        <td><?php echo $value->amount; ?></td>  
                    </tr>      
                     <?php endforeach;?>     
                </tbody>
            </table>
        </div>

  <?php endif;?>
    <br>

     <br>
    <?php 
    // echo "<pre>";
    // print_r($report_result['issue_date']);
    // die();
    if(!empty($report_result['category_wise'] )):
   ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Category</th>
                        <th>No. of.Issued</th>
                        <th>No. of.Issued Item</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                     $tot_cnt=0;
                     $tot_qty=0;
                     $tot_amt=0;
                    foreach ($report_result['category_wise'] as $key => $ct):
                        $tot_cnt +=$ct->cnt;
                        $tot_qty +=$ct->qty;
                        $tot_amt +=$ct->amount;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $ct->eqca_category; ?></td>   
                        <td><?php echo ($ct->cnt); ?></td>         
                        <td><?php echo ($ct->qty); ?></td>         
                        <td><?php echo $ct->amount; ?></td>  
                    </tr>      
                     <?php endforeach;?>     
                      <tr>
                    <td colspan='2'>Total</td>
                    <td><?=$tot_cnt?></td>
                    <td><?=number_format($tot_qty,2)?></td>
                    <td><?=number_format($tot_amt,2)?></td>
                </tr>
                </tbody>

            </table>
        </div>

  <?php endif;?>

  
    <?php 
    if(!empty($report_result['received_by'] )):
   ?>

    <div class="table-responsive">
    <table class="table table-striped alt_table">
    <thead>
        <tr>
            <th width="5%">S.N</th>
            <th width="25%">Received By</th>
            <th width="10%">Item Cnt.</th>
            <th width="10%">Qty</th>
            <th width="10%">Rate</th>
            <th width="10%">Total Amt.</th>
        </tr>
    </thead>
    <tbody>
        <?php 
          $tot_amt = $tot_cnt = $tot_qty = $tot_rate =0;
        
        foreach ($report_result['received_by'] as $key => $sum):
        ?>  
        <tr>
            <td><?=$key+1?></td>
            <td><?=ucfirst($sum->rema_reqby)?></td>        
            <td><?php echo sprintf('%g',$sum->cnt); ?></td>           
            <td><?php echo sprintf('%g',$sum->qty); ?></td>           
            <td><?php echo $sum->rate; ?></td>           
            <td><?php echo number_format($sum->amount,2); ?></td>           
                    
        </tr>
        <?php 
            $tot_amt += !empty($sum->amount) ? $sum->amount : 0;
            $tot_cnt += !empty($sum->cnt) ? $sum->cnt : 0;
            $tot_qty += !empty($sum->qty) ? $sum->qty : 0;
            $tot_rate += !empty($sum->rate) ? $sum->rate : 0;
        ?>
        <?php endforeach;?>
        <tr>
            <td colspan='2'>Total</td>
            <td><?=$tot_cnt?></td>
            <td><?=number_format($tot_qty,2)?></td>
            <td><?=number_format($tot_rate,2)?></td>
            <td><?=number_format($tot_amt,2)?></td>
           
        </tr>
    </tbody>
    </table>
    </div>
    <br>
    <?php endif;?>
    </div>
</div>