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
p, li {
  color: #000
}
.listings li{
 display: grid;
 grid-template-columns: 1fr 1fr
}
.listings_last li{
 display: grid;
 grid-template-columns: 2fr 1fr;
 grid-gap: 1em;

}
.listings li:not(:last-child) span {
  border-bottom: 0 !important
}
.bottom_order p {
  margin-bottom: 3px
}
.center_no td {
  text-align: center;
}
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
    <div  style="margin-top: 10px">
        <p style="margin:0 0 5px; text-align: center;">आ.ब.............</p>
        <p style="margin:0 0 15px">कार्यालय कोड नं:</p>
    </div>
    <div style="display: grid;grid-template-columns: 46% 34% 20%;">
      <ul class="listings" style="list-style-type: none;padding-left: 0">
        <li>सामानको ववरणः <span style="border:1px solid #000; width:100px;padding:2px 8px;display: inline-block"></span></li>
        <li>सामानको सकेत नं:<span style="border:1px solid #000; width:100px;padding:2px 8px;display: inline-block"></span></li>
        <li>सामानको एकाइ:<span style="border:1px solid #000 ; width:100px;padding:2px 8px;display: inline-block"></span></li>
        <li>सामानको भzारण $ान:<span style="border:1px solid #000!important; width:100px;padding:2px 8px;display: inline-block"></span></li>
        <li style="margin-top: 20px">नकासा व ध:<span style="border:1px solid #000 !important; width:100px;padding:2px 8px;display: inline-block"></span></li>

      </ul>
      <ul class="listings" style="list-style-type: none;">
        <li>tून मौšात तहः<span style="border:1px solid #000; width:100px;padding:2px 8px;display: inline-block"></span></li>
        <li>अ धक मौšात तहः<span style="border:1px solid #000; width:100px;padding:2px 8px;display: inline-block"></span></li>
        <li>खरीद आदेश तहः<span style="border:1px solid #000; width:100px;padding:2px 8px;display: inline-block"></span></li>
        <li>खरीद आदेश स+ ा<span style="border:1px solid #000; width:100px;padding:2px 8px;display: inline-block"></span></li>
      </ul>
      <ul class="listings_last" style="list-style-type: none;">
        <li>बन कार्ड नं.:.........</li>

        <li style=" margin-bottom: 3px">खर्च भएर जानेः<span style="border:1px solid #000; width:50px;padding:2px 8px;display: inline-block"></span></li>
        <li>भच# भएर नजानेः<span style="border:1px solid #000; width:50px;padding:2px 8px;display: inline-block"></span></li>

      </ul>

    </div>
   <?php if(!empty($stock_result)){ ?>
    <div class="table-responsive">
    <table class="table alt_table">
      <thead>
        <tr>
        <th style="text-align: center" colspan="5">सामानको विवरण</th>
        <th style="text-align: center" colspan="3">सामान निकासाको विवरण</th>
        <th style="text-align: center" >बाँकी</th>
        <th style="text-align: center" rowspan="2">ज/ेवा र &लने /उपयोग गन</th>
      </tr>
      <tr>
          <th style="text-align: center">दाखिला न</th>
          <th style="text-align: center">दाखिला म त</th>
          <th style="text-align: center">उ›ादन म त</th>
           <th style="text-align: center">अŸlम उपभोम त</th>
           <th style="text-align: center">एकाई</th>
           <th style="text-align: center">परिमाण</th>
           <th style="text-align: center">निकासा नं.</th>
           <th style="text-align: center">परिमाण</th>
           <th style="text-align: center">परिमाण</th>
      </tr>
      </thead>
      <tbody>
      <tr class="center_no">
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
                      <?php echo sprintf('%g',($inspec->balanceqty)); ?>
                  </td>
                    <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                      <?php $brate=$inspec->balanceamt/$inspec->balanceqty; echo number_format($brate,2); ?>
          </td>

                  <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
                      <?php echo number_format($inspec->balanceamt,2); ?>
                  </td>
        
          <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            
          </td>
         
          <td style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
            
          </td>
        </tr><?php
        $sum += $inspec->balanceamt;
          // $vatsum += $inspec->recd_vatamt;

        
         } ?>
         <tr>
          <td colspan="15"  style="text-align: center;text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;font-size: 12px;">
            <span class="<?php echo FONT_CLASS; ?>">कुल  जम्मा : </span>:
          
            <?php echo !empty($sum)?number_format($sum,2):''; ?>
          </td>
        
        </tr>
        </tbody>
    </table>
      </div>
      
  
       <?php } ?> 
         <div class="bottom_order" style="margin: 30px 0;padding:0 100px 0 0 ;display: flex;justify-content: flex-end;">
       <div>
           <h6>फांटवालाको दस्ताखत </h6>
           <p>नाम :</p>
           <p>पद :</p>
           <p>मिति :</p>

       </div>


   </div>
   
</div>
    </div>
</div>
