<? if(!empty($asset_insurance_report)): ?>
<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		<?php  $this->load->view('common/v_report_header',$this->data); ?>
        <br>
        <table id="" class="format_pdf" width="100%"> 
        <thead>
        <tr>
            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('ass_code'); ?></th>
            <th width="10%">Description</th>
            <th width="8%">Insurance Company</th>
            <th width="8%">Policy No.</th>
            <th width="8%">Frequency</th>
            <th width="8%">Start Date</th>
            <th width="8%">End Date</th>
            <th width="8%">Insurance Rate</th>  
            <th width="8%">Insurance Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php 
          $i=1;
          $total_insurance_amount = 0;
          $total_insurance_rate = 0;
          foreach ($asset_insurance_report as $key => $result): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $result->asen_assetcode; ?></td>
            <td><?php echo $result->asen_desc; ?></td>
            <td><?php echo $result->inco_name; ?></td> 
            <td><?php echo $result->asin_policyno; ?></td>
            <td><?php echo $result->frty_name; ?></td>
            <td><?php echo $result->asin_startdatebs; ?></td>
            <td><?php echo $result->asin_enddatebs; ?></td>  
            <td><?php echo $result->asin_insurancerate; ?></td>
            <td><?php echo $result->asin_insuranceamount; ?></td>
        </tr>
        <?php
        $total_insurance_rate += $result->asin_insurancerate;
        $total_insurance_amount += $result->asin_insuranceamount;

        $i++;
        endforeach;
        ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="8">Total:</th>
        <th class="text-right"><?php echo $total_insurance_rate ?></th>
        <th class="text-right"><?php echo $total_insurance_amount ?></th>
      </tr>
    </tfoot>
</table>
<?php endif;?>