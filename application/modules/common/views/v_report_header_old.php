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

	.alt_table {  border-collapse:collapse; border:1px solid #000; margin: 0 auto; width: 100%;}
	.alt_table thead tr th, .alt_table tbody tr td { border:1px solid #000; padding:2px 5px; font-size:12px; }
	.alt_table thead tr th { font-weight: bold; }
	.alt_table tbody tr td { padding:5px; font-size:12px; }
	.alt_table tbody tr td.header { padding:5px; font-size:12px; font-weight: bold;}
	.alt_table tbody tr.alter td { border:0; text-align:center; }
	.alt_table tbody tr td.noboder { border-right:0; text-align:center; }
	.alt_table tbody tr td.noboder+td{ border-left: 0px; }
	.alt_table table.noborder{border:0px;}
	.alt_table tr.noborder{border:0px;}
	.alt_table td.noborder{border:0px;}
	.alt_table tr.borderBottom{border-bottom:2px solid #333;}
	.alt_table tr.header td{font-weight: bold;}


	table.organizationInfo{
		margin:0px;
		/*margin-top: -50px;*/
		padding: 0px;
	} 

	/*used in purchase reports */
	.format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>
<?php if(!empty($pdf_url) || !empty($excel_url)):?>
<div class="pull-right pad-btm-5 reportGeneration">
	<a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
	<a href="javascript:void(0)" class="btn btn_excel btn_gen_report" data-exporturl="<?php echo !empty($excel_url)?$excel_url:'';?>" data-exporttype="excel"><i class="fa fa-file-excel-o"></i></a>
	<a href="javascript:void(0)" class="btn btn_pdf2 btn_gen_report"  data-exporturl="<?php echo !empty($pdf_url)?$pdf_url:'';?>" data-exporttype="pdf" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
</div>
<?php endif; ?>
<div class="table-wrapper" id="tblwrapper">
<table class="organizationInfo" width="100%" style="font-size:12px; margin-bottom: 5px; ">
	  <tr class="title_sub">
	        <td width="20%"></td>  
          <td width="33.33%" style="text-align: left;">
            <a href="#"> <img src="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>" style="width: 100px;"></a>
          </td>
            <td width="25%"></td>          
      </tr>
	<tr>
  	 	<td width="20%"></td>
  		<td  style="text-align: center;">
  			<h4 style="color:#101010;margin-bottom: 0px;">
  				<span style="font-size: 14px;" class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAMETITLE; ?></span>
  			</h4>
  		</td>
  		 <td width="25%"></td> 
	</tr>
	<tr>
		<td width="20%"></td>
		<td  style="text-align: center;">
			<h4 style="color:#101010;margin-bottom: 0px;font-size: 10px;">
				<span class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAME; ?></span>
			</h4>
		</td>
		<td width="25%"></td>
	</tr>

	<tr class="title_sub">
		<td width="20%"></td>
		<td style="text-align: center;">
			<h4 style="color:black;font-size: 14px;" class="<?php echo FONT_CLASS; ?>" >
				<?php echo ORGNAMEDESC; ?>
			</h4>
		</td> 
		<td width="25%" style="text-align:right; font-size:10px;">
			<strong><?php echo $this->lang->line('date_time'); ?>: </strong> 
			<?php echo CURDATE_NP ?> BS, <?php echo CURDATE_EN ?> AD <?php echo $this->general->get_currenttime(); ?>
		</td>
	</tr> 

	<tr class="title_sub">
		<td width="20%"></td>
		<td style="text-align: center;"><font color="black"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>" ><?php echo LOCATION; ?></span></font>
		</td>
		<td width="25%" style="text-align:right; font-size:10px;"></td>
	</tr>
</table>

<table class="table_jo_header purchaseInfo">
	<tr>
		<td class="text-center" align="center">
			<h4 style="margin: 0px; margin-top:4.5px;padding: 0px;font-size: 15px;line-height: 14px;padding-bottom: 9px !important;">
				<u>
					<?php echo !empty($report_title)?$report_title:''; ?>
				</u>
			</h4>
		</td>
	</tr>
</table>

<table class="jo_tbl_head">
	<tr>
		<td colspan="5" style="text-align: center;" align="center"> 
			<?php if(!empty($fromdate)): ?>
			<strong><?php echo $this->lang->line('from_date'); ?> :</strong> <?php echo !empty($fromdate)?$fromdate:'';?> 
		<?php endif; ?>
		<?php if(!empty($todate)): ?>
			<strong><?php echo $this->lang->line('to_date'); ?> :</strong> <?php echo !empty($todate)?$todate:'';?> 
		<?php endif; ?>
		</td>
	</tr>

	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<?php
		if(!empty($store_type) || !empty($materialtype) || !empty($department) || !empty($eq_category) || !empty($location) || !empty($username) || !empty($item)):
	?>
	<tr>
		<?php if(!empty($store_type)):?>
		<td style="text-align: left;width:20%;" align="left">
			<strong><?php echo $this->lang->line('store'); ?>: </strong>
			<?php
				echo !empty($store_type[0]->eqty_equipmenttype)?$store_type[0]->eqty_equipmenttype:'All';
			?>
		</td>
		<?php endif; ?>
		
		<?php if(!empty($materialtype)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('material_type'); ?>: </strong>
			<?php
				echo !empty($materialtype[0]->maty_material)?$materialtype[0]->maty_material:'All';
			?>
		</td>
		<?php endif; ?>

		<?php if(!empty($item)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('items'); ?>: </strong>
			<?php
				echo !empty($item[0]->itli_itemname)?$item[0]->itli_itemname:'All';
			?>
		</td>
		<?php endif; ?>

		<?php if(!empty($department)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('department'); ?>: </strong>
			<?php
				echo !empty($department[0]->dept_depname)?$department[0]->dept_depname:'All';
			?>
		</td>
		<?php endif;?>

		<?php if(!empty($eq_category)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('category'); ?>: </strong>
			<?php
				echo !empty($eq_category[0]->eqca_category)?$eq_category[0]->eqca_category:'All';
			?>
		</td>
		<?php endif; ?>

	 	<?php if(!empty($username)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('username'); ?>: </strong>
			<?php
				echo !empty($username[0]->usma_username)?$username[0]->usma_username:'All';
			?>
		</td>
		<?php endif; ?> 

		<?php if(!empty($supplier)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('supplier_name'); ?>: </strong>
			<?php
				echo !empty($supplier[0]->dist_distributor)?$supplier[0]->dist_distributor:'All';
			?>
		</td>
		<?php endif; ?> 


		<?php if(!empty($location)): ?>
		<td style="text-align: right;width:20%;" align="right">
			<strong><?php echo $this->lang->line('location'); ?>: </strong>
			<?php
				echo !empty($location[0]->loca_name)?$location[0]->loca_name:'All';
			?>
		</td>
		<?php endif; ?>

	
	<!-- 	<?php if(!empty($status)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong>Status: </strong>
			<?php
				echo !empty($status[0]->asst_statusname)?$status[0]->asst_statusname:'All';
			?>
		</td>
		<?php endif; ?>
 -->


	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<?php
		endif;
	?>
</table>


<table class="jo_tbl_head">
	<?php
		if(!empty($status) || !empty($condition) || !empty($depreciation) || !empty($assettype)):
	?>
	<tr>
		<?php if(!empty($status)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('status'); ?>: </strong>
			<?php
				echo !empty($status[0]->asst_statusname)?$status[0]->asst_statusname:'All';
			?>
		</td>
		<?php endif; ?>

		
		<?php if(!empty($condition)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('condition'); ?>: </strong>
			<?php
				echo !empty($condition[0]->asco_conditionname)?$condition[0]->asco_conditionname:'All';
			?>
		</td>
		<?php endif; ?>	

		<?php if(!empty($manufacture)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('manufacture'); ?>: </strong>
			<?php
				echo !empty($manufacture[0]->manu_manlst)?$manufacture[0]->manu_manlst:'All';
			?>
		</td>
		<?php endif; ?>	

		<?php if(!empty($assettype)): ?>
		<td style="text-align: center;width:20%;" align="center">
			<strong><?php echo $this->lang->line('assets_type'); ?>: </strong>
			<?php
				echo !empty($assettype[0]->eqca_category)?$assettype[0]->eqca_category:'All';
			?>
		</td>
		<?php endif; ?>	

	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<?php
		endif;
	?>


	</table>