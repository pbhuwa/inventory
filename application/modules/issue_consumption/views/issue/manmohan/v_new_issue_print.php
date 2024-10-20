<style>	
	.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
	.table_jo_header { width:100%; vertical-align: top; font-size:12px; }
	.table_jo_header td.text-center { text-align:center; }
	.table_jo_header td.text-right { text-align:right; }
	h4 { font-size:18px; margin:0; }
	.table_jo_header u { text-decoration:underline; padding-top:15px; }

	.jo_table { border-right:1px solid #333; margin-top:5px; }
	.jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

	.jo_table tr th { padding:5px 3px;}
	.jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
	
	.jo_footer { border:1px solid #333; vertical-align: top; }
	.jo_footer td { padding:8px 8px;	}
	.preeti{
		font-family: preeti;
	}
	.borderbottom{ border-bottom: 1px dashed #333;margin: 0px;padding: 0px; }
	.tableWrapper{
		min-height:45%;
		height:45vh;
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
		min-width: 130px;display: inline-block; border:1px dashed #333;
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
	<div class="headerWrapper">
		<?php 
			$header['report_no'] = 'म.ले.प.फा.नं ५१';
			$header['report_title'] = 'निकासी फारम';
			$this->load->view('common/v_print_report_header',$header);
		?>
		<table class="jo_tbl_head">
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td width="33.33333%%" class="text-right" style="padding-bottom: 5px;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> निकासी न </span> . :
				<span style="border-bottom: 1px dashed;font-size: 12px;">
					<?php if($issue_details){ 
						echo !empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:'';
					}else{
					 	echo !empty($report_data['sama_invoiceno'])?$report_data['sama_invoiceno']:'';
					} ?>
				</span>
				</td>
			</tr>
			<tr>
				<td>
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> श्री  प्रमुख</span>
					<span style="border-bottom: 1px dashed;font-size: 12px;"> <?php
						// if($issue_details){
						// 	echo !empty($store[0]->eqty_equipmenttype)?$store[0]->eqty_equipmenttype:'';
						// }else{
					    	echo !empty($store[0]->eqty_equipmenttype)?$store[0]->eqty_equipmenttype:'';
					   // } ?></span>
					   <span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> शाखा </span>
				</td>
				<!-- <td width="25%" class="text-right"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> शाखा </span>
				</td> -->
				<td width="10%" class="text-center"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> माग न </span>:
					<span style="border-bottom: 1px dashed;font-size: 12px;">
						<?php if($issue_details){ 
							echo !empty($issue_master[0]->sama_requisitionno)?$issue_master[0]->sama_requisitionno:'';
						}else{
						 	echo !empty($report_data['sama_requisitionno'])?$report_data['sama_requisitionno']:'';
						} ?>
					</span>
				</td>

				<td width="20%" class="text-right"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> आर्थिक वर्ष </span>: 
					<span style="border-bottom: 1px dashed;font-size: 12px;">
						<?php if ($issue_details){
							echo !empty($issue_master[0]->sama_fyear)?$issue_master[0]->sama_fyear:'';
						}else{  
						 echo !empty($report_data['sama_fyear'])?$report_data['sama_fyear']:'';
						} ?>
					</span>
				</td>

				<td width="25%" class="text-right"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> मिति </span>:
					<span style="border-bottom: 1px dashed;font-size: 12px;"> 
						<?php
							if(DEFAULT_DATEPICKER == 'NP'){
								echo !empty($issue_master[0]->sama_billdatebs)?$issue_master[0]->sama_billdatebs:'';
							} else{
								echo !empty($issue_master[0]->sama_billdatead)?$issue_master[0]->sama_billdatead:'';
							}
						?>
					</span>
				</td>
			</tr>
		</table>
	</div>

	<div class="tableWrapper">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<th width="5%" class="td_cell" style="text-align: center"> सि .</th>
					<th width="10%" class="td_cell" style="text-align: center"> मलसामानको विवरण </th>
					<th width="30%" class="td_cell" style="text-align: center"> सामानको नाम </th>
					<th width="10%" class="td_cell" style="text-align: center"> एकाइ </th>
					<!-- <th width="10%">परिमाण</th> -->
					<th width="10%" class="td_cell" style="text-align: center"> सामानको परिमाण </th>
					<th width="10%" class="td_cell" style="text-align: center"> निकासी गरेको माल को परिमाण </th>
					<th width="25%" class="td_cell" style="text-align: center"> कैफियत </th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($issue_details){ 
					foreach($issue_details as $key=>$products):
				?>
				<tr>
	                <td class="td_cell" style="text-align: center">
	                    <?php echo $key+1; ?>
	                </td>
	                <td class="td_cell" style="text-align: center">
	                    <?php echo $products->itli_itemcode;?>
	                </td>
	                <td class="td_cell" style="text-align: center">
	                    <?php
	                    	if(ITEM_DISPLAY_TYPE=='NP'){
	                    		echo !empty($products->itli_itemnamenp)?$products->itli_itemnamenp:$products->itli_itemname;
							 }else{ 
							 	echo !empty($products->itli_itemname)?$products->itli_itemname:'';
							}

	                    // echo $products->itli_itemname;
	                    ?>
	                </td>
	                <td class="td_cell" style="text-align: center">
	                     <?php $unit=!empty($products->unit_unitname)?$products->unit_unitname:'';?> 
	                        <?php echo $unit;?> 
	                </td>
	                <!-- <td>
	                    <?php $qty=!empty($products->totalqty)?$products->totalqty:'';?> 
	                        <?php echo $qty;?>
	                </td> -->
	                <td class="td_cell" style="text-align: center">
	                   <?php $rede_qty=!empty($products->rede_qty)?$products->rede_qty:'';?>
	                        <?php echo $rede_qty;?>
	                </td>
	                <td class="td_cell" style="text-align: center">
	                    <?php $qty=!empty($products->totalqty)?$products->totalqty:'';?>
	                    <?php echo $qty;?>
	                </td>

	                <td class="td_cell" style="text-align: center">
	                    <?php $puderemaks=!empty($products->sade_remarks)?$products->sade_remarks:'';?>
	                        <?php echo $puderemaks;?>
	                            
	                </td>
	            </tr>
				<?php  
					endforeach;
				?>
				<?php
				        $row_count=0;
				        if(is_array($products) && !empty($products)):
						$row_count = count($products);
					endif;

						if($row_count < 12):
					?>
				<tr>
						<td class="td_empty" style="text-align: center"></td>
						<td class="td_empty" style="text-align: center"></td>
						<td class="td_empty" style="text-align: center"></td>
						<td class="td_empty" style="text-align: center"></td>
						<td class="td_empty" style="text-align: center"></td>
						<td class="td_empty" style="text-align: center"></td>
						<td class="td_empty" style="text-align: center"></td>
					</tr>
				<?php endif ?>
				<?php }else{ ?>
				<?php 
				$itemid = !empty($report_data['sade_itemsid'])?$report_data['sade_itemsid']:'';
				if(!empty($itemid)): // echo"<pre>";print_r($itemid);die;
				
				foreach($itemid as $key=>$products):
			?>
			<tr>
				<td class="td_cell" style="text-align: center">
					<?php echo $key+1; ?>
				</td>
				<td class="td_cell" style="text-align: center">
					<?php 
						$itemid = !empty($report_data['sade_itemsid'][$key])?$report_data['sade_itemsid'][$key]:'';
						$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
						echo !empty($itemname[0]->itli_itemcode)?$itemname[0]->itli_itemcode:'';
					?>
					<?php echo !empty($report_data['rede_code'][$key])?$report_data['rede_code'][$key]:''; ?>
				</td>
				<td class="td_cell" style="text-align: center">
					<?php 
						$itemid = !empty($report_data['sade_itemsid'][$key])?$report_data['sade_itemsid'][$key]:'';
						$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
						
						if(ITEM_DISPLAY_TYPE=='NP'){
                    $iss_itemname = !empty($itemname[0]->itli_itemnamenp)?$itemname[0]->itli_itemnamenp:$itemname[0]->itli_itemname;
                }else{ 
                    $iss_itemname = !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';
                }

						echo $iss_itemname;

					?>
				</td>
				<td class="td_cell" style="text-align: center">
					<?php echo !empty($report_data['unit'][$key])?$report_data['unit'][$key]:''; ?> 
				</td>
				<!-- <td>
					<?php echo !empty($report_data['qtyinstock'][$key])?$report_data['qtyinstock'][$key]:''; ?>
				</td> -->
				<td class="td_cell" style="text-align: center">
					<?php echo !empty($report_data['remqty'][$key])?$report_data['remqty'][$key]:''; ?>
				</td>
				<td class="td_cell" style="text-align: center">
					<?php echo !empty($report_data['sade_qty'][$key])?$report_data['sade_qty'][$key]:''; ?>
				</td>
				<td class="td_cell" style="text-align: center">
					<?php echo !empty($report_data['sade_remarks'][$key])?$report_data['sade_remarks'][$key]:''; ?>
				</td>
			</tr>
			<?php
				endforeach;?>
				<?php
						$row_count = count($report_data['sade_itemsid']);

						if($row_count < 12):
					?>
				<tr>
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
				
			</tbody>
		</table>
	</div>

	<?php
		if(DEFAULT_DATEPICKER == 'NP'){
			$bill_date = !empty($issue_master[0]->sama_billdatebs)?$issue_master[0]->sama_billdatebs:'';
		} else{
			$bill_date = !empty($issue_master[0]->sama_billdatead)?$issue_master[0]->sama_billdatead:'';
		}
		$received_by = !empty($issue_master[0]->sama_receivedby)?$issue_master[0]->sama_receivedby:'';
		$received_dep = !empty($issue_master[0]->sama_depid)?$issue_master[0]->sama_depid:'';

		$dep_name_data = $this->general->get_tbl_data('dept_depname','dept_department',array('dept_depid'=>$received_dep));

		$dep_name = !empty($dep_name_data[0]->dept_depname)?$dep_name_data[0]->dept_depname:'';
	?>

	<div class="footerWrapper">
		<table class="jo_footer" style="padding-top: 10px;padding-bottom: 10px;border: 1px solid #000;border-top: 0px;page-break-inside: avoid;">
			<tr>
				<td width="60%" style="padding-top: 30px;"> बजारबाट खरिद गरिदिनु / मौज्दातबाट दिनु </td>
				<td></td>
			</tr>
			<tr>
				<td>
					<u>बुझिलिने</u>  
					<div class="p-t-10 p-b-10">नाम : 
						<?php
							if(!empty($received_by)):
						?>
							<span class="borderbottom">
								<?php echo $received_by; ?>
							</span>
						<?php
							else:
						?>
							<span class="dateDashedLine"></span>	
						<?php
							endif;
						?>
					</div>
					
					<div class="p-t-10 p-b-10">दस्तखत : <span class="signatureDashedLine"></span> </div>
					<div class="p-t-10 p-b-10">बिभाग : 
						<?php 
							if(!empty($dep_name)):
						?>
							<span class="borderbottom">
								<?php echo $dep_name; ?>
							</span>
						<?php
							else:
						?>
							<span class="dateDashedLine"></span>
						<?php
							endif;
						?>
					</div>
				</td>
			</tr>

			<tr>
				<td>
					<u>निकासी आदेश दिने</u>
					<div class="p-t-10 p-b-10">नाम : 
						<span class="dateDashedLine"></span>
					</div>
					<div class="p-t-10 p-b-10">पद : 
						<span class="dateDashedLine"></span>
					</div> 
					<div class="p-t-10 p-b-10">दस्तखत : 
						<span class="signatureDashedLine"></span>
					</div>
				</td>
				<td>
					<u>दाखिला गर्ने</u>  
					<div class="p-t-10 p-b-10">नाम : 
						<span class="borderbottom">
							<?php echo !empty($user_signature->usma_fullname)?$user_signature->usma_fullname: '';?>
						</span>  
					</div>
					<div class="p-t-10 p-b-10">दस्तखत : 
						<?php
							if(!empty($user_signature->usma_signaturepath)):
						?>
						<img src="<?php echo base_url(SIGNATURE_UPLOAD_PATH).'/'.$user_signature->usma_signaturepath; ?>" alt="" class="signatureImage">
						<?php
							else:
						?>
						<span class="signatureDashedLine"></span>
						<?php
							endif;
						?> 
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>