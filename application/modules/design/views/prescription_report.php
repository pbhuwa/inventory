<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700" rel="stylesheet">

	

<style>
	.prescript_report { font-family:'Poppins'; font-size:12px;  }
	.detail_form .pt_id { display:block; width:100px; border: 1px solid #bbb; padding: 5px 10px; text-align:center; }
	.detail_form table td { font-size:12px; }
	.detail_form .person_detail { list-style:none; }
	
	ul.person_detail { margin:3px 0; padding-left:0; }
	ul.person_detail li span.bdy_info { width:300px; display:inline-block; }
	
    
/* --- table start --- */
	.prescript_table .ptable_ttl { font-size:18px; text-transform:uppercase; text-align:center; font-weight:bold; padding-bottom:5px; padding-top:10px; }
    
	table.p_table, table.d_table { border-collapse: collapse; font-size:11px; border: 1px solid #ddd; }
    table.p_table { border-right:0; }
    table.d_table { border-top:0; }
    
    .prescript_table .p_table tr th { border-bottom:1px solid #ddd; }
	.prescript_table .p_table tr td, .prescript_table .p_table tr th { border-right:1px solid #ddd; height:35px;  }
    .prescript_table .p_table tr th { text-align:center; }
	.prescript_table .p_table tr td { padding:0px 5px; vertical-align: middle; line-height:13px; }
    
	.prescript_table .p_table tr td.tl { text-align:left; }
	.prescript_table .p_table tr td.uc { text-transform:uppercase; }
    .d_table td { vertical-align:top;}
    

	.mbtm_10 { margin-bottom:10px; }
	.mbtm_15 { margin-bottom:15px; }
    .mbtm_20 { margin-bottom:20px; }
    .mbtm_25 { margin-bottom:25px; }
    .pad_top_80 { padding-top:80px; }
    
    .border { border: 1px solid #ddd; }
    .b_top { border-top:1px solid #ddd; }
    .b_btm { border-bottom:1px solid #ddd; }
    .b_left { border-left: 1px solid #ddd; }
    .b_right { border-right: 1px solid #ddd; }
    
    .text-center { text-align:center; }
    .text-right { text-align:right; }
    .white { color:#fff; }

</style>

<div class="prescript_report pad_top_80">
	<div class="detail_form">
		<table class="mbtm_25">
			<tr>
				<td class="pt_id"><b>Pt.Id.No.</b> <?php //echo $value->pama_patientid; ?></td>
				<td width="100%"></td>
				<td class="date"><span>Date -</span> 2017/10/11 <span class="time">12:54:16</span></td>
			</tr>
		</table>
		<table>
			<tr>
				<td width="12%"><b>Name -</b></td>
				<td><?php //echo $value->pama_title . $value->pama_fname .  $value->pama_mname . $value->pama_lname?></td>
				<td width="12%"><b class="label">Age/Sex -</b></td>
				<td><?php //echo $value->pama_age?>/<?php echo $value->pama_gender?></td>
			</tr>
		</table>
		<ul class="person_detail">
			<li>
				<span class="bdy_info">Ht. (cm): 160 &nbsp;&nbsp;&nbsp;</span>
				<span class="bdy_info">Wt. (Kg): 64.5 &nbsp;&nbsp;&nbsp;</span>
				<span class="bdy_info">BMI: 25.19 &nbsp;&nbsp;&nbsp;</span>
				<span class="bdy_info">W/H Ratio: 0 &nbsp;&nbsp;&nbsp;</span>
				<span class="bdy_info">B.P(mmofHg): 100/70 &nbsp;&nbsp;&nbsp;</span>
			</li>
		</ul>
		<table class="mbtm_15">
			<tr>
				<td width="12%"><b class="label">Diagnosis :</b></td>
				<td>C-PEPTIDE - 2.65 (30/8/2017)</td>
				<td width="12%"><b class="label">C/O :</b></td>
				<td></td>
			</tr>
		</table>

	</div>
	<div class="prescript_table">
		<div class="ptable_ttl">
			Follow Up Prescription
		</div>
		<table class="p_table" width="100%">
			<thead>
				<tr>
					<th width="6%">S.No.</th>
					<th width="13%">Type</th>
					<th width="28%">Medicine(Rs)</th>
					<th width="10%">Strength</th>
					<th width="10%">Dose Frequently</th>
					<th width="18%">Remarks</th>
					<th width="10%">Course</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="tl">1</td>
					<td class="uc text-center">Insulin</td>
					<td class="uc text-center">Lantus</td>
					<td class="text-center">16 IU</td>
					<td class=" text-center">1</td>
					<td class="tl">evening @ 9 pm</td>
					<td class=" text-center">Continue</td>
				</tr>
				<tr>
					<td class="tl">2</td><td class="uc text-center">Insulin</td> <td class="uc text-center">Novorapid Penfill</td> <td class="text-center">10 IU</td> <td class="text-center">1</td> <td class="tl">morning before meal</td> <td class="text-center">Continue</td>
				</tr>
				<tr>
					<td class="tl">3</td> <td class="uc text-center">Insulin</td> <td class="uc text-center">Novorapid Penfill</td> <td class=" text-center">6 IU</td> <td class=" text-center">1</td> <td class="tl">evening before meal</td> <td class=" text-center">Continue</td>
				</tr>
				<tr>
					<td class="tl">4</td> <td class="uc text-center">Tablet</td> <td class="uc text-center">Formin 500</td> <td class="text-center">1/2 Tab</td> <td class="text-center">2</td> <td class="tl">after meal</td> <td class="text-center">Continue</td>
				</tr>
				<tr>
					<td class="tl">5</td> <td class="uc text-center">Ointment</td> <td class="uc text-center">Neoxin</td> <td class="text-center">Apply locally</td> <td class="text-center">2</td> <td class="tl">two time a day</td> <td class="text-center">Continue</td>
				</tr>
				<tr>
					<td></td> <td></td>  <td></td>  <td></td>  <td></td>  <td></td>  <td></td>
				</tr>
				<tr>
					<td></td> <td></td>  <td></td>  <td></td>  <td></td>  <td></td>  <td></td>
				</tr>
				<tr>
					<td></td> <td></td>  <td></td>  <td></td>  <td></td>  <td></td>  <td></td>
				</tr>
				<tr>
					<td></td> <td></td>  <td></td>  <td></td>  <td></td>  <td></td>  <td></td>
				</tr>
				<tr>
					<td></td> <td></td>  <td></td>  <td></td>  <td></td>  <td></td>  <td></td>
				</tr>
				<tr>
					<td></td> <td></td>  <td></td>  <td></td>  <td></td>  <td></td>  <td></td>
				</tr>
				<tr>
					<td></td> <td></td>  <td></td>  <td></td>  <td></td>  <td></td>  <td></td>
				</tr>
			</tbody>
		</table>
		<table class="d_table">
		    <tbody>
		        <tr>
                   <td width="80%" class=" b_left b_btm">
                      <table class="advice">
                          <tr>
                              <td colspan="2"><b>Advice:</b></td>
                          </tr>
                          <tr>
                             <td width="30px"></td>
                              <td>BSF, BSPP, POST KHAJA, POST DINNER -2-3 DAYS BSF, BSPP, HBA1C, CBC, RFT, URINE RE, MICROALBUMIN, FU - 1 MONTH</td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                          </tr>
                          <tr>
                              <td></td>
                          </tr>
                          <tr>
                              <td colspan="2"><b>Follow Up:</b></td>
                          </tr>
                          <tr>
                              <td width="30px"></td>
                              <td>123</td>
                          </tr>
                      </table>
                       
                   </td>
                   <td width="20%" class="b_left b_right b_btm">
                      <table class="d_detail">
                          <tr>
                             <td colspan="4">
                              <b>Doctor's Signature:</b>
                             </td>
                          </tr>
                          <tr>
                              <td></td>
                          </tr>
                          <tr>
                             <td colspan="4" class="white">
                              __
                              </td>
                          </tr>
                          <tr>
                             <td colspan="4">
                              <u>For the use of pharmacy</u>
                              </td>
                          </tr>
                          <tr>
                              <td width="30px" class="border"></td>
                              <td width="80px">Fully</td>
                              <td width="30px" class="border"></td>
                              <td width="140px">Partially Dispended</td>
                          </tr>
                          <tr>
                              <td colspan="4">Dispensed for .......... Days</td>
                          </tr>
                          <tr>
                              <td colspan="4">Bill No. .....................</td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                          </tr>
                          <tr>
                              <td colspan="2"></td>
                              <td colspan="2" class="text-right">________________________</td>
                          </tr>
                          <tr>
                              <td colspan="2">Date of Dispense</td>
                              <td colspan="2" class="text-right">Pharmacist's Signature</td>
                          </tr>
                      </table>
                       
                   </td>
                    
                </tr>
		    </tbody>
		</table>
	</div>
	<div class="prescription_footer">

            
	</div>

</div>
<?php //} ?>