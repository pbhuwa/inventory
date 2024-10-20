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
       
    <?php if (!empty($report_result)):
        $this->load->view('v_common_report_head');
        
		foreach ($report_result as $key => $result):
    ?>
    <div style="padding: 10px">
    <h5 ><strong><?=$result['department_name']?></strong></h5>
    <?php if(count($result['department_details'])):?>
 	<div class="table-responsive">
        <table class="table  alt_table">
        	<thead>
        		<tr>
        			<th width="2%">S.N</th>
                    <th width="5%">Issue No.</th>
                    <th width="5%">Issue Date(B.S)</th>
                    <th width="5%">Issue Date(A.D)</th>
                    <th width="5%">Item Code</th>
                    <th width="20%">Item Name</th>
                    <th width="10%">Issued By</th>
                    <th width="12%">Received By</th>
                    <th width="5%">Qty</th>
                    <th width="6%">Rate</th>
                    <th width="8%">Amount</th>
        		</tr>
        	</thead>
        	<tbody>
        		<?php 
        		$tot_amt = $tot_qty = 0;
        		foreach($result['department_details'] as $kd => $sum):
                    ?>
        			<tr>
    				<td><?=$kd+1?></td>
                    <td><?php echo $sum->sama_invoiceno; ?></td>           
                    <td><?php echo $sum->sama_billdatebs; ?></td>           
                    <td><?php echo $sum->sama_billdatead; ?></td>           
                    <td><?php echo $sum->itli_itemcode; ?></td>           
                    <td><?php echo $sum->itli_itemname; ?></td> 
    			     <td><?php echo $sum->sama_username; ?></td>           
                    <td><?php echo $sum->sama_receivedby; ?></td>           
                    <td style="text-align: right;"><?php echo sprintf('%g',($sum->sade_qty)); ?></td>           
                    <td style="text-align: right;"><?php echo number_format($sum->sade_unitrate,2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($sum->issueamt,2); ?></td>  
        			</tr>
        		<?php 
                    $tot_amt += !empty($sum->issueamt) ? $sum->issueamt : 0;
                    $tot_qty += !empty($sum->sade_qty) ? $sum->sade_qty : 0;
                    endforeach;
                ?>
    			<tr>
                    <td colspan='8' style="text-align: center;">Total</td>
                    <td style="text-align: right;"><?=sprintf('%g',($tot_qty))?></td>
                    <td></td>
                    <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                </tr>
    		</tbody>

        </table>
    </div>
    </div>

	<?php endif;endforeach;endif;?>

</div>	
</div>	
        