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

/*.table_jo_header td.text-center {

    position: relative;

    top: -35px;

}

.table_jo_header td span.pull-right {

    position: relative;

}

.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer {

    width: 100%;

    font-size: 12px;

    border-collapse: collapse;

}*/

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

.table_jo_header {

    margin-bottom: 30px;

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

/*.header-wrapper .purchaseInfo {

        margin: 0;

    padding: 0;

}*/

</style>

<table class="table_jo_header purchaseInfo" >

    <tr>

        <td width="33%" style="min-width: 200px; " align="center">

             <div class="logo" style="position: relative; top: -15px; left:-50px; ">

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

                        <img src="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>" alt="" style=" height: 100px !important; width:100px !important;" />

                    </a>

                <?php

                    endif;

                ?>

            </div>

        </td>
        <?php if (ORGANIZATION_NAME == 'NPHL'):?>
            <td width="33%" class="text-center">

            <h6 style="font-weight: 500;font-size: 14px;margin-bottom: 0px;margin-top: 3px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE;?></h6>

            <h6 style="margin-bottom: 1px;margin-top: 1px;font-size: 14px;font-weight: 500;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></h6>

            <h6 style="margin-bottom: 1px;margin-top: 1px;font-size: 14px;font-weight: 500;" class="<?php echo FONT_CLASS; ?>"><?php echo "स्वास्थ्य सेवा विभाग";?></h6>

            <span style="font-size: 16px; font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME ;?></span></br>

            <span style="font-size: 12px;"><?php echo LOCATION;?></span>

            <h4 style="font-weight: 600;font-size: 15px;margin-top: 8px;"><u>

            <?php echo !empty($report_title)?$report_title:'';?></u></h4>
        </td>
        <?php elseif(ORGANIZATION_NAME == 'KUKL'): ?>
        <td width="33%" class="text-center">

            <span style="font-size: 18px; font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME ;?></span>

            <h3 style="font-weight: 600;font-size: 16px;margin-bottom: 0px;margin-top: 3px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE;?></h3>

            <h6 style="margin-bottom: 1px;margin-top: 1px;font-size: 12px;font-weight: 300;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></h6>

            <span style="font-size: 11px;">
                <?php 
                $location_ismain = $this->session->userdata(ISMAIN_LOCATION);
                $location_name = LOCATION;
                if($location_ismain != 'Y'){
                $location_name = $this->session->userdata(LOCATION_NAME);
                }
            echo $location_name;?></span>

            <h4 style="font-weight: 600;font-size: 15px;margin-top: 8px;"><u>

            <?php echo !empty($report_title)?$report_title:'';?></u></h4>
        </td>
        <?php elseif(ORGANIZATION_NAME=='PU'): ?>
        <td width="33%" class="text-center">
             <span style="font-size: 18px; font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME ;?></span>
            <?php $session_locationid=$this->session->userdata(LOCATION_ID); 
                $inp_locationid=!empty($locationid)?$locationid:$session_locationid;
            if (!empty($inp_locationid)) {
                            $location_data = $this->general->get_tbl_data('loca_name,loca_namenp', 'loca_location', array('loca_locationid' => $inp_locationid));
                            if ($location_data) {
                                $location_name= !empty($location_data[0]->loca_namenp)?$location_data[0]->loca_namenp:$location_data[0]->loca_name;
                            } else {
                                 $location_name='_______________________ कार्यालय';
                            }
                        }
            ?>


          
            <h3 style="font-weight: 600;font-size: 16px;margin-bottom: 0px;margin-top: 3px;" ><span style="font-size: 16px;"><?php echo $location_name; ?></span></h3>

            <h4 style="font-weight: 600;font-size: 15px;margin-top: 8px;"><u>

            <?php echo !empty($report_title)?$report_title:'';?></u></h4>
        </td>
        
        <?php else: ?>
        <td width="33%" class="text-center">

            <span style="font-size: 18px; font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME ;?></span>

            <h3 style="font-weight: 600;font-size: 16px;margin-bottom: 0px;margin-top: 3px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE;?></h3>

            <h6 style="margin-bottom: 1px;margin-top: 1px;font-size: 12px;font-weight: 300;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></h6>

            <span style="font-size: 11px;"><?php echo LOCATION;?></span>

            <h4 style="font-weight: 600;font-size: 15px;margin-top: 8px;"><u>

            <?php echo !empty($report_title)?$report_title:'';?></u></h4>
        </td>
        <?php endif;?>

        <td width="33%" class="text-right" style="min-width: 150px; vertical-align: top;">

            <span>

                <?php echo !empty($report_no)?$report_no:'';?><br/>

                <?php echo !empty($old_report_no)?$old_report_no:'';?>

            </span>

        </td>

    </tr>

</table>