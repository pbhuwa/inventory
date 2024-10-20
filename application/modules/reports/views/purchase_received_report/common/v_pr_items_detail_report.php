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
       $this->load->view('v_common_report_head.php'); ?>

    <?php if (!empty($report_result)):
        $i=1;
    		foreach ($report_result as $key => $result):
    ?>
    <div style="padding: 10px">
    <h5 ><strong><?php echo $i ?>. <?=$result['item_name']?>&nbsp;(<?=$result['item_unit']?>)</strong></h5>
    <?php if(count($result['item_details'])):?>
 	<div class="table-responsive">
        <table class="table  alt_table">
        	<thead>
        		<tr>
        			<th width="2%">S.N</th>
        			<th width="5%">Date(A.D)</th>
        			<th width="5%">Date(B.S)</th>
        			<th width="6%">Inv No.</th>
        			<th width="5%">Bill No.</th>
                    <th width="15%">Supplier</th>
        			<th width="4%" style="text-align: center;">Qty</th>
        			<th width="5%" align="right">Unit Price</th>
        			<th width="4%" align="center">VAT(%)</th>
                    <th width="10%">Actual Unit Price</th>
        			<th width="8%" align="center">VAT Amt.</th>
        			<th width="8%" align="right">Total Amt.</th>
        			<th width="8%">Mat.Type</th>
        		   
        		</tr>
        	</thead>
        	<tbody>
        		<?php 
        		$tot_amt = $tot_vat = $tot_gtot = $tot_qty = 0;
        		foreach($result['item_details'] as $kd => $det):?>
        			<tr>
    				<td><?=$kd+1?></td>
        			<td><?=$det->recm_receiveddatead?></td>
        			<td><?=$det->recm_receiveddatebs?></td>
        			<td><?=$det->recm_invoiceno?></td>
        			<td><?=$det->recm_supplierbillno?></td>
        			<td><?=$det->dist_distributor?></td>
        			<td align="center"><?=sprintf('%g',$det->recd_purchasedqty)?></td>
        			<td align="right"><?=$det->recd_unitprice?></td>
        			<td align="center"><?=sprintf('%g',$det->recd_vatpc)?></td>
                         <td align="right"><?=($det->recd_unitprice)+($det->recd_unitprice*$det->recd_vatpc/100)?></td>
        			<td align="right"><?=$det->recd_vatamt?></td>
        			<td align="right"><?=$det->recd_amount?></td>
        			<td><?=$det->maty_material?></td>
        			<?php
                            $tot_amt +=$det->recd_unitprice;
                            $tot_vat += $det->recd_vatamt;
                            $tot_gtot += $det->recd_amount; 
                            $tot_qty += $det->recd_purchasedqty; 
                           
                        ?>
        			</tr>
        		<?php endforeach;?>
    			<tr>
    				<td colspan="6" align="center">Grand Total</td>
                    <td align="center"><?=sprintf('%g',($tot_qty))?></td>
    				<td align="right"><?=number_format($tot_amt,2)?></td>
    				<td></td>
                        <td></td>
    				<td align="right"><?=number_format($tot_vat,2)?></td>
    				<td align="right"><?=number_format($tot_gtot,2)?></td>
    				<td></td>
    			  
    			</tr>
    		</tbody>

        </table>
    </div>
    </div>

	<?php endif; $i++; endforeach;endif;?>

</div>	
</div>	
        