<? if(!empty($asset_disposal_report)): ?>
<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		<?php  $this->load->view('common/v_report_header',$this->data); ?>
        <br>
        <table id="" class="format_pdf" width="100%"> 
        <thead>
        <tr>
            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%">Date(B.S)</th>
            <th width="10%">Date(A.D)</th>
            <th width="10%"><?php echo $this->lang->line('ass_code'); ?></th>
            <th width="10%">Description</th>
            <th width="8%">Department Name</th>
            <th width="8%">Disposal Type</th>
            <th width="8%">Disposal No.</th>
            <th width="8%">Customer Name</th>
            <th width="8%">Original Cost</th>
            <th width="8%">Current Cost</th>  
            <th width="8%">Sales Cost</th>
        </tr>
    </thead>
    <tbody>
        <?php 
          $i=1;
          $total_original_cost = 0;
          $total_current_cost = 0;
          $total_sales_cost = 0;

          foreach ($asset_disposal_report as $key => $result): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $result->asde_deposaldatebs;?></td>
            <td><?php echo $result->asde_desposaldatead;?></td>
            <td><?php echo $result->asen_assetcode; ?></td>
            <td><?php echo $result->asen_desc; ?></td>
            <td><?php echo $result->dept_depname; ?></td> 
            <td><?php echo $result->dety_name; ?></td>
            <td><?php echo $result->asde_disposalno; ?></td>
            <td><?php echo $result->asde_customer_name; ?></td>
            <td><?php echo $result->asdd_originalvalue; ?></td>  
            <td><?php echo $result->asdd_currentvalue; ?></td>
            <td><?php echo $result->asdd_sales_amount; ?></td>
        </tr>
        <?php
        $total_current_cost += $result->asdd_currentvalue;
        $total_original_cost += $result->asdd_originalvalue;
        $total_sales_cost += $result->asdd_sales_amount;


        $i++;
        endforeach;
        ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="9">Total:</th>
        <th class="text-right"><?php echo $total_original_cost ?></th>
        <th class="text-right"><?php echo $total_current_cost ?></th>
        <th class="text-right"><?php echo $total_sales_cost ?></th>

      </tr>
    </tfoot>
</table>
<?php endif;?>