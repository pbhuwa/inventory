 <style>
  .table>tbody>tr>td, .table>thead>tr>th {
    vertical-align: middle !important;
    white-space: normal !important; 
}
.table>thead>tr>th  {
  color:#000;
  font-size: 15px
}
.table td.td_empty {
  padding:6px 4px;
}

</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php 
        $header['report_no'] = 'म.ले.प.फा.नं ४११';
        $header['old_report_no'] = 'साबिकको फारम न. ४९';
        $header['report_title'] = 'जिन्सी निरीक्षण फारम';
       
        if (ORGANIZATION_NAME == 'NPHL') {
        $this->load->view('v_stock_report_header',$header); 
        }else{
        $this->load->view('common/v_report_header'); 
        }
        ?>
    <div  style="margin-top: 20px">
    <!-- <span style="float: right; text-align: right; white-space: nowrap;">म.ले.प.फा.नं ४११</span> -->
      <p style="margin:0 0 6px">
        कार्यालय संकेत नं: <br>

        आर्थिक वर्ष:......................</p>
    </div>
    <!-- <div class="clearfix"></div> -->

   <?php if(!empty($stock_result)){ ?>
    <div class="table-responsive">
    <table class="table  alt_table">
      <thead>
        <tr>
        <th style="text-align: center;" rowspan="2">क्र. सं.</th>
        
        <th style="text-align: center;" rowspan="2">जिन्सी संकेत नं</th>
        <th style="text-align: center;" rowspan="2">खाता पाना नं.</th>
        <th style="text-align: center;" rowspan="2">विवरण</th>
        <th style="text-align: center;" rowspan="2">एकाइ</th>
        <th style="text-align: center;" colspan="2">जिन्सी खाता बमोजिमको माैज्दात</th>
        <th style="text-align: center;" colspan="2">स्पेसीफिकेसन</th>
        <th style="text-align: center;" colspan="3">भैातिक परिक्षण गर्दा</th>
        <th style="text-align: center;" colspan="2">चालु हालतमा</th>
        <th style="text-align: center;" colspan="4" >सामानको अवस्था</th>
        <th style="text-align: center;" colspan="1" rowspan="2">कुल परिमाण</th>
        <th style="text-align: center;" rowspan="2">कैफियत</th>
      </tr>
      <tr>
        <th style="text-align: center;">परिमाण</th>
        <th style="text-align: center;">मुल्य</th>
        <th style="text-align: center;">भिडेको</th>
        <th style="text-align: center;">नभिडेको</th>
        <th style="text-align: center;">घट संख्या</th>
        <th style="text-align: center;">बढ संख्या </th>
        <th style="text-align: center;">घट|बढ मुल्य</th>
        <th style="text-align: center;">रहेको</th>
        <th style="text-align: center;">नरहेको</th>
        <th style="text-align: center;">मर्मत गर्नु पर्ने</th>
        <th style="text-align: center;">लिलाम/बिकि्र गर्नु पर्ने</th>
        <th style="text-align: center;">मिन्हा गर्नु पर्ने</th>
        <th style="text-align: center;">संरक्षण गर्नु पर्ने</th>
       
      </tr>
      </thead>
      <tbody>
      <tr>
      <td>१</td>
      <td>२</td>
      <td>३</td>
      <td>४</td>
      <td>५</td>
      <td>६</td>
      <td>७</td>
      <td>८</td>
      <td>९</td>
      <td>१०</td>
      <td>११</td>
      <td>१२</td>
      <td>१३</td>
      <td>१४</td>
      <td>१५</td>
      <td>१६</td>
      <td>१७</td>
      <td>१८</td>
      <td>१९</td>
      <td>२०</td>
      </tr>

  <?php  
            $sum=0; 
            foreach ($stock_result as $key => $inspec) {
              $balance_qty = $inspec->balanceqty;
              $balance_amt = $inspec->balanceamt;
              $ad_qty = 0;
              $ad_amount = 0;
              if (ORGANIZATION_NAME == 'NPHL') {
                  if(!empty($inspec->auction_disposal_data)){
                  $ad_data = explode('@',$inspec->auction_disposal_data);
                  $ad_qty = (float)$ad_data[0];
                  $ad_amount = (float)$ad_data[1];
               }
              }
              $actual_balance_qty = (float)($balance_qty - $ad_qty);
              $actual_balance_amt = (float)($balance_amt - $ad_amount);
              if ($actual_balance_qty <= 0){
                continue;
              }
             ?>
              <tr style="border-bottom: 1px solid #212121;">
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            <?php echo $key+1; ?>
          </td>
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            <?php echo $inspec->itli_itemcode; ?>
          </td>
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            <?php echo !empty($inspec->itli_catid)?$inspec->itli_catid:''; ?>
          </td>
          <td  class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
             <?php echo !empty($inspec->itli_itemname)?$inspec->itli_itemname:''; ?>
          </td>
           
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                      <?php echo !empty($inspec->unit_unitname)?$inspec->unit_unitname:''; ?>
                  </td>

                  <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: right;">
                      <?php echo sprintf('%g',($actual_balance_qty)); ?>
                  </td>

                  <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
                      <?php echo $actual_balance_amt > 0 ? number_format($actual_balance_amt ,2) : '0.00'; ?>
                  </td>
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
          </td>
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            
          </td>
           <td class="td_cell">
                  </td>
                   <td class="td_cell">
                  </td>
                   <td class="td_cell">
                  </td>
          <td class="td_cell"></td>
          <td class="td_cell">
          </td>
          <td class="td_cell">
                  </td>
                  <td class="td_cell">
                  </td>
                  <td class="td_cell">
                  </td>
                  <td class="td_cell">
                  </td>
                  <td class="td_cell">
                  </td>
                  <td class="td_cell">
                  </td>
        </tr><?php
        $sum += $actual_balance_amt > 0 ? $actual_balance_amt : 0;
          // $vatsum += $inspec->recd_vatamt;

         } ?>
         <tr>
          <td colspan="20"  style="text-align: center;text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;font-size: 12px;">
            <span class="<?php echo FONT_CLASS; ?>">कूल  जम्मा : </span>:
          
            <?php echo !empty($sum)?number_format($sum,2):''; ?>
          </td>
        </tr>
        <tr>
        <td colspan="20"  style="text-align: center;text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;font-size: 12px;">
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
        <th>जिल्ला निरिक्षक दस्तखत</th>
      </tr>
      <tr>
        <td>नाम:</td>
        <td>नाम:</td>
        <td>नाम:</td>
      </tr>
      <tr>
                <td>पद:</td>
                <td>पद:</td>
        <td>पद:</td>
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

<!-- <div style="margin-top: 20px;padding-left: 10px">
  <p style="font-size: 14px;margin-bottom: 10px">जिन्सी निरीक्षण समिति गठन मिति:<br>
  जिन्सी निरीक्षण प्रतिवेदन  पेश मिति:
</p>

  <p>जिन्सी निरीक्षण समितिका पदाधिकारीको विवरण</p>
  </div>

<table class="table alt_table" style="width: 40%;margin-left: 0">
  <thead>
  <tr>
      <th>नाम</th>
      <th>पद</th>
      <th>हस्ताक्षर</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="td_empty"></td>
      <td class="td_empty"></td>
      <td class="td_empty"></td>
    </tr>
    <tr>
      <td class="td_empty"></td>
      <td class="td_empty"></td>
      <td class="td_empty"></td>
    </tr>
    <tr>
      <td class="td_empty"></td>
      <td class="td_empty"></td>
      <td class="td_empty"></td>
    </tr>
  </tbody>

</table> -->
  
</div>
    </div>
</div>