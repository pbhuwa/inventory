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

.listings li {
  display: grid;
  margin-bottom: 3px;
  grid-template-columns: 1fr 1fr
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
    <div style="margin:20px 0; display: grid;grid-template-columns:40% 30% 30%;justify-content: space-between;align-items: flex-end;">
        <div>
          <p style="font-weight: bold;margin:0">नण#यको ववरण </p>
          <ul class="listings" style="border:1px solid;padding:1px 3px;list-style-type: none;margin:0 30px 0 0">
            <li>मžा/ नसग#को नण#य म तः<span></span></li>
            <li>नण#य गनM पदा धकारीको नाम र पदः<span></span></li>
          </ul>
        </div>
        <div></div>
        <div >
          <p style="margin:0">आ थb क बष :</p>
          <p style="margin:0">म तः</p>

        </div>
    </div>
   <?php if(!empty($stock_result)){ ?>
    <div class="table-responsive">
    <table class="table alt_table">
      <thead>
        <tr>
          <th style="text-align: center">क्र. सं.</th>
          <th style="text-align: center">जिन्सी स+केत  नं</th>
          <th style="text-align: center">जिन्सी&ज(ी खाता पाना नं .</th>
          <th style="text-align: center">मालसामानको नाम</th>
          <th style="text-align: center">,े&स-फकेसन</th>
          <th style="text-align: center">सुd Jा| म त</th>
          <th style="text-align: center">Jयोग भएको बष</th>
          <th style="text-align: center">प रमाण</th>
          <th style="text-align: center">परल मू\</th>
          <th style="text-align: center">हालको मू\ाि+कत मू\</th>
          <th style="text-align: center">&ज(ी नसग# / मžा गनु#पन कारण</th>
          <th style="text-align: center">कै-फयत</th>
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
        <td>११</td>
        <td>१२</td>
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
          <td></td>
          <td></td>
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
         <div class="bottom_order" style="margin: 30px 0;padding:0 20px;display: flex;justify-content: space-around;">
       <div>
           <h6>•ोर Jमुखको दKखतः</h6>
           <p>नाम:</p>
          <p>पदः</p>
           <p>म तः</p>

       </div>
       <div>
           <h6>शाखा Jमुखको दKखतः</h6>
           <p>नाम:</p>
           <p>पदः</p>
           <p>म तः</p>

       </div>
       <div style="padding-right: 40px">
           <h6>आदेश Vदनेको दKखत:</h6>
           <p>नाम:</p>
          <p>पदः</p>
           <p>म तः</p>

       </div>

   </div>
   
</div>
    </div>
</div>
