<style type="text/css">
.table-header thead tr td {
    padding: 10px 0;
}
.table-header tbody td {
    padding: 0px 0 28px 0;
}

.main-table {
    width: 100%;
    border: 1px solid;
    margin-top: 28px;
}
.main-table tbody tr th {
    border: 1px solid;
    border-top: none;
    border-left: none;
    text-align: center;
}
td.empty {
    height: 35vh;
    border: 1px solid;
    border-top: none;
    border-left: none;
}
.bottom-table {
	/*border: 1px solid;*/
    margin: 40px 0 0 0;
}
.bottom-table tr td {
	padding: 9px 7px;
}
.table-header tr .thead_td-01 {
    padding-bottom: 28px;
}
.main span {
    color: #00a4e4;
}
.table-header tr td {
	/*font-weight: 600;*/
}
</style>

<table class="main" style="width: 100%;">
	<?php 
			$header['report_no'] = '';
			$header['report_title'] = 'जिन्सी आम्दानी भौचर';
			$this->load->view('common/v_print_report_header',$header);
		?>
	<table style="width: 100%; margin-top: -30px;" class="table-header">
		<thead>
			<!-- <tr>
				<h1 style="text-align: center; font-weight: 600;">Material Income Voucher </h1>
			</tr> -->
			<?php if($issue_master){
    		$invoiceno = !empty($issue_master[0]->haov_handoverno)?$issue_master[0]->haov_handoverno:'';
    		$handover_reqno = !empty($issue_master[0]->haov_handoverreqno)?$issue_master[0]->haov_handoverreqno:'';
    		$handoverby = !empty($issue_master[0]->haov_handoverby)?$issue_master[0]->haov_handoverby:'';
    		$orderby = !empty($issue_master[0]->haov_receivedby)?$issue_master[0]->haov_receivedby:'';
    		$depid = !empty($issue_master[0]->haov_depid)?$issue_master[0]->haov_depid:'';
    		$fromlocation = !empty($issue_master[0]->fromlocation)?$issue_master[0]->fromlocation:'';

    		$dep_info =  $this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$depid),false,'DESC');
    		$depname = !empty($dep_info[0]->dept_depname)?$dep_info[0]->dept_depname:'';

    		if(DEFAULT_DATEPICKER == 'NP'){
    			$issue_date = !empty($issue_master[0]->haov_reqdatebs)?$issue_master[0]->haov_reqdatebs:'';
    			$req_date = !empty($issue_master[0]->haov_reqdatebs)?$issue_master[0]->haov_reqdatebs:'';
    		}else{
    			$issue_date = !empty($issue_master[0]->haov_reqdatead)?$issue_master[0]->haov_reqdatead:'';
    			$req_date = !empty($issue_master[0]->haov_reqdatead)?$issue_master[0]->haov_reqdatead:'';
    		}

	    	$receivedby = !empty($issue_master[0]->haov_receivedby)?$issue_master[0]->haov_receivedby:'';
    	} 
    	?>
		
				<tr>
					<td width="70%">दा.न. :<?php echo $handover_reqno ?></td>
					<td>फर्मको नाम  :<?php echo $handoverby;  ?> </td>
				</tr> <br> 
				<tr>
					<td width="70%">खरिद आदेश न. :<?php echo $orderby;  ?></td>
					<td>बिल न. र मिति  :<?php echo $invoiceno.','.$req_date.''  ?></td>
				</tr> <br> 
				<tr>
					<td width="70%">सामानको किसिम :</td>
					<td>स्टोर दाखिला मिति :<?php echo $req_date ?></td>
				</tr> <br> 
				<!-- <tr></tr> <br> 
				<tr></tr> <br> 
				<tr></tr>
			 -->

			</thead>

	</table>

	<table class="main-table">
		<thead>
		<tr>
			<th rowspan="2" style="border:1px solid;padding: 7px;">सि.न.</th>
			<th rowspan="2" style="border:1px solid;padding: 7px;">सामानको कोड न.</th>
			<th rowspan="2" style="border:1px solid;padding: 7px;">विवरण </th>
			<th rowspan="2" style="border:1px solid;padding: 7px;">परिमाण आदेश  </th>
			<th rowspan="2" style="border:1px solid;padding: 7px;">इकाई</th>
			<th rowspan="2" style="text-align: center;border:1px solid;padding: 4px;">परिणाम प्राप्त </th>
			<th style="border:1px solid;padding: 7px;">दर </th>
			<th style="border:1px solid;padding: 7px;">जम्मा रकम </th>
			<th style="border:1px solid;padding: 7px;" rowspan="2">कैफियत</th>
		</tr>
		
		
		<tr>
			<th style="border:1px solid;padding: 7px;">रु</th>
			<th style="border:1px solid;padding: 7px;">रु</th>
		</tr>
		</thead>
		<tbody>
			<?php
					if($all_issue_details){
						// print_r($all_issue_details);
						// die();
						$i=0;
						$gtotal=0;
						foreach($all_issue_details as $key=>$products):
							$productcode = !empty($products->itli_itemcode)?$products->itli_itemcode:'';
							$productname = !empty($products->itli_itemname)?$products->itli_itemname:'';
							$unit=!empty($products->unit_unitname)?$products->unit_unitname:'';
							$hard_qty=!empty($products->haod_qty)?$products->haod_qty:'';	
							$rate = !empty($products->haod_unitprice)?$products->haod_unitprice:'';
							$total=!empty($products->haod_totalamt)?$products->haod_totalamt:'';
							$remaks=!empty($products->haod_remarks)?$products->haod_remarks:'';
				?>
					<tr>
		                <td  style="border:1px solid;padding: 4px;">
		                    <?php echo $i+1; ?>
		                </td>
		               
		                <td  style="border:1px solid;padding: 4px;">
		                    <?php echo $productcode; ?>
		                </td>
		               
		                <td  style="border:1px solid;padding: 4px;">
		                    <?php echo $productname; ?>
		                </td>
		               
		                <td   style="border:1px solid;padding: 4px;">
		                   <?php echo $hard_qty; ?>
		                </td>
		                
		                <td   style="border:1px solid;padding: 4px;"> 
		                    <?php echo $unit; ?> 
		                </td>
		                  <td  style="border:1px solid;padding: 4px;">
		                   <?php echo $hard_qty; ?>
		                </td>
		                 
		                <td  style="border:1px solid;padding: 4px;">
		                    <?php echo $rate;?>
		                </td>
		                <td  style="border:1px solid;padding: 4px;">
		                	 <?php echo $total;?>
		                </td>
		                 <td style="border:1px solid;padding: 4px;"><?php echo $remaks; ?></td> 
		            </tr>
		        <?php 
		        $gtotal+= $total;
		        $i++;
					endforeach;

				}
					

			$row_count = count($all_issue_details);
			if($row_count< 7):
			?>
		<tr>
			<td class="empty"></td>
			<td class="empty"></td>
			<td class="empty"></td>
			<td class="empty"></td>
			<td class="empty"></td>
			<td class="empty"></td>
			<td class="empty"></td>
			<td class="empty"></td>
			<td class="empty"></td>
		</tr>
		<?php endif;
		 ?>
	</tbody>

		<tr>
			<th  style="text-align: left; padding-left: 2px;">अक्ष्ररेपी:</th> 
			
			<th  colspan="6" style="border-bottom: 1px solid; border-right: 1px solid"><?php echo !empty($gtotal)?$this->general->number_to_word( $gtotal):''; ?></th>
			<th colspan="1" style="text-align: center; border-right: 1px solid">Total:</th>
			<th style="border-bottom: 1px solid; border-right: 1px solid"><?php echo !empty($gtotal)? $gtotal:''; ?></th>
		</tr>

	</table>


		<table width="100%" class="bottom-table">
			<tr>
				<td style="width: 50%;">माथि उलेखित सामानहरु आम्दानी बाँध्न आदेश दिने </td>
				<td>उलेखित सामानहरु नियमानुसार आम्दानी बाँधिएको छ । </td>
			</tr>

			<tr>
				<td style="width: 50%; margin-top: 28px ;"> 
					<span style="border-bottom:1px dashed #333"> <?php echo $store_head_signature; ?></span>
				</td>
				<td> 
					<span style="border-bottom:1px dashed #333"> <?php echo $user_signature; ?></span>
				</td>
			</tr>
			<tr>
				<td>जिन्सिशाखा प्रमुखको सहि </td>
				<td>स्टोर किपरको सहि </td>
			</tr>
			<tr>
				<td>नाम :<?php echo $store_head_signature; ?> </td>
				<td>नाम :<?php echo $user_signature; ?> </td>
			</tr>

			<tr>
				<td>पद : </td>
				<td>पद : </td>
			</tr>
		</table>
</table>