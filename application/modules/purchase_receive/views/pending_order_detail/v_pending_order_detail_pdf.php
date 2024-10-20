<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
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
                <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
                <th width="8%"><?php echo $this->lang->line('order_no'); ?></th>
                <th width="8%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="25%"><?php echo $this->lang->line('item_name'); ?></th>
                <th width="6%"><?php echo $this->lang->line('odr_qty'); ?></th>
                <th width="6%"><?php echo $this->lang->line('rem_qty'); ?></th>
                <th width="6%"><?php echo $this->lang->line('rate'); ?></th>
                <th width="6%"><?php echo $this->lang->line('vat'); ?></th>
                <th width="6%"><?php echo $this->lang->line('discount'); ?></th>
                <th width="8%"><?php echo $this->lang->line('amount'); ?></th>
                <th width="8%"><?php echo $this->lang->line('order_date'); ?></th>
                <th width="8%"><?php echo $this->lang->line('delivery_date'); ?></th>
                <th width="8%"><?php echo $this->lang->line('approved'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if($searchResult): 
            $i=1;
            foreach ($searchResult as $key => $pending):
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo !empty($pending->suppliername)?$pending->suppliername:'';?></td>
                <td><?php echo !empty($pending->orderno)?$pending->orderno:'';?></td>
                <td><?php echo !empty($pending->itemcode)?$pending->itemcode:'';?></td>
                <td>
                    <?php echo !empty($pending->itemname)?$pending->itemname:'';?>
                </td>
                <td>
                    <?php echo !empty($pending->quantity)?$pending->quantity:'';?>
                </td>
                <td><?php echo !empty($pending->remquantity)?$pending->remquantity:'';?></td>
                <td><?php echo !empty($pending->rate)?$pending->rate:'';?></td>
                <td><?php echo !empty($pending->vat)?$pending->vat:'';?></td>
                <td><?php echo !empty($pending->discount)?$pending->discount:'';?></td>
                <td><?php echo !empty($pending->purchaseamount)?$pending->purchaseamount:'';?></td>
                <td><?php echo !empty($pending->orderdate)?$pending->orderdate:'';?></td>
                <td><?php echo !empty($pending->deliverydate)?$pending->deliverydate:'';?></td>
                <td><?php echo !empty($pending->approvedby)?$pending->approvedby:'';?></td>
            </tr>
            <?php
            $i++;
            endforeach;
            endif;
            ?>
        </tbody>
    </table>