<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
       
      <table class="table table-striped alt_table">
       <thead>
       
        <tr>
          <th scope="col" rowspan="2" >क)</th>
           <th scope="col" rowspan="2" >चू.नि.का. खर्च</th>
          <th scope="col" rowspan="2" >जम्मा रकम</th>
         
        </tr>
        <tr>
          
         
           
         
        </tr>
           <tr>
          <th>१</th>
          <th>लिक मर्मत (विभिन्न स्थानमा)</th>
          <th style="text-align: right;"><?php echo !empty($get_leakage_report->totalamt)?$get_leakage_report->totalamt:'0.00';
?></th>
          
         
        </tr>
        <tr>
          <th></th>
          <th align="right" style="text-align: right">जम्मा रकम</th>
          <th style="text-align: right;"><?php echo $lake_total=!empty($get_leakage_report->totalamt)?$get_leakage_report->totalamt:'0.00';
?></th>
          
        </tr>
         <tr>
          <th>ख)</th>
          <th>पा लाइन सुधार कार्य</th>
          <th></th>
          
         
        </tr>
         <tr>
          <th>५</th>
          <th>पा लु सु (काेड न 6-51-4) खर्च</th>
          <th style="text-align: right;"><?php echo $pipe_man_total=!empty($get_pipe_maintainance_report->totalamt)?$get_pipe_maintainance_report->totalamt:'0.00';?></th>
          
         
        </tr>
      
      </thead>
      <tbody>
       
        
       <tr style="font-weight: bold;">
                     <td colspan="2" align="right">पूजिगत कूल खर्च जम्मा</td> 
                     <td><?php $gtotal= $pipe_man_total+$lake_total; echo number_format($gtotal,2); ?></td>
                   
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