<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_pdf thead tr th{text-align: left;}
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }

    table.reportTitle tr td{font-size: 15px; font-weight: bold;text-decoration: underline;}
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
        <td style="text-align: center;">
            <h4 style="color:black;font-size: 14px;" class="<?php echo FONT_CLASS; ?>" >
                <?php echo ORGNAMEDESC; ?>
            </h4>
        </td> 
        <td width="25%" style="text-align:right; font-size:10px;">
            <strong><?php echo $this->lang->line('date_time'); ?>: </strong> 
            <?php echo CURDATE_NP ?> BS, <?php echo CURDATE_EN ?> AD <?php echo $this->general->get_currenttime(); ?>
        </td>
    </tr> 

    <tr class="title_sub">
        <td width="25%"></td>
        <td style="text-align: center;"><b><font color="black"><span class="<?php echo FONT_CLASS; ?>" ><?php echo LOCATION; ?></span></font></b></td>
        <td width="25%" style="text-align:right; font-size:10px;"></td>
    </tr>

</table>