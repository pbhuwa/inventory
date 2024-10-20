<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:1px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>

<?php echo $this->load->view('common/v_pdf_excel_header'); ?>


<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('received_date'); ?> </th>
            <th width="10%"><?php echo $this->lang->line('invoice_no'); ?></th>
            <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
            <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="20%"><?php echo $this->lang->line('budget_name'); ?></th>
            <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('tax'); ?></th>
            <th width="5%"><?php echo $this->lang->line('clearance_amt'); ?></th>
            <th width="10%"><?php echo $this->lang->line('time'); ?></th></th>
            <!-- <th width="5%"><?php echo $this->lang->line('canceled'); ?></th></th> -->
            <th width="5%"><?php echo $this->lang->line('amount'); ?></th></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->recm_receiveddatebs)?$row->recm_receiveddatebs:'';?></td>
            <td><?php echo !empty($row->recm_invoiceno)?$row->recm_invoiceno:'';?></td>
            <td><?php echo !empty($row->orderno)?$row->orderno:'';?></td>
            <td><?php echo !empty($row->dist_distributor)?$row->dist_distributor:'';?></td>
            <td><?php echo !empty($row->budg_budgetname)?$row->budg_budgetname:'';?></td>
            <td><?php echo !empty($row->recm_discount)?$row->recm_discount:'';?></td>
            <td><?php echo !empty($row->recm_taxamount)?$row->recm_taxamount:'';?></td>
            <td><?php echo !empty($row->recm_clearanceamount)?$row->recm_clearanceamount:'';?></td>
            <td><?php echo !empty($row->recm_posttime)?$row->recm_posttime:'';?></td>
           <!--  <td><?php if($row->recm_status == "M")
                    {
                        echo "Cancelled";
                    }?></td> -->
            <td><?php echo !empty($row->recm_amount)?$row->recm_amount:'';?></td>

        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

