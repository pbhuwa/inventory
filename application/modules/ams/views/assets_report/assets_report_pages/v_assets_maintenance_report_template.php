<? if(!empty($asset_maintenance_report)): ?>
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
            <th width="8%">Maintenance Type</th>
            <th width="8%">PM Company</th>
            <th width="8%">Frequency</th>
            <th width="8%">Maintenance Date(B.S)</th>
            <th width="8%">Upcoming Maintenance Date(B.S)</th>
        </tr>
    </thead>
    <tbody>
        <?php 
          $i=1;
          foreach ($asset_maintenance_report as $key => $result): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $result->asen_assetcode; ?></td>
            <td><?php echo $result->asen_desc; ?></td>
            <td><?php echo $result->pmam_pmamtype; ?></td> 
            <td><?php echo $result->dist_distributor; ?></td>
            <td><?php echo $result->frty_name; ?></td>
            <td><?php echo $result->pmad_datebs; ?></td>
            <td><?php echo $result->pmad_upcomingdatebs; ?></td>  
        </tr>
        <?php
        $i++;
        endforeach;
        ?>
    </tbody>
    <!-- <tfoot>
      <tr>
        <th colspan="8">Total:</th>
        <th class="text-right"><?php echo $total_insurance_rate ?></th>
        <th class="text-right"><?php echo $total_insurance_amount ?></th>
      </tr>
    </tfoot> -->
</table>
<?php endif;?>