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
                        <th width="5%">S.N</th>
                        <th width="5%">Disposal Type</th>
                        <th width="5%">Grand Total</th>
                        <th width="5%">Sales Cost</th>
                        <th width="5%">Item Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    $sales_total = 0;
                    $item_total = 0;
                    foreach ($report_result as $key => $value):
                        $grand_total += $value->asdd_sales_amount; 
                        $sales_total += $value->asdd_sales_totalamt; 
                        $item_total += $value->item_count; 
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $value->dety_name; ?></td>           
                        <td style="text-align:right;"><?php echo $value->asdd_sales_amount; ?></td>           
                        <td style="text-align:right;"><?php echo $value->asdd_sales_totalamt; ?></td>                 
                        <td style="text-align:right;"><?php echo sprintf("%g",$value->item_count); ?></td>           
                    </tr>
                    <?php endforeach;?>
                    <tr style="text-align:right">
                        <td colspan="2">Total</td>
                        <td><?php echo number_format($grand_total,2); ?></td>
                        <td><?php echo number_format($sales_total,2); ?></td>
                        <td><?php echo $item_total; ?></td>

                    </tr>
                </tbody>
                
            </table>
        </div>
    <br>
    <?php endif;?>
     </div> 