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
        <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('cancel_order_list'); ?>  </u></b> </td>
    </tr>
</table>

<table id="cancel_print" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="15%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="5%"><?php echo $this->lang->line('cancel_date'); ?></th>
            <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
            <th width="5%"><?php echo $this->lang->line('order_date'); ?></th>
            <!-- <th width="5%"><?php //echo $this->lang->line('cancel_qty'); ?></th> -->
            <th width="5%"><?php echo $this->lang->line('odr_qty'); ?></th>
            <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="5%"><?php echo $this->lang->line('vat'); ?> </th>
            <th width="5%"><?php echo $this->lang->line('dis'); ?> </th>
            <!-- <th width="5%"><?php //echo $this->lang->line('cancel_amount'); ?></th>
            <th width="5%"><?php //echo $this->lang->line('cancel_all'); ?></th> -->
            <th width="5%"><?php echo $this->lang->line('remarks'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
            $rate = !empty($row->rate)?$row->rate:'';
            $cancelqty = !empty($row->cancelqty)?$row->cancelqty:'';
            $cancel_all = $rate * $cancelqty;
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->itemcode)?$row->itemcode:'';?></td>
            <td><?php echo !empty($row->itemname)?$row->itemname:'';?></td>
            <td>
                <?php echo !empty($row->suppliername)?$row->suppliername:'';?>
            </td>
            <td>
                <?php echo !empty($row->canceldate)?$row->canceldate:'';?>
            </td>
            <td><?php echo !empty($row->orderno)?$row->orderno:'';?></td>
            <td><?php echo !empty($row->orderdate)?$row->orderdate:'';?></td>
            
            <td><?php echo !empty($row->quantity)?$row->quantity:'';?></td>
            <td><?php echo !empty($row->rate)?$row->rate:'';?></td>
            <td><?php echo !empty($row->vat)?$row->vat:'';?></td>
            <td><?php echo !empty($row->discount)?$row->discount:'';?></td>
            
            <td><?php echo !empty($row->remarks)?$row->remarks:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;

        endif;
        ?>
    </tbody>
</table>