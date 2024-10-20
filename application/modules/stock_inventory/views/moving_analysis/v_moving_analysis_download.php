<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

</table>
<strong><?php echo $this->lang->line('from_date'); ?>: </strong><?php echo $fromdate; ?>&nbsp;&nbsp;&nbsp;
<strong><?php echo $this->lang->line('to_date'); ?>: </strong><?php echo $todate; ?>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="30%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('category'); ?></th>
            <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="10%"><?php echo $this->lang->line('issue_qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('total_amount'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if($searchResult): 
            $totalsum=0;
            $i=1;
            foreach ($searchResult as $key => $stock):
                $total = !empty($stock->TotalIsseAmt)?$stock->TotalIsseAmt:'';
                $totalsum+= $total;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($stock->itli_itemcode)?$stock->itli_itemcode:'';?></td>
            <td><?php echo !empty($stock->itli_itemname)?$stock->itli_itemname:'';?></td>
            <td><?php echo !empty($stock->eqca_category)?$stock->eqca_category:'';?></td>
            <td><?php echo !empty($stock->salesrate)?$stock->salesrate:'';?></td>
             <td><?php echo !empty($stock->total_issue_qty)?$stock->total_issue_qty:'';?></td>
              <td><?php echo !empty($stock->TotalIsseAmt)?$stock->TotalIsseAmt:'';?></td>
        </tr>
        <?php
            $i++;
            endforeach;
        endif;
        ?>
        <tr>
            <td colspan="6" style="text-align:right;"><strong>Total: </strong></td>
            <td><?php echo $totalsum;?></td>
        </tr>
    </tbody>
</table>