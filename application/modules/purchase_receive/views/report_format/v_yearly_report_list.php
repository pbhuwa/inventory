<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
         <tr > <th colspan="11">आ बा <strong><?php if(!empty($yearly_rpt)): echo $fiscalyrs; endif; ?></strong>   को बार्षिक जिन्सी(स्टोर) प्रतिवेदन </th></tr>
      <table class="table table-striped alt_table">
       <thead>
       
        <tr>
          <th scope="col" >मिति </th>
          <th scope="col" >अल्या </th>
          <th scope="col" >हस्तान्तरण आम्दानी</th>
          <th scope="col" >जिन्सी आम्दानी </th>
          <th scope="col" >स्टाेर केडिटनाेट </th>
          <th scope="col" >जम्मा आम्दानी </th>
          <th scope="col" >जि नि सू बाट खर्च</th>
          <th scope="col" >हस्तान्तरण खर्च </th>
          <th scope="col" >जिन्सी बिक्री</th>
          <th scope="col" >जम्मा खर्च </th>
          <th scope="col" >माैज्दात </th>

        </tr>
      
      </thead>
      <tbody>
         <?php 
                     $i=1;
                        $rcamt=0;
                        $hdramt=0;
                        $retamt=0;
                        $t_incomeamt=0;
                        $hdoamt=0;
                        $isamount=0;
                        $t_expamt=0;
                    if(!empty($yearly_rpt)): 
                       
                        foreach ($yearly_rpt as $kyr => $rpt):
                        $rcamt +=$rpt->rc_amount;
                        $hdramt +=$rpt->hdr_amount;
                        $retamt +=$rpt->iss_retamt;
                        $t_incomeamt +=$rpt->rc_amount+$rpt->hdr_amount;
                        $hdoamt +=$rpt->hdo_amount;
                        $isamount +=$rpt->isamt;
                        $t_expamt +=$rpt->hdo_amount+$rpt->isamt;

                        ?>
        <tr>
         
          <td rowspan="1"><a href="javascript:void(0)" data-viewreport='<?php echo $fiscalyrs.'@'.$rpt->yrs.'-'.$rpt->mnth.'@'.$branch_id ?>' class="view_detail_rpt" data-displayid='displayReportDiv' data-url='<?php echo ('/purchase_receive/report_format/monthly_income_exp'); ?>' style="font-weight: bold; color: black;"><?php echo $rpt->yrs.'-'.$this->general->get_monthname($rpt->mnth,'np'); ?></a></td> 
          <td><?php $opnbal=$rpt->opening_balance; echo number_format($rpt->opening_balance,2); ?></td>
          <td rowspan="1" align="right"><?php echo number_format($rpt->hdr_amount, 2); ?></td>
          <td align="right"><?php echo number_format($rpt->rc_amount,2);?></td>
          <td align="right"><?php echo number_format($rpt->iss_retamt,2);?></th>
         <td rowspan="1" align="right"><?php $rctot= ($opnbal+$rpt->rc_amount+$rpt->hdr_amount); echo number_format($rctot, 2); ?> </td>
        <td rowspan="1" align="right"><?php echo number_format($rpt->isamt, 2) ?> </td>
          <td rowspan="1" align="right"><?php echo number_format($rpt->hdo_amount, 2) ?> </td>
          <td align="right">0.00</td>
          <td rowspan="1" align="right"><?php $outamt= $rpt->hdo_amount+$rpt->isamt; echo number_format($outamt, 2) ?></td>
          <td align="right"><?php $closingbal= $rctot-$outamt; echo number_format($closingbal,2); ?></td>
         
        </tr>
        <?php
                    $i++;
                    endforeach; 
                    endif; ?>
                    <tr>
                        <td colspan="11" style="border: 0; height: 10px"></td>
                    </tr>
                     <tr style="
    background: #cacaca;
    font-weight: bold;
">
                     <td>Grand Total</td> 
                     <td></td> 
                     <td rowspan="1" align="right"><?php  echo number_format($hdramt, 2); ?></td>
                     <td rowspan="1" align="right"><?php  echo number_format($rcamt, 2); ?></td>
                     
                      <td rowspan="1" align="right"><?php  echo number_format($retamt, 2); ?></td>
                     <td rowspan="1" align="right"><?php echo number_format($t_incomeamt, 2);  ?> </td>
                     <td rowspan="1" align="right"> <?php echo number_format($isamount, 2);  ?></td>
                    
                     <td rowspan="1" align="right"> <?php echo number_format($hdoamt, 2); ?></td>
                     <td></td>
                     
                     <td rowspan="1" align="right"><?php echo number_format($t_expamt, 2); ?> </td>
                     <td rowspan="1"></td>
                     
                 </tr>
       
      </tbody>
     
    </table>
  </div>
   <div class="footerWrapper">
        <table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
          
             <tr>
                  <td><span class="signatureDashedLine"></span> ........................</td>
                  <td><span class="signatureDashedLine"></span> ........................</td>
                  <td><span class="signatureDashedLine"></span> ........................</td>
               
            </tr>
            <tr>
                <td><span class="signatureDashedLine"></span> तयार गर्ने:</td>
                <td><span class="signatureDashedLine"></span>पेश गर्ने:</td>
                <td><span class="signatureDashedLine"></span>सदर गर्ने:</td>
            </tr>
            
        </table>
    </div>
</div>
</div>
</div>

<!--  <div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php //$this->load->view('common/v_report_header');?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                  <tr > <th colspan="11">आ बा <?php //if(!empty($yearly_rpt)): echo $fiscalyrs; endif; ?>  साधारण स्टोरे तर्फ को बार्षिक बिवरण </th></tr>
                    <tr>
                        <th  rowspan="2">सि.नं</th>
                        <th  rowspan="2">महिना </th>
                        <th colspan="4" rowspan="1" style="text-align: center;">आम्दानी तर्फ </th>
                        <th  colspan="4" rowspan="1" style="text-align: center;">खर्च तर्फ</th>
                        <th  rowspan="1">कैफियत </th>
                    </tr>
                    <tr>
                         <th rowspan="1">बजार खरीद </th>
                         <th rowspan="1">हस्तान्तरण </th>
                         <th rowspan="1">अन्य आम्दानी</th>
                         <th rowspan="1">जम्मा आम्दानी</th> 
                         <th rowspan="1">हस्तान्तरण </th>
                         <th rowspan="1">जि.नि.सु. बाट </th>
                         <th rowspan="1">जम्मा खर्च </th>
                         <th rowspan="1">बाँकी मौजाद</th>
                         <th rowspan="1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                   //  $i=1;
                      //  $rcamt=0;
                       // $hdramt=0;
                      //  $t_incomeamt=0;
                       // $hdoamt=0;
                       // $isamount=0;
                      //  $t_expamt=0;
                   // if(!empty($yearly_rpt)): 
                       
                       // foreach ($yearly_rpt as $kyr => $rpt):
                       // $rcamt +=$rpt->rc_amount;
                       // $hdramt +=$rpt->hdr_amount;
                      //  $t_incomeamt +=$rpt->rc_amount+$rpt->hdr_amount;
                       // $hdoamt +=$rpt->hdo_amount;
                       // $isamount +=$rpt->isamt;
                       // $t_expamt +=$rpt->hdo_amount+$rpt->isamt;

                        ?>
                    <tr>
                         <td rowspan="1"><?php// echo $i; ?></td> 
                         <td rowspan="1"><a href="javascript:void(0)" data-viewreport='<?php //echo $fiscalyrs.'@'.$rpt->yrs.'-'.$rpt->mnth.'@'.$branch_id ?>' class="view_detail_rpt" data-displayid='displayReportDiv' data-url='<?php// echo ('/purchase_receive/report_format/monthly_income_exp'); ?>' style="font-weight: bold; color: black;"><?php// echo $rpt->yrs.'-'.//$this->general->get_monthname($rpt->mnth,'np'); ?></a></td> 
                         <td rowspan="1" align="right"><?php //echo number_format($rpt->rc_amount, 2); ?></td>
                         <td rowspan="1" align="right"><?php //echo number_format($rpt->hdr_amount, 2); ?></td>
                         <td rowspan="1" align="right"></td>
                         <td rowspan="1" align="right"><?php $rctot= ($rpt->rc_amount+$rpt->hdr_amount); //echo number_format($rctot, 2); ?> </td>
                         
                         <td rowspan="1" align="right"><?php //echo number_format($rpt->hdo_amount, 2) ?> </td>
                         <td rowspan="1" align="right"><?php //echo number_format($rpt->isamt, 2) ?> </td>
                         <td rowspan="1" align="right"><?php $outamt= $rpt->hdo_amount+$rpt->isamt; //echo number_format($outamt, 2) ?></td>
                         <td rowspan="1"></td>
                         <td rowspan="1"></td> 
                    </tr>
                <?php
                    //$i++;
                   // endforeach; 
                    //endif; ?>
                   <tr>
                     <td rowspan="1"></td> 
                     <td rowspan="1">जम्मा</td> 
                     <td rowspan="1" align="right"><?php  //echo number_format($rcamt, 2); ?></td>
                     <td rowspan="1" align="right"><?php // echo number_format($hdramt, 2); ?></td>
                     <td rowspan="1"></td>
                     <td rowspan="1" align="right"><?php //echo number_format($t_incomeamt, 2);  ?> </td>
                    
                     <td rowspan="1" align="right"> <?php //echo number_format($hdoamt, 2); ?></td>
                     <td rowspan="1" align="right"> <?php //echo number_format($isamount, 2);  ?></td>
                     <td rowspan="1" align="right"><?php //echo number_format($t_expamt, 2); ?> </td>
                     <td rowspan="1"></td>
                      <td rowspan="1" align="right"></td> 
                 </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                  <tr ><th colspan=3>हस्तान्तरण  आम्दानी को बिवरण</th> </tr>
                    <tr width="">
                     <th>सि नं </th>
                     <th>स्थान</th>
                     <th>रकम</th>
                   </tr>
                </thead>
                <tbody>
                       <tr>
                         <td></td>
                         <td>केन्द्रिय स्टोर</td> 
                         <td><?php //echo  number_format($t_incomeamt, 2);   ?></td>
                    </tr>
                     <tr>
                         <td></td>
                         <td>जम्मा</td> 
                         <td><?php //echo  number_format($t_incomeamt, 2);   ?> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <div class="footerWrapper">
        <table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
          
             <tr>
                  <td><span class="signatureDashedLine"></span> ........................</td>
                  <td><span class="signatureDashedLine"></span> ........................</td>
                  <td><span class="signatureDashedLine"></span> ........................</td>
               
            </tr>
            <tr>
                <td><span class="signatureDashedLine"></span> तयार गर्ने:</td>
                <td><span class="signatureDashedLine"></span>पेश गर्ने:</td>
                <td><span class="signatureDashedLine"></span>सदर गर्ने:</td>
            </tr>
            
        </table>
    </div>

    </div>
</div> -->
 