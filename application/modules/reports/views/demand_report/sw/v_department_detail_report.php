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
       $this->load->view('v_common_report_head.php'); 
       ?>
        

    <?php if (!empty($report_result)):
    		foreach ($report_result as $key => $result):
    ?>
    <div style="padding: 10px">
    <h5 ><strong><?=$result['name']?></strong></h5>
    <?php if(count($result['details'])):?>
 	<div class="table-responsive">
        <table class="table  alt_table">
        	<thead>
        		<tr>
        			<th width="3%">S.N</th>
        			<th width="5%">Req. Date(A.D)</th>
        			<th width="5%">Req. Date(B.S)</th>
        			<th width="5%">Req. No</th>
                    <th width="20%">Item Name</th>
        			<th width="5%" style="text-align: center;">Req. Qty</th>
                    <th width="5%" style="text-align: center;">Issued Qty</th>
                    <th width="5%" style="text-align: center;">Rem. Qty</th>
        			<th width="8%">Material Type</th>
                    <th width="5%">Req. By</th>
        			<th width="15%">Remarks</th>
        		</tr>
        	</thead>
        	<tbody>
        		<?php 
        		$tot_qty = $tot_issued_qty = $tot_rem_qty = 0;
        		foreach($result['details'] as $kd => $det):?>
        			<tr>
    				<td><?=$kd+1?></td>
        			<td><?=$det->rema_reqdatead?></td>
        			<td><?=$det->rema_reqdatebs?></td>
        			<td><?=$det->rema_reqno?></td>
                    <td><?=$det->itli_itemcode.'-'.$det->itli_itemname?><br>(<?=$det->unit_unitname?>)</td>
        			<td align="center"><?=$det->rede_qty?></td>
        			<td align="right"><?=($det->rede_qty - $det->rede_remqty)?></td>
        			<td align="center"><?=$det->rede_remqty?></td>
        			<td ><?=$det->maty_material?></td>
                    <td ><?=$det->rema_reqby?></td>
        			<td ><?=$det->rede_remarks?></td>
        			</tr>
    				<?php
    					$tot_qty +=$det->rede_qty;
    					$tot_rem_qty += $det->rede_remqty; 
   
    				?>
        		<?php endforeach;?>
    			<tr>
    				<td colspan="5">Grand Total</td>
                    <td align="center"><?=number_format($tot_qty,2)?></td>
    				<td align="right"><?=number_format(($tot_qty - $tot_rem_qty),2)?></td>
    				<td align="right"><?=number_format($tot_rem_qty,2)?></td>
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
        