<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
    .format_pdf tr th{border: 1px solid #000;}
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
            <th rowspan="2" width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th rowspan="2" width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th rowspan="2" width="10%"><?php echo $this->lang->line('unit'); ?></th>
            <th colspan="2"><?php echo $this->lang->line('opening'); ?></th>
            <th colspan="2"><?php echo $this->lang->line('purchase'); ?></th>
            <th colspan="2"><?php echo $this->lang->line('total'); ?></th>
            <th colspan="2"><?php echo $this->lang->line('issued'); ?></th>
            <th colspan="2"><?php echo $this->lang->line('balance'); ?></th></th>
        </tr>
        <tr>
            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
            <th width="10%"><?php echo $this->lang->line('qty'); ?> </th>
            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
            <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
        </tr>   


    </thead>
    <tbody>
        <?php 
        if($searchResult): 
            $i=1;
            $amounttotal=0;
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
            <td><?php echo !empty($stock->reqno)?$stock->reqno:'';?></td>
            <td><?php echo !empty($stock->reqno)?$stock->reqno:'';?></td>
            <td><?php echo !empty($stock->reqno)?$stock->reqno:'';?></td>
            <td><?php echo !empty($stock->reqno)?$stock->reqno:'';?></td>
            <td><?php echo !empty($stock->reqno)?$stock->reqno:'';?></td>
        </tr>
        <?php
            $i++;
            endforeach;
        endif;
        ?>
        <tr>
            <td colspan="11" style="text-align:right;">Total: </td>
            <td colspan="2"><?php echo $amounttotal; ?></td>
        </tr>
    </tbody>
</table>