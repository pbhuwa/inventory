<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>



              <table width="100%" style="font-size:12px;">
    <tr>
    <td width="200px">
        <td width="200px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('purchase_requisition_book'); ?>  </u></b> </td>
            </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('received_date'); ?> </th>
            <th width="7%"><?php echo $this->lang->line('invoice_no'); ?></th>
            <th width="7%"><?php echo $this->lang->line('receiver_no'); ?></th>
            <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('tax'); ?></th>
            <th width="5%"><?php echo $this->lang->line('clearance_amt'); ?></th>
            <th width="5%"><?php echo $this->lang->line('time'); ?></th>
            <!-- <th width="5%"><?php echo $this->lang->line('canceled'); ?></th> -->
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
			<td><?php echo $pending->recm_receiveddatebs; ?></td>
			<td><?php echo $pending->recm_invoiceno; ?></td>
			<td><?php echo $pending->orderno; ?></td>
			<td><?php echo $pending->dist_distributor; ?></td>
			<td><?php echo $pending->recm_discount; ?></td>
            <td><?php echo $pending->recm_taxamount; ?></td>
            <td><?php echo $pending->recm_clearanceamount; ?></td>
            <td><?php echo $pending->recm_posttime; ?></td>
            <!-- <td><?php echo $pending->recm_status; ?></td> -->
            <td><?php echo $pending->recm_amount; ?></td>
           

        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>