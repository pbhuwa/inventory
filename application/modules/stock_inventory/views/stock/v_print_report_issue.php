<style>	
	.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
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
	.jo_footer td { padding:8px 8px;	}
	.preeti{
		font-family: preeti;
	}
	.borderbottom{ border-bottom: 1px dashed #333;margin: 0px;padding: 0px; }
	.tableWrapper{
		min-height:60%;
		height:60vh;
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
	<div class="headerWrapper">
		<?php 
			$header['report_no'] = 'म.ले.प.फा.नं ५१';
			$header['report_title'] = 'माग फारम';
			$this->load->view('common/v_print_report_header',$header);
		?>

		<table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">
			<tr>
				<td width="33.333333%"></td>
				<td width="33.333333%"></td>
				<td width="33.333333%" style="text-align: right;">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">निकासी  नं </span>
					<span class="borderbottom" style="min-width:80px;display: inline-block;margin: 0px;padding: 0px; "></span>
				</td>
			</tr>
			<tr>
				<td width="33.333333%">
					<span style="font-size: 12px; margin-bottom: 5px;" class="<?php echo FONT_CLASS; ?>"> श्री </span> <span class="borderbottom"><?php
					if($stock_requisition){
						echo !empty($stock_requisition[0]->rema_reqby)?$stock_requisition[0]->rema_reqby:''; 
					}else{
					 	echo !empty($report_data['rema_reqby'])?$report_data['rema_reqby']:'';
					} ?> </span>
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">लाई </span>
				</td>
				<td width="33.333333%" style="text-align: center;padding-right: 70px;" class="text-center">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">माग नं </span> 
						<?php
						if($stock_requisition){ ?>
							<span class="borderbottom"> 
								<?php 
							echo !empty($stock_requisition[0]->rema_reqno)?$stock_requisition[0]->rema_reqno:''; ?> 
						<?php }else{ ?>
						<span class="borderbottom">
						 	<?php echo !empty($report_data['rema_reqno'])?$report_data['rema_reqno']:'';
						} ?></span>
				</td>
				<!-- rema_reqdatebs -->
				<td width="33.333333%" style="text-align: right;">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> मिति </span>: 
					<span class="borderbottom">
						<?php echo !empty($stock_requisition[0]->rema_reqdatebs)?$stock_requisition[0]->rema_reqdatebs: CURDATE_NP;?>
					</span>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="tableWrapper">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<th width="5%" class="td_cell"> सि .</th>
					<th width="10%" class="td_cell">जी. सि. खा. पा. नं </th>
					<th width="45%" class="td_cell">विवरण  </th>
					<th width="10%" class="td_cell">माग गरेको माल सामान को परिमाण  </th>
					<th width="10%" class="td_cell">एकाइ </th>
					<th width="10%" class="td_cell">निकासी गरेको माल को परिमाण </th>
					<th width="10%" class="td_cell">कैफियत </th>
				</tr>
			</thead>
			<tbody>
				<?php if($stock_requisition){  //echo"<pre>";  print_r($stock_requisition);die;
					foreach($stock_requisition as $key => $stock){ ?>
				<tr>
					<td class="td_cell">
						<?php echo $key+1; ?>
					</td>
					<td class="td_cell">
						<?php echo !empty($stock->itli_itemcode)?$stock->itli_itemcode:''; ?>
					</td>
						<td class="td_cell">
							<?php 

							if(ITEM_DISPLAY_TYPE=='NP'){
							
								echo !empty($stock->itli_itemnamenp)?$stock->itli_itemnamenp:$stock->itli_itemname;
							}else
							{
								
								echo !empty($stock->itli_itemname)?$stock->itli_itemname:'';
							}
							?>
							
						</td>
						<td class="td_cell">
							<?php echo !empty($stock->rede_qty)?$stock->rede_qty:''; ?>
						</td>
						<td class="td_cell">
							<?php echo !empty($stock->unit_unitname)?$stock->unit_unitname:''; ?>
						</td>
						<td class="td_cell"></td>
						<td class="td_cell">
							<?php echo !empty($stock->rede_remarks)?$stock->rede_remarks:''; ?>
						</td>
					</tr>
				<?php //$sumnewno += $newno; 
			}?>
			<?php
					$row_count = count($stock);

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
				<?php endif;?>
				<?php
				 } else{ ?>
				<?php
				$itemid = !empty($report_data['rede_itemsid'])?$report_data['rede_itemsid']:'';
				if(!empty($itemid)): // echo"<pre>";print_r($itemid);die;
				//$sumnewno=0; $newno=0;
				foreach($itemid as $key=>$products):
			?>
			<tr>
				<td class="td_cell">
					<?php echo $key+1; ?>
				</td>
				<td class="td_cell">
					<?php echo !empty($report_data['rede_code'][$key])?$report_data['rede_code'][$key]:''; ?>
				</td>
				<td class="td_cell">
					<?php 
						$itemid = !empty($report_data['rede_itemsid'][$key])?$report_data['rede_itemsid'][$key]:'';
						$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
						if(ITEM_DISPLAY_TYPE=='NP'){
							echo !empty($itemname[0]->itli_itemnamenp)?$itemname[0]->itli_itemnamenp:$itemname[0]->itli_itemname;
						}else
						 {
							echo !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';
						}

						
					?>
				</td>
				<td class="td_cell">
					<?php echo !empty($report_data['rede_qty'][$key])?$report_data['rede_qty'][$key]:''; ?>
				</td>
				<td class="td_cell">
					<?php 
						$unitid = !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:'';
						$unitname =  $this->general->get_tbl_data('*','unit_unit',array('unit_unitid'=>$unitid),false,'DESC');
						echo !empty($unitname[0]->unit_unitname)?$unitname[0]->unit_unitname:'';
					?>
					<!-- <?php echo !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:''; ?> -->
				</td>
				<td class="td_cell"></td>
				<td class="td_cell">
					<?php echo !empty($report_data['rede_remarks'][$key])?$report_data['rede_remarks'][$key]:''; ?>
				</td>
			</tr>
			<?php
				endforeach;
			?>
				<?php
					$row_count = count($report_data['rede_itemsid']);

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
				<?php endif;?>
			<?php
				endif;
			}
			?>
			</tbody>
		</table>
	</div>

	<div class="footerWrapper">
		<table class="jo_footer" style="padding-top: 10px;padding-bottom: 10px;border: 1px solid #000;border-top: 0px;page-break-inside: avoid;">
			<tr>
				<td width="60%" style="padding-top: 30px;"> बजारबाट खरिद गरिदिनु / मौज्दात </td>
				<td style="padding-top: 40px;">माग गर्नेको दस्तखत :
					<span class="signatureDashedLine"></span>
				</td>
			</tr>
			<tr>
				<td style="padding-top: 25px;">आदेश दिनेको दस्तखत :
					
					<?php
						if(!empty($approver_signature->usma_signaturepath)):
					?>
					<img src="<?php echo base_url(SIGNATURE_UPLOAD_PATH).'/'.$approver_signature->usma_signaturepath; ?>" alt="" class="signatureImage">
					<?php
						else:
					?>
					<span class="signatureDashedLine"></span>
					<?php
						endif;
					?> 
				</td>
				<td style="padding-top: 25px;">मिति  : 
					<span class="dateDashedLine"></span>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="padding-top: 10px;white-space: nowrap;">जिन्सी खाता चढाइयो  : 
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
				</td>
			</tr>
			<tr>
				<td style="padding-top: 25px;">माग बुझ्ने को दस्तखत : 
					<span class="signatureDashedLine"></span>
				</td>
				<td style="padding-top: 25px;">फाटवाला  : 
					<span class="signatureDashedLine"></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style="padding-top: 10px;padding-bottom: 20px;">मिति  : 
					<span class="dateDashedLine"></span>
				</td>
			</tr>
		</table>
	</div>
</div>