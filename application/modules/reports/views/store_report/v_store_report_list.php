<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
        <td style="text-align: center;"><span style="text-align: center; text-decoration: underline;font-weight: bold;"><?php echo $month[0]->mona_namenp; ?></span></td></span></div>
      <table class="table table-striped alt_table">
      	<tr>
      		<td>गत महिनाको मौज्दात</td>
      		<td><?php $opbalamt=!empty($opening_summary->openingbalance)?$opening_summary->openingbalance:'0.00'; echo number_format($opbalamt,2); ?></td>

      	</tr>
      	<tr>
      		<td colspan="2" style="
    background: black;
    color: white;
"><span class="pull-left"><strong>आम्दानी</strong></span></td>
      	</tr>
      	<tr><td>यो महिनाको खरीद</td><td><?php  $rcamt=!empty($get_store_report)?$get_store_report[0]->rc_amount:'0.00'; echo number_format($rcamt,2) ?></td></tr>
      	<tr><td>यो महिनाका हस्तान्तरण प्राप्त</td><td><?php echo $hdoamt= !empty($get_store_report)?$get_store_report[0]->hdo_amount:'0.00'; echo number_format($hdoamt,2) ?></td></tr>
      	<tr><td>यो महिनाका स्टोर क्रेडिट रकम</td><td><?php echo $retamt= !empty($get_store_report)?$get_store_report[0]->iss_retamt:'0.00'; ?></td></tr>
      	<tr><td>यो महिनाका अन्य आम्दानी</td><td>0.00</td></tr>
      	<tr><td><strong>जम्म आम्दानी</strong></td><td><strong><?php $totalincome=$rcamt+$hdoamt+$retamt; echo number_format($totalincome,2); ?></strong></td></tr>
      	
      	<tr><td colspan="2"></td></tr>
      		<tr style="
    background: black;
    color: white;
"><td colspan="2"><span class="pull-left"><strong>खर्च</strong></td></span></tr>
      		<tr><td>चालु महिनाको कार्य सञ्चालन खर्च
(विवरण संलग्न)</td><td><?php  $oper_exp_amt=!empty($get_operation_summary->totalamt)?$get_operation_summary->totalamt:'0.00'; echo number_format($oper_exp_amt,2); ?></td></tr>
<tr><td>जिन्सी बिक्री</td><td>0.00</td></tr>
      		<tr><td>चालु महिनाको(आन्तरिक) पुँजीगत खर्च
</td><td><?php  $cap_int_exp_amt=!empty($get_capital_int_summary->totalamt)?$get_capital_int_summary->totalamt:'0.00'; echo number_format($cap_int_exp_amt,2); ?></td></tr>
<tr><td>चालु महिनाको(बाह्य) पुँजीगत खर्च
</td><td><?php $cap_ext_exp_amt=!empty($get_capital_ext_summary->totalamt)?$get_capital_ext_summary->totalamt:'0.00'; echo number_format($cap_ext_exp_amt,2); ?></td></tr>
<tr><td>सडक</td><td><?php $road_exp_amt=!empty($get_road_summary->totalamt)?$get_road_summary->totalamt:'0.00'; echo number_format($road_exp_amt,2);?></td></tr>
<tr><td><strong>चालु महिनाको जम्मा खर्च</strong></td><td><strong><?php
$t_amt=$oper_exp_amt+$cap_int_exp_amt+$cap_ext_exp_amt+$road_exp_amt;
echo number_format($t_amt,2)
?></strong></td></tr>
<tr>
  <td></td>
</tr>
<tr>
  <td>हालसम्माको जिन्सी मौज्दात</td>
  <td> <?php $total_closing=$opbalamt+$totalincome-$t_amt; echo number_format($total_closing,2); ?></td>
</tr>
    </table>
  </div>





