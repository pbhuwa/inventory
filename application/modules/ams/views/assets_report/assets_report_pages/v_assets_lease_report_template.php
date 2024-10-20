<? if(!empty($asset_lease_report)): ?>
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
            <th width="8%">Lease Company</th>
            <th width="8%">Contract No</th>
            <th width="8%">Frequency</th>
            <th width="8%">Lease Date(B.S)</th>
            <th width="8%">Initial Cost</th>
            <th width="8%">Rental Rate</th>  
        </tr>
    </thead>
    <tbody>
        <?php 
          $i=1;
          $total_initial_cost = 0;
          $total_rental_rate = 0;

          foreach ($asset_lease_report as $key => $result): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $result->asen_assetcode; ?></td>
            <td><?php echo $result->asen_desc; ?></td>
            <td><?php echo $result->leco_companyname; ?></td> 
            <td><?php echo $result->lema_contractno; ?></td>
            <td><?php echo $result->frty_name; ?></td>
            <td><?php echo "$result->lema_startdatebs - $result->lema_enddatebs" ?></td> 
            <td><?php echo $result->lede_initcost; ?></td>
            <td><?php echo $result->lede_rental_amt; ?></td>
        </tr>
        <?php
        $total_rental_rate += $result->lede_rental_amt;
        $total_initial_cost += $result->lede_initcost;

        $i++;
        endforeach;
        ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="7">Total:</th>
        <th class="text-right"><?php echo $total_initial_cost ?></th>
        <th class="text-right"><?php echo $total_rental_rate ?></th>
      </tr>
    </tfoot>
</table>
<?php endif;?>