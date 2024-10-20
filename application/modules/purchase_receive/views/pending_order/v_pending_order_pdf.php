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
    <td width="215px"></td>
    <td width="215px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('pending_order_list'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="30%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('delivery_date'); ?></th>
            <th width="10%"><?php echo $this->lang->line('order_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('order_date'); ?></th>
            <th width="10%"><?php echo $this->lang->line('delivery_site'); ?></th>
            <th width="10%"><?php echo $this->lang->line('order_amount'); ?></th>
            <th width="10%"><?php echo $this->lang->line('approved'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending):
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($pending->dist_distributor)?$pending->dist_distributor:'';?></td>
            <td><?php echo !empty($pending->puor_deliverydatebs)?$pending->puor_deliverydatebs:'';?></td>
            <td>
                <?php echo !empty($pending->puor_orderno)?$pending->puor_orderno:'';?>
            </td>
            <td>
                <?php echo !empty($pending->puor_orderdatebs)?$pending->puor_orderdatebs:'';?>
            </td>
            <td><?php echo !empty($pending->puor_deliverysite)?$pending->puor_deliverysite:'';?></td>
            <td><?php echo !empty($pending->puor_amount)?$pending->puor_amount:'';?></td>
            <td><?php echo !empty($pending->puor_approvedby)?$pending->puor_approvedby:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>