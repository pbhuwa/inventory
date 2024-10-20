<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                 <thead>
                      <tr>
                        <th scope="col" rowspan="2">सि.नं.</th>
                        <th scope="col" rowspan="2">बिवरण</th>
                        <th scope="col" colspan="4">आम्दानी
                        </th>
                        <th scope="col" rowspan="2">जम्मा </th>
                      </tr>
                      <tr>
                        
                        <th>बजार खरिद</th>
                        <th>हस्तान्तरण  </th>
                        <th>स्टोरे क्रेडिट नोट </th>
                        <th>अन्य </th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
                     $i=1;
                        $rcamt=0;
                        $hdramt=0;
                        $t_incomeamt=0;
                        $hdoamt=0;
                        $issretamt=0;
                       
                    if(!empty($monthly_income_data)): 
                       
                        foreach ($monthly_income_data as $kyr => $rpt):
                        $rcamt +=$rpt->rc_amount;
                        $hdramt +=$rpt->hdr_amount;
                        $issretamt +=$rpt->iss_retamt;
                        $t_incomeamt +=$rpt->rc_amount+$rpt->hdr_amount+$rpt->iss_retamt;
                       

                        ?>
                    <tr>
                         <td rowspan="1"><?php echo $i; ?></td> 
                         <td rowspan="1"><a href="javascript:void(0)" data-id='<?php echo $fiscalyrs.'@'.$rpt->rdate.'@'.$branch_id ?>'class="view" data-displayid='displayReportDiv' data-viewurl='<?php echo ('/purchase_receive/report_format/daily_income_only'); ?>' style="font-weight: bold; color: black;"><?php echo $rpt->rdate; ?></a></td> 
                         <td rowspan="1" align="right"><?php echo sprintf('%0.2f', round($rpt->rc_amount, 2)); ?></td>
                         <td rowspan="1" align="right"><?php echo sprintf('%0.2f', round($rpt->hdr_amount, 2)); ?></td>
                         <td rowspan="1" align="right"><?php echo sprintf('%0.2f', round($rpt->iss_retamt, 2)); ?></td>
                        
                         <td rowspan="1"></td>
                          <td rowspan="1" align="right"><?php $rctot= ($rpt->rc_amount+$rpt->hdr_amount+$rpt->iss_retamt); echo sprintf('%0.2f', round($rctot, 2)); ?> </td>
                         
                    </tr>
                <?php
                    $i++;
                    endforeach; 
                    endif; ?>
                   <tr style="font-weight: bold;">
                     <td rowspan="1"></td> 
                     <td rowspan="1">जम्मा</td> 
                     <td rowspan="1" align="right"><?php  echo sprintf('%0.2f', round($rcamt, 2)); ?></td>
                     <td rowspan="1" align="right"><?php  echo sprintf('%0.2f', round($hdramt, 2)); ?></td>
                     <td rowspan="1" align="right"><?php  echo sprintf('%0.2f', round($issretamt, 2)); ?></td>
                     <td rowspan="1"></td>
                     <td rowspan="1" align="right"><?php echo sprintf('%0.2f', round($t_incomeamt, 2));  ?> </td>
                     
                    
                 </tr>
                </tbody>
                     
                    </tbody>
                </table>
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
                <td><span class="signatureDashedLine"></span> तया्र गर्ने:</td>
                <td><span class="signatureDashedLine"></span>पेश गर्ने:</td>
                <td><span class="signatureDashedLine"></span>सदर गर्ने:</td>
            </tr>
        </table>
    </div>
    </div>
</div>