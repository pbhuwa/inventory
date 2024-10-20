<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>

<!-- <?php //echo $this->load->view('common/v_pdf_excel_header'); ?> -->
<table width="100%" style="font-size:12px;" class="format_pdf_head">
<tr>
        <td></td>
        <td class="web_ttl text-center" style="text-align:center;">
            <!-- <h2><?php //echo ORGA_NAME; ?></h2> -->
            <h2><?php echo ORGNAMETITLE; ?></h2>
        </td>
        <td></td>
    </tr>
    <tr class="title_sub">
        <td></td>
        <!-- <td style="text-align:center;"><?php //echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td> -->
        <td style="text-align:center;"><b style="font-size:10px;"><?php echo ORGNAME ?></b></td>
        <td style="text-align:right; font-size:10px;"><?php echo $this->lang->line('date_time'); ?>: <?php echo CURDATE_NP ?> BS,</td>
    </tr>
    <tr class="title_sub">
        <td></td>
        <td style="text-align:center;"><b style="font-size:10px;">
        <?php echo ORGNAMEDESC ?></td>
            <span id="rptType"></span></b></td>
        <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
    </tr>
    <tr class="title_sub">
        <td width="200px"></td>
        <td style="text-align:center;"><b style="font-size:10px;"><span id="rptTypeSelect"><?php echo LOCATION ?></span><span id="rptTypeCheck"></span></b></td>
        <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
    </tr>
</table>


<table>
    <tr class="title_sub">
        <td width="200px"></td>
        <td width='200px'></td>

        <td style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('received_test_details'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
    </tr>
</table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>     <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('issue_no'); ?></th> 
                    <th width="6%"><?php echo $this->lang->line('date'); ?></th>
                     <th width="7%"><?php echo $this->lang->line('issue_time'); ?></th>
                     <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>      
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('received_qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('expenses_qty'); ?></th>
                   
                    <th width="5%"><?php echo $this->lang->line('remaining_qty'); ?></th>
                   
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $purchase): 
            
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($purchase->sama_invoiceno)?$purchase->sama_invoiceno:'';?></td>
            <td><?php echo !empty($purchase->sama_billdatebs)?$purchase->sama_billdatebs:'';?></td>
            <td>
                <?php echo !empty($purchase->sama_billtime)?$purchase->sama_billtime:'';?>
            </td>
            <td>
                <?php echo !empty($purchase->itli_itemcode)?$purchase->itli_itemcode:'';?>
            </td>
            <td><?php echo !empty($purchase->itli_itemname)?$purchase->itli_itemname:'';?></td>
           
            <td><?php echo !empty($purchase->sama_depname)?$purchase->sama_depname:'';?></td>
            
            <td><?php echo !empty($purchase->unit_unitname)?$purchase->unit_unitname:'';?></td>

           
          <td align="right"><?php echo !empty($purchase->sade_qty)?$purchase->sade_qty:'';?></td> 
            <td align="right" ><?php echo !empty($purchase->expqty)?$purchase->expqty:'0.00';?></td>
            <td align="right"><?php echo ($purchase->sade_qty-$purchase->expqty);?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>

</table>

