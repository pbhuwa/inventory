<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                   <tr colspan="11"><strong>१. बजार खरिद आम्दानी</strong></tr>
                    <tr>
                        <th  rowspan="1">सि.नं</th>
                        <th  rowspan="1">मिति </th>
                        <th colspan="1">जि.आ.भौ.न </th>
                        <th  colspan="1">पार्टीकोनाम</th>
                        <th  rowspan="1">बिल न.</th>
                        <th  rowspan="1">रकम</th>
                    </tr> 
                </thead>
                 <tbody>
                    <?php
                      $j=1;
                      $total_rcamt=0;
                    if(!empty($material_income_rpt)):
                      
                        foreach ($material_income_rpt as $kmi => $income):
                            $total_rcamt +=$income->rc_amount;
                     ?>
                    <tr>
                         <td rowspan="1"><?php echo $j; ?></td> 
                         <td rowspan="1"><?php echo $income->rdate ?></td> 
                         <td rowspan="1"><?php echo $income->recm_invoiceno ?></td>
                         <td rowspan="1"><?php echo $income->dist_distributor ?></td> 
                         <td rowspan="1"><?php echo $income->recm_supplierbillno ?></td>
                         <td rowspan="1"><?php echo number_format($income->rc_amount, 2);    ?></td>
                           
                     </tr>
                 <?php $j++;
                        endforeach;
                        endif; ?>
                     <tr>
                         <td rowspan="1"></td> 
                         <td rowspan="1"></td> 
                         <td rowspan="1"></td>
                         <td rowspan="1" ></td>
                         <td rowspan="1" align="right">जम्मा</td>
                         <td rowspan="1"><strong><?php echo number_format($total_rcamt, 2) ; ?></strong></td>
                     </tr>
                </tbody>
            </table>
        </div>

         <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
               
                   <tr colspan="11"><strong>२. स्टाेर क्रेडिटर आम्दानी</strong></tr>
                    <tr>
                        <th  rowspan="1">सि.नं</th>
                        <th  rowspan="1">मिति </th>
                        <th colspan="1"> क्रेडिटर जि.आ.भौ.न </th>
                        <th  colspan="1">ल्याएकाे शाखा/विवरण</th>
                        <th  rowspan="1"></th>
                         <th  rowspan="1">रकम</th>
                      
                    </tr>
                  
                </thead>
                 <tbody>

                     <tr>
                         <td colspan="3">पा. ला. वि. खर्च</td> 
                         <!-- <td rowspan="1"></td>
                         <td rowspan="1"></td> -->
                         <td rowspan="1"></td>
                         <td rowspan="1"></td>
                         <td rowspan="1"></td>
                        
                          
                    </tr>
                     <?php 
                     $m=1;
                     $ramt=0;
                     if(!empty($material_return_rpt)): 
                        foreach ($material_return_rpt as $krt => $mret):
                            $ramt += $mret->ret_amt;
                     ?>
                      <tr>
                         <td rowspan="1"><?php echo $m; ?></td> 
                         <td rowspan="1"><?php echo $mret->rema_returndatebs ?></td> 
                         <td rowspan="1"><?php echo $mret->rema_invoiceno ?></td>
                         <td rowspan="1"><?php echo $mret->dept_depname ?></td>
                         <td rowspan="1"></td>
                         <td rowspan="1"><?php echo number_format($mret->ret_amt, 2); ?></td> 
                    </tr>
                    <?php
                        $m++;

                        endforeach; 
                        endif; ?>
                     <tr>
                         <td rowspan="1"></td> 
                         <td rowspan="1"></td> 
                         <td rowspan="1"></td>
                         <td rowspan="1"></td>
                        <td rowspan="1" align="right">जम्मा</td>
                         <td rowspan="1"><strong><?php echo number_format($ramt, 2); ?></strong></td>
                        
                     </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
               
                   <tr colspan="11"><strong>३.हस्तान्तरण आम्दानी </strong></tr>
                    <tr>
                        <th  rowspan="1">सि.नं</th>
                        <th  rowspan="1">मिति </th>
                        <th colspan="1">  ह.फा.भौ.न </th>
                        <th  colspan="1">ल्याएकाे शाखा/विवरण</th>
                         <th  rowspan="1">रकम</th>
                      
                    </tr>
                  
                </thead>
                 <tbody>
                    <?php
                    $n=1;
                    $totamt_hand=0;
                    if(!empty($handover_rec_rpt)):
                        foreach ($handover_rec_rpt as $hk => $hand):
                            $totamt_hand +=$hand->haov_totalamount;
                     ?>
                     <tr>
                         <td rowspan="1"><?php echo $n; ?></td> 
                         <td rowspan="1"><?php echo $hand->handoverdate; ?></td> 
                         <td rowspan="1"><?php echo $hand->haov_handoverno; ?></td>
                         <td rowspan="1"><?php echo $hand->loca_name ?> बाट  सामान प्राप्त</td>
                         <td rowspan="1"></td>
                         <td rowspan="1"><?php echo number_format($hand->haov_totalamount, 2); ?></td>
                    </tr>
                     <?php
                    endforeach;
                    else:?>
                        <tr><td colspan="6"></td> </tr>
                    <?php endif;

                      ?>
                     <tr>
                         <td rowspan="1"></td> 
                         <td rowspan="1"></td> 
                         <td rowspan="1"></td>
                         <td rowspan="1" align="right"> हस्तान्तरण आम्दानी जम्मा रकम</td>
                         <td rowspan="1"></td>
                         <td rowspan="1"><?php echo number_format($totamt_hand, 2); ?></td>
                      </tr>
                      <tr style="height: 25px">
                          <td colspan="6"></td>
                      </tr>

                      <tr style="
    background: #d0d0d0;
">
                         <td rowspan="1"></td> 
                         <td rowspan="1"></td> 
                         <td rowspan="1"></td>
                         <td rowspan="1" align="right"><strong> कूल आम्दानी (१+२) रकम</strong></td>
                         <td rowspan="1"></td>
                         <td rowspan="1"><strong><?php $grandtotal= $total_rcamt+$ramt+$totamt_hand ; echo number_format($grandtotal, 2); ?></strong></td>
                        
                     </tr>
                </tbody>
            </table>
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