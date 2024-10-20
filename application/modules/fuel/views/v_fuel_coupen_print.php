<?php echo $this->load->view('common/v_print_report_header'); ?>

<style type="text/css">
	table.content-table tr td {
		padding: 3px 7px;
	}
</style>

<table width="100%" cellspacing="0">
	<tr>
		<th></th>
		<th style="text-align: left;">कुपन नं  :...<?php echo !empty($details[0]->fude_coupenno)?$details[0]->fude_coupenno:'' ?>..</th>
		
		
	</tr>
	<tr>
		<th></th>
		<th style="text-align: left;"> मिति: ..<?php echo !empty($details[0]->fude_assigneddatebs)?$details[0]->fude_assigneddatebs:'' ?>..</th>
	</tr>
	<tr>
		<th></th>
		<th style="text-align: left;"> लागुहुने  मिति: .. <?php echo !empty($details[0]->fuel_expdatebs)?$details[0]->fuel_expdatebs:'' ?>..</th>
	</tr>
	<tr>
		<th></th>
		<th style="text-align: left;">महिना : <?php echo !empty($details[0]->mona_namenp)?$details[0]->mona_namenp:'' ?></th>
	</tr>
	<tr>
		<th></th>
		<th style="text-align: left;">आर्थिक बर्ष:  <?php echo !empty($details[0]->fuel_fyear)?$details[0]->fuel_fyear:'' ?></th>
	</tr>
	<tr>
		<th></th>
		<th style="text-align: left;">गाडी नं :..................</th>
	</tr>
	<tr>
		<th style="text-align: right;"> नेपाल आयल निगम को नमुना बिक्र्रेता  </th>
	</tr>
	<tr>
		<th style="text-align: right;padding-right: 55px;">कुपन</th>
	</tr>
	<tr>
		<td>नोट : तल लेखियका समानहरु मेरो नाम मा लेखि पठाइदिनु होला। </td>
	</tr>
</table>
<table width="100%" cellspacing="0" class="content-table" style="border: 1px solid;margin-top: 7px;">
	<tr>
		<td style="border-right:1px solid;width:5%;">1</td>
		<td style="border-right:1px solid;width:20%;"><?php echo !empty($details[0]->futy_name)?$details[0]->futy_name:'' ?></td>
		<td style="border-right:1px solid;width:40%;"></td>
		<td style="border:none"></td>
	</tr>
	<tr>
		<td style="border-right:1px solid;width:5%;"></td>
		<td style="border-right:1px solid;width:20%;"></td>
		<td style="border-right:1px solid;width:40%;"></td>
		<td style="border:none"></td>
	</tr>
	
</table>
<table style="    margin-top: 14px;" width="100%">
	<tr>
		<td>फोर्म वा स्वथाको नाम : <?php echo ORGNAME; ?></td>
	</tr>
	<tr>
		<td style="width: 40%"></td>
		<td style="width: 25%"></td>
		<td style="width: 25%"></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="width: 25%">..................</td>
	</tr>
	<tr>
		<td style="width: 40%"></td>
		<td style="width: 25%"></td>
		<td style="width: 25%"></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="width: 25%">आधिकारिक हस्ताक्षेर</td>
	</tr>
</table>





