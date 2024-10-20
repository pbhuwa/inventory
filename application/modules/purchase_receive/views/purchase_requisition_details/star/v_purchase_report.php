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

	.jo_table {
		border-right: 1px solid #333;
		border-bottom: 1px solid #000;
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
		border-bottom: 1px solid #333;
		font-size: 12px;
	}

	.jo_footer {
		vertical-align: top;
	}

	.jo_footer td {
		padding: 4px 8px;
	}

	.borderbottom {
		border-bottom: 1px dashed #333;
		padding-bottom: 0px;
	}

	.tableWrapper {
		min-height: 45%;
		height: 45vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
	}

	.itemInfo {
		height: 100%;
	}

	.itemInfo .td_cell {
		padding: 5px;
		margin: 5px;
	}

	.itemInfo .td_empty {
		height: 100%;
		border-style: none;
	}

	.footerWrapper {
		margin-top: 20px;
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

	/*.jo_table tr td{border-bottom: 1px solid #000; padding: 0px 4px;}*/
	/*.itemInfo tr:last-child td{border:0px !important;}
	.itemInfo {border-bottom: 0px;}*/
	/*	@page {
	   size: 7in 9.25in;
	}*/
	.jo_footer img {
		margin-top: -15px;
		margin-left: 10px;
	}

	img.signatureImage {
		width: 70px;
	}
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper" style="margin-bottom: -25px ">

		<?php
		$mattype = !empty($requisition_details[0]->pure_mattypeid) ? $requisition_details[0]->pure_mattypeid : '';

		if ($mattype == '1') {

			$header['report_title'] = 'नखप्ने सामान माग फारम (खरिद)';
		} else if($mattype == '2') {

			$header['report_title'] = 'खप्ने सामान माग फारम (खरिद) ';
		}
		else{
			$header['report_title'] = 'माग फारम(खरिद)';
		}


		$header['report_no'] = 'म.ले.प.फारम.नं ४०१';
		// $header['report_title'] = 'माग फारम (खरिद)';
		$this->load->view('common/v_print_report_header', $header);
		?>

		<table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">
			<tr>
				<td width="35%">

					<span style="font-size: 12px; margin-bottom: 5px;" class="<?php echo FONT_CLASS; ?>"> आर्थिक वर्ष :- </span> <span class="borderbottom">
					</span>

					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">
						<strong><?php

						echo !empty($requisition_details[0]->pure_fyear) ? $requisition_details[0]->pure_fyear : ''; ?></strong> </span>

				</td>
				<td width="30%">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">खरिद माग फारम नं :</span>

					<?php
					if ($requisition_details) {
						$pure_reqno = !empty($requisition_details[0]->pure_reqno) ? $requisition_details[0]->pure_reqno : '';
					} else {
						$pure_reqno = !empty($report_data['rema_reqno']) ? $report_data['rema_reqno'] : '';
					}
					?>
					<span class="borderbottom">
						<strong><?php echo $pure_reqno; ?></strong>
					</span>
					<?php
					$store_reqno = !empty($requisition_details[0]->pure_streqno) ? $requisition_details[0]->pure_streqno : '';
					if(!empty($store_reqno)):
					?>
					<div style="float:right"><span>माग नं :<span class="borderbottom"><strong><?php echo $store_reqno; ?></strong></span>
					</span>
				</div>
					<?php 
					endif
					?>

				</td>
				
				<td width="35%" style="text-align: right;" class="text-center magh_faram">
					
						माग मिति:<strong><span class="borderbottom" style="min-width:80px;display: inline-block;margin: 0px;padding: 0px; "><?php echo !empty($requisition_details[0]->pure_reqdatebs) ? $requisition_details[0]->pure_reqdatebs : CURDATE_NP; ?></span></strong>

				</td>
				

				<!-- rema_reqdatebs -->

			</tr>
			

		</table>

	</div>



	<div class="tableWrapper">
		<table class="jo_table itemInfo" id="jo_table">
			<thead>
				<tr>
					<th width="5%" class="td_cell"> क्र.स</th>
					<th width="40%" class="td_cell"> मालसामानको विवरण </th>
					<th width="18%" class="td_cell"> स्पेसिफिकेशन (आवश्यक पर्नेमा) </th>
					<th width="8%" class="td_cell"> एकाइ </th>
					<th width="8%" class="td_cell"> सामानको परिमाण </th>
					<th width="10%" class="td_cell">जिन्सी खाता पाना नम्बर </th>
					<th width="25%" class="td_cell"> कैफियत </th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($purchase_requisition) {
					foreach ($purchase_requisition as $key => $details) { ?>
						<tr>
							<td class="td_cell">
								<?php echo $key + 1; ?>
							</td>
							<td class="td_cell">
								<?php

								if (ITEM_DISPLAY_TYPE == 'NP') {
									echo !empty($details->itli_itemnamenp) ? $details->itli_itemnamenp : $details->itli_itemname;
								} else {

									echo !empty($details->itli_itemname) ? $details->itli_itemname : '';
								}
								?>
							</td>
							<td class="td_cell"></td>
							<td class="td_cell">
								<?php echo !empty($details->unit_unitname) ? $details->unit_unitname : ''; ?>
							</td>
							<td class="td_cell" style="text-align: right">
								<?php echo !empty($details->purd_qty) ? sprintf('%g',$details->purd_qty) : ''; ?>
							</td>
							<td class="td_cell" style="text-align: right">
								<?php echo !empty($details->itli_itemcode) ? $details->itli_itemcode : ''; ?>
							</td>
							<td class="td_cell">
								<?php echo !empty($details->purd_remarks) ? $details->purd_remarks : ''; ?>
							</td>
						</tr>
					<?php
					}
					$row_count = count($purchase_requisition);
					if ($row_count < 15) :
					?>
						<tr>
							<td class="td_empty" style="border-left: 1px solid black;"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
						</tr>
				<?php
					endif;
				}
				?>
			</tbody>
		</table>
	</div>

<div class="footerWrapper">
		 <table class="jo_footer" style="padding-top: 0px;padding-bottom: 0px;border: 0px solid #000;border-top: 0px;page-break-inside: avoid;">

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