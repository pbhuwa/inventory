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
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <?php 
        if(!empty($report_result)):
    ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="5%">Date (A.D)</th>
                        <th width="5%">Date (B.S)</th>
                        <th width="7%">Disposal Type</th>
                        <th width="5%">Item Code</th>
                        <th width="8%">Item Name</th>
                        <th width="5%">Purchase Qty</th>
                        <th width="5%">Item Count</th>
                        <th width="8%">Sales Amount</th>
                        <th width="5%">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    $sales_total = 0;
                    $item_total = 0;
                    $purchase_total = 0;
                    foreach ($report_result as $key => $value):
                        $grand_total += $value->asdd_sales_amount; 
                        $sales_total += $value->asdd_sales_totalamt; 
                        $item_total += $value->asdd_disposalqty; 
                        $purchase_total += $value->asdd_purchaseqty; 
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $value->asde_desposaldatead; ?></td>           
                        <td><?php echo $value->asde_deposaldatebs; ?></td>           
                        <td><?php echo $value->dety_name; ?></td>           
                        <td><?php echo $value->itli_itemcode; ?></td>           
                        <td><?php echo $value->itli_itemname; ?></td>           
                        <td style="text-align:right;"><?php echo sprintf("%g",$value->asdd_purchaseqty); ?></td>           
                        <td style="text-align:right;"><?php echo sprintf("%g",$value->asdd_disposalqty); ?></td>           
                        <td style="text-align:right;"><?php echo $value->asdd_sales_totalamt; ?></td>                 
                        <td><?php echo $value->asdd_remarks ?></td>           
                    </tr>
                    <?php endforeach;?>
                    <tr style="text-align:right">
                        <td colspan="6">Total</td>
                        <td><?php echo $purchase_total; ?></td>
                        <td><?php echo $item_total; ?></td>
                        <td><?php echo number_format($sales_total,2); ?></td>
                        <td></td>
                    </tr>
                </tbody>
                
            </table>
        </div>
    <br>
    <?php endif;?>
     </div> 