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
    <td width="200px"></td>
    <td width="200px"></td>
   
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%" ><?php echo $this->lang->line('sn'); ?></th>
            <th width="8%">Rec. Date</th>
            <th width="10%"><?php echo $this->lang->line('invoice_no'); ?></th>
            <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
            <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
            <th width="10%">Bill no</th>
            <th width="10%">Bill Date</th>
            <th width="5%">Dis. Amt.</th>
            <th width="7%">VAT Amt.</th>
            <th width="10%">Total Amt.</th>
            <th width="10%">Entry Date</th>
            <th width="6%">Status</th>
          
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        $sum_discount=0;
        $sum_tax=0;
        $sum_total=0;
        foreach ($searchResult as $key => $row): 
            $discount=!empty($row->recm_discount)?$row->recm_discount:'0';
            $tax=!empty($row->recm_taxamount)?$row->recm_taxamount:'0';
            $gtotal=!empty($row->recm_clearanceamount)?$row->recm_clearanceamount:'';

            $sum_discount+=$discount;
            $sum_tax+=$tax;
            $sum_total+=$gtotal;
        ?>

        <tr>
            <td style="border: 1px solid;"><?php echo $i; ?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->recm_receiveddatebs)?$row->recm_receiveddatebs:'';?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->recm_invoiceno)?$row->recm_invoiceno:'';?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->recm_purchaseorderno)?$row->recm_purchaseorderno:'';?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->dist_distributor)?$row->dist_distributor:'';?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->recm_supplierbillno)?$row->recm_supplierbillno:'';?></td>
              <td style="border: 1px solid;"><?php echo !empty($row->recm_supbilldatebs)?$row->recm_supbilldatebs:'';?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->recm_discount)?$row->recm_discount:'';?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->recm_taxamount)?$row->recm_taxamount:'';?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->recm_clearanceamount)?$row->recm_clearanceamount:'';?></td>
            <td style="border: 1px solid;"><?php echo !empty($row->recm_postdatebs)?$row->recm_postdatebs:'';?> <?php echo !empty($row->recm_posttime)?$row->recm_posttime:'';?></td>
            <td>
                <?php 
                if($row->recm_status=='M'): 
                    echo "Cancel";
                else:
                    echo "Received";
                endif; ?>
            </td>
     

        </tr>
        <?php
        $i++;
        endforeach;
        ?>
        <tr>
            <td colspan="7"> Grand Total</td>
            <td><?php echo number_format($sum_discount,2) ?></td>
             <td><?php echo number_format($sum_tax,2) ?></td>
            <td><?php echo number_format($sum_total,2) ?></td>
            <td></td>
            <td></td>
        </tr>
        <?php
        endif;
        ?>
    </tbody>
</table>

