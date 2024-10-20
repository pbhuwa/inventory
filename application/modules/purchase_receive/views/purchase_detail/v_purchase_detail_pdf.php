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
        <td style="text-align:right; font-size:10px;">Date/Time: <?php echo CURDATE_NP ?> BS,</td>
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
            <th width="5%">S.No.</th>
            <th width="10%">Date</th>
            <th width="10%">Inv No.</th>
            <th width="20%">Bill No.</th>
            <th width="10%">Item Code</th>
            <th width="10%">Item Name</th>
            <th width="10%">Mat Type</th>
            <th width="10%">Category</th>
            <th width="10%">Supplier</th>
            <th width="10%">Order No.</th>
            <th width="10%">Qty</th>
            <th width="10%">Unit</th>
            <th width="10%">Rate</th>
            <th width="10%">Dis %</th>
            <th width="10%">VAT %</th>
            <th width="10%">Net Rate</th>
            <th width="10%">Net Amt</th>
            <th width="10%">Desc</th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $purchase): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($purchase->recm_receiveddatebs)?$purchase->recm_receiveddatebs:'';?></td>
            <td><?php echo !empty($purchase->recm_invoiceno)?$purchase->recm_invoiceno:'';?></td>
            <td>
                <?php echo !empty($purchase->recm_supplierbillno)?$purchase->recm_supplierbillno:'';?>
            </td>
            <td>
                <?php echo !empty($purchase->itli_itemcode)?$purchase->itli_itemcode:'';?>
            </td>
            <td><?php echo !empty($purchase->itli_itemname)?$purchase->itli_itemname:'';?></td>
            <td><?php echo !empty($purchase->materialtypename)?$purchase->materialtypename:'';?></td>
            <td><?php echo !empty($purchase->categoryname)?$purchase->categoryname:'';?></td>
            <td><?php echo !empty($purchase->dist_distributor)?$purchase->dist_distributor:'';?></td>
            <td><?php echo !empty($purchase->recm_purchaseorderno)?$purchase->recm_purchaseorderno:'';?></td>
            <td><?php echo !empty($purchase->recd_purchasedqty)?$purchase->recd_purchasedqty:'';?></td>
            <td><?php echo !empty($purchase->unit_unitname)?$purchase->unit_unitname:'';?></td>
            <td><?php echo !empty($purchase->recd_unitprice)?$purchase->recd_unitprice:'';?></td>
            <td><?php echo !empty($purchase->recd_discountpc)?$purchase->recd_discountpc:'';?></td>
            <td><?php echo !empty($purchase->recd_vatpc)?$purchase->recd_vatpc:'';?></td>
            <td><?php echo !empty($purchase->netrate)?$purchase->netrate:'';?></td>
            <td><?php echo !empty($purchase->recd_amount)?$purchase->recd_amount:'';?></td>
            <td><?php echo !empty($purchase->itli_remarks)?$purchase->itli_remarks:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

