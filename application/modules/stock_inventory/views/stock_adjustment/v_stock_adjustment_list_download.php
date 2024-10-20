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
    <td style="width:45%">
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('stock_adjustment_list'); ?>  </u></b> </td>
            </table>

<div class="table-responsive">
    <!-- <h5><span><?php echo $this->lang->line('from_date'); ?>:<?php echo $this->input->post('fromDate'); ?> <?php echo $this->lang->line('to_date'); ?> :<?php echo $this->input->post('toDate'); ?></span></h5> -->
<!-- <strong><?php //echo $this->lang->line('date'); ?>: </strong><?php // echo $fromdate; ?>&nbsp;&nbsp;&nbsp; -->
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th ><?php echo $this->lang->line('sn'); ?></th>
            <th><?php echo $this->lang->line('stock_date_bs'); ?></th>
            <th><?php echo $this->lang->line('stock_date_ad'); ?></th>
            <th><?php echo $this->lang->line('counter'); ?></th>
            <th><?php echo $this->lang->line('remarks'); ?></th>
            <th><?php echo $this->lang->line('operator'); ?></th>
    </thead>
    <tbody>
        <?php
            if(!empty($searchResult)):
                 foreach($searchResult as $key=>$list): ?>
            <tr>
            	<td><?php echo $key+1; ?></td>
                <td>
                    <?php echo !empty($list->stma_stockdatebs)?$list->stma_stockdatebs:''; ?>
                </td>
                <td>
                    <?php echo !empty($list->stma_stockdatead)?$list->stma_stockdatead:''; ?>
                </td>
                <td>
                    <?php echo !empty($list->eqty_equipmenttype)?$list->eqty_equipmenttype:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->stma_remarks)?$list->stma_remarks:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->stma_operator)?$list->stma_operator:0; ?>
                </td>
                <!-- <td>
                	 <?php echo !empty($list->stma_counterid)?$list->stma_counterid:0; ?>
                </td> -->
            </tr>    
        <?php
                endforeach;
            endif;
        ?>
    </tbody>
</table>