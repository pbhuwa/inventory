<style type="text/css">




.tableWrapper {
/*    min-height: 60%;
    height: 60vh;*/
    /*max-height: 100vh;*/
    white-space: nowrap;
    display: table;
    width: 100%;
    margin: 20px 0 0 0;
}
.table_jo_header td.text-center {
    /*text-align: center;*/
    position: relative;
    top: -35px;
}
.table_jo_header td span.pull-right {
    position: relative;
    /*left: 45px;*/

}
.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer {
    width: 100%;
    font-size: 12px;
    border-collapse: collapse;
}
.jo_table {
    margin-top: 15px !important;
    border-right: 1px solid#333;
}
.itemInfo .td_cell {
    padding: 5px;
    margin: 5px;
}
.jo_table tr td {
    border-left: 1px solid #333;
    border-bottom: 1px solid #000;
    padding: 0px 4px;
    background-color: white;
    border-left: 1px solid #333;

}
.itemInfo .td_empty {
    height: 100%;
}
.jo_table tr th {
    border-top: 1px solid #333;
    border-bottom: 1px solid #333;
    border-left: 1px solid #333;
}

.header-wrapper:after{
    clear: both;
    content: "";
    display: block;
}
.logo {
    float: left;
    width: 20%;
    margin: 0px 0 0 0;
    height: 100px;
    position: relative;
    /*top: -10px;*/
    margin-top: -10px;
}
.purchaseInfo {
    float: right;
    width: 85%;
    font-size: 14px;
   /* position: relative;
    right: 50px;*/

}

/*.itemInfo {
    height: 100%;
}*/
.footerWrapper {
    page-break-inside: avoid;
}
.jo_footer {
    border: 1px solid #333;
    vertical-align: top;
}
.jo_footer td {
    padding: 21px 8px;
}

.signatureDashedLine {
    min-width: 170px;
    display: inline-block;
    border: 1px dashed #333;
    position: relative;
    top: -11px;
}
tfoot tr:first-child {
    font-weight: 900;
}

.header-wrapper {
    margin: 0;
    padding: 0;
    line-height: 1;
}
.header-wrapper .purchaseInfo {
        margin: 0;
    padding: 0;
}
</style>
<div class="header-wrapper">
    <table class="table_jo_header purchaseInfo" style="position: relative;">
        <tr>
            <div class="logo">
                 <a href="http://kathmanduwater.org/" class="logo"><img src="..\\htdocs\sql_hold\assets\template\images\logo.jpg" alt="Logo"></a> 

                <?php
                    if(ORGANIZATION_NAME == 'KUKL'):
                ?>
                    <a href="">
                        <img src="<?php echo base_url(TEMPLATE_IMG) ?>/logo5.png" class="img-responsive" alt="" />
                    </a>
                <?php
                    else:
                ?>
                    <a href="">
                        <img src="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>" alt="">
                    </a>
                <?php
                    endif;
                ?>
            </div>
        </tr>
        <tr>
                       <!-- <td width=""></td> -->
            <td class="text-center"><span style="font-size: 13px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE ;?></span></td>
            <td width="" class="" style="white-space: nowrap;">
                <span class="pull-right">
                    <?php echo !empty($report_no)?$report_no:'';?><br/>
                    <?php echo !empty($old_report_no)?$old_report_no:'';?>
                </span>
            </td>
            

        </tr>
        <tr>
            <td width="" rowspan="5"></td>
            <td class="text-center"><h3 style="font-weight: 600;margin-bottom: 0px;margin-top: 0px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></h3></td>
            <!-- <td></td> -->
        </tr>
        <tr>
            <td class="text-center"><h6 style="margin-bottom: 1px;margin-top: 0px;font-size: 12px;font-weight: 300;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></h6></td>
        </tr>
        <tr>
            <td class="text-center <?php echo FONT_CLASS; ?>"><span style="font-size: 12px;"><?php echo LOCATION;?></span></td>
        </tr>

        <tr>
            <td style="" class="text-center <?php echo FONT_CLASS; ?>"><h4 style="font-weight: 600;font-size: 15px;margin-top: 5px;"><u>
                <?php echo !empty($report_title)?$report_title:'';?></u></h4>
            </td>
        </tr>
    </table>
</div>
