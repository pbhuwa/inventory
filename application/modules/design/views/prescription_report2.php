<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700" rel="stylesheet">

<style>
	.prescript_report { font-family:'Poppins'; font-size:12px;  }
	.detail_form .pt_id { display:block; width:100px; border: 1px solid #bbb; padding: 5px 10px; text-align:center; }
	.detail_form table td { font-size:12px; }
	.detail_form .person_detail { list-style:none; }
	/*table tr td span { font-weight:bold; }*/
	
	ul.person_detail { margin:3px 0; padding-left:0; }
	ul.person_detail li span.bdy_info { width:300px; display:inline-block; }
	
/*    .prescript_table { max-height:500px; }*/
	.prescript_table .ptable_ttl { font-size:18px; text-transform:uppercase; text-align:center; font-weight:bold; padding-bottom:5px; padding-top:10px; }
    
    .ptable { border:1px solid #ddd; font-size:11px; height:600px; }
    .ptable .thead div { float:left; border-left:1px solid #ddd; padding:2px; height:35px; text-align:center; font-weight:bold; line-height:13px;  }
    .ptable .tbody div { float:left; border-left:1px solid #ddd; border-top:1px solid #ddd; padding:2px; height:32px; line-height:13px;  }
    .ptable .sno { width:35px; }
    .ptable .type { width:80px; }
    .ptable .med { width:180px; }
    .ptable .str { width:80px; }
    .ptable .df { width:70px; }
    .ptable .remark { width:130px; }
    .ptable .course { width:68px; }
    .ptable .tbody .type, .ptable .tbody .med, .ptable .tbody .str, .ptable .tbody .df, .ptable .tbody .course { text-align:center; }
    .ptable .tbody.last div { height:100%; float:left; }
    
	.mbtm_10 { margin-bottom:10px; }
	.mbtm_15 { margin-bottom:15px; }

</style>

<div class="prescript_report">
	<div class="detail_form">
		<table class="mbtm_15">
			<tr>
				<td class="pt_id"><b>Pt.Id.No.</b> 12345</td>
				<td width="100%"></td>
				<td class="date"><span>Date -</span> 2017/10/11 <span class="time">12:54:16</span></td>
			</tr>
		</table>
		<table>
			<tr>
				<td width="12%"><b>Name -</b></td>
				<td> Aryan Mainali</td>
				<td width="12%"><b class="label">Age/Sex -</b></td>
				<td>13/Male</td>
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
		<table>
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
		<div class="ptable">
		    <div class="trow">
		        <div class="thead">
                    <div class="sno">S.No.</div>
                    <div class="type">Type</div>
                    <div class="med">Medicine(Rs)</div>
                    <div class="str">Strength</div>
                    <div class="df">Dose Frequently</div>
                    <div class="remark">Remarks</div>
                    <div class="course">Course</div>
		        </div>
		        <div class="tbody">
		            <div class="sno">1</div>
                    <div class="type">INSULIN</div>
                    <div class="med">LANTUS</div>
                    <div class="str">16 UI</div>
                    <div class="df">1</div>
                    <div class="remark">evening @ 9pm</div>
                    <div class="course">Continue</div>
		        </div>
		        <div class="tbody">
		            <div class="sno">2</div>
                    <div class="type">INSULIN</div>
                    <div class="med">NOVORAPID PENFILL</div>
                    <div class="str">10 UI</div>
                    <div class="df">1</div>
                    <div class="remark">morning before meal</div>
                    <div class="course">Continue</div>
		        </div>
		        <div class="tbody">
		            <div class="sno">3</div>
                    <div class="type">INSULIN</div>
                    <div class="med">NOVORAPID PENFILL</div>
                    <div class="str">6 UI</div>
                    <div class="df">1</div>
                    <div class="remark">evening before meal</div>
                    <div class="course">Continue</div>
		        </div>
		        <div class="tbody">
		            <div class="sno">4</div>
                    <div class="type">TABLET</div>
                    <div class="med">FORMIN 500</div>
                    <div class="str">1/2 Tab</div>
                    <div class="df">2</div>
                    <div class="remark">after meal</div>
                    <div class="course">Continue</div>
		        </div>
		        <div class="tbody">
		            <div class="sno">5</div>
                    <div class="type">OINTMENT</div>
                    <div class="med">NEOXIN</div>
                    <div class="str">Apply locally</div>
                    <div class="df">2</div>
                    <div class="remark">2 times a day</div>
                    <div class="course">Continue</div>
		        </div>
		        <div class="tbody last">
		            <div class="sno"></div>
                    <div class="type"></div>
                    <div class="med"></div>
                    <div class="str"></div>
                    <div class="df"></div>
                    <div class="remark"></div>
                    <div class="course"></div>
		        </div>
		    </div>
		</div>
	</div>
	<div class="prescription_footer">

	</div>
	hellow
	
<!--
	
-->
</div>