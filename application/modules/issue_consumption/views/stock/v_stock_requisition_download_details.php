<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
    .body {
        border-top: 5px solid red !important;
    }
    .format_pdf tbody tr td {
    text-align: center !important;
    }
</style>
<body class="body">
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>
<!-- <br> -->
<table width="100%">
    <tr class="title_sub">
        <td colspan="6" style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('stock_requisition_details'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
    </tr>
</table>
<br>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="7%"><?php echo $this->lang->line('req_no'); ?></th>
            <th width="7%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="7%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="15%"><?php echo $this->lang->line('fiscal_year'); ?></th>
            <th width="15%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('rem_qty'); ?></th>
            <th width="17%"><?php echo $this->lang->line('remarks'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->rema_reqno)?$row->rema_reqno:'';?></td>          
            <td>
               <?php echo !empty($row->itli_itemcode)?$row->itli_itemcode:'';?>
            </td>
            <td>
                <?php echo !empty($row->itli_itemname)?$row->itli_itemname:'';?>
            </td>
            <td><?php echo !empty($row->rema_fyear)?$row->rema_fyear:'';?></td>
            <td><?php echo !empty($row->rede_qty)?$row->rede_qty:'';?></td>
            <td><?php echo !empty($row->rede_remqty)?$row->rede_remqty:'';?></td> 
            <td><?php echo !empty($row->rede_remarks)?$row->rede_remarks:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>
</body>