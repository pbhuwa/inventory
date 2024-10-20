<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>

<?php echo $this->load->view('common/v_pdf_excel_header'); ?>
<!-- <?php $this->load->view('common/v_report_header_datatable');?>
 -->

<table class="table_jo_header purchaseInfo">
    <tr>
        <td width="175px"></td>
        <td width="175px"></td>
        <td class="text-center" align="center">
            <h4>
                <u>
       <?php echo $this->lang->line('receive_dispatch_analysis_report'); ?>
            </h4>
            <br>
        </td>
    </tr>
</table>

<!-- 
<table width="100%" style="font-size:12px;" class="format_pdf_head">
    <tr>
        <td></td>
        <td class="web_ttl text-center" style="text-align:center;">
            <h2><?php echo ORGA_NAME; ?></h2>
        </td>
        <td></td>
    </tr>
    <tr class="title_sub">
        <td></td>
        <td style="text-align:center;"><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td>
        <td style="text-align:right; font-size:10px;"><?php echo $this->lang->line('date_time'); ?>: <?php echo CURDATE_NP ?> BS,</td>
    </tr>
    <tr class="title_sub">
        <td></td>
        <td style="text-align:center;"><b style="font-size:15px;"><span id="rptType"></span></b></td>
        <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
    </tr>
    <tr class="title_sub">
        <td width="200px"></td>
        <td style="text-align:center;"><b><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></b></td>
        <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
    </tr>
</table> -->



<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th ><?php echo $this->lang->line('sn'); ?></th>
            <th ><?php echo $this->lang->line('item_code'); ?></th>
            <th ><?php echo $this->lang->line('item_name'); ?></th>
            <th ><?php echo $this->lang->line('type'); ?></th>
            <th ><?php echo $this->lang->line('description'); ?></th>
            <th ><?php echo $this->lang->line('unit'); ?></th>
            <th ><?php echo $this->lang->line('rec_qty'); ?></th>
            <th ><?php echo $this->lang->line('rec_rate'); ?></th>
            <th ><?php echo $this->lang->line('rec_total'); ?></th>
            <th ><?php echo $this->lang->line('dispatch_qty'); ?> </th>
            <th ><?php echo $this->lang->line('dispatch_rate'); ?> </th>
            <th ><?php echo $this->lang->line('dispatch_total'); ?> </th>
            <th ><?php echo $this->lang->line('dispatch_loc'); ?> </th>
            <th ><?php echo $this->lang->line('balance_qty'); ?> </th>
            <th ><?php echo $this->lang->line('balance_rate'); ?> </th>
            <th ><?php echo $this->lang->line('balance_total'); ?> </th>
            <th ><?php echo $this->lang->line('remarks'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $pending->itli_itemcode; ?></td>
            <td><?php echo $pending->itli_itemname; ?></td>
            <td><?php echo $pending->maty_material; ?></td>
            <td><?php echo $pending->eqca_category; ?></td>
            <td><?php echo $pending->unit_unitname; ?></td>
            <td><?php echo $pending->receivedqty; ?></td>
            <td><?php echo $pending->trde_unitprice; ?></td>
            <td><?php echo ($pending->trde_unitprice) * ($pending->receivedqty); ?> </td>
            <td><?php echo $pending->dispatch_qty; ?></td>
            <td><?php echo $pending->dispatch_rate; ?></td>
            <td><?php echo (($pending->dispatch_rate) * ($pending->dispatch_qty)) ?></td>
            <td><?php echo $pending->dispatchlocation; ?></td>
            <td><?php echo ($pending->receivedqty - $pending->dispatch_qty) ?></td>
            <td><?php echo $pending->trde_unitprice; ?></td>
            <td><?php echo number_format((($pending->receivedqty - $pending->dispatch_qty) * $pending->dispatch_rate), 2);?></td>
            <td><?php echo $pending->sade_remarks; ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>