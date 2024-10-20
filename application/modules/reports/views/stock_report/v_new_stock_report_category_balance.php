<style>
    .table>tbody>tr>td, .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important; 
}
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php 
        $this->load->view('common/v_report_header'); 
        if(!empty($stock_result)): 
        $grand_balanceqty = 0;
        $grand_balanceamt = 0;
        $db_array = array();
               
        ?>
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                    <th rowspan="2" width="5%">S.n</th>
                    <th rowspan="2" width="10%">Item code</th>
                    <th rowspan="2" width="20%">Item Name</th>
                    <th rowspan="2" width="10%">Unit</th>
                    <th rowspan="2" width="10%">Category</th>
                    <th rowspan="2" width="10%">Material Type</th>
                    <th colspan="3" width="15%" style="text-align:center;">Balance</th>
                    </tr>
                    <tr>
                        <th width="5%">Qty</th>
                        <th width="7%">Rate</th>
                        <th width="7%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $i=1;
                    $sum_openqty = 0;
                    $sum_opamt = 0;
                    $sum_purqty = 0;
                    $sum_puramt = 0;
                    $sum_issqty = 0;
                    $sum_issamt = 0;
                    $sum_balanceqty = 0;
                    $sum_balanceamt = 0;

                    foreach ($stock_result as $ksr => $srslt):
                        // print_r($srslt);die;

                        $ad_qty = 0;
                        $ad_amount = 0;
                        if (ORGANIZATION_NAME == 'NPHL') {
                            if(!empty($srslt->auction_disposal_data)){
                            $ad_data = explode('@',$srslt->auction_disposal_data);
                            $ad_qty = (float)$ad_data[0];
                            $ad_amount = (float)$ad_data[1];
                         }
                        }
                        $bal_qty = (float)($srslt->opqty + $srslt->purqty ) - ($srslt->issqty + $ad_qty);
                       
                        if($bal_qty<=0 ){ 
                            continue;
                        } 
                        
                    ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><?php echo $srslt->itli_itemcode ?></td>
                        <td><?php echo $srslt->itli_itemname ?></td>
                        <td><?php echo !empty($srslt->unit_unitname) ? $srslt->unit_unitname : ''; ?></td>
                        <td><?php echo !empty($srslt->eqca_category) ? $srslt->eqca_category : ''; ?></td>
                        <td><?php echo !empty($srslt->maty_material) ? $srslt->maty_material : ''; ?></td>
                       
                        <td>
                        <?php  
                           
                            $grand_balanceqty += $bal_qty;
                            echo sprintf('%g',$bal_qty);
                        ?> 
                        </td>
                        <td>
                        <?php
                            $bal_rate = ($srslt->trde_unitprice);
                            echo ($bal_rate > 0) ? number_format($bal_rate,2) : '';
                         ?>     
                        </td>
                        <td>
                        <?php
                            $bal_amt = ($srslt->opamt + $srslt->puramt) - $srslt->issamt;
                            $grand_balanceamt += $bal_amt; 
                            echo ($bal_amt > 0) ? number_format($bal_amt,2) : '';     
                        ?>    
                        </td>
                    </tr>
                 <?php 
                 $i++;
                endforeach; 
              ?>
              <tr>
            <th colspan="6" width="30%">Grand Total</th>
            <th width="5%">
                <?php
                if($grand_balanceqty>0){
                echo sprintf('%g',$grand_balanceqty);
                } 

                  ?>
                </th>
                <th width="7%"></th>
                 <th width="7%">
                <?php
                if($grand_balanceamt>0){
                echo number_format($grand_balanceamt,2);
                } 
                 ?>
               </th>
            </tr>
            </tbody>
        </table>    
    <?php endif;?>
    </div>
</div>