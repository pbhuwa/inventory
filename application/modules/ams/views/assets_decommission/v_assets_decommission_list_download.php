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
    <td class="text-center"><b style="font-size:15px;"> <u>Asset Decommission Lists</u></b> </td>
            </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%">S.No</th>
            <th width="10%">Asset code</th>
            <th width="7%">Date(AD)</th>
            <th width="7%">Date(BS)</th>
            <th width="10%">Time</th>
            <th width="10%">Reason</th>
            <th width="5%">Method</th>
            <th width="5%">Disposition Type</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $sum=0;
        if(!empty($searchResult)): 
        foreach ($searchResult as $key => $result): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
      			<td><?php echo $result->asen_assetcode; ?></td>
      			<td><?php echo $result->deeq_postdatead; ?></td>
      			<td><?php echo $result->deeq_postdatebs; ?></td>
      			<td><?php echo $result->deeq_posttime; ?></td>
      			<td><?php echo $result->deeq_reason; ?></td>
            <td><?php echo $result->deme_decomname; ?></td>
            <td><?php echo $result->deeq_disposition; ?></td>
        </tr>
        <?php
        // $sum= $sum +$result->asin_insuranceamount;
        // echo $sum;
        endforeach;
        endif;

        ?>
    </tbody>
</table>