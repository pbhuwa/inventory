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
        font-weight: bold
    }
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
       <?php 
       $this->load->view('v_common_report_head.php'); 
        if(!empty($report_result['suppliers'] )):
       ?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="2%">S.N</th>
                        <th width="30%">Supplier</th>
                        <th width="8%">S.Total</th>
                        <th width="6%">Discount</th>
                        <th width="7%">VAT</th>
                        <th width="7%">Refund</th>
                        <th width="7%">G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
                    
                    foreach ($report_result['suppliers'] as $key => $supp):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $supp->suppliername; ?></td>           
                        <td style="text-align: right;"><?php echo $supp->amount; ?></td>           
                        <td style="text-align: right;"><?php echo $supp->discount; ?></td>           
                        <td style="text-align: right;"><?php echo $supp->taxamount; ?></td>           
                        <td style="text-align: right;"><?php echo $supp->refund; ?></td>           
                        <td style="text-align: right;"><?php echo $supp->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($supp->amount) ? $supp->amount : 0;
                        $tot_dis += !empty($supp->discount) ? $supp->discount : 0;
                        $tot_tax += !empty($supp->taxamount) ? $supp->taxamount : 0;
                        $tot_refund += !empty($supp->refund) ? $supp->refund : 0;
                        $tot_gtotal += !empty($supp->recm_gtotal) ? $supp->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2' style="text-align: center;">Total</td>
                        <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_dis,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_tax,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_refund,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_gtotal,2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>

     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['invoice'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="10%">Invoice No.</th>
                        <th width="10%">Received Date</th>
                        <th width="10%">Order No</th>
                        <th width="10%">Bill No.</th>
                        <th width="10%">Bill Date</th>
                        <th width="20%">Supplier</th>
                        <th width="10%">Sub.Total</th>
                        <th width="10%">VAT</th>
                        <th width="15%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['invoice'] as $key => $inv):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $inv->recm_invoiceno; ?></td>           
                        <td style="text-align: left;"><?php echo $inv->recm_receiveddatebs; ?></td>           
                        <td style="text-align: left;"><?php echo $inv->recm_purchaseorderno; ?></td>           
                        <td style="text-align: left;"><?php echo $inv->recm_supplierbillno; ?></td>      
                         <td style="text-align: left;"><?php echo $inv->recm_supbilldatebs; ?></td>           
                        <td style="text-align: left;"><?php echo $inv->dist_distributor; ?></td>        
                         <td style="text-align: right;"><?php echo $inv->amount; ?></td>   
                        <td style="text-align: right;"><?php echo $inv->taxamount; ?></td>
                         <td style="text-align: right;"><?php echo $inv->recm_gtotal; ?></td>
                    </tr>               
                    <?php 
                        $tot_amt += !empty($inv->amount) ? $inv->amount : 0;
                        $tot_tax += !empty($inv->taxamount) ? $inv->taxamount : 0;
                        $tot_gtotal += !empty($inv->recm_gtotal) ? $inv->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='7' style="text-align: center;">Total</td>
                        <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_tax,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_gtotal,2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>

     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['material'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Material Category</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['material'] as $key => $mat):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $mat->materialname; ?></td>           
                        <td style="text-align: right;"><?php echo $mat->amount; ?></td>           
                        <td style="text-align: right;"><?php echo $mat->discount; ?></td>           
                        <td style="text-align: right;"><?php echo $mat->taxamount; ?></td>           
                        <td style="text-align: right;"><?php echo $mat->refund; ?></td>           
                        <td style="text-align: right;"><?php echo $mat->recm_gtotal; ?></td>
                    </tr>               
                    <?php 
                        $tot_amt += !empty($mat->amount) ? $mat->amount : 0;
                        $tot_dis += !empty($mat->discount) ? $mat->discount : 0;
                        $tot_tax += !empty($mat->taxamount) ? $mat->taxamount : 0;
                        $tot_refund += !empty($mat->refund) ? $mat->refund : 0;
                        $tot_gtotal += !empty($mat->recm_gtotal) ? $mat->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2' style="text-align: center;">Total</td>
                        <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_dis,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_tax,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_refund,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_gtotal,2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['school'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">School</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['school'] as $key => $sch):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $sch->schoolname; ?></td>           
                        <td style="text-align: right;"><?php echo $sch->amount; ?></td>           
                        <td style="text-align: right;"><?php echo $sch->discount; ?></td>           
                        <td style="text-align: right;"><?php echo $sch->taxamount; ?></td>           
                        <td style="text-align: right;"><?php echo $sch->refund; ?></td>           
                        <td style="text-align: right;"><?php echo $sch->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($sch->amount) ? $sch->amount : 0;
                        $tot_dis += !empty($sch->discount) ? $sch->discount : 0;
                        $tot_tax += !empty($sch->taxamount) ? $sch->taxamount : 0;
                        $tot_refund += !empty($sch->refund) ? $sch->refund : 0;
                        $tot_gtotal += !empty($sch->recm_gtotal) ? $sch->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2' style="text-align: center;">Total </td>
                        <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_dis,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_tax,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_refund,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_gtotal,2)?></td>
                    </tr>
                </tbody>
                
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['department'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Department</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['department'] as $key => $dep):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $dep->departmentname; ?></td>           
                        <td style="text-align: right;"><?php echo $dep->amount; ?></td>           
                        <td style="text-align: right;"><?php echo $dep->discount; ?></td>           
                        <td style="text-align: right;"><?php echo $dep->taxamount; ?></td>           
                        <td style="text-align: right;"><?php echo $dep->refund; ?></td>           
                        <td style="text-align: right;"><?php echo $dep->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($dep->amount) ? $dep->amount : 0;
                        $tot_dis += !empty($dep->discount) ? $dep->discount : 0;
                        $tot_tax += !empty($dep->taxamount) ? $dep->taxamount : 0;
                        $tot_refund += !empty($dep->refund) ? $dep->refund : 0;
                        $tot_gtotal += !empty($dep->recm_gtotal) ? $dep->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2' style="text-align: center;" >Total</td>
                        <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_dis,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_tax,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_refund,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_gtotal,2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['budget_head'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Budget Head</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['budget_head'] as $key => $bud):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $bud->budgetname; ?></td>           
                        <td style="text-align: right;"><?php echo $bud->amount; ?></td>           
                        <td style="text-align: right;"><?php echo $bud->discount; ?></td>           
                        <td style="text-align: right;"><?php echo $bud->taxamount; ?></td>           
                        <td style="text-align: right;"><?php echo $bud->refund; ?></td>           
                        <td style="text-align: right;"><?php echo $bud->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($bud->amount) ? $bud->amount : 0;
                        $tot_dis += !empty($bud->discount) ? $bud->discount : 0;
                        $tot_tax += !empty($bud->taxamount) ? $bud->taxamount : 0;
                        $tot_refund += !empty($bud->refund) ? $bud->refund : 0;
                        $tot_gtotal += !empty($bud->recm_gtotal) ? $bud->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2' style="text-align: center;">Total</td>
                        <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_dis,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_tax,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_refund,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_gtotal,2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
            if (!empty($report_result['items'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="2%">S.N</th>
                        <th width="6%">Item Code</th>
                        <th width="30%">Item Name</th>
                        <th width="5%">Qty.</th>
                        <th width="7%">S.Total</th>
                        <th width="6%">Discount</th>
                        <th width=6%>VAT</th>
                        <th width="10%">G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['items'] as $key => $bud):
                        $t_amount = $bud->amount ;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $bud->itli_itemcode; ?></td>  
                        <td><?php echo $bud->itemname; ?></td>           
                        <td style="text-align: right;"><?php echo sprintf('%g',$bud->qty); ?></td>           
                        <td style="text-align: right;"><?php echo $t_amount; ?></td>           
                        <td style="text-align: right;"><?php echo $bud->discount; ?></td>           
                        <td style="text-align: right;"><?php echo $bud->taxamount; ?></td>           
                        <td style="text-align: right;"><?php echo $bud->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($t_amount) ? $t_amount : 0;
                        $tot_qty += !empty($bud->qty) ? $bud->qty : 0;
                        $tot_dis += !empty($bud->discount) ? $bud->discount : 0;
                        $tot_tax += !empty($bud->taxamount) ? $bud->taxamount : 0;
                        $tot_gtotal += !empty($bud->recm_gtotal) ? $bud->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='3' style="text-align: center;">Total</td>
                        <td style="text-align: right;"><?=sprintf('%g',$tot_qty)?></td>
                        <td style="text-align: right;"><?=$tot_amt?></td>
                        <td style="text-align: right;"><?=$tot_dis?></td>
                        <td style="text-align: right;"><?=$tot_tax?></td>
                        <td style="text-align: right;"><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?>
  

    <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
            if (!empty($report_result['received_date'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Received Date</th>
                       
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['received_date'] as $key => $rd):
                        $t_amount = $rd->amount;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $rd->recm_receiveddatebs; ?></td>           
                                
                        <td style="text-align: right;"><?php echo $t_amount; ?></td>           
                        <td style="text-align: right;"><?php echo $rd->discount; ?></td>           
                        <td style="text-align: right;"><?php echo $rd->taxamount; ?></td>           
                        <td style="text-align: right;"><?php echo $rd->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($t_amount) ? $t_amount : 0;
                      
                        $tot_dis += !empty($rd->discount) ? $rd->discount : 0;
                        $tot_tax += !empty($rd->taxamount) ? $rd->taxamount : 0;
                        $tot_gtotal += !empty($rd->recm_gtotal) ? $rd->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2' style="text-align: center;">Total</td>
                       
                        <td style="text-align: right;"><?=$tot_amt?></td>
                        <td style="text-align: right;"><?=$tot_dis?></td>
                        <td style="text-align: right;"><?=$tot_tax?></td>
                        <td style="text-align: right;"><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?>

    <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
            if (!empty($report_result['bill_date'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Bill Date</th>
                      
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['bill_date'] as $key => $rd):
                        $t_amount = $rd->amount;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $rd->recm_supbilldatebs; ?></td>           
                                
                        <td style="text-align: right;"><?php echo number_format($t_amount,2); ?></td>           
                        <td style="text-align: right;"><?php echo number_format($rd->discount,2); ?></td>     
                        <td style="text-align: right;"><?php echo number_format($rd->taxamount,2); ?></td>     
                        <td style="text-align: right;"><?php echo number_format($rd->recm_gtotal,2); ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($t_amount) ? $t_amount : 0;
                     
                        $tot_dis += !empty($rd->discount) ? $rd->discount : 0;
                        $tot_tax += !empty($rd->taxamount) ? $rd->taxamount : 0;
                        $tot_gtotal += !empty($rd->recm_gtotal) ? $rd->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2' style="text-align: center;">Total</td>
                       
                        <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_dis,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_tax,2)?></td>
                        <td style="text-align: right;"><?=number_format($tot_gtotal,2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?>
    </div>
</div>