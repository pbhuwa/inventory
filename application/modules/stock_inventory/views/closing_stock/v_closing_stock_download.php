<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; text-align: left;}
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>
    <br>
    <table width="100%" style="font-size:12px;">
            <tr>
            <td style="width:45%">
            <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('closing_stock_summary'); ?>  </u></b> </td>
    </table>

    <strong><?php echo $this->lang->line('from_date'); ?>: </strong><?php echo $searchResult[0]->clsm_fromdatebs; ?>&nbsp;&nbsp;&nbsp;
    <strong><?php echo $this->lang->line('to_date'); ?>: </strong><?php echo $searchResult[0]->clsm_todatead; ?>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="50%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="25%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="25%"><?php echo $this->lang->line('total_amount'); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Purchase Return </td>
            <td><?php echo !empty($searchResult[0]->prtnQty)?$searchResult[0]->prtnQty:'';?></td>
            <td><?php echo !empty($searchResult[0]->prtnValue)?$searchResult[0]->prtnValue:'';?></td>
        </tr>
        <tr>
            <td>Issue </td>
            <td><?php echo !empty($searchResult[0]->issueQtyTtotal)?$searchResult[0]->issueQtyTtotal:'';?></td>
            <td><?php echo !empty($searchResult[0]->isAmnt)?$searchResult[0]->isAmnt:'';?></td>
        </tr>
        <tr>
            <td>Opening </td>
            <td><?php echo !empty($searchResult[0]->opQty)?$searchResult[0]->opQty:'';?></td>
            <td><?php echo !empty($searchResult[0]->opAmnt)?$searchResult[0]->opAmnt:'';?></td>
        </tr>
        <tr>
            <td>Current Opening</td>
            <td><?php echo !empty($searchResult[0]->cuRQtyTotal)?$searchResult[0]->cuRQtyTotal:'';?></td>
            <td><?php echo !empty($searchResult[0]->curopeningamt)?$searchResult[0]->curopeningamt:'';?></td>
        </tr>
        <tr>
            <td>Transactiopn</td>
            <td><?php echo !empty($searchResult[0]->transactionqty)?$searchResult[0]->transactionqty:'';?></td>
            <td><?php echo !empty($searchResult[0]->transactionvalue)?$searchResult[0]->transactionvalue:'';?></td>
        </tr>
        <tr>
            <td>Adjust </td>
            <td><?php echo !empty($searchResult[0]->adjqty)?$searchResult[0]->adjqty:'';?></td>
            <td><?php echo !empty($searchResult[0]->adjvalue)?$searchResult[0]->adjvalue:'';?></td>
        </tr>
        <tr>
            <td>In Con </td>
            <td><?php echo !empty($searchResult[0]->incon)?$searchResult[0]->incon:'';?></td>
            <td><?php echo !empty($searchResult[0]->inconvalue)?$searchResult[0]->inconvalue:'';?></td>
        </tr>
        <tr>
            <td>Out Con</td>
            <td><?php echo !empty($searchResult[0]->outcon)?$searchResult[0]->outcon:'';?></td>
            <td><?php echo !empty($searchResult[0]->outconvalue)?$searchResult[0]->outconvalue:'';?></td>
        </tr>
        <tr>
            <td style="text-align:right;"></td>
            <td>
                <?php
           $inco = !empty($searchResult[0]->incon)?$searchResult[0]->incon:0;
           $incval = !empty($searchResult[0]->inconvalue)?$searchResult[0]->inconvalue:0;
                 $qtySum  = ($searchResult[0]->prtnQty + $searchResult[0]->issueQtyTtotal + $searchResult[0]->opQty + $searchResult[0]->cuRQtyTotal + $searchResult[0]->transactionqty + $searchResult[0]->adjqty + $inco + $searchResult[0]->outcon); 
                $valueSum = ($searchResult[0]->prtnValue + $searchResult[0]->isAmnt + $searchResult[0]->opAmnt + $searchResult[0]->curopeningamt + $searchResult[0]->transactionvalue + $searchResult[0]->adjvalue + $incval + $searchResult[0]->outconvalue); 
                ?>
                <span>Total  Qty: <?php echo number_format($qtySum,2); ?></span><h5 style="font-weight: 900;font-size: 16px;text-align: right;">Total Amnt: </h5>
            </td>
            <td><?php echo number_format($valueSum, 2); ?></td>
            <td></td>
        </tr>
    </tbody>
</table>