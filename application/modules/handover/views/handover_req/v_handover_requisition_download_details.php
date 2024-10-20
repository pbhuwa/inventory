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
        
        <td colspan="6" class="web_ttl text-center" style="text-align:center;">
            <!-- <h2><?php //echo ORGA_NAME; ?></h2> -->
            <h3><?php echo ORGNAMETITLE; ?></h3>
        </td>
        <td></td>
    </tr>
    <tr class="title_sub">
        
        <!-- <td style="text-align:center;"><?php //echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td> -->
        <td colspan="6" style="text-align:center;"><h3 style="margin: 0px"><?php echo ORGNAME ?></h3></td>
        <td style="text-align:right; font-size:10px;"><?php echo $this->lang->line('date_time'); ?>: <?php echo CURDATE_NP ?> <?php echo $this->lang->line('bs'); ?>,</td>
    </tr>
    <tr class="title_sub">
        <!-- <td></td> -->
        <td colspan="6" style="text-align:center;"><h3 style="margin: 0px">
        <?php echo ORGNAMEDESC ?></h3></td><span id="rptType"></span></td>
        <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> <?php echo $this->lang->line('ad'); ?> </td>
    </tr>
    <tr class="title_sub">
        <!-- <td width="200px"></td> -->
        <td colspan="6" style="text-align:center;"><h4 style="margin: 0px;"><span id="rptTypeSelect"><?php echo LOCATION ?></h4></span><span id="rptTypeCheck"></span></td>
        <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
    </tr>
</table>
<br>
<table width="100%">
    <tr class="title_sub">

        <td colspan="6" style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('handover_requisition_details'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
    </tr>
</table>
<br>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="7%"><?php echo $this->lang->line('handover_no'); ?></th>
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
            <td><?php echo !empty($row->harm_handoverreqno)?$row->harm_handoverreqno:'';?></td>          
            <td>
               <?php echo !empty($row->itli_itemcode)?$row->itli_itemcode:'';?>
            </td>
            <td>
                <?php echo !empty($row->itli_itemname)?$row->itli_itemname:'';?>
            </td>
            <td><?php echo !empty($row->harm_fyear)?$row->harm_fyear:'';?></td>
            <td><?php echo !empty($row->hard_qty)?$row->hard_qty:'';?></td>
            <td><?php echo !empty($row->hard_remqty)?$row->hard_remqty:'';?></td> 
            <td><?php echo !empty($row->hard_remarks)?$row->hard_remarks:'';?></td>
         
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

