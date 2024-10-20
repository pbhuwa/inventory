<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>
            <table width="100%" style="font-size:12px;">
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
                  <td width="25%" style="text-align:right; font-size:10px;">Date/Time: <?php echo CURDATE_NP ?> BS,</td>
                </tr> 

                <tr class="title_sub">
                  <td width="25%"></td>
                 <td style="text-align: center;"><b><font color="black"><span class="<?php echo FONT_CLASS; ?>" ><?php echo LOCATION; ?></span></font></b></td>
                  <td width="25%" style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
                </tr>
</table>
<br>
<br>
<table width="100%" style="font-size:12px;">
                <tr>
                  <td width="25%"></td>
                  <td  style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><u><span class="<?php echo FONT_CLASS; ?>" > <?php echo $this->lang->line('current_stock_details'); ?></span></u></h3></td>
                  <td width="25%"></td>
                </tr>
               <!--  <tr class="title_sub">
                  <td width="25%"></td>
                  <td style="text-align:center;"><b></b></td>
                  <td width="25%" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
                </tr> -->

              </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th ><?php echo $this->lang->line('sn'); ?></th>
            <th ><?php echo $this->lang->line('code'); ?></th>
            <th ><?php echo $this->lang->line('name'); ?></th>
            <th ><?php echo $this->lang->line('category'); ?></th> 
            <th ><?php echo $this->lang->line('type'); ?> </th>
            <th ><?php echo $this->lang->line('at_stock'); ?> </th>
            <?php if($pdf_details == "details"){ ?><th > </th><?php } ?>
           
            <th ><?php echo $this->lang->line('unit_price'); ?>  </th>
            <th ><?php echo $this->lang->line('unit'); ?> </th>
            <?php if($pdf_details == "details"){ ?>
            <th ><?php echo $this->lang->line('batch_no'); ?> </th>
            <th ><?php echo $this->lang->line('expiry_date'); ?> </th> <?php } ?>
            <th ><?php echo $this->lang->line('amount'); ?></th> 
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending): 
            if($pending->itli_itemcode!=''):
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $pending->itli_itemcode; ?></td>
            <td><?php echo $pending->itli_itemname; ?></td>
            <td><?php echo $pending->eqca_category; ?></td>
            <td><?php echo $pending->maty_material; ?></td>
            <td><?php echo $pending->atstock; ?></td>
            <?php if($pdf_details == "details"){ ?><td><?php echo $pending->itli_maxlimit; ?></td><?php } ?>
            
            <td><?php echo $pending->trde_unitprice; ?></td>
            <td><?php echo $pending->unit_unitname; ?></td>
            <?php if($pdf_details == "details"){ ?>
            <td><?php echo $pending->batchno; ?></td>
            <td><?php echo $pending->trde_expdatebs; ?></td>
            <?php } ?>
            <td><?php echo $pending->amount; ?></td>
        </tr>
        <?php
        $i++;
    endif;
        endforeach;
        endif;
        ?>
    </tbody>
</table>