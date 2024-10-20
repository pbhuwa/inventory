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
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('stock_transfer_list'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('from_store'); ?></th>
            <th width="5%"><?php echo $this->lang->line('to_store'); ?></th>
            <th width="10%"><?php echo $this->lang->line('dispatch_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('dispatch_date_bs'); ?></th>
            <th width="10%"><?php echo $this->lang->line('dispatch_date_ad'); ?></th>
            <th width="10%"><?php echo $this->lang->line('transfer_number'); ?></th> 
            <th width="10%"><?php echo $this->lang->line('fiscal_year'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
             <td><?php echo !empty($row->trma_reqno)?$row->trma_reqno:'';?></td>
              <td><?php echo !empty($row->fromStore)?$row->fromStore:'';?></td>
            <td><?php echo !empty($row->toStore)?$row->toStore:'';?></td>          
           
            <td>
                <?php echo !empty($row->trma_fromby)?$row->trma_fromby:'';?>
            </td>
            
            <td><?php echo !empty($row->trma_transactiondatebs)?$row->trma_transactiondatebs:'';?></td>
             <td><?php echo !empty($row->trma_toby)?$row->trma_toby:'';?></td>
            
            <td><?php echo !empty($row->trma_issueno)?$row->trma_issueno:'';?></td>
            <td><?php echo !empty($row->trma_fyear)?$row->trma_fyear:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

