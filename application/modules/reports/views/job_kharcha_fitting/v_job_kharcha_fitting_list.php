<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
       
      <table class="table table-striped alt_table">
       <thead>
       
        <tr>
          <th scope="col" rowspan="2" >सि न </th>
           <th scope="col" rowspan="2" >मिति</th>
          <th scope="col" rowspan="2" >जि नि सु न</th>
          <?php 
          if(!empty($catlist)):
            foreach ($catlist as $kc => $cat) {
             ?>
             <th scope="col">
               <?php echo $cat->eqca_category; ?>
             </th>
             <?php
            }
          endif;
          ?>
          <th scope="col" rowspan="2" >जम्मा खर्च</th>
        </tr>
        <tr>
          
          <?php 
          if(!empty($catlist)):
            foreach ($catlist as $kc => $cat) {
               $colvar='col_cat'.$cat->eqca_equipmentcategoryid ;
              ${$colvar}=0.00
             ?>
             <th scope="col">
               <?php echo $cat->eqca_code; ?>
             </th>
             <?php
            }
          endif;
          ?>
        </tr>
       
      
      </thead>
      <tbody>
        <?php 
         $i=1;
          $sumall_cat=0.00;
           $sum_cat=0.00;
        if(!empty($job_kharcha_fitting_report)):

          if(!empty($catlist)):
            foreach ($catlist as $kc => $cat) {
             ?>
             <?php 
              $colvar='col_cat'.$cat->eqca_equipmentcategoryid ;
              ${$colvar}=0.00
              ?>
            
             <?php
            }
          endif;
          foreach($job_kharcha_fitting_report as $jkh){
          ?>
          <tr>
           <td> <?php echo $i;  ?></td>
          <td><?php echo $jkh->sama_billdatebs; ?></th>
          <td><?php echo $jkh->sama_invoiceno; ?></td>
          <?php 
          if(!empty($catlist)):
            $sum_cat=0.00;
            foreach ($catlist as $kc => $cat) {
               $colvar='col_cat'.$cat->eqca_equipmentcategoryid ;
             ?>
             <td scope="col" style="text-align: right;">
               <?php 
               $catvar = 'catval_'.$cat->eqca_equipmentcategoryid; 
               $catval=$jkh->{$catvar};
               $sum_cat =$sum_cat+ $catval;
              ${$colvar}+=$catval;
               echo $catval;
               ?>
             </td>

             <?php
            }
          endif;
          ?>
          <td style="text-align: right;"><?php echo  number_format($sum_cat,2); $sumall_cat=$sumall_cat+$sum_cat; ?></td>
        </tr>
        <?php
        $i++;
        }
        endif;
        ?>
       
<tr style="font-weight: bold;">
                <td colspan="3">जम्मा</td> 
          <?php 
          if(!empty($catlist)):
            foreach ($catlist as $kc => $cat) {
               $colvar='col_cat'.$cat->eqca_equipmentcategoryid ;
             ?>
             <td scope="col" style="text-align: right;">
              <?php echo number_format(${$colvar},2); ?>
             </td>
             <?php
            }

          endif;
          ?>
            <td> <?php echo number_format($sumall_cat,2) ?></td>
              </tr>
              <tr style="font-weight: bold;">
                 <td colspan="3" align="right">फिटिन्स शिर्षगत जिन्सी कुल खर्च जम्मा</td> 
                 <td colspan="<?php if(is_array($catlist)&& !empty($catlist)) echo sizeof($catlist)+1; ?>" style="text-align: center;">
                   <?php echo number_format($sumall_cat,2) ?>
                 </td>  
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
      <td><span class="signatureDashedLine"></span> तया्र गर्ने:</td>
      <td><span class="signatureDashedLine"></span>पेश गर्ने:</td>
      <td><span class="signatureDashedLine"></span>सदर गर्ने:</td>
    </tr>

  </table>
</div>
  </div>




<!--<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php // $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
       
      <table class="table table-striped alt_table">
       <thead>
       
        <tr>
          <th scope="col" rowspan="2" >सि न </th>
           <th scope="col" rowspan="2" >मिति</th>
          <th scope="col" rowspan="2" >जि नि सु न</th>
          <th scope="col">पम्प तथा मेसिनरी </th>
          <th scope="col" >सवारी तथा इक्वीपमेण्त </th>
          <th scope="col" >सवारी मर्मत </th>
          <th scope="col" >भबन मर्मत </th>
          <th scope="col" colspan="3" >सि आइ पि कार्यक्म </th>
          <th scope="col" colspan="3">सुख्खा माैसम कार्यक्म </th>
          <th scope="col" >प्णली मर्मत खर्च </th>
          <th scope="col" colspan="2" >आन्तरिक पुजिगत खर्च </th>
          <th scope="col" >सडक बिभाग खर्च </th>
          <th scope="col" >निन्सी बिक्री </th>
          <th scope="col" rowspan="2" >जम्मा खर्च</th>
        </tr>
        <tr>
          
          <th>११०१</th>
          <th>१६०२</th>
          <th>१६०७</th>
          <th>१७०७</th>
          <th>चु नि का तथा म का</th>
          <th>पा लु सु वि कार्य </th>
          <th>श्ाेत सँरधण सुधार</th>
          <th>पाेलुसन  नियन्त्ण</th>
           <th>साइकल खरिद</th>
          <th>गाडि मर्मत</th>
          <th>३५०२</th>
          <th>सवारि साधन</th>
          <th>औजार</th>
          <th></th>
          <th>मिटर बिक्री</th>
           
         
        </tr>
        
      
      </thead>
      <tbody>
       
        <tr>
          <td></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          
        
         
        </tr>
       
      
         
       <tr style="font-weight: bold;">
                     <td></td>
                     <td colspan="2">जम्मा</td> 
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                      <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                      <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     
                    
                 </tr>
                  <tr style="font-weight: bold;">
                     <td colspan="7" align="right">फिटिन्स शिर्षगत जिन्सी कुल खर्च जम्मा</td> 
                     <td colspan="2"></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                      <td></td>
                     <td></td>
                      <td></td>
                     <td></td>
                     <td></td>
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
      <td><span class="signatureDashedLine"></span> तया्र गर्ने:</td>
      <td><span class="signatureDashedLine"></span>पेश गर्ने:</td>
      <td><span class="signatureDashedLine"></span>सदर गर्ने:</td>
    </tr>

  </table>
</div>

</div>
</div>
</div>