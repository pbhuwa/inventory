 <style>
  .table>tbody>tr>td, .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important; 
}
.table>thead>tr>th  {
  color:#000;
  font-size: 15px
}
.bottom_order h6{

    padding: 2px 0;

    font-size: 15px;
}
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
      <?php 
         $header['report_no'] = 'सै.क.काेष.फा.नं २८';
        $header['old_report_no'] = '';
        $header['report_title'] = 'जिन्सी मैाज्दातको वार्षिक विवरण';
        if (ORGANIZATION_NAME == 'NPHL') {
        $this->load->view('v_stock_report_header',$header); 
        }else{
        $this->load->view('common/v_report_header',$header); 
        }
        ?>
        <div  style="margin-top: 20px">
      <p style="margin:0 0 6px">
        कार्यालयकाे नाम:&nbsp;<?php echo $form_branch_name ?? ''; ?><br>
      </p>
    </div>
   <?php if(!empty($stock_result)){ ?>
    <div class="table-responsive">
    <table class="table alt_table">
      <thead>
        <tr>
        <th style="text-align: center" rowspan="2" width="5%">सि.नं.</th>
        <th style="text-align: center" rowspan="2" width="10%">जिन्सी नं / खा.पा.नं.</th>
        <th style="text-align: center" rowspan="2" width="8%">जिन्सी वगीर्करण संकेत नं.</th>
        <th style="text-align: center" rowspan="2" width="20%">जिन्सी सामानको नाम / स्पेसीफिकेसन</th>
        <th style="text-align: center" colspan="4" width="30%">माैज्दात बाँकी</th>
        <th style="text-align: center" colspan="4" width="10%">जिन्सी सामानको भाैतिक अवस्था</th>
        <th style="text-align: center" rowspan="2" width="10%">कैफियत</th>
      </tr>
      <tr>
        <th style="text-align: center">परिमाण</th>
        <th style="text-align: center">इकाई</th>
        <th style="text-align: center">दर</td>
       <th style="text-align: center">जम्मा मूल्य रू</th>
       <th style="text-align: center;">प्रयोग रहेकाे</th>
        <th style="text-align: center;">प्रयोग नरहेकाे</th>
        <th style="text-align: center;">मर्मत गर्नुपर्ने</th>
        <th style="text-align: center;">मर्मत हुन नसक्ने</th>
       </tr>
      </thead>
      <tbody>
      <tr>
      <td style="text-align: center">१</td>
      <td style="text-align: center">२</td>
      <td style="text-align: center">३</td>
      <td style="text-align: center">४</td>
      <td style="text-align: center">५</td>
      <td style="text-align: center">६</td>
      <td style="text-align: center">७</td>
      <td style="text-align: center">८</td>
      <td style="text-align: center">९</td>
      <td style="text-align: center">१०</td>
      <td style="text-align: center">११</td>
      <td style="text-align: center">१२</td>
      <td style="text-align: center">१३</td>
      </tr>

  <?php  
            $sum=0; 
            foreach ($stock_result as $key => $inspec) { 
               $inspec_balance_amt=!empty($inspec->balanceamt) && $inspec->balanceamt > 0 ? $inspec->balanceamt:'0.00';
                $inspec_balance_qty=!empty($inspec->balanceqty)?$inspec->balanceqty:'0.00';
                 $ad_qty = 0;
                $ad_amount = 0;
                if (ORGANIZATION_NAME == 'NPHL') {
                    if(!empty($inspec->auction_disposal_data)){
                    $ad_data = explode('@',$inspec->auction_disposal_data);
                    $ad_qty = (float)$ad_data[0];
                    $ad_amount = (float)$ad_data[1];
                 }
                }
                $actual_balance_qty = (float)($inspec_balance_qty - $ad_qty);
                $actual_balance_amt = (float)($inspec_balance_amt - $ad_amount);
                if ($actual_balance_qty <= 0){
                  continue;
                }
                $brate = $actual_balance_amt / $actual_balance_qty;
              ?>
              <tr style="border-bottom: 1px solid #212121;">
          <td class="td_cell" style="text-align: center; text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            <?php echo $key+1; ?>
          </td>
          <td class="td_cell" style="text-align: center; text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            <?php echo $inspec->itli_itemcode; ?>
          </td>
          <td class="td_cell" style="text-align: center; text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            <?php echo !empty($inspec->itli_catid)?$inspec->itli_catid:''; ?>
          </td>
          <td  class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
             <?php echo !empty($inspec->itli_itemname)?$inspec->itli_itemname:''; ?>
          </td>
           
                  <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: right;">
                      <?php echo sprintf('%g',( $actual_balance_qty)); ?>
                  </td>
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                      <?php echo !empty($inspec->unit_unitname)?$inspec->unit_unitname:''; ?>
                  </td>

                    <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                      <?php 
                     
                      // $brate=$inspec_balance_amt/$inspec_balance_qty; 
                      echo number_format($brate,2); ?>
          </td>

                  <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
                      <?php echo number_format($actual_balance_amt,2); ?>
                  </td>
        
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            
          </td> 
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            
          </td>
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            
          </td>
         
          <td style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            
          </td>
          <td style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            
          </td>
        </tr><?php
        $sum += !empty($actual_balance_amt) && $actual_balance_amt > 0 ? $actual_balance_amt : '0.0';
          // $vatsum += $inspec->recd_vatamt;

         } ?>
         <tr>
          <td colspan="13"  style="text-align: center;text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;font-size: 12px;">
            <span class="<?php echo FONT_CLASS; ?>">कूल  जम्मा : </span>:
          
            <?php echo !empty($sum)?number_format($sum,2):''; ?>
          </td>
        
        </tr>
        <tr>
          <td colspan="13"  style="text-align: center;text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;font-size: 12px;">
            <span class="<?php echo FONT_CLASS; ?>">शब्दमा :</span>:
          
            <?php echo !empty($sum)? $this->general->number_to_word($sum) : '';?>
          </td>
        </tr>
        </tbody>
    </table>
      </div>
      
       <?php } ?> 
       <table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
      <tr>
        <th>फांटवालाको दस्तखत </th>
        <th>शाखा प्रमुखको दस्तखत </th>
        <th>जिन्सी निरिक्षकको दस्तखत</th>
      </tr>
      <tr>
        <td>नाम:</td>
        <td>नाम:</td>
        <td>नाम:</td>
      </tr>
      <tr>
                <td>दर्जा:</td>
                <td>दर्जा:</td>
        <td>दर्जा:</td>
      </tr>
      
      <tr>
                <td>मिति: </td>
                <td>मिति: </td>
        <td>मिति: </td>
      </tr>
      
        </table>

        <table class="jo_footer" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom:  1px solid #333;">
      <tfoot>
      <tr>
        <td>१.</td>
        <td style="padding: 4px;">

          <span class="<?php echo CURDATE_NP;?>"> कार्यालय प्रमुखले सामानको स्पेसीफिकेसन अनुसार सम्बन्धित प्राविधिक समेतलाई समावेश गराई कम्तीमा बर्षको एक पटक जिन्सी निरिक्षण गरी तालुक कार्यालयमा समेत पठाउनु पर्ने छ| </span> 
          
        </td> 
      </tr>
      <tr>
        <td>२.</td>
        <td style="padding: 4px;">
          <span class="<?php echo CURDATE_NP;?>"> यो फारम अनुसार जिन्सी निरिक्षण गरी मर्मत गराउनु पर्ने तथा लिलाम बिक्रि गराउनु कारवाही संचालन गर्नु पर्ने छ| </span> 
          
        </td> 
      </tr>
      <tr>
        <td>३.</td>
        <td style="padding: 4px;">
          <span class="<?php echo CURDATE_NP;?>"> यो फारम सम्बन्धित फांटवाला र निरिक्षकले पेश गर्नु पर्ने छ| </span> 
          
        </td> 
      </tr>
      <tr>
        <td>४.</td>
        <td style="padding: 4px;">
          <span class="<?php echo CURDATE_NP;?>">मिशनको हकमा प्रत्येक डफ्फाको प्रमुखले आफ्नो कार्यालयमा जिन्सी निरिक्षण गराउनु पर्ने छ| </span> 
          
        </td> 
      </tr>
      </tfoot>
    </table>
        <!--  <div class="bottom_order" style="margin: 30px 0;padding:0 20px;display: flex;justify-content: space-around;">
       <div>
           <h6>फांटवालाको दस्तखत </h6>
           <p>नाम:</p>

       </div>
       <div>
           <h6>फांटवालाको दस्तखत </h6>
           <p>नाम:</p>

       </div>
       <div style="padding-right: 40px">
           <h6>जिल्ला निरिक्षक दस्तखत</h6>
           <p>नाम:</p>

       </div>

   </div> -->
   
</div>
    </div>
</div>