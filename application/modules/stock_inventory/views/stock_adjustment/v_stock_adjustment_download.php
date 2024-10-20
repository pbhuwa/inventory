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
<strong>Date: </strong><?php echo $fromdate; ?>&nbsp;&nbsp;&nbsp;
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="15%"><?php echo $this->lang->line('item_name'); ?></th> 
            <th width="10%"><?php echo $this->lang->line('stock_date_bs'); ?></th>
            <th width="10%"><?php echo $this->lang->line('stock_date_ad'); ?></th>
            <th width="15%"><?php echo $this->lang->line('posted_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
            <th width="15%"><?php echo $this->lang->line('amount'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($searchResult)):
                 foreach($searchResult as $key=>$list): ?>
            <tr>
            	<td><?php echo $key+1; ?></td>
                <td>
                    <?php echo !empty($list->itli_itemcode)?$list->itli_itemcode:''; ?>
                </td>
                <td>
                    <?php echo !empty($list->itli_itemname)?$list->itli_itemname:''; ?>
                </td>
                <td>
                    <?php echo !empty($list->stde_adjustdatebs)?$list->stde_adjustdatebs:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->stde_adjustdatead)?$list->stde_adjustdatead:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->remarks)?$list->remarks:0; ?>
                </td>
                <td>
                	 <?php echo !empty($list->stde_postby)?$list->stde_postby:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->stde_adjustamount)?round($list->stde_adjustamount,2):0; ?>
                </td>
            </tr>    
        <?php
                endforeach;
            endif;
        ?>
    </tbody>
</table>