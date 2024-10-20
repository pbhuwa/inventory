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
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('purchase_order_detail'); ?>  </u></b> </td>
            </table>
<!-- <strong><?php echo $this->lang->line('from_date'); ?>: </strong><?php echo $frmdate; ?>&nbsp;&nbsp;&nbsp;
<strong><?php echo $this->lang->line('to_date'); ?>: </strong><?php echo $todate; ?> -->
<!-- <table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%">S.No.</th>
            <th width="5%">Req. No.</th>
            <th width="5%">Req. Date</th>
            <th width="10%">Requested By</th>
            <th width="10%">Items Name</th>
            <th width="5%">Unit</th>
            <th width="5%">Req. Qty</th>
            <th width="10%">Material Type</th>
            <th width="10%">Category Name</th>
            <th width="5%">Order</th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->reqno)?$row->reqno:'';?></td>
            <td><?php echo !empty($row->reqdatebs)?$row->reqdatebs:'';?></td>
            <td>
                <?php echo !empty($row->requser)?$row->requser:'';?>
            </td>
            <td>
                <?php echo !empty($row->itemname)?$row->itemname:'';?>
            </td>
            <td><?php echo !empty($row->unit)?$row->unit:'';?></td>
            <td><?php echo !empty($row->qty)?$row->qty:'';?></td>
            <td><?php echo !empty($row->materialname)?$row->materialname:'';?></td>
            <td><?php echo !empty($row->category)?$row->category:'';?></td>
            <td><?php echo !empty($row->status)?$row->status:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table> -->
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('date'); ?></th>
            <th width="5%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('material_type'); ?></th>
            <th width="5%"><?php echo $this->lang->line('category'); ?></th>
            <th width="10%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
            <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
            <th width="5%"><?php echo $this->lang->line('net_amount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('remarks'); ?></th>
            <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $purchase): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($purchase->orderdatebs)?$purchase->orderdatebs:'';?></td>
            <td><?php echo !empty($purchase->itemcode)?$purchase->itemcode:'';?></td>
            <td>
                <?php echo !empty($purchase->itemname)?$purchase->itemname:'';?>
            </td>
            <td>
                <?php echo !empty($purchase->materialname)?$purchase->materialname:'';?>
            </td>
            <td><?php echo !empty($purchase->category)?$purchase->category:'';?></td>
            <td><?php echo !empty($purchase->suppliername)?$purchase->suppliername:'';?></td>
            <td><?php echo !empty($purchase->orderno)?$purchase->orderno:'';?></td>
            <td><?php echo !empty($purchase->quantity)?$purchase->quantity:'';?></td>
            <td><?php echo !empty($purchase->unit)?$purchase->unit:'';?></td>
            <td><?php echo !empty($purchase->rate)?$purchase->rate:'';?></td>
            <td><?php echo !empty($purchase->discount)?$purchase->discount:'';?></td>
            <td><?php echo !empty($purchase->vat)?$purchase->vat:'';?></td>
            <td><?php echo !empty($purchase->amount)?$purchase->amount:'';?></td>
            <td><?php echo !empty($purchase->remarks)?$purchase->remarks:'';?></td>
            <td><?php echo !empty($purchase->requno)?$purchase->requno:'';?></td>
            <!-- <td><?php echo !empty($purchase->recd_amount)?$purchase->recd_amount:'';?></td>
            <td><?php echo !empty($purchase->itli_remarks)?$purchase->itli_remarks:'';?></td> -->
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

