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
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('demand_report_list'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('items_id'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('demand_quantity'); ?></th>
            <th width="10%"><?php echo $this->lang->line('stock_quantity'); ?></th>
            <th width="10%"><?php echo $this->lang->line('diff'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $demand): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($demand->itli_itemlistid)?$demand->itli_itemlistid:'';?></td>
            <td><?php echo !empty($demand->itli_itemcode)?$demand->itli_itemcode:'';?></td>
            <td>
                <?php echo !empty($demand->itli_itemname)?$demand->itli_itemname:'';?>
            </td>
            <td>
                <?php echo !empty($demand->demandqty)?$demand->demandqty:'';?>
            </td>
            <td><?php echo !empty($demand->stockqty)?$demand->stockqty:'';?></td>
            <td><?php echo !empty($demand->diff)?$demand->diff:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

