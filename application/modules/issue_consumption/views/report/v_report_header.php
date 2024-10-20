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
	.alt_table thead tr th, .alt_table tbody tr td { border:1px solid #000; padding:2px 5px; font-size:13px; }
	.alt_table tbody tr td { padding:5px; font-size:12px; }
	.alt_table tbody tr td.header { padding:5px; font-size:12px; font-weight: bold;}
	.alt_table tbody tr.alter td { border:0; text-align:center; }
	.alt_table tbody tr td.noboder { border-right:0; text-align:center; }
	.alt_table tbody tr td.noboder+td{ border-left: 0px; }
	.alt_table tr.borderBottom{border-bottom:2px solid #333;}
	.alt_table tr.header td{font-weight: bold;}

	table.organizationInfo{
		margin:0px;
		/*margin-top: -50px;*/
		padding: 0px;
	} 
</style>

<table class="organizationInfo" width="100%" style="font-size:12px; margin-bottom: 10px; ">
	<tr>
  		<td width="20%"></td>
  		<td  style="text-align: center;">
  			<h4 style="color:#101010;margin-bottom: 0px;">
  				<span class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAMETITLE; ?></span>
  			</h4>
  		</td>
  		<td width="25%"></td>
	</tr>
	<tr>
		<td width="20%"></td>
		<td  style="text-align: center;">
			<h4 style="color:#101010;margin-bottom: 0px;">
				<span class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAME; ?></span>
			</h4>
		</td>
		<td width="25%"></td>
	</tr>

	<tr class="title_sub">
		<td width="20%"></td>
		<td style="text-align: center;">
			<h4 style="color:black" class="<?php echo FONT_CLASS; ?>" >
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
		<td style="text-align: center;"><font color="black"><span class="<?php echo FONT_CLASS; ?>" ><?php echo LOCATION; ?></span></font>
		</td>
		<td width="25%" style="text-align:right; font-size:10px;"></td>
	</tr>
</table>