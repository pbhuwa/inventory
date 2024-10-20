<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

<strong><?php echo $this->lang->line('from_date'); ?>: </strong><?php echo $fromdate; ?>&nbsp;&nbsp;&nbsp;
<strong><?php echo $this->lang->line('to_date'); ?>: </strong><?php echo $todate; ?>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="30%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('current_stock'); ?></th>
            <th width="10%"><?php echo $this->lang->line('total_amount'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $totalsum=0;
        if($searchResult): 
            $i=1;
            foreach ($searchResult as $key => $stock):
                $total = !empty($stock->totalamount)?$stock->totalamount:'';
                $totalsum+= $total;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($stock->itemcode)?$stock->itemcode:'';?></td>
            <td><?php echo !empty($stock->itemname)?$stock->itemname:'';?></td>
            <td><?php echo !empty($stock->stockqty)?$stock->stockqty:'';?></td>
            <td align="right"><?php echo number_format((!empty($stock->totalamount)?$stock->totalamount:0),2);?></td>
        </tr>
        <?php
            $i++;
            endforeach;
        endif;
        ?>
        <tr>
            <td colspan="4" style="text-align:right;"><strong><?php echo $this->lang->line('total'); ?>: </strong></td>
            <td align="right"><?php echo number_format($totalsum,2);?></td>
        </tr>
    </tbody>
</table>