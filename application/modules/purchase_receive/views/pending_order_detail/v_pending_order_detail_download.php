<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


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
</table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="30%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('order_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('odr_qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('rem_qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="10%"><?php echo $this->lang->line('vat'); ?></th>
            <th width="10%"><?php echo $this->lang->line('discount'); ?></th>
            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
            <th width="10%"><?php echo $this->lang->line('order_date'); ?></th>
            <th width="10%"><?php echo $this->lang->line('delivery_date'); ?></th>
            <th width="10%"><?php echo $this->lang->line('approved'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending):
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($pending->suppliername)?$pending->suppliername:'';?></td>
            <td><?php echo !empty($pending->orderno)?$pending->orderno:'';?></td>
            <td>
                <?php echo !empty($pending->itemcode)?$pending->itemcode:'';?>
            </td>
            <td>
                <?php echo !empty($pending->itemname)?$pending->itemname:'';?>
            </td>
            <td>
                <?php echo !empty($pending->quantity)?$pending->quantity:'';?>
            </td>
            <td><?php echo !empty($pending->remquantity)?$pending->remquantity:'';?></td>
            <td><?php echo !empty($pending->rate)?$pending->rate:'';?></td>
            <td><?php echo !empty($pending->vat)?$pending->vat:'';?></td>
            <td><?php echo !empty($pending->discount)?$pending->discount:'';?></td>
            <td><?php echo !empty($pending->purchaseamount)?$pending->purchaseamount:'';?></td>
            <td><?php echo !empty($pending->orderdate)?$pending->orderdate:'';?></td>
            <td><?php echo !empty($pending->deliverydate)?$pending->deliverydate:'';?></td>
            <td><?php echo !empty($pending->approvedby)?$pending->approvedby:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>