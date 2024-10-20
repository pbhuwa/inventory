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
    <td width="190px"></td>
    <td width="190px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('debit_note_qty_purchase_note_list'); ?>  </u></b> </td>
            </table>


<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('return_no'); ?> </th>
            <th width="10%"><?php echo $this->lang->line('date'); ?></th>
            <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="15%"><?php echo $this->lang->line('discount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('vat_amount'); ?></th> 
            <th width="20%"><?php echo $this->lang->line('amount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('return_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('net_amount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('time'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
            $rate = !empty($row->rate)?$row->rate:'';
            $cancelqty = !empty($row->cancelqty)?$row->cancelqty:'';
            $cancel_all = $rate * $cancelqty;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->purr_returnno)?$row->purr_returnno:'';?></td>
            <td><?php echo !empty($row->purr_returndatebs)?$row->purr_returndatebs:'';?></td>
            <td>
                <?php echo !empty($row->dist_distributor)?$row->dist_distributor:'';?>
            </td>
            <td>
                <?php echo !empty($row->purr_vatamount)?$row->purr_vatamount:'';?>
            </td>
            <td><?php echo !empty($row->purr_discount)?$row->purr_discount:'';?></td>
            <td><?php echo !empty($row->purr_returnamount)?$row->purr_returnamount:'';?></td>
            <td><?php echo !empty($row->purr_returnby)?$row->purr_returnby:'';?></td>
            <td><?php echo !empty($row->netamount)?$row->netamount:'';?></td>
            <td><?php echo !empty($row->purr_returntime)?$row->purr_returntime:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

