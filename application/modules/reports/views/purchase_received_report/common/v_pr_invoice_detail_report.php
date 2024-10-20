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
    <h5 ><strong style="border-bottom: 1px dotted black;"><?=$result['invoice_no']?></strong></h5>
    <?php if(count($result['invoice_detail'])):?>
 	<div class="table-responsive">
        <table class="table alt_table">
        	<thead>
        		<tr>
        			<th width="2%">S.N</th>
        			<th width="4%">Item Code</th>
        			<th width="4%">Item Name</th>
                    <th width="5%">Unit</th>
        			<th width="5%">Rec. Qty</th>
        			<th width="5%">Unit Rate.</th>
        			<th width="5%">VAT(%)</th>
        			<th width="8%">VAT Amt.</th>
        			<th width="8%">Total Amt.</th>
        			<th width="8%">Description</th>
        			
        		</tr>
        	</thead>
        	<tbody>
        		<?php 
                $j=1;
        		$tot_amt = $tot_vat = $tot_gtot = $tot_qty = 0;
        		foreach($result['invoice_detail'] as $kd => $det):

                    ?>
        			<tr>
    				<td><?=$kd+1?></td>
        			<td><?=$det->itli_itemcode?></td>
        			<td><?=$det->itli_itemname?></td>
        			<td><?=$det->unit_unitname?></td>
        			<td><?=sprintf('%g',$det->recd_purchasedqty) ?></td>
        			<td align="right"><?=$det->recd_unitprice?></td>
        			<td align="center"><?=sprintf('%g',$det->recd_vatpc)?></td>
        			<td align="right"><?=$det->recd_vatamt?></td>
        			<td align="right"><?=$det->recd_amount?></td>
        			<td><?=$det->recd_description?></td>
        			 <?php
                $tot_amt +=$det->recd_unitprice;
                $tot_vat += $det->recd_vatamt;
                $tot_gtot += $det->recd_amount; 
                $tot_qty += $det->recd_purchasedqty; 

                ?>
        			</tr>
        		<?php endforeach;?>
               
    			<tr>
    				<td colspan="4" align="center">Grand Total</td>
                    <td align="center"><?=sprintf('%g',($tot_qty))?></td>
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

	<?php endif;endforeach;endif;?>

</div>	
</div>	
        