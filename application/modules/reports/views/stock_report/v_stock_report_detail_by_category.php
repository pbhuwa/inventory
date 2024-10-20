 <style>
	.table>tbody>tr>td, .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important; 
}
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
 <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                	<tr>
                	<th rowspan="2">S.n</th>
                	<th rowspan="2">Item code</th>
                	<th rowspan="2">Item Name</th>
                	<th rowspan="2">Unit</th>
                	<th colspan="3" style="text-align:center;">Opening</th>
                	<th colspan="3" style="text-align:center;">Purchase</th>
                	<th colspan="3" style="text-align:center;">Issue</th>
                	<th colspan="3" style="text-align:center;">Balance</th>
               	 	</tr>
               	 	<tr>
               	 		<th>Qty</th>
               	 		<th>Rate</th>
               	 		<th>Amount</th>
               	 		<th>Qty</th>
               	 		<th>Rate</th>
               	 		<th>Amount</th>
               	 		<th>Qty</th>
               	 		<th>Rate</th>
               	 		<th>Amount</th>
               	 		<th>Qty</th>
               	 		<th>Rate</th>
               	 		<th>Amount</th>
               	 	</tr>
                </thead>
                <tbody>
                <?php 
                	if(!empty($stock_result)): 
                		$i=1;
                    $sum_openqty=0;
                    $sum_opamt=0;
                    $sum_purqty=0;
                    $sum_puramt=0;
                    $sum_issqty=0;
                    $sum_issamt=0;
                    $sum_balanceqty=0;
                    $sum_balanceamt=0;

                	foreach ($stock_result as $ksr => $srslt):
                ?>
                	<tr>
                		<td><?php echo $i; ?>.</td>
                		<td><?php echo $srslt->itli_itemcode ?></td>
                		<td><?php echo $srslt->itli_itemname ?></td>
                		<td><?php echo $srslt->unit_unitname ?></td>
                		<td><?php echo $srslt->opqty ; $sum_openqty += $srslt->opqty;  ?></td>
                		<td><?php  if($srslt->opamt>0){ $orate=$srslt->opamt/$srslt->opqty; echo number_format($orate,2); } else{ echo ''; }; ?></td>
                		<td><?php echo number_format($srslt->opamt,2); $sum_opamt += $srslt->opamt; ?></td>
                		<td><?php  if($srslt->purqty>0) echo $srslt->purqty; $sum_purqty += $srslt->purqty; ?></td>
                		<td><?php  if($srslt->puramt>0){  
                        $rrate=$srslt->puramt/$srslt->purqty; echo number_format($rrate,2) ;} else{ echo ''; } 
                      ?></td>
                		<td><?php if($srslt->puramt>0) echo number_format($srslt->puramt,2);  $sum_puramt += $srslt->puramt; ?></td>
                		<td><?php if($srslt->issqty >0) echo $srslt->issqty ; $sum_issqty += $srslt->issqty; ?></td>
                		<td><?php  if($srslt->issamt>0){ $irate=$srslt->issamt/$srslt->issqty ; echo number_format($irate,2); } else{ echo ''; } ?></td>
                		<td><?php if($srslt->issamt>0) echo number_format($srslt->issamt,2); $sum_issamt += $srslt->issamt;  ?></td>
                		<td><?php  if($srslt->balanceqty>0) echo $srslt->balanceqty; $sum_balanceqty += $srslt->balanceqty; ?></td>
                		<td><?php  if($srslt->balanceamt>0){ $brate=$srslt->balanceamt/$srslt->balanceqty; echo number_format($brate,2);} else {echo ''; } ?></td>
                		<td><?php if($srslt->balanceamt>0) echo number_format($srslt->balanceamt,2); $sum_balanceamt += $srslt->balanceamt; ?></td>
                	</tr>
                 <?php 
                 $i++;
            	endforeach; 
              ?>
              <tr style="
    font-weight: bold;
">
                <td colspan="4">Grand Total</td>
                 <td><?php
                    if($sum_openqty>0) echo number_format($sum_openqty,2);
                ?></td>
                <td></td>
                <td>
                <?php
                    if($sum_opamt>0) echo number_format($sum_opamt,2);
                      ?>
                </td>
                 <td>
                <?php
                    if($sum_purqty>0) echo number_format($sum_purqty,2);
                    ?>
                  </td>
                  <td></td>
                   <td>
                <?php
                    if($sum_puramt>0) echo number_format($sum_puramt,2);
                    ?>
                  </td>
                   <td>
                <?php
                if($sum_issqty>0) echo number_format($sum_issqty,2);
                ?>
              </td>
              <td></td>
               <td>
                <?php
                if($sum_issamt>0) echo number_format($sum_issamt,2);
                  ?>
                </td>
                 <td>
                <?php
                if($sum_balanceqty>0) echo number_format($sum_balanceqty,2);
                  ?>
                </td>
                <td></td>
                 <td>
                <?php
                if($sum_balanceamt>0) echo number_format($sum_balanceamt,2);
                 ?>
               </td>
                
              </tr>
              <?php
         	endif; 
         	?>
                 </tbody>
            </table>	
        </div>
    </div>
</div>
