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
    <td width="180px"></td>
    <td width="180px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('non_expandable_expandable_items'); ?>  </u></b> </td>
            </table>

<strong><?php echo $this->lang->line('from_date'); ?>: </strong><?php echo $fromdate; ?>&nbsp;&nbsp;&nbsp;
<strong><?php echo $this->lang->line('to_date'); ?>: </strong><?php echo $todate; ?>&nbsp;&nbsp;&nbsp;
<strong><?php echo $this->lang->line('category'); ?>: </strong><?php echo !empty($category[0]->eqca_category)?$category[0]->eqca_category:'ALL'; ?>&nbsp;&nbsp;&nbsp;
<strong><?php echo $this->lang->line('material_type'); ?>: </strong><?php echo !empty($material_type[0]->maty_material)?$material_type[0]->maty_material:'ALL'; ?>&nbsp;&nbsp;&nbsp;
<strong><?php echo $this->lang->line('counter'); ?>: </strong><?php echo !empty($counter_type[0]->eqty_equipmenttype)?$counter_type[0]->eqty_equipmenttype:'ALL'; ?>

<table id="" class="format_pdf" width="100%" style="margin-top: 14px;">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('receipt_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('date'); ?></th>
            <th width="10%"><?php echo $this->lang->line('fiscal_year'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('category'); ?></th>
            <th width="10%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('location'); ?></th>
            <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if($searchResult):  $totalqty=0;
            $totalamt=0;
            $i=1;
            foreach ($searchResult as $key => $stock):
                $qty = !empty($stock->purchasedqty)?$stock->purchasedqty:'';
                $rate = !empty($stock->salerate)?$stock->salerate:'';
                $amount = $qty * $rate;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($stock->invoiceno)?$stock->invoiceno:'';?></td>
            <td><?php echo !empty($stock->datebs)?$stock->datebs:'';?></td>
            <td><?php echo !empty($stock->fyear)?$stock->fyear:'';?></td>
            <td><?php echo !empty($stock->itemcode)?$stock->itemcode:'';?></td>
            <td><?php echo !empty($stock->itemname)?$stock->itemname:'';?></td>
            <td><?php echo !empty($stock->categoryname)?$stock->categoryname:'';?></td>
            <td><?php echo !empty($stock->distributorname)?$stock->distributorname:'';?></td>
            <td><?php echo !empty($stock->location)?$stock->location:'';?></td>
            <td><?php echo $qty; ?></td>
            <td><?php echo $rate;?></td>
            <td><?php echo $amount;?></td>
        </tr>
        <?php
            $i++;

            $totalqty += $qty;
            $totalamt += $amount;
            endforeach;
        endif;
        ?>
        <tr>
            <th colspan="9" style="text-align:right"><?php echo $this->lang->line('total'); ?></th><td><?php echo $totalqty; ?></td><td></td><td><?php echo $totalamt; ?></td>
        </tr>
        <tr>
            <th colspan="9" style="text-align:right"><?php echo $this->lang->line('grand_total'); ?></th><td><?php echo $totalqty; ?></td><td></td><td><?php echo $totalamt; ?></td>
        </tr>
    </tbody>
</table>