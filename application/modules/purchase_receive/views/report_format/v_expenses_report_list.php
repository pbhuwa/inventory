<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
       <th>कार्य सँचालन तर्फ स्टाेर खर्च विवरण</th>
      <table class="table table-striped alt_table">
       <thead>
       
        <tr>
          <th scope="col" >सि न </th>
          <th scope="col" >काेड न </th>
          <th scope="col" >बजेत शिर्षक </th>
          <th scope="col" >चालु महिनाकाे खर्च </th>
          <th scope="col" >कैफियत </th>
        </tr>
      
      </thead>
      <tbody>
        <?php 
        $i=1;
        $tamt=0;
                        
          if(!empty($expenses_rpt)):
          foreach($expenses_rpt as $key=>$expreport):
              $tamt +=$expreport->totalamt;
              ?>
        <tr>
          <td><?php echo $i;?></th>
          <td><?php echo $expreport->eqca_code;?></td>
          <td><?php echo $expreport->eqca_category;?></td>
          <td align="right"><?php echo $expreport->totalamt;?></td>
          <td></td>
         
        </tr>
        <?php  $i++;
      endforeach;
      endif;?>
       <tr style="font-weight: bold;">
                     <td rowspan="1"></td> 
                     <td rowspan="1"></td>
                     <td rowspan="1">जम्मा कार्य सँचालन खर्च</td> 
                     <td rowspan="1" align="right"><?php  echo sprintf('%0.2f', round($tamt, 2)); ?></td>
                     <td rowspan="1"></td>
                     
                     
                    
                 </tr>
      </tbody>
    </table>
  </div>

   <div class="table-responsive">
     <th>पूँजीगत तर्फ स्टाेर खर्च विवरण</th>
      <table class="table table-striped alt_table">
       <thead>
       
        <tr>
          <th scope="col" >सि न </th>
          <th scope="col" >काेड न </th>
          <th scope="col" >बजेत शिर्षक </th>
          <th scope="col" >चालु महिनाकाे खर्च </th>
          <th scope="col" >कैफियत </th>
        </tr>
        <tr>
          <th rowspan="2"></th>
          <th rowspan="2">(१) आन्तरिक खर्च</th>
        </tr>
      
      </thead>
      <tbody>
        <?php 
        $i=1;
        $tamt=0;
                        
          if(!empty($capital_internal_rpt)):
          foreach($capital_internal_rpt as $key=>$capreport):
              $tamt +=$capreport->totalamt;
              ?>
        <tr>
          <td><?php echo $i;?></th>
          <td><?php echo $capreport->eqca_code;?></td>
          <td><?php echo $capreport->eqca_category;?></td>
          <td align="right"><?php echo $capreport->totalamt;?></td>
          <td></td>
         
        </tr>
        <?php  $i++;
      endforeach;
      endif;?>
       <tr style="font-weight: bold;">
                     <td rowspan="1"></td> 
                     <td rowspan="1"></td>
                     <td rowspan="1">जम्मा (आन्तरिक) पूँजीगत खर्च</td> 
                     <td rowspan="1" align="right"><?php  echo sprintf('%0.2f', round($tamt, 2)); ?></td>
                     <td rowspan="1"></td>
                     
                     
                    
                 </tr>
      </tbody>
      <thead>
         <tr>
          <th rowspan="2"></th>
          <th rowspan="2">(२) बाह्रय पूँजीगत खर्च</th>
        </tr>
      </thead>
       <tbody>
        <?php 
        $i=1;
        $tamt=0;
                        
          if(!empty($capital_external_rpt)):
          foreach($capital_external_rpt as $key=>$capextreport):
              $tamt +=$capextreport->totalamt;
              ?>
        <tr>
          <td><?php echo $i;?></th>
          <td><?php echo $capextreport->eqca_code;?></td>
          <td><?php echo $capextreport->eqca_category;?></td>
          <td align="right"><?php echo $capextreport->totalamt;?></td>
          <td></td>
         
        </tr>
        <?php  $i++;
      endforeach;
      endif;?>
       <tr style="font-weight: bold;">
                     <td rowspan="1"></td> 
                     <td rowspan="1"></td>
                     <td rowspan="1">जम्मा (बाह्रय) पूँजीगत खर्च</td> 
                     <td rowspan="1" align="right"><?php  echo sprintf('%0.2f', round($tamt, 2)); ?></td>
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
      <td><span class="signatureDashedLine"></span> तया्र गर्ने:</td>
      <td><span class="signatureDashedLine"></span>पेश गर्ने:</td>
      <td><span class="signatureDashedLine"></span>सदर गर्ने:</td>
    </tr>

  </table>
</div>
  
</div>
</div>
</div>