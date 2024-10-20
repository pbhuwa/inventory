<style type="text/css">
    .format_pdf thead tr th {
        border: 1px solid;
    }
    .format_pdf tbody tr td {
        border: 1px solid;
    }

</style>
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

<table class="reportTitle" width="100%" style="font-size:12px;">
    <tr>
        <td class="text-center" align="center" style="font-size: 16px; text-decoration: underline;">
            <?php echo $this->lang->line('quotation_review'); ?>
        </td>
    </tr>
</table>

<table class="format_pdf" width="100%" style="border:1px solid;"cellspacing="0">
    <thead>
        <tr>
            <th width="2%"><?php echo $this->lang->line('sn'); ?> </th>
            <th width="4%"><?php echo $this->lang->line('item_code'); ?> </th>
            <th width="14%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="13%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="8%"><?php echo $this->lang->line('quotation_date'); ?></th>
            <th width="8%"><?php echo $this->lang->line('quotation_no'); ?></th>
            <th width="8%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
            <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
            <th width="10%"><?php echo $this->lang->line('net_rate'); ?></th>
            <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
            <th width="10%"><?php echo $this->lang->line('valid_till'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $purchase): 
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($purchase->itli_itemcode)?$purchase->itli_itemcode:'';?></td>
            <td><?php echo !empty($purchase->itli_itemname)?$purchase->itli_itemname:'';?></td>
            <td><?php echo !empty($purchase->supp_suppliername)?$purchase->supp_suppliername:'';?></td>
            <?php if(DEFAULT_DATEPICKER == 'NP'){ ?>
            <td><?php echo !empty($purchase->quma_quotationdatebs)?$purchase->quma_quotationdatebs:'';?></td>
            <?php } 
            else { ?>
             <td><?php echo !empty($purchase->quma_quotationdatead)?$purchase->quma_quotationdatead:'';?></td>
             <?php } ?>

            <td><?php echo !empty($purchase->quma_quotationnumber)?$purchase->quma_quotationnumber:'';?></td>
            <td><?php echo !empty($purchase->qude_rate)?$purchase->qude_rate:'';?></td>
            <td><?php echo !empty($purchase->qude_discountpc)?$purchase->qude_discountpc:'';?></td>
            <td><?php echo !empty($purchase->qude_vatpc)?$purchase->qude_vatpc:'';?></td>
            <td><?php echo !empty($purchase->qude_netrate)?$purchase->qude_netrate:'';?></td>
            <td><?php echo !empty($purchase->quma_remarks)?$purchase->quma_remarks:'';?></td>
               <td><?php echo !empty($purchase->quma_expdatebs)?$purchase->quma_expdatebs:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>