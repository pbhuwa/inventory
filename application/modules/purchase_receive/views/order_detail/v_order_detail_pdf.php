
<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
   .preeti{font-family: preeti;}
</style>

<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

              <table width="100%" style="font-size:12px;">
    <tr>
    <td style="width:45%">
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('order_detail_list'); ?>  </u></b> </td>
            </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('order_date'); ?></th>
            <th width="10%"><?php echo $this->lang->line('order_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $demand): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($demand->itli_itemcode)?$demand->itli_itemcode:'';?></td>
            <td><?php echo !empty($demand->itli_itemname)?$demand->itli_itemname:'';?></td>
            <td>
                <?php echo !empty($demand->dist_distributor)?$demand->dist_distributor:'';?>
            </td>
            <td>
                <?php echo !empty($demand->puor_orderdatebs)?$demand->puor_orderdatebs:'';?>
            </td>
            <td><?php echo !empty($demand->puor_orderno)?$demand->puor_orderno:'';?></td>
            <td><?php echo !empty($demand->pude_quantity)?$demand->pude_quantity:'';?></td>
            <td><?php echo !empty($demand->pude_rate)?$demand->pude_rate:'';?></td>
            <td><?php echo !empty($demand->pude_remarks)?$demand->pude_remarks:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

