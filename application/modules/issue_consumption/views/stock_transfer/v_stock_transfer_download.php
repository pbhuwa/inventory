<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php $this->load->view('common/v_report_header'); ?>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('transfer_number'); ?></th>
            <th width="10%"><?php echo $this->lang->line('transfer_date'); ?></th>
            <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th>
            <th width="10%"><?php echo $this->lang->line('location_from'); ?></th>
            <th width="10%"><?php echo $this->lang->line('location_to'); ?></th>
            <th width="10%"><?php echo $this->lang->line('requested_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('remarks'); ?>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
             <td><?php echo !empty($row->tfma_transferinvoice)?$row->tfma_transferinvoice:'';?></td>
              <td><?php echo !empty($row->tfma_transferdatebs)?$row->tfma_transferdatebs:'';?></td>
            <td><?php echo !empty($row->tfma_fiscalyear)?$row->tfma_fiscalyear:'';?></td>        
            <td>
                <?php echo !empty($row->fromlocation)?$row->fromlocation:'';?>
            </td>
            <td><?php echo !empty($row->tolocation)?$row->tolocation:'';?></td>
            <td><?php echo !empty($row->tfma_transferby)?$row->tfma_transferby:'';?></td>
            <td><?php echo !empty($row->tfma_remarks)?$row->tfma_remarks:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

