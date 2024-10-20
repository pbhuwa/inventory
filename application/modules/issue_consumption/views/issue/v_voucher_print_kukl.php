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
	
	.jo_footer {vertical-align: top; }
	.jo_footer td { padding:8px 8px;}

	.preeti{
		font-family: preeti;
		}
	.bb{border-bottom:1px dashed #333;}
	.bold{ font-weight: bold; }
	.jo_table tr td{border-bottom: 1px solid #333;}
	.dakhila_form_footer {border: 1px solid #212121;border-top: 0px;padding: 5px 15px;}
    .officer_detailTable tr th{text-align: left; font-weight: 500;margin-bottom: 5px;font-size: 12px;}
    .officer_detailTable tr td{font-size: 12px;}	
        .preeti{
        font-family: preeti;
    }
    .bordertblone{border-bottom: 1px dashed #333; }	
    .purchaserecive{border-collapse: collapse;}
    .purchaserecive-table tr th{border-bottom: 1px solid #ddd;padding: 4px;}
    .purchaserecive-table tr td{border-bottom: 1px solid #ddd;padding: 4px;}
    .purchaserecive-table tr:last-child td{border-bottom: 0px;}
    .jo_table tr.total-amount td{border-bottom: 0px !important;}
    .jo_table tr.total-amount td:last-child{border-left: 0px;}
    .jo_table tr.total-amount td:nth-child(2){border: 0px;}
	/*.jo_table tr:last-child td:nth-child(2){border: 0px;}*/
	/*.jo_table tr:last-child td:last-child{border-left: 0px;}*/
	.tableWrapper{
		/*min-height:52%;
		height:52vh;
		max-height: 100vh;*/
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
	}
	.itemInfo{
		height:100%;
	}
	.itemInfo .td_cell{
		padding:5px;
		margin:5px; 
	}

	.itemInfo th.td_cell{
		font-weight: bold;
		text-align: center; 
	}

	.itemInfo .td_empty{
		height:100%;
	}
	.jo_table tbody tr td:nth-child(3){
		width: 100% !important;
	}
	.tableWrapper tr th{
		word-wrap: break-word;
		white-space: initial;
	}

	.amount-table{
		border-collapse: collapse;
		border:1px solid #000;
		border-top: 0px;
		margin: 0px;
		margin-top: 5px;
	
	}
	.amount-table tbody tr td{
		border-bottom:1px solid #000;
		font-size: 12px;
		padding: 5px 15px;
	}
	.amount-table tbody tr td span{
		font-size: 12px;
		display: inline-block;
		margin:0px;
		padding: 0px;
	}
	.amount-table tbody tr td:first-child{
		border: 1px solid #000;
		border-top:0px;
	}
	.footerWrapper{
		page-break-inside: avoid;
	}
	.bold_title{
		font-weight: bold;
	}
	.dateDashedLine{
		min-width: 100px;display: inline-block; border:1px dashed #333;
	}
	.signatureDashedLine {
		min-width: 170px;display: inline-block; border:1px dashed #333; margin-top: 50px;
	}
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper">

		<?php 
            $header['report_no'] = '';
            $header['report_title'] = 'Voucher Details';
            $this->load->view('common/v_print_report_header',$header);
        ?>

        <?php
        	// echo "<pre>";
        	// print_r($issue_master);
        	// die();
        ?>

		<table class="jo_tbl_head">
			<tr>
				<td>
					<span style="font-size: 12px;" class="bold_title">Branch Name:</span>	
					<span class="bb">
						<?php
							$location_id = !empty($issue_master[0]->sama_locationid)?$issue_master[0]->sama_locationid:'';
							$location_data = $this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$location_id));
							echo !empty($location_data[0]->loca_name)?$location_data[0]->loca_name:'';
						?>
					</span>
				</td>

				<td>
					<span style="font-size: 12px;" class="bold_title">Transaction Date:</span>	
					<span class="bb">
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

			<tr>
				<td>
					<span style="font-size: 12px;" class="bold_title">Voucher No.: </span>
					<span class="bb">
						<?php if($issue_details){ 
						echo !empty($issue_master[0]->sama_requisitionno)?$issue_master[0]->sama_requisitionno:'';
					}else{
					 	echo !empty($report_data['sama_requisitionno'])?$report_data['sama_requisitionno']:'';
					} ?>
					</span>
				</td>

				<td>
					<span style="font-size: 12px;" class="bold_title">Account Type: </span>
					<span class="bb">
						Expenditure Account
					</span>
				</td>

				<td>
					<span style="font-size: 12px;" class="bold_title">Voucher Type: </span>
					<span class="bb">
						Journal Voucher
					</span>
				</td>

			</tr>

		</table>
	</div>
	

	<div class="tableWrapper">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333; table-layout: fixed;">
			<thead>
				<tr>
					<th width="30%"  class="td_cell">Account Title</th>
					<th width="30%"  class="td_cell">Subsidary</th>
					<th width="5%"  class="td_cell">L.F.</th>
					<th width="5%"  class="td_cell">L.F.</th>
					<th width="10%"  class="td_cell">Debit </th>
					<th width="10%"  class="td_cell">Credit </th>
				</tr>
				
			</thead>
			<tbody>
				<?php if($issue_details){ 
					// echo "<pre>"; print_r($issue_details);die;
					$sum= 0; $vatsum=0;$gtotal = 0; 
                    foreach ($issue_details as $key => $direct) { ?>
            	<tr style="border-bottom: 1px solid #212121;">
					
					<td width="500px" class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						<?php
							if(ITEM_DISPLAY_TYPE=='NP'){
		                		echo !empty($direct->itli_itemnamenp)?$direct->itli_itemnamenp:$direct->itli_itemname;
		                	}else{ 
		                    	echo !empty($direct->itli_itemname)?$direct->itli_itemname:'';
		                	}
						?>
					</td>
					<td class="td_cell">
						
                	</td>
                	<td class="td_cell">
						
                	</td>
                	<td class="td_cell">
						
                	</td>

                	<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: right;">
						<?php echo $direct->sade_unitrate; ?>
					</td>

                	<td class="td_cell">
						
                	</td>
					
				</tr>

				 <?php
				 	
					$subtotal=!empty($direct->subtotal)?$direct->subtotal:0;

					?>
				<?php  
					$gtotal +=$subtotal;
					}
					
				?>
			  	<tr>
					<td width="" class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						To <?php echo !empty($issue_master[0]->sama_receivedby)?$issue_master[0]->sama_receivedby:'';?>
					</td>
					<td class="td_cell">
						
                	</td>
                	<td class="td_cell">
						
                	</td>
                	
					
					<td class="td_cell">
						
					</td>

					<td class="td_cell">
						
                	</td>
                	<td class="td_cell">
						<?php echo $gtotal; ?>
                	</td>
				</tr>
			</tbody>

			<tfoot>
	            <tr>
	               <td colspan="4">Total:</td>
	               <td align="right"><?php echo $gtotal; ?></td>
	               <td align="right"><?php echo $gtotal; ?></td>
	            </tr>

	            <tr>
	               <td class="td_cell" colspan="6">In words : <?php echo $this->general->number_to_word( $gtotal);?> </td>
	            </tr>

	         </tfoot>


		<!-- 	<tfoot>
			
			<tr>
				<td width="60%" colspan="6" style="overflow-wrap: break-word;white-space: nowrap;text-align: left;"><span class="bold_title">अक्षरेपी:  </span>
					<?php if($req_detail_list){
                            echo $this->general->number_to_word($total);
                        }else{
                            echo $this->general->number_to_word($report_data['clearanceamt']);
                        } ?> </td>
				<td style="text-align: right;font-size: 12px;">
					<span class="bold_title">कुल जम्मा : </span>
				</td>
				<td>
					<?php echo !empty($total)?number_format($total,2):''; ?>
				</td>
			</tr>
            <?php } ?>
		</tfoot> -->
		</table>
	</div>

	<?php
		$user_data = $this->general->get_user_list_by_group(false,false,false,false, array('SK'));
		// echo $this->db->last_query();
		// die();
	?>

	<div class="footerWrapper">
		<table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
			
			<tr style="padding-top: 50px;">
				<td><span class="signatureDashedLine"></span></td>
				<td><span class="signatureDashedLine"></span></td>
				<td><span class="signatureDashedLine"></span></td>
			</tr>
			<tr>
	            <td><span class="bold_title">Prepared By</span></td>
	            <td><span class="bold_title">Recommended By</span></td>
	            <td><span class="bold_title">Approved By By</span></td>
			</tr>
			
	    </table>
	</div>
</div>