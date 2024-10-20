<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>

<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

              <table width="100%" style="font-size:12px;text-align: center;">
    <tr>
    
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('purchase_order_summary'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
            <th width="7%"><?php echo $this->lang->line('order_date'); ?> (AD)</th>
            <th width="7%"><?php echo $this->lang->line('order_date'); ?> (BS)</th>
            <th width="10%"><?php echo $this->lang->line('delivery_date'); ?>(AD)</th>
            <th width="10%"><?php echo $this->lang->line('delivery_date'); ?>(BS)</th>
            <th width="15%"><?php echo $this->lang->line('delivery_site'); ?></th>
            <th width="10%"><?php echo $this->lang->line('supplier_name'); ?></th> 
            <th width="10%"><?php echo $this->lang->line('order_amount'); ?></th>
            <th width="7%"><?php echo $this->lang->line('req_no'); ?></th>
            <th width="7%"><?php echo $this->lang->line('approved_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('materials_type_category'); ?></th>  

             
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
			<td><?php echo $row->puor_orderno; ?></td>
            <td><?php echo $row->puor_orderdatead;  ?></td>
			<td><?php echo $row->puor_orderdatebs; ?></td>
            <td><?php echo $row->puor_deliverydatead;  ?></td>
            <td><?php echo $row->puor_deliverydatebs; ?></td>
            <td><?php echo $row->puor_deliverysite; ?></td>
			<td><?php echo $row->dist_distributor; ?></td>
			<td><?php echo round($row->puor_amount,2); ?></td>
            <td><?php echo $row->puor_requno; ?></td>
			<td><?php echo $row->appr_approvedname; ?></td>
            <td><?php echo $row->maty_material; ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>