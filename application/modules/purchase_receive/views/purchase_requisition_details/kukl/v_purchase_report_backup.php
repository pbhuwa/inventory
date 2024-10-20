<?php
   // for remarks
	$rema_workplace = !empty($purchase_requisition[0]->rema_workplace)?$purchase_requisition[0]->rema_workplace:'';
	$rema_workdesc = !empty($purchase_requisition[0]->rema_workdesc)?$purchase_requisition[0]->rema_workdesc:'';
	$rema_recommendstatus = !empty($purchase_requisition[0]->rema_recommendstatus)?$purchase_requisition[0]->rema_recommendstatus:'';
	$rema_remarks = !empty($purchase_requisition[0]->rema_remarks)?$purchase_requisition[0]->rema_remarks:'';

	$reqno = !empty($purchase_requisition[0]->rema_reqno)?$purchase_requisition[0]->rema_reqno:'';

	$fyear = !empty($purchase_requisition[0]->rema_fyear)?$purchase_requisition[0]->rema_fyear:'';

	// department supervisor
	$department_supervisor_data = $this->general->get_user_list_for_report($reqno, $fyear, '4', 'rema_approved');
	$department_supervisor_fullname = !empty($department_supervisor_data[0]->usma_fullname)?$department_supervisor_data[0]->usma_fullname:'';
	$department_supervisor_empid = !empty($department_supervisor_data[0]->usma_employeeid)?$department_supervisor_data[0]->usma_employeeid:'';

	// storekeeper
	$storekeeper_data = $this->general->get_user_list_for_report($reqno, $fyear, '1', 'rema_proceedissue');
	$storekeeper_fullname = !empty($storekeeper_data[0]->usma_fullname)?$storekeeper_data[0]->usma_fullname:'';
	$storekeeper_empid = !empty($storekeeper_data[0]->usma_employeeid)?$storekeeper_data[0]->usma_employeeid:'';

	// procurement
	$procurement_data = $this->general->get_user_list_for_report($reqno, $fyear, 'V', 'pure_isapproved');
	$procurement_fullname = !empty($procurement_data[0]->usma_fullname)?$procurement_data[0]->usma_fullname:'';
	$procurement_empid = !empty($procurement_data[0]->usma_employeeid)?$procurement_data[0]->usma_employeeid:'';

	// accountant
	$accountant_data = $this->general->get_user_list_for_report($reqno, $fyear, 'P', 'pure_isapproved');
	$accountant_fullname = !empty($accountant_data[0]->usma_fullname)?$accountant_data[0]->usma_fullname:'';
	$accountant_empid = !empty($accountant_data[0]->usma_employeeid)?$accountant_data[0]->usma_employeeid:'';

	// branch manager
	$branch_manager_data = $this->general->get_user_list_for_report($reqno, $fyear, 'Y', 'pure_isapproved');
	$branch_manager_fullname = !empty($branch_manager_data[0]->usma_fullname)?$branch_manager_data[0]->usma_fullname:'';
	$branch_manager_empid = !empty($branch_manager_data[0]->usma_employeeid)?$branch_manager_data[0]->usma_fullname:'';

	// department supervisor
	$it_officer_data = $this->general->get_user_list_for_report($reqno, $fyear, '2', 'rema_itstatus');
	$it_officer_fullname = !empty($it_officer_data[0]->usma_fullname)?$it_officer_data[0]->usma_fullname:'';
	$it_officer_empid = !empty($it_officer_data[0]->usma_employeeid)?$it_officer_data[0]->usma_employeeid:'';
?>

<style>	
	.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:14px; border-collapse:collapse; }
   .table_jo_header { width:100%; vertical-align: top; font-size:12px; }
   .table_jo_header td.text-center { text-align:center; }
   .table_jo_header td.text-right { text-align:right; }
   h4 { font-size:18px; margin:0; }
   .table_jo_header u { text-decoration:underline; padding-top:15px; }
   .jo_tbl_head td td
   {
      padding-bottom: 10px;
   }
   .jo_table{margin-top: 15px !important;}
   .jo_table { border-right:1px solid #333; margin-top:5px; }
   .jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }
   .jo_table tr th { padding:5px 3px;}
   .jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
   .jo_footer { border:1px solid #333; vertical-align: top; }
   .jo_footer td { padding:8px 8px; }
   .preeti{
      font-family: preeti;
   }
   .footerwrapper .spanborder {
      border: none !important;
      border-bottom: 1px dashed #000 !important;
   }
   .borderbottom{ border-bottom: 1px dashed #333;margin: 0px;padding: 0px; }
   .tableWrapper{
      min-height:50%;
      height:50vh;
      max-height: 100vh;
      white-space: nowrap;
      display: table;
      width: 100%;
      /*overflow-y: auto;*/
   }
   .itemInfo{
      height:100%;
   }
   .itemInfo .td_cell{
      padding:5px;margin:5px; 
   }
   .itemInfo .td_empty{
      height:100%;
   }
   .jo_table tr td{border-bottom: 1px solid #000; padding: 0px 4px;}
   /*.itemInfo tr:last-child td{border:0px !important;}
   .itemInfo {border-bottom: 0px;}*/
   .footerWrapper{
      page-break-inside: avoid;
   }
   .dateDashedLine{
      min-width: 100px;display: inline-block; border:1px dashed #333;
   }
   .signatureDashedLine {
      min-width: 170px;display: inline-block; border:1px dashed #333;
   }
   .jo_footer img{
      margin-top: -15px;
      margin-left: 10px;
   }
   img.signatureImage{
      width: 70px;
   }
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper" style="margin-bottom: -25px ">
		<?php 
            // $header['report_no'] ='म.ले.प.फा.नं ५१';	
            $header['report_title'] = 'माग फारम ';
            $this->load->view('common/v_print_report_header',$header);
        ?>

		<table width="100%">
		<!-- 	<tr>
				<td width="25%" style="white-space: nowrap;">
					<span style="padding-right: 3px;font-size: 12px;display: inline-block !important;" class="<?php echo FONT_CLASS; ?>">अनुमानित लागत</span> 
					<span class="borderbottom" style="display: inline-block !important;font-size: 12px;">
						
							<?php echo !empty($requisition_details[0]->pure_estimateamt)?$requisition_details[0]->pure_estimateamt:'0.00'; ?>
					</span>
				</td>
			</tr> -->

			<tr>
				<td width="25%" style="white-space: nowrap;">
					<span style="padding-right: 3px;font-size: 12px;display: inline-block !important;" class="<?php echo FONT_CLASS; ?>">श्री</span> 
					<span class="borderbottom" style="display: inline-block !important;font-size: 12px;">
						<?php
							if($requisition_details){
								$request_to = !empty($requisition_details[0]->pure_requestto)?$requisition_details[0]->pure_requestto:''; 
							}else{
								$request_to = !empty($report_data['requested_to'])?$report_data['requested_to']:'';
							}
						?>
							<?php echo $request_to; ?>
					</span>
				</td>
				
				<td width="25%" style="text-align: center;">
					<?php
						if($requisition_details){
							$pure_reqno = !empty($requisition_details[0]->pure_reqno)?$requisition_details[0]->pure_reqno:'';
						}else{
							$pure_reqno = !empty($report_data['rema_reqno'])?$report_data['rema_reqno']:'';
						}
					?>

					<span  style="position: relative;left: -36px;font-size: 12px;white-space: nowrap;">माग नं : 
						<span class="borderbottom"><?php echo $pure_reqno; ?></span>
					</span>
				</td>
				
				<td width="25%"  style="font-size: 12px;white-space: nowrap;text-align: center;">
					<?php
						$fiscal_year = !empty($requisition_details[0]->pure_fyear)?$requisition_details[0]->pure_fyear:CUR_FISCALYEAR;
					?>
					आर्थिक वर्ष : 
					<span class="borderbottom">
						<?php echo $fiscal_year; ?>
					</span>
				</td>

				<td width="25%"  style="font-size: 12px;white-space: nowrap;text-align: right;">
					<?php
						if(DEFAULT_DATEPICKER == 'NP'){
							$pur_reqdate = !empty($requisition_details[0]->pure_reqdatebs)?$requisition_details[0]->pure_reqdatebs:'';
						}else{
							$pur_reqdate = !empty($requisition_details[0]->pure_reqdatead)?$requisition_details[0]->pure_reqdatead:'';
						}
						
					?>
					मिति : 
					<span class="borderbottom">
						<?php echo $pur_reqdate; ?>
					</span>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="tableWrapper">
		<table class="jo_table itemInfo" id="jo_table">
			<thead>
                <tr>
                    <th width="5%" class="td_cell" rowspan="2"> सि.न.</th>
                    <!-- <th width="7%" class="td_cell" rowspan="2">जिन्सी खातापन न. </th> -->
                    <th width="25%" style="padding-left: 50px;" class="td_cell" rowspan="2"> सामानको विवरण </th>
                    <th width="7%"  style="padding-left: 60px;" class="td_cell" colspan="2"> परिमाण </th>
                    <th width="7%"  style="padding-left: 15px;" class="td_cell" rowspan="2"> इकाई </th>
                    <th width="10%" style="padding-left: 30px;" class="td_cell"> दर</th>
                    <th width="10%" style="padding-left: 10px;" class="td_cell"> जम्मा रकम </th>
                    <th width="10%" style="padding-left: 30px;" class="td_cell" rowspan="2"> कैफियत </th>
                </tr>
                
                <tr>
                    <th width="10%" style="padding-left: 30px;" class="td_cell">माग</th>
                    <th width="10%" style="padding-left: 20px;" class="td_cell">निकासा</th>
                    <th width="10%" style="padding-left: 30px;" class="td_cell"> रू</th>
                    <th width="10%" style="padding-left: 30px;" class="td_cell">रू </th>
                  </tr>
            </thead>
			<tbody>
				<?php
					if($purchase_requisition){
						$it_comment_list = array();
	                    
	                    foreach($purchase_requisition as $key => $stock){
	                        if(!empty($stock->rede_itcomment)):
	                           $it_comment_list[] = !empty($stock->rede_itcomment)?$stock->rede_itcomment:'';
	                        endif;

	                        $all_it_comment = '';
	                        if(!empty($it_comment_list)):
	                           	foreach($it_comment_list as $ikey=>$icom):
	                            	$all_it_comment .= $icom.',';
	                         	endforeach;
	                      	endif;
	                   	}

	                   	$account_comment = '';
	                   	if(!empty($account_action_log)):
	                     	foreach($account_action_log as $log):
	                        	$account_comment .= $log->usma_fullname.'-'.$log->aclo_comment.',';
	                     	endforeach;
	                 	endif;

	                  	$it_comment = rtrim($all_it_comment,',');

	                  	// $all_remarks = !empty($it_comment)?$it_comment.', '.$account_comment:$account_comment;
	                  	$all_remarks = !empty($it_comment)?$it_comment:'';

	                  	// details view start
	                  	$count_items = count($purchase_requisition);
	                  	$grandtotal=0;

						foreach ($purchase_requisition as $key => $details) { 
				?>
						<tr>
							<td class="td_cell">
								<?php echo $key+1; ?>
							</td>
							<td class="td_cell">
								<?php

								 if(ITEM_DISPLAY_TYPE=='NP')
							    	{
							    		 echo !empty($details->itli_itemnamenp)?$details->itli_itemnamenp:$details->itli_itemname;
							    	}
							    	else
							    	{
							    		
							    		 echo !empty($details->itli_itemname)?$details->itli_itemname:'';
							    	}
								?>
							</td>
							<td class="td_cell">
								<?php echo !empty($details->purd_qty)?$details->purd_qty:''; ?>
							</td>
							<td class="td_cell">
								
							</td>
							<td class="td_cell">
								<?php echo !empty($details->unit_unitname)?$details->unit_unitname:''; ?>
							</td>
							<td class="td_cell">
								
							</td>
							<td class="td_cell">
								
							</td>
							<!-- <td class="td_cell">
								<?php echo !empty($details->purd_remarks)?$details->purd_remarks:''; ?>
							</td> -->
							<?php if($key == 0): ?>
	                        <td style="height: 100%; clear: both;overflow: hidden;" class="td_cell" rowspan="<?php echo $count_items+20; ?>">
	                           <div style="writing-mode: vertical-rl;width: 100%;height: 100%; font-size:10px;">
	                              <?php 
	                           // echo !empty($stock->rede_remarks)?$stock->rede_remarks:'';
	                            if(!empty($fullremarks)):
	                               echo "Full Remarks:"; 
	                              echo !empty($fullremarks)?$fullremarks:'';
	                              endif;

	                              ?>
	                              <br/>
	                              <?php 
	                              if(!empty($it_comment)):
	                                 echo !empty($it_officer_fullname)?$it_officer_fullname.' (IT)-':'';
	                              endif;
	                              ?>  
	                              <?php 
	                              echo !empty($all_remarks)?$all_remarks:''; 
	                              ?> 
	                              <br/>
	                           </div>
	                        </td>
	                     <?php endif; ?> 
						</tr>
					<?php 
						} 
						$row_count = count($purchase_requisition);
						if($row_count < 15):
					?>
					<tr>
						<td class="td_empty"></td>
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
	
			<tfoot>
	         	<tr>
	            	<td class="td_cell" colspan="5">अक्षरूपी : <?php echo $this->general->number_to_word( $grandtotal);?> </td>
	            	<td>अनुमानित लागत :</td>
	            	<td align="right"><?php echo $grandtotal; ?></td>
	           		<td></td>
	        	</tr>
	      	</tfoot>
      	</table>
	</div>

	<div class="footerWrapper">
	   <table class="jo_footer" style="padding-top: 10px;padding-bottom: 10px;border: 0px solid #000;border-top: 0px;page-break-inside: avoid;">
	      	<tr>
	         	<td width="60%" style="padding-top: 30px;"> 
	            	बजेटमा रकम ब्यवस्था
	            	<?php
	            		echo ($check_budget_availability[0]->pure_isapproved == 'B')?'छैन':'छ';
	            	?>
	         	</td>
	         	<td width="60%" style="padding-top: 30px;"> 
	            	मौज्दात छ 
	         	</td>
	      	</tr>
	      	
	      	<tr>
	         	<td style="padding-top: 25px;">
	            	<span class="signatureDashedLine spanborder">
	               	<?php 
	               		echo $accountant_fullname; 
	              	 	echo ($accountant_empid)?'('.$accountant_empid.')':'';
	               	?>
	            	</span> 
	            	<br/>लेखा अधिकृत 
	         	</td>
	         	
	         	<td style="padding-top: 10px;white-space: nowrap;">
	            	<?php
	            		if(!empty($storekeeper_fullname)):
	               	?>
	               	<span class="signatureDashedLine spanborder"  >
	                	<?php 
	                  		echo $storekeeper_fullname; 
	                  		echo ($storekeeper_empid)?'('.$storekeeper_empid.')':'';
	                  	?>
	               </span>
	               	<?php
	            		else:
	               	?>
	               		<span class="signatureDashedLine"></span>
	               	<?php
	            		endif;
	            	?>
	        		</br>
	         		स्टोर किपर
	      		</td>
	      		
	      		<td style="padding-top: 10px;">
	         		<?php
	         			$demander_id = $purchase_requisition[0]->rema_postby;

	         			if(!empty($demander_id)):
	            			$get_demander_signature = $this->general->get_signature($demander_id);

	            			$demander_fullname = $get_demander_signature->usma_fullname;
	            			$demander_empid = $get_demander_signature->usma_employeeid;
	         			else:
	            			$demander_fullname = '';
	            			$demander_empid = '';
	         			endif;

	         			if(!empty($demander_fullname)):
	            	?>
	            	<span class="signatureDashedLine spanborder" >
		              	<?php 
		              		echo $demander_fullname; 
		              		echo ($demander_empid)?'('.$demander_empid.')':'';
		              	?>
	           		</span> माग गर्नेको सही र मिति
		           	<?php
		        		else:
		         	?>
		         		<span class="signatureDashedLine"></span> माग गर्नेको सही र मिति
		         	<?php
		      			endif;
		      		?>
	   			</td>
			</tr>
			
			<tr>
	   			<td style="padding-top: 25px;">
	      			<span class="signatureDashedLine spanborder">
			        <?php 
			        	echo $procurement_fullname; 
			        	echo ($procurement_empid)?'('.$procurement_empid.')':'';
			        ?>
	     			</span></br>
	     			बजारबाट  खरीद  गर्न स्वीकृत 
	  			</td>

	  			<td></td>
	  
	  			<td style="padding-top: 20px;padding-bottom: 20px;">
	  				<?php
	   					if(!empty($department_supervisor_fullname)):
	      			?>
	      			<span class="signatureDashedLine spanborder">
	         		<?php 
	         			echo $department_supervisor_fullname; 
	         			echo ($department_supervisor_empid)?'('.$department_supervisor_empid.')':'';
	         		?>
	     			</span> 
	      			शाखा प्रमुखको सिफारिश 
	      			<?php
	   					else:
	      			?>
	      			<span class="signatureDashedLine"></span> शाखा प्रमुखको सिफारिश 
	      			<?php
	   					endif;
	   				?>
				</td>
			</tr>
			
			<tr>
	   			<td style="padding-top: 20px;padding-bottom: 20px;">
	      			<span class="signatureDashedLine spanborder">
	         		<?php 
	         			echo $branch_manager_fullname; 
	         			echo ($branch_manager_empid)?'('.$branch_manager_empid.')':'';
	         		?>
	      			</span></br>आदेश  दिने अधिकारी
	   			</td>
	   			<td style="padding-top: 10px;padding-bottom: 20px;">
	   			</td>
			</tr>
		</table>
	</div>
</div>