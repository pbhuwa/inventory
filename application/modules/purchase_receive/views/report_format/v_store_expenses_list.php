<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
      <table class="table table-striped alt_table">
        <thead>
          <tr><td  colspan="5">आ.व <?php echo $fiscalyrs; ?> खर्च तर्फ वार्षिक रिपोर्ट</td> </tr>
          <tr><td colspan="5" class="text-right"><?php echo !empty($month[0]->mona_namenp) ? $month[0]->mona_namenp :$month ; ?></td></tr> 
          <tr>
            <th width="5%">सि नं</th>
            <th width="10%">कोड नं</th>
            <th width="25%">बजेट शिर्षक  </th>
            <th width="25%">चालु आ.व को खर्च</th>
            <th width="15%">कैफियत </th>
          </tr>
        </thead>
        <tbody>
          <?php 
           $i=1;
            $totalexpamt=0;
          if(!empty($store_expenses_rpt)): 
           
            foreach ($store_expenses_rpt as $kse => $rpt):
              $totalexpamt +=$rpt->totalamt;
          ?>

          <tr>
            <td><?php echo $i ;?></td>
            <td><?php echo $rpt->eqca_code ?></td>
            <td><?php echo $rpt->eqca_category ?></td>
            <td><?php echo sprintf('%0.2f', round($rpt->totalamt, 2))   ?></td>
            <td></td>
          </tr>
          <?php 
          $i++;
          endforeach; ?>
          <tr>
          <td></td>
          <td colspan="2">जम्मा</td>
          <td><?php echo sprintf('%0.2f', round($totalexpamt, 2)) ?></td>
          <td></td>
          </tr>

        <?php endif; ?>
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







<!-- <div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php // $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
      <table class="table table-striped alt_table">
        <thead>
          <tr><td  colspan="5">स्टोर आम्दानी तथा खर्च बिवरण</td> </tr>
          <tr>
            <th width="5%">सि नं</th>
            <th width="10%">कोड नं</th>
            <th width="25%">बजेट शिर्षक  </th>
            <th width="25%">चालु महिनाको खर्च</th>
            <th width="15%">कैफियत </th>
          </tr>
        </thead>
        <tbody>
          <?php 
          //  $i=1;
          //   $totalexpamt=0;
          // if(!empty($store_expenses_rpt)): 
           
          //   foreach ($store_expenses_rpt as $kse => $rpt):
          //     $totalexpamt +=$rpt->tisamt;
          ?>

          <tr>
            <td><?php//echo $i ;?></td>
            <td><?php //echo $rpt->eqca_code ?></td>
            <td><?php //echo $rpt->itemcat ?></td>
            <td><?php //echo sprintf('%0.2f', round($rpt->tisamt, 2))   ?></td>
            <td></td>
          </tr>
          <?php 
          // $i++;
          // endforeach;
        //endif; ?>
          
          <tr>
            <td></td>
            <td></td>
            <td>क).जम्मा कार्य संचालन खर्च </td>
            <td><?php //echo sprintf('%0.2f', round($totalexpamt, 2))  ?></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>ख)जिन्सि बिक्री खर्च </td>
            <td>५६४५६</td>
            <td></td>
          </tr>



        </tbody>
      </table>
      <table class="table table-striped alt_table">
        <thead>
          <tr><td  colspan="5">पुजीगत तर्फ स्टोरे खर्च बिवरण </td> </tr>
          <tr>
            <th widh="5%" rowspan="2">सि नं</th>
            <th widh="10%" rowspan="1">कोड नं</th>
            <th widh="25%" rowspan="1">बजेट शिर्षक</th>
            <th widh="25%" rowspan="1">चालु महिनाको खर्च</th>
            <th widh="15%" rowspan="1">गत महिनासम्मको खर्च</th>
          </tr>
          <tr>

            <th widh="10%" >१)आन्तरिक खर्च</th>
            <th widh="25%" ></th>
            <th widh="25%" ></th>
            <th widh="15%" ></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>१</td>
            <td></td>
            <td>बकमा</td>
            <td>२४५१</td>
            <td>५५४</td>
          </tr>
          <tr>
            <td>२</td>
            <td></td>
            <td>चभतभ</td>
            <td>१२३४</td>
            <td></td>
          </tr>
          <tr>
            <td>३</td>
            <td></td>
            <td>बकमा</td>
            <td>१२३४१</td>
            <td>६५४६</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td> ग )जम्मा (आन्तरिक)  पुजीगत खर्च</td>
            <td>१२३१४३३</td>
            <td></td>
          </tr>

          <tr>
            <td></td>
            <td>२)बाह्य  पुजीगत खर्च</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>


          <tr>
            <td></td>
            <td></td>
            <td>शहअकम</td>
            <td>३३३३</td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>बकमाबक</td>
            <td>१२३४</td>
            <td>४५५</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>तततभचभ</td>
            <td>७६४५</td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>कबमाम</td>
            <td>७६४५</td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>७६७८</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>कुल खर्च (क ,ख ग घ)</td>
            <td>७६४५४३४५</td>
            <td></td>
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