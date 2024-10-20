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
                  <td width="25%"></td>
                  <td  style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><B><span class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAMETITLE; ?></span></B></h3></td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td  style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><B><span class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAME; ?></span></B></h3></td>
                  <td width="25%"></td>
                </tr>

                <tr class="title_sub">
                  <td width="25%"></td>
                  <td style="text-align: center;"><h4 style="color:black" class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAMEDESC; ?></h4></td> 
                  <td width="25%" style="text-align:right; font-size:10px;">
                    <?php echo $this->lang->line('date_time'); ?>: <?php echo CURDATE_NP ?> BS,</td>
                </tr> 

                <tr class="title_sub">
                  <td width="25%"></td>
                 <td style="text-align: center;"><b><font color="black"><span class="<?php echo FONT_CLASS; ?>" ><?php echo LOCATION; ?></span></font></b></td>
                  <td width="25%" style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
                </tr>

              </table>
<br><br>
              <table width="100%" style="font-size:12px;">
    <tr>
    <td style="width:45%">
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('pending_requisition'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('requisition_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('requisition_date'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
            <th width="5%"><?php echo $this->lang->line('req_qty'); ?></th>
            <!-- <th width="5%"><?php echo $this->lang->line('rem_qty'); ?></th> -->
            <th width="10%"><?php echo $this->lang->line('category_name'); ?> </th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->pure_reqno)?$row->pure_reqno:'';?></td>
            <td><?php echo !empty($row->pure_reqdatebs)?$row->pure_reqdatebs:'';?></td>
            <td><?php echo !empty($row->itli_itemcode)?$row->itli_itemcode:'';?></td>
            <td><?php echo !empty($row->itli_itemname)?$row->itli_itemname:'';?></td>
            <td><?php echo !empty($row->unit_unitname)?$row->unit_unitname:'';?></td>
            <td><?php echo !empty($row->purd_qty)?$row->purd_qty:'';?></td>
            <!-- <td><?php echo !empty($row->redt_remaqty)?$row->redt_remaqty:'';?></td> -->
            <td><?php echo !empty($row->eqty_equipmenttype)?$row->eqty_equipmenttype:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

