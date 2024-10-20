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

    <td class="text-center"><b style="font-size:15px;"> <u>Asset Transfer Summary</u></b> </td>

            </table>

<table id="" class="format_pdf" width="100%">

    <thead>

        <tr>

            <th width="5%">S.No</th>

            <th width="10%">Date (AD)</th>

            <th width="7%">Date (BS)</th>

            <th width="7%">Transfer No.</th>

            <th width="5%">Transfer From</th>

            <th width="5%">Transfer To</th>

            <th width="5%">Manual No</th>

            <th width="5%">Fiscal Year</th>

            <th width="5%">Assets Cnt</th>

            <th width="5%">Remarks</th>



           

        </tr>

    </thead>

    <tbody>

        <?php

        if(!empty($searchResult)):

        $sum=0; 

        foreach ($searchResult as $key => $result): 

        	$transfertype=$result->astm_transfertypeid;

      $fromschool=$result->fromlocation;
      $fromdepparent=$result->fromdepparent;
      $fromdep =$result->fromdep;
            if(!empty($fromdepparent)){
              $from_departmentname=$fromdepparent.'/'.$fromdep;
            }
            else{
              $from_departmentname=$fromdep;
            }
      $from=$fromschool.'-'.$from_departmentname;

      $toschoolname=$result->tolocation;
      $todep=$result->todep;
      $todepparent=$result->todepparent;
      if(!empty($todepparent)){
              $to_departmentname=$todepparent.'/'.$todep;
            }
            else{
              $to_departmentname=$todep;
            }

      $to=$toschoolname.'-'.$to_departmentname;        

        ?>

        <tr>

            <td><?php echo $key+1;?></td>

      			<td><?php echo $result->astm_transferdatead; ?></td>

      			<td><?php echo $result->astm_transferdatebs; ?></td>

      			<td><?php echo $result->astm_transferno; ?></td>

      			<td><?php echo $from; ?></td>

            <td><?php echo $to; ?></td>

            <td><?php echo $result->astm_manualno; ?></td>

            <td><?php echo $result->astm_fiscalyrs; ?></td>

            <td><?php echo $result->astm_noofassets; ?></td>

            <td><?php echo $result->astm_remark; ?></td>

        </tr>

        <?php

        endforeach;

        // $sum++;

        ?>

      

        <?php

        endif;



        ?>

    </tbody>

</table>