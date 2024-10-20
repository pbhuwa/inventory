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
	.jo_tbl_head td{
		position: relative;
	}
	
	.jo_table{margin-top: 15px !important;}
	.jo_table { border-right:1px solid #333; margin-top:5px; }
	.jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

	.jo_table tr th { padding:5px 3px;}
	.jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
	
	.jo_footer { vertical-align: top; }
	.jo_footer td { padding:8px 8px;	}
	.preeti{
		font-family: preeti;
	}
	.borderbottom{ border-bottom: 1px dashed #333; padding:0px; }
	.tableWrapper{
		min-height:70%;
		height:70vh;
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
	.bdr_btm{border-bottom: 1px solid #000;display: inline-block}
	.jo_tbl_head tr td{
		font-size: 12px;
	}
	.jo_table tr td{
		padding: 4px 6px;
	}
	.jo_footer tr td p{
		font-size: 11px;
	}
</style>
<div class="jo_form organizationInfo">
	<div class="headerWrapper">
		<?php 
            $header['report_no'] = 'म.ले.प.फा.नं ५१';
            $header['report_title'] = 'चलान फारम';
            $this->load->view('common/v_print_report_header',$header);
        ?>
		<table class="jo_tbl_head">
			<tr>
				<td>
					<table style="width: 100%;border-collapse: collapse;">
						<tr>
							<td style="padding-top: 10px;width: 25%;box-sizing: border-box;">प्राप्त चलान नं: 
								<span class="bdr_btm" style="position: relative !important;top: 0px !important;">
									<?php echo !empty($chalan_details[0]->chma_challanrecno)?$chalan_details[0]->chma_challanrecno:''; ?>
								</span>
							</td>
							<td style="padding-top: 10px;width: 25%;box-sizing: border-box;">आपूर्तिकर्ता चलान नं.:
								<?php
									$challanno=!empty($chalan_details[0]->chma_challannumber)?$chalan_details[0]->chma_challannumber:'';
								?> 
								<span class="bdr_btm" style="position: absolute !important;top: 10px !important;">
									<?php echo $challanno; ?>
								</span>
							</td>
							
							<td style="padding-top: 10px;width: 25%;box-sizing: border-box;">अर्डर नं.:
								<?php
									$challan_orderno=!empty($chalan_details[0]->chma_puorid)?$chalan_details[0]->chma_puorid:'';
								?> 
								<span class="bdr_btm" style="position: relative !important;top: 0px !important;">
									<?php echo $challan_orderno; ?>
								</span>
							</td>

							<td style="padding-top: 10px;width: 25%;box-sizing: border-box;">चलान प्राप्त मिति: 
								<span class="bdr_btm"style="position: absolute !important;top: 10px !important;">
									<?php
										echo !empty($chalan_details[0]->chma_challanrecdatebs)?$chalan_details[0]->chma_challanrecdatebs:'';  
									?>
								</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding-top: 10px;">
					<table style="width: 100%;border-collapse: collapse;">
						<tr>
							<td>आपूर्तिकर्ता: 
								<span class="bdr_btm" style="position: relative !important;top: 0px !important;">
									<?php
										echo !empty($chalan_details[0]->dist_distributor)?ucwords(strtolower($chalan_details[0]->dist_distributor)):'';  
									?>, 
									<?php
										echo !empty($chalan_details[0]->dist_address1)?ucwords(strtolower($chalan_details[0]->dist_address1)):'';  
									?>
								</span>
							</td>
						</tr>		
					</table>
				</td>
			</tr>
		</table>
		<div class="tableWrapper">
			<table class="jo_table itemInfo">
				<thead>
					<tr>
						<th width="5%" class="td_cell">सि .</th>
						<th width="10%" class="td_cell">वस्तु कोड</th>
						<th width="45%" class="td_cell">विवरण</th>
						<th width="10%" class="td_cell">एकाइ</th>
						<!-- <th width="10%" class="td_cell">माग गरेको माल सामान को परिमाण</th> -->
						<th width="10%" class="td_cell">प्राप्त सामान को परिमाण</th>
						<th width="10%" class="td_cell">कैफियत </th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(!empty($chalan_details)):
							foreach($chalan_details as $key => $challan):
					?>
						<tr>
							<td class="td_cell">
								<?php echo $key+1; ?>
							</td>
							<td class="td_cell">
								<?php echo !empty($challan->itli_itemcode)?$challan->itli_itemcode:''; ?>
							</td>
							<td class="td_cell">
								<?php 

								if(ITEM_DISPLAY_TYPE=='NP'){
								
									echo !empty($challan->itli_itemnamenp)?$challan->itli_itemnamenp:$challan->itli_itemname;
								}else
								{
									
									echo !empty($challan->itli_itemname)?$challan->itli_itemname:'';
								}
								?>
							</td>
							<td class="td_cell">
								<?php echo !empty($challan->unit_unitname)?$challan->unit_unitname:''; ?>
							</td>
							<!-- <td class="td_cell">
								<?php echo !empty($challan->chde_qty)?$challan->chde_qty:''; ?>
							</td> -->
							<td class="td_cell">
								<?php echo !empty($challan->chde_qty)?$challan->chde_qty:''; ?>
							</td>
							<td class="td_cell">
								<?php echo !empty($challan->chde_remarks)?$challan->chde_remarks:''; ?>
							</td>
						</tr>
					<?php
							endforeach;
						endif;
					?>

					<?php
					$row_count=0;
					if(is_array($challan) && !empty($challan)):
						$row_count = count($challan);
					endif;
						if($row_count <15):
					?>
					<tr>
						<td class="td_empty"></td>
						<td class="td_empty"></td>
						<td class="td_empty"></td>
						<td class="td_empty"></td>
						<td class="td_empty"></td>
						<td class="td_empty"></td>
						<!-- <td class="td_empty"></td> -->
					</tr>
					<?php
						endif;
					?>
				</tbody>
			</table>
			<table class="jo_footer">
				<tr>
					<td style="width: 80%;padding-top: 40px;white-space: normal;">
						<span style="display: block;"></span>
					</td>
					<td style="width: 20%;padding-top: 40px;white-space: normal;">
						<span class="bdr_btm" style="display: block;"></span>
						<p style="padding-top: 5px;">बुझ्ने को दस्तखत</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>