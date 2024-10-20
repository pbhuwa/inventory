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
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('purchase_detail_list'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('date'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('invoice_no'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('bill_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('material_type'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('order_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('dis'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('vat'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('net_rate'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('net_amount'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('description'); ?></th>
           
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
            <td>
                <?php echo !empty($row->recm_supplierbillno)?$row->recm_supplierbillno:'';?>
            </td>
            <td>
                <?php echo !empty($row->itli_itemcode)?$row->itli_itemcode:'';?>
            </td>
            <td><?php echo !empty($row->itli_itemname)?$row->itli_itemname:'';?></td>
            <td><?php echo !empty($row->materialtypename)?$row->materialtypename:'';?></td>
            <td><?php echo !empty($row->categoryname)?$row->categoryname:'';?></td>
            <td><?php echo !empty($row->dist_distributor)?$row->dist_distributor:'';?></td>
            <td><?php echo !empty($row->recm_purchaseorderno)?$row->recm_purchaseorderno:'';?></td>
            <td><?php echo !empty($row->recd_purchasedqty)?$row->recd_purchasedqty:'';?></td>
          <td><?php echo !empty($row->unit_unitname)?$row->unit_unitname:'';?></td> 
            <td><?php echo !empty($row->recd_unitprice)?$row->recd_unitprice:'';?></td>
            <td><?php echo !empty($row->recd_discountpc)?$row->recd_discountpc:'';?></td>
            <td><?php echo !empty($row->recd_vatpc)?$row->recd_vatpc:'';?></td>
            <td><?php echo !empty($row->netrate)?$row->netrate:'';?></td>
            <td><?php echo !empty($row->recd_amount)?$row->recd_amount:'';?></td>
            <td><?php echo !empty($row->itli_remarks)?$row->itli_remarks:'';?></td>
           
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

