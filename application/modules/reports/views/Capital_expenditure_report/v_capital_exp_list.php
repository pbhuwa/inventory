<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <div class="table-responsive">
       
      <table class="table table-striped alt_table">
       <thead>
       
        <tr>
          <th scope="col" >सि न </th>
           <th scope="col" >कोड नम्बर</th>
          <th scope="col" >विवरण</th>
          <th scope="col" >रकम </th>
          <th scope="col" >थान </th>
           <th scope="col" >बुझिलिने </th>
            <th scope="col" >मिति </th>
          <th scope="col" >कैफियत </th>
        </tr>
      
      </thead>
      <tbody>
        <?php 
        $i=1;
        $tamt=0;

        // echo "<pre>";
        // print_r($get_capital_exp_report);
        // die();
                        
          if(!empty($get_capital_exp_report)):
          foreach($get_capital_exp_report as $key=>$capreport):
              $tamt +=$capreport->totalamt;
              ?>
        <tr>
          <td><?php echo $i;?></th>
          <td><?php echo $capreport->itli_itemcode;?></td>
          <td><?php echo $capreport->itli_itemname;?></td>
          <td align="right"><?php echo $capreport->totalamt;?></td>
          <td align="right"><?php echo $capreport->sade_curqty;?></td>
          <td><?php echo $capreport->sama_receivedby;?></td>
          <td><?php echo $capreport->sama_billdatebs;?></td>
          <td><?php echo $capreport->sama_remarks;?></td>
        
         
        </tr>
        <?php  $i++;
      endforeach;
      endif;?>
       <tr style="font-weight: bold;">
                     <td rowspan="1"></td>
                     <td rowspan="1"></td> 
                     <td rowspan="1">जम्मा कार्रय सँचालन खर्रच</td> 
                     <td rowspan="1" align="right"><?php  echo sprintf('%0.2f', round($tamt, 2)); ?></td>
                     <td rowspan="1"></td>
                     <td rowspan="1"></td>
                     <td rowspan="1"></td>
                     <td rowspan="1"></td>
                     
                     
                    
                 </tr>
      </tbody>
    </table>
  </div>

</div>
</div>
</div>