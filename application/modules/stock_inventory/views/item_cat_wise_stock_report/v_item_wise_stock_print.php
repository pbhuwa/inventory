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
    <td width="200px"></td>
    <td width="200px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('category_wise_stock_report'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('code'); ?></th>
            <th width="15%"><?php echo $this->lang->line('name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('unit'); ?></th>
            <th width="5%">Op. Qty</th>
            <th width="5%">Op. Amt</th>
            <th width="5%"><?php echo $this->lang->line('rec_qty'); ?></th>
            <th width="5%"><?php echo $this->lang->line('rec_amt'); ?></th>
            <th width="5%"><?php echo $this->lang->line('issue_qty'); ?> </th>
            <th width="5%"><?php echo $this->lang->line('issue_amt'); ?></th>
            <th width="10%"><?php echo $this->lang->line('bal_qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('bal_amt'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->itli_itemcode)?$row->itli_itemcode:'';?></td>
            <td><?php echo !empty($row->itli_itemname)?$row->itli_itemname:'';?></td>
            <td>
                <?php echo !empty($row->unit_unitname)?$row->unit_unitname:'';?>
            </td>
            <td>
                <?php echo !empty($row->opqty)?$row->opqty:'';?>
            </td>
            <td><?php echo !empty($row->opamount)?$row->opamount:'';?></td>
            <td><?php echo !empty($row->rec_qty)?$row->rec_qty:'';?></td>
            <td><?php echo !empty($row->recamount)?$row->recamount:'';?></td>
            <td><?php echo !empty($row->issQty)?$row->issQty:'';?></td>
            <td><?php echo !empty($row->isstamt)?$row->isstamt:'';?></td>
            
            <td><?php echo !empty($row->balanceqty)?$row->balanceqty:'';?></td>
            <td><?php $blnamt= !empty($row->balanceamt)?$row->balanceamt:'';
                echo round($blnamt,2);?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

