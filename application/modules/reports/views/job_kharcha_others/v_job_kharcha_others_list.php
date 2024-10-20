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
        if(!empty($job_kharcha_others_list)):

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
          foreach($job_kharcha_others_list as $jkh){
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
                 <td colspan="3" align="right">स्टेशनरी शिर्षगत जिन्सी कुल खर्च जम्मा</td> 
                 <td colspan="<?php if(is_array($catlist)&& !empty($catlist)) echo sizeof($catlist)+1; ?>" style="text-align: center;">
                   <?php echo number_format($sumall_cat,2) ?>
                 </td>  
               </tr>
              <tr style="font-weight: bold;">
                <td colspan="<?php if(is_array($catlist)&& !empty($catlist)) echo sizeof($catlist)+4; ?>" align="left" style="text-align: left">शिर्षगत कुल जम्मा</td>  
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