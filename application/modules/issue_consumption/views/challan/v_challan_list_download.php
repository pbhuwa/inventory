<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

<table>
    <tr class="title_sub">
        <td width="225px"></td>
        <td width='225px'></td>

        <td style="text-align:center;"><font style="font-size:15px;"><u>Challan Details</u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
    </tr>
</table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>      <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('order_date').' '.$this->lang->line('bs'); ?></th>
                    
                    <th width="8%"><?php echo $this->lang->line('challan_number'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('challan_receive_no'); ?></th>
                    
                    <th width="10%"><?php echo $this->lang->line('challan_rcv_date_bs'); ?></th>
                 
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;  
        foreach ($searchResult as $key => $purchase):      
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($purchase->chma_fyear)?$purchase->chma_fyear:'';?></td>
            <td><?php echo !empty($purchase->chma_puorid)?$purchase->chma_puorid:'';?></td>
            <td>
                <?php echo !empty($purchase->puor_orderdatebs)?$purchase->puor_orderdatebs:'';?>
            </td>
            <td>
                <?php echo !empty($purchase->chma_challannumber)?$purchase->chma_challannumber:'';?>
            </td>
            <td><?php echo !empty($purchase->dist_distributor)?$purchase->dist_distributor:'';?></td>
           
            <td><?php echo !empty($purchase->chma_challanrecno)?$purchase->chma_challanrecno:'';?></td>
            <td><?php echo !empty($purchase->chma_challanrecdatebs)?$purchase->chma_challanrecdatebs:'';?></td>

            
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>

</table>

