<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

</table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('category'); ?></th>
            <th width="10%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="5%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="5%"><?php echo $this->lang->line('mrno'); ?></th>
            <th width="5%"><?php echo $this->lang->line('supplier_bill_no'); ?></th>
            <th width="5%"><?php echo $this->lang->line('bill_date'); ?></th>
            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
            <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
            <th width="5%"><?php echo $this->lang->line('net_rate'); ?></th>
            <th width="5%"><?php echo $this->lang->line('amount'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
			<td><?php echo $pending->eqca_category; ?></td>
			<td><?php echo $pending->dist_distributor; ?></td>
			<td><?php echo $pending->itli_itemcode; ?></td>
			<td><?php echo $pending->itli_itemname; ?></td>
			<td><?php echo $pending->recm_invoiceno; ?></td>
            <td><?php echo $pending->recm_supplierbillno; ?></td>
            <td><?php echo $pending->recm_receiveddatebs; ?></td>
            <td><?php echo $pending->recd_purchasedqty; ?></td>
            <td><?php echo $pending->recd_unitprice; ?></td>
            <td><?php echo $pending->recd_discountpc; ?></td>
            <td><?php echo $pending->recd_vatpc;?></td>
			<td><?php echo ($pending->recd_purchasedqty)*($pending->recd_unitprice);?></td>
            <td><?php echo $pending->recd_amount; ?></td>

        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>