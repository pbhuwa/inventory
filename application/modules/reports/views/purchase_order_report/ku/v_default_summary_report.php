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
        <?php $this->load->view('common/v_report_header');
            $this->load->view('v_common_report_head.php'); 
        ?>
        <?php 
            $tot_amt = 0;
            if (!empty($report_result['summary'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Order Date (A.D)</th>
                        <th>Order Date (B.S)</th>
                        <th>Order No.</th>
                        <th>Supplier Name</th>
                        <th>Order Amt.</th>
                        <th>Delivery Date(A.D)</th>
                        <th>Delivery Date(B.S)</th>
                        <th>Req. No</th>
                        <th>Material Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['summary'] as $key => $value):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $value->puor_orderdatead?></td>
                        <td><?php echo $value->puor_orderdatebs?></td>
                        <td><?php echo $value->puor_orderno?></td>
                        <td><?php echo $value->dist_distributor?></td>
                        <td><?php echo $value->puor_amount?></td>
                        <td><?php echo $value->puor_deliverydatead?></td>
                        <td><?php echo $value->puor_deliverydatebs?></td>
                        <td><?php echo $value->puor_requno?></td>
                        <td><?php echo $value->maty_material?></td>
                             
                    </tr>
                    <?php 
                        $tot_amt += !empty($value->puor_amount) ? $value->puor_amount : 0;
                       ;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='5'>Total</td>
                        <td><?=$tot_amt?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?> 
       <?php 
        if(!empty($report_result['supplier'] )):
       ?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Supplier</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>VAT</th>
                        <th>G.Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tot_qty = $tot_rate = $tot_amount = $tot_gtotal= 0;
                    
                    foreach ($report_result['supplier'] as $key => $supp):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $supp->suppliername; ?></td>           
                        <td><?php echo $supp->qty; ?></td>           
                        <td><?php echo $supp->rate; ?></td>           
                        <td><?php echo number_format($supp->amount,2); ?></td>           
                        <td><?php echo number_format($supp->total_amount - $supp->amount,2); ?></td>           
                        <td><?php echo $supp->total_amount; ?></td>           
                    </tr>
                    <?php 
                        $tot_qty += !empty($supp->qty) ? $supp->qty : 0;
                        $tot_rate += !empty($supp->rate) ? $supp->rate : 0;
                        $tot_amount += !empty($supp->amount) ? $supp->amount : 0;
                        $tot_gtotal += !empty($supp->total_amount) ? $supp->total_amount : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_qty?></td>
                        <td><?=$tot_rate?></td>
                        <td><?=number_format($tot_amount,2)?></td>
                        <td><?=number_format($tot_gtotal - $tot_amount),2?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
        $tot_qty = $tot_rate = $tot_amount = $tot_gtotal= 0;    
        if (!empty($report_result['material'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Material Category</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>VAT</th>
                        <th>G.Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['material'] as $key => $mat):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $mat->materialname; ?></td>           
                        <td><?php echo $mat->qty; ?></td>           
                        <td><?php echo $mat->rate; ?></td>           
                        <td><?php echo number_format($mat->amount,2); ?></td>           
                        <td><?php echo number_format($mat->total_amount - $mat->amount,2); ?></td>
                        <td><?php echo $mat->total_amount; ?></td>           
                    </tr>
                    <?php 
                        $tot_qty += !empty($mat->qty) ? $mat->qty : 0;
                        $tot_rate += !empty($mat->rate) ? $mat->rate : 0;
                        $tot_amount += !empty($mat->amount) ? $mat->amount : 0;
                        $tot_gtotal += !empty($mat->total_amount) ? $mat->total_amount : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_qty?></td>
                        <td><?=$tot_rate?></td>
                        <td><?=number_format($tot_amount,2)?></td>
                        <td><?=number_format($tot_gtotal - $tot_amount,2)?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     
    <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
            if (!empty($report_result['order_date'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Order Date</th>
                         <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>VAT</th>
                        <th>G.Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['order_date'] as $key => $mat):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo "$mat->puor_orderdatebs (B.S)-$mat->puor_orderdatead (A.D)"; ?></td>           
                        <td><?php echo $mat->qty; ?></td>           
                        <td><?php echo $mat->rate; ?></td>           
                        <td><?php echo number_format($mat->amount,2); ?></td>           
                        <td><?php echo number_format($mat->total_amount - $mat->amount,2); ?></td>
                        <td><?php echo $mat->total_amount; ?></td>           
                    </tr>
                    <?php 
                        $tot_qty += !empty($mat->qty) ? $mat->qty : 0;
                        $tot_rate += !empty($mat->rate) ? $mat->rate : 0;
                        $tot_amount += !empty($mat->amount) ? $mat->amount : 0;
                        $tot_gtotal += !empty($mat->total_amount) ? $mat->total_amount : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_qty?></td>
                        <td><?=$tot_rate?></td>
                        <td><?=number_format($tot_amount,2)?></td>
                        <td><?=number_format($tot_gtotal - $tot_amount,2)?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?>

    <?php 
        $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
        if (!empty($report_result['delivery_date'])):
    ?>
    <div class="table-responsive">
        <table class="table table-striped alt_table">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th width="30%">Delivery Date</th>
                     <th>Qty</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>VAT</th>
                    <th>G.Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($report_result['delivery_date'] as $key => $mat):
                ?>  
                <tr>
                    <td><?php echo $key+1?></td>
                    <td><?php echo "$mat->puor_deliverydatebs (B.S)-$mat->puor_deliverydatead (A.D)"; ?></td>           
                    <td><?php echo $mat->qty; ?></td>           
                    <td><?php echo $mat->rate; ?></td>           
                    <td><?php echo number_format($mat->amount,2); ?></td>           
                    <td><?php echo number_format($mat->total_amount - $mat->amount,2); ?></td>
                    <td><?php echo $mat->total_amount; ?></td>           
                </tr>
                <?php 
                    $tot_qty += !empty($mat->qty) ? $mat->qty : 0;
                    $tot_rate += !empty($mat->rate) ? $mat->rate : 0;
                    $tot_amount += !empty($mat->amount) ? $mat->amount : 0;
                    $tot_gtotal += !empty($mat->total_amount) ? $mat->total_amount : 0;
                ?>
                <?php endforeach;?>
                <tr>
                    <td colspan='2'>Total</td>
                    <td><?=$tot_qty?></td>
                    <td><?=$tot_rate?></td>
                    <td><?=number_format($tot_amount,2)?></td>
                    <td><?=number_format($tot_gtotal - $tot_amount,2)?></td>
                    <td><?=$tot_gtotal?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endif;?>
    </div>
</div>