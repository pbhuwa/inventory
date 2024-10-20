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
           		
			<table class="alt_table">
			<thead>
				<tr>
					<th width="5%">S.n</th>
					<th width="10%">School</th>
					<th width="25%">Demand</th>
					<th width="20%">Issue</th>
					<th width="10%">Pur.Requisition</th>
					<th width="15%">Purchase Order</th>
					<th width="20%" align="right">Receive</th>
				</tr>
            </thead>
            <tbody>
            	<?php 
            	if(!empty($combine_data)):
            		$i=1;
            		$sum_rema=0;
            		$sum_issue=0;
            		$sum_pur_req=0;
            		$sum_po=0;
            		$sum_rec=0;

            		foreach($combine_data as $cd):
            		$sum_rema +=$cd->remaCnt;
            		$sum_issue +=$cd->issueCnt;
            		$sum_pur_req +=$cd->pur_reCnt;
            		$sum_po +=$cd->poCnt;
            		$sum_rec +=$cd->recCnt;

            	?>
            	<tr>
            		<td><?php echo $i ?>.</td>
            		<td><?php echo $cd->loca_name ?></td>
        			<td><?php echo $cd->remaCnt ?></td>
        			<td><?php echo $cd->issueCnt ?></td>
        			<td><?php echo $cd->pur_reCnt ?></td>
        			<td><?php echo $cd->poCnt ?></td>
        			<td><?php echo $cd->recCnt ?></td>
            	</tr>

            <?php 
            	$i++;
            	endforeach;
        	endif; ?>
        	<tr style="
    font-weight: bold;
    background: #f9f4eb;
">
        		<td colspan="2">G.Total</td>
        		<td><?php echo $sum_rema;  ?></td>
    			<td><?php echo $sum_issue;  ?></td>
    			<td><?php echo $sum_pur_req;  ?></td>
    			<td><?php echo $sum_po;  ?></td>
    			<td><?php echo $sum_rec;  ?></td>
        	</tr>

           
            </tbody>
		</table>
		
        </div>
    </div>
</div>