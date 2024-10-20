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
        <?php $this->load->view('common/v_report_header');?>
    <div  style="margin-top: 20px">

        <p style="margin:0 0 6px">
कार्यालय संकेत नं: <br>

आर्थिक वर्ष:......................</p>

    </div>

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
            foreach ($stock_result as $key => $inspec) { ?>
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
                      <?php echo number_format($inspec->balanceqty,2); ?>
                  </td>

                  <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
                      <?php echo number_format($inspec->balanceamt,2); ?>
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
        $sum += $inspec->balanceamt;
          // $vatsum += $inspec->recd_vatamt;

        
         } ?>
         <tr>
          <td colspan="15"  style="text-align: center;text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;font-size: 12px;">
            <span class="<?php echo FONT_CLASS; ?>">कूल  जम्मा : </span>:
          
            <?php echo !empty($sum)?number_format($sum,2):''; ?>
          </td>
        
        </tr>
        	</tbody>
    </table>
      </div>
      
  
       <?php } ?> 
<div style="margin-top: 20px;padding-left: 10px">
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

</table>
  
   
</div>
    </div>
</div>
