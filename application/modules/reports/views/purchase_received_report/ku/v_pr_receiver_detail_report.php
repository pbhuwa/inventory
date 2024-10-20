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
       ?>
    <?php if (!empty($report_result)):
    		foreach ($report_result as $key => $result):
    ?>
    <div style="padding: 10px">
    <h5 ><strong><?=$result['staff_name']?></strong></h5>
    <?php if(count($result['receiver_details'])):?>
 	<div class="table-responsive">
        <table class="table  alt_table">
        	<thead>
        		<tr>
        			<th width="3%">S.N</th>
                    <th width="5%">Rec. Date(A.D)</th>
                    <th width="5%">Rec. Date(B.S)</th>
        			<th width="7%">Inv No.</th>
        			<th width="7%">Bill No.</th>
                    <th width="8%">Supplier</th>
                    <th width="10%">Item Name</th>
        			<th width="3%" style="text-align: center;">Qty</th>
        			<th width="5%">Amount</th>
        			<th width="4%" style="text-align: center;">VAT(%)</th>
        			<th width="8%">VAT Amt.</th>
        			<th width="8%">Total Amt.</th>
                    <th width="8%">Mat.Type</th>
        			<th width="15%">Department</th>
                    <th width="13%">Received By</th>
        		</tr>
        	</thead>
        	<tbody>
        		<?php 
        		$tot_amt = $tot_vat = $tot_gtot = $tot_qty = 0;
        		foreach($result['receiver_details'] as $kd => $det):?>
        			<tr>
    				<td><?=$kd+1?></td>
                    <td><?=$det->recm_receiveddatead?></td>
                    <td><?=$det->recm_receiveddatebs?></td>
        			<td><?=$det->recm_invoiceno?></td>
        			<td><?=$det->recm_supplierbillno?></td>
        			<td><?=$det->dist_distributor?></td>
                    <td><?=$det->itli_itemcode.'-'.$det->itli_itemname?><br>(<?=$det->unit_unitname?>)</td>
        			<td align="center"><?=$det->recd_purchasedqty?></td>
        			<td align="right"><?=$det->recd_unitprice?></td>
        			<td align="center"><?=$det->recd_vatpc?></td>
        			<td align="right"><?=$det->recd_vatamt?></td>
        			<td align="right"><?=$det->recd_amount?></td>
                    <td><?=$det->maty_material?></td>
        			<td>
        				<?php
        					$tot_amt +=$det->recd_unitprice;
        					$tot_vat += $det->recd_vatamt;
        					$tot_gtot += $det->recd_amount; 
                            $tot_qty += $det->recd_purchasedqty; 
        					if (!empty($det->fromdepparent)) {
        						$department = $det->schoolname.'-'.$det->fromdepparent.'/'.$det->fromdep;
        					}else{
        						$department = $det->schoolname.'-'.$det->fromdep;
        					}

        					echo $department;
        				?>
        			</td>
                    <td style="word-wrap: normal;"><?=$det->recm_receivedby?></td>
        			</tr>
        		<?php endforeach;?>
    			<tr>
    				<td colspan="7">Grand Total</td>
                    <td align="center"> <?=number_format($tot_qty,2)?></td >
    				<td align="right"><?=number_format($tot_amt,2)?></td>
    				<td></td>
    				<td align="right"><?=number_format($tot_vat,2)?></td>
    				<td align="right"><?=number_format($tot_gtot,2)?></td>
    				<td></td>
    				<td></td>
                    <td></td>
    			</tr>
    		</tbody>

        </table>
    </div>
    </div>

	<?php endif;endforeach;endif;?>

</div>	
</div>	
        