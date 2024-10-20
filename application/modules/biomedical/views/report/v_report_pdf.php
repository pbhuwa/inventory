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
    <td class="text-center"><b style="font-size:15px;"> <u> Equipment Reports List </u></b> </td>
            </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="3%">S.N</th>
               <th width="10%">Equp.ID</th>
               <th width="15%">Description</th>
               <th width="10%">Department</th>
               <th width="5%">Room</th>
               <th width="10%">Model No</th>
               <th width="10%">Serial No</th>
               <th width="15%">Manufacture</th>
               <th width="15%">Distributor.</th>
               <th width="10%">Risk </th>
               <th width="10%">AMC</th>
               <th width="5%">Oper.</th>
               <th width="10%">Ser.St.Date.</th>
               <th width="10%">Ser.End.Warr.</th>
               <th width="15%">Maunal</th>
                     
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 

        $i=1;
        foreach ($searchResult as $key => $result): 
          // $publishdate=strtotime(CURDATE_EN);
          // $submitdate=strtotime($result->proc_submitdatead);
          //   $status=  ($submitdate - $publishdate)/60/60/24; 
            // echo $status;
            // die();
            // if($status<=0)
            // {
            //   $cur_status='<label class="text-danger">Expiry</label>';
            // }
            // else if($status>0 && $status<=3)
            // {
            //   $cur_status='<label class="text-warning">Expiry</label>';
            // }
            // else
            // {
            //   $cur_status=$status.' Days left';
            // }
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $result->bmin_equipmentkey; ?></td>
            <td><?php echo $result->eqli_description; ?></td>
            <td><?php echo $result->dein_department; ?></td>
            <td><?php echo $result->rode_roomname; ?></td>
            <td><?php echo $result->bmin_modelno; ?></td>
            <td><?php echo $result->bmin_serialno; ?></td>
            <td><?php echo $result->manu_manlst; ?></td>
            <td><?php echo $result->dist_distributor ; ?></td>
            <td><?php echo $result->riva_risk ; ?></td>
            <td><?php echo $result->bmin_amc ; ?></td>
            <td><?php echo $result->bmin_equip_oper ; ?></td>
            <td><?php echo $result->bmin_servicedatebs ; ?></td>
            <td><?php echo $result->bmin_endwarrantydatebs ; ?></td>
            <td><?php echo $result->bmin_ismaintenance ; ?></td>
     <!--  <td><?php echo $cur_status; ?></td> -->     

        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>