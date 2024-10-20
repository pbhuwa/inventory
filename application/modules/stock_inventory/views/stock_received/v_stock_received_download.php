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
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('stock_received'); ?>  </u></b> </td>
            </table>
<strong><?php echo $this->lang->line('from_date'); ?>: </strong><?php echo $fromdate; ?>&nbsp;&nbsp;&nbsp;
<strong><?php echo $this->lang->line('to_date'); ?>: </strong><?php echo $todate; ?>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('issue_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('store'); ?></th>
            <th width="10%"><?php echo $this->lang->line('dispatch_date_bs'); ?></th>
            <th width="10%"><?php echo $this->lang->line('dispatch_date_ad'); ?></th>
            <th width="10%"><?php echo $this->lang->line('dispatch_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('received_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
            <!-- <th width="10%">Req. No.</th> -->
        </tr>
    </thead>
    <tbody>
        <?php 
        if($searchResult): 
            $i=1;
            foreach ($searchResult as $key => $stock):
                $amounttotal += !empty($stock->amount)?$stock->amount:'';
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($stock->issueno)?$stock->issueno:'';?></td>
            <td><?php echo !empty($stock->departmentname)?$stock->departmentname:'';?></td>
            <td><?php echo !empty($stock->transactiondatead)?$stock->transactiondatead:'';?></td>
            <td><?php echo !empty($stock->transactiondatebs)?$stock->transactiondatebs:'';?></td>
            <td><?php echo !empty($stock->fromby)?$stock->fromby:'';?></td>
            <td><?php echo !empty($stock->receivedby)?$stock->receivedby:'';?></td>
            <td><?php echo !empty($stock->amount)?$stock->amount:'';?></td>
            <!-- <td><?php echo !empty($stock->reqno)?$stock->reqno:'';?></td> -->
        </tr>
        <?php
            $i++;
            endforeach;
        endif;
        ?>
        <tr>
            <td colspan="7" style="text-align:right;">Total: </td>
            <!-- <td><?php //echo $amounttotal; ?></td> -->
            <td><?php echo !empty($amounttotal)?$amounttotal:0; ?></td>
        </tr>
    </tbody>
</table>