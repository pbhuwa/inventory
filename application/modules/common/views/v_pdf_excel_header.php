
<style>

    table tr th { font-family: freesans; }

    @media print{
        @page {
        margin:10mm
    }
        .format_pdf_body thead tr th{ font-size:13px; border:1px solid #000; padding:2px 4px !important}
    .format_pdf_body  tbody tr td { font-size:12px !important; padding:4px !important; }
    }


</style>
<div class="format_pdf_body">

<table width="100%" style="font-size:12px;" class="format_pdf_head" style="margin-bottom: 10px">

    <tr class="title_sub">          

        <th width="25%" style="text-align: left;">

            <a href="#">

               <img src="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>" style="width: 100px;">

            </a>

        </th>

        <th width="50%" style="text-align: center; font-family: freesans;">

      <p style="font-size: 17px;font-family: freesans;font-weight:bold"> <?php echo ORGNAME; ?></p>  

        <span style="font-size: 13px;display: block;"> <?php echo ORGNAMETITLE; ?> </span><br><br>

        <p style="font-size: 13px;font-weight: 400;margin:10px 0;display: block;">Date Range:<span style="font-weight: 600"> <?php echo !empty($fromdate)?$fromdate:'' ?></span>-<span style="font-weight: 600"> <?php echo !empty($todate)?$todate:'' ?></span></p>
        <div style="font-size: 600;font-family: freesans;text-decoration: underline;font-size: 15px;display: block;">  <?php echo !empty($report_title)?$report_title:'';?></div>

        </th>

        <td width="25%" style="text-align: right; font-size: 12px">

            Date/Time :<?php echo CURDATE_NP ?> BS, <br>

            <?php echo CURDATE_EN ?> AD <br>

            <?php echo $this->general->get_currenttime(); ?>

        </td>

    </tr>



</table>
