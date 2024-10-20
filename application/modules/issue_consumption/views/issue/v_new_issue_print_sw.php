<style>
	.table_jo_header,
	.jo_tbl_head,
	.jo_table,
	.jo_footer {
		width: 100%;
		font-size: 12px;
		border-collapse: collapse;
	}

	.table_jo_header {
		width: 100%;
		vertical-align: top;
		font-size: 12px;
	}

	.table_jo_header td.text-center {
		text-align: center;
	}

	.table_jo_header td.text-right {
		text-align: right;
	}

	h4 {
		font-size: 18px;
		margin: 0;
	}

	.table_jo_header u {
		text-decoration: underline;
		padding-top: 15px;
	}

	.jo_tbl_head td td {
		padding-bottom: 10px;
	}

	.jo_table {
		margin-top: 15px !important;
	}

	.jo_table {
		border-right: 1px solid #333;
		margin-top: 5px;
	}

	.jo_table tr th {
		border-top: 1px solid #333;
		border-bottom: 1px solid #333;
		border-left: 1px solid #333;
	}

	.jo_table tr th {
		padding: 5px 3px;
	}

	.jo_table tr td {
		padding: 3px 3px;
		height: 15px;
		border-left: 1px solid #333;
	}

	.jo_footer {
		border: 1px solid #333;
		vertical-align: top;
	}

	.jo_footer td {
		padding: 3px;
	}

	.footerWrapper {
		padding-top: 20px
	}

	.jo_table_footer td {
		padding: 4px;
		font-size: 12px
	}

	.preeti {
		font-family: preeti;
	}

	.borderbottom {
		border-bottom: 1px dashed #333;
		margin: 0px;
		padding: 0px;
	}

	.tableWrapper {
		min-height: 40%;
		height: 40vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		margin: 0px !important;
		/*overflow-y: auto;*/
	}

	.itemInfo {
		height: 100%;
	}

	.itemInfo .td_cell {
		padding: 5px;
		margin: 2px;
	}

	.itemInfo .td_empty {
		height: 100%;
	}

	.jo_table tr td {
		border-bottom: 1px solid #000;
		padding: 0px 4px;
	}

	/*.itemInfo tr:last-child td{border:0px !important;}
	.itemInfo {border-bottom: 0px;}*/
	.footerWrapper {
		page-break-inside: avoid;
	}

	.dateDashedLine {
		min-width: 100px;
		display: inline-block;
		border: 1px dashed #333;
	}

	.signatureDashedLine {
		min-width: 170px;
		display: inline-block;
		border: 1px dashed #333;
	}

	.jo_footer img {
		margin-top: -15px;
		margin-left: 10px;
	}

	img.signatureImage {
		width: 70px;
	}

	td.magh_faram span.borderbottom {
		min-width: 80px;
		display: inline-block;
		margin: 0px;
		padding: 0px;
		text-align: center;
	}
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper">
			<?php

		$header['report_no'] = 'म.ले.प.फारम.नं ४०१';
		// $header['old_report_no'] = 'साबिकको फारम न. ५१';

		// $header['report_title'] = 'माग फारम';
		$mattype = !empty($stock_requisition_details[0]->rema_mattypeid) ? $stock_requisition_details[0]->rema_mattypeid : '';

		if ($mattype == '1') {

			$header['report_title'] = 'माग/निकासी फाराम (नखप्ने सामान )';
		} else {

			$header['report_title'] = 'माग/निकासी फाराम(खप्ने सामान )';
		}

		$this->load->view('common/v_print_report_header', $header);

		?>
		<table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">
			<tr>
				<td width="40%">
				<span style="font-size: 12px; margin-bottom: 5px;" class="<?php echo FONT_CLASS; ?>"> आर्थिक वर्ष :- </span> <span class="borderbottom">
					</span>

					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">
						<?php

						echo !empty($issue_master[0]->sama_fyear) ? $issue_master[0]->sama_fyear : ''; ?> </span>
				</td>
				<td width="20%">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">माग फारम नं :</span>
					<strong>
					<?php if ($issue_details) {
							echo !empty($issue_master[0]->sama_requisitionno) ? $issue_master[0]->sama_requisitionno : '';
						} else {
							echo !empty($report_data['sama_requisitionno']) ? $report_data['sama_requisitionno'] : '';
						} ?></span>
						</strong>
				</td>
				<td width="40%" style="text-align: right;" class="text-center magh_faram">
					
						माग मिति:<strong><span class="borderbottom" style="min-width:80px;display: inline-block;margin: 0px;padding: 0px; "><?php echo !empty($stock_requisition[0]->rema_reqdatebs) ? $stock_requisition[0]->rema_reqdatebs : CURDATE_NP; ?></span></strong>

				</td>

				<!-- rema_reqdatebs -->

			</tr>
			<tr>
				<td width="40%">

					
				</td>
				<td width="20%">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">निकासी नं : </span><span class="borderbottom" style="min-width:80px;display: inline-block;margin: 0px;padding: 0px; ">
						<?php if ($issue_details) {
							echo !empty($issue_master[0]->sama_invoiceno) ? $issue_master[0]->sama_invoiceno : '';
						} else {
							echo !empty($report_data['sama_invoiceno']) ? $report_data['sama_invoiceno'] : '';
						} ?></span></td>
				<td width="40%" style="text-align: right;">

					निकासी मिति:<span class="borderbottom" style="min-width:80px;display: inline-block;margin: 0px;padding: 0px; "><strong>
						<?php
						if (DEFAULT_DATEPICKER == 'NP') {
							echo !empty($issue_master[0]->sama_billdatebs) ? $issue_master[0]->sama_billdatebs : '';
						} else {
							echo !empty($issue_master[0]->sama_billdatead) ? $issue_master[0]->sama_billdatead : '';
						}
						?>
					</strong></span>

				</td>
			</tr>
		</table>


		
	</div>
	<div class="tableWrapper" style="margin-top: 10px;">
		<table class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<thead>
					<th width="3%" class="td_cell"> क्.सं.</th>
					<th width="25%" class="td_cell">सामानको नाम</th>
					<th width="20%" class="td_cell">स्पेसिफिकेशन</th>
					<th width="10%" class="td_cell">सामानको परिमाण </th>
					<th width="8%" class="td_cell">एकाइ </th>
					<th width="10%" class="td_cell">निकासी सामानको परिमाण </th>
					<th width="10%" class="td_cell">जिन्सी खाता पाना नम्बर </th>
					<th width="12%" class="td_cell">कैफियत </th>
				</tr>

			</thead>
				
			<tbody>
				<?php
				if ($issue_details) {
					$gtotal = 0;
					foreach ($issue_details as $key => $products) :
				?>
						<tr>
							<td class="td_cell" style="text-align: center">
								<?php echo $key + 1; ?>
							</td>
							
							<td class="td_cell">
								<?php
								if (ITEM_DISPLAY_TYPE == 'NP') {
									echo !empty($products->itli_itemnamenp) ? $products->itli_itemnamenp : $products->itli_itemname;
								} else {
									echo !empty($products->itli_itemname) ? $products->itli_itemname : '';
								}
								
								?>
							</td>
							<td class="td_cell"></td>

							<td class="td_cell" style="text-align: right;">
								<?php $order_qty = !empty($products->rede_qty) ? $products->rede_qty : ''; ?>
								<?php echo sprintf('%g',$order_qty); ?>
							</td>
							<td class="td_cell" style="text-align: center">
								<?php $unit = !empty($products->unit_unitname) ? $products->unit_unitname : ''; ?>
								<?php echo $unit; ?>
							</td>

							<td class="td_cell" style="text-align: right;">
								<?php $qty = !empty($products->totalqty) ? $products->totalqty : ''; ?>
								<?php echo sprintf('%g', $qty); ?>
							</td>
							
							<td class="td_cell" style="text-align: center">
								<?php echo $products->itli_itemcode; ?>
							</td>

							<td class="td_cell"></td>
							
						</tr>
					<?php
						
					endforeach;
					?>
					<?php
					$products = array();
					$row_count = count($products);
					if ($row_count < 12) :
					?>
						<tr>
							<td class="td_empty" style="text-align: center"></td>
							<td class="td_empty" style="text-align: center"></td>
							<td class="td_empty" style="text-align: center"></td>
							<td class="td_empty" style="text-align: center"></td>
							<td class="td_empty" style="text-align: center"></td>
							<td class="td_empty" style="text-align: center"></td>
							<td class="td_empty" style="text-align: center"></td>
							<td class="td_empty" style="text-align: center"></td>
							
						</tr>
					<?php endif ?>
				<?php } else { ?>
					<?php
					$itemid = !empty($report_data['sade_itemsid']) ? $report_data['sade_itemsid'] : '';
					if (!empty($itemid)) : // echo"<pre>";print_r($itemid);die;
						foreach ($itemid as $key => $products) :
					?>
							<tr>
								<td class="td_cell" style="text-align: center">
									<?php echo $key + 1; ?>
								</td>
								
								<td class="td_cell" style="text-align: center">
									<?php
									$itemid = !empty($report_data['sade_itemsid'][$key]) ? $report_data['sade_itemsid'][$key] : '';
									$itemname =  $this->general->get_tbl_data('*', 'itli_itemslist', array('itli_itemlistid' => $itemid), false, 'DESC');
									if (ITEM_DISPLAY_TYPE == 'NP') {
										$iss_itemname = !empty($itemname[0]->itli_itemnamenp) ? $itemname[0]->itli_itemnamenp : $itemname[0]->itli_itemname;
									} else {
										$iss_itemname = !empty($itemname[0]->itli_itemname) ? $itemname[0]->itli_itemname : '';
									}
									echo $iss_itemname;
									?>
								</td>
								<td class="td_cell"></td>

								
								<td class="td_cell" style="text-align: center">
									<?php echo !empty($report_data['remqty'][$key]) ? $report_data['remqty'][$key] : ''; ?>
								</td>
								<td class="td_cell" style="text-align: center">
									<?php echo !empty($report_data['unit'][$key]) ? $report_data['unit'][$key] : ''; ?>
								</td>
								
								<td class="td_cell" style="text-align: center">
									<?php echo !empty($report_data['sade_qty'][$key]) ? $report_data['sade_qty'][$key] : ''; ?>
								</td>

								<td class="td_cell" style="text-align: center">
									<?php
									$itemid = !empty($report_data['sade_itemsid'][$key]) ? $report_data['sade_itemsid'][$key] : '';
									$itemname =  $this->general->get_tbl_data('*', 'itli_itemslist', array('itli_itemlistid' => $itemid), false, 'DESC');
									echo !empty($itemname[0]->itli_itemcode) ? $itemname[0]->itli_itemcode : '';
									?>
									<?php echo !empty($report_data['rede_code'][$key]) ? $report_data['rede_code'][$key] : ''; ?>
								</td>

								<td class="<td class="td_cell">" style="text-align: center">
									<?php echo !empty($report_data['sade_remarks'][$key]) ? $report_data['sade_remarks'][$key] : ''; ?>
								</td>
							</tr>
						<?php
						endforeach; ?>
						<?php
						$row_count = count($report_data['sade_itemsid']);
						if ($row_count < 12) :
						?>
							<tr>
								<td class="td_empty" style="text-align: center"></td>
								<td class="td_empty" style="text-align: center"></td>
								<td class="td_empty" style="text-align: center"></td>
								<td class="td_empty" style="text-align: center"></td>
								<td class="td_empty" style="text-align: center"></td>
								<td class="td_empty" style="text-align: center"></td>
								<td class="td_empty" style="text-align: center"></td>
								<td class="td_empty" style="text-align: center"></td>
							</tr>
						<?php endif ?>
				<?php
					endif;
				}
				?>
				<tr style="height:350px;">
					<td style="text-align: center"></td>
					<td style="text-align: center"></td>
					<td style="text-align: center"></td>
					<td style="text-align: center"></td>
					<td style="text-align: center"></td>
					<td style="text-align: center"></td>
					<td style="text-align: center"></td>
					<td style="text-align: center"></td>
					
				</tr>
				
			</tbody>
		</table>
	</div>
	
	<div class="footerWrapper">
		 <table class="jo_footer" style="padding-top: 50px;padding-bottom: 0px;border: 0px solid #000;border-top: 0px;page-break-inside: avoid;">

      <tr>

         <td width="60%" style="padding-top: 30px;"> 

            बजेटमा रकम ब्यवस्था छ/छैन ?

          	</td>

         <td width="40%" style="padding-top: 30px;"> 

            मौज्दात छ/छैन ?

         </td>

      </tr>

      <tr>

         <td style="padding-top: 25px;">

            <?php

            if(!empty($accountant_fullname)):

               ?>

            <span class="signatureDateLine">

               <?php 

               echo $accountant_fullname; 

               echo ($accountant_empid)?'('.$accountant_empid.')':'';

               ?>

            </span> 

             <span class="signatureDashedLine spanborder" >

               <?php 

                  echo $accountant_date; 

               ?>

            </span> 

            <?php

            else:

               ?>

               <span class="signatureDashedLine"></span>

               <?php

            endif;

            ?>

            <br/><strong>लेखा अधिकृत </strong>
            <br>नाम:-
            <br>पद:-

         </td>

         <td style="padding-top: 10px">
			<span class="signatureDashedLine"></span>
		 </br>
         <strong>स्टोर किपर</strong>
         <br>नाम:-
          <br>पद:-
      </td>

      <td style="padding-top: 10px">

         <?php

         $demander_date = !empty($stock_requisition[0]->rema_reqdatebs)?$stock_requisition[0]->rema_reqdatebs:'';
         $demander_fullname=!empty($stock_requisition[0]->rema_reqby)?$stock_requisition[0]->rema_reqby:'';

       ?>

         <span class="signatureDashedLine"></span> <strong>माग गर्नेको सही</strong>
          <br>मिति :- <?php  echo $demander_date;  ?>
          <br>नाम:-<?php   echo $demander_fullname;;  ?>
          <br>पद:-


   </td>

</tr>

<tr>

   <td style="padding-top: 25px;">

      

      <span class="signatureDashedLine">

      </span>

  </br>

      <strong>बजारबाट  खरीद  गर्न स्वीकृत </strong>
      <br>मिति :-
      <br>नाम:-
     <br>पद:-

  </td>

  <td>
  	<span class="signatureDashedLine"></span>
		 </br>
         <strong>स्टोर प्रमुख</strong>
         <br>मिति :-
         <br>नाम:-
          <br>पद:-
  </td>

  

  <td style="padding-top: 20px;padding-bottom: 20px;">

   <span class="signatureDashedLine"></span> <strong>शाखा प्रमुखको सिफारिश </strong>
     <br>मिति :-
     <br>नाम:-
     <br>पद:-
  

</td>

</tr>

<tr>

   <td style="padding-top: 20px;padding-bottom: 20px;">
	<span class="signatureDashedLine"></span><br><strong>आदेश  दिने अधिकारी</strong>
	<br>मिति :-
	<br>नाम:-
    <br>पद:-
   </td>
   <td>
   </td>

   <td style="padding-top: 10px;padding-bottom: 20px;">
	<span class="signatureDashedLine"></span><strong>मालसामान बुझ्नेको सही</strong>
	 <br> मिति :-
	 <br>नाम:-
     <br>पद:-
   </td>

</tr>

</table>
	</div>
</div>