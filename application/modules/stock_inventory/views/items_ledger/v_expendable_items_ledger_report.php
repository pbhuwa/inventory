<style type="text/css">
    .table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
    .table_jo_header { width:100%; vertical-align: top; font-size:12px; }
    .table_jo_header td.text-center { text-align:center; }
    .table_jo_header td.text-right { text-align:right; }
    h4 { font-size:18px; margin:0; }
    .table_jo_header u { text-decoration:underline; padding-top:15px; }

    .jo_table { border-right:1px solid #333; border-bottom:1px solid #000; margin-top:5px; margin-bottom:15px; }
    .jo_table tr{border-bottom:  1px solid #333;}
    .jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

    .jo_table tr th { padding:5px 3px; font-weight: bold; text-align: center;}
    .jo_table tr td { padding:5px 3px; height:15px; border-left:1px solid #333; font-size: 12px; }
    .jo_table tr td span{font-size: 12px;}
    .jo_footer { vertical-align: top; }
    .jo_footer td { padding:4px 0px; font-weight: bold;   }
    .bdr-table{border: 1px solid #000;}
    .tableWrapper{
        min-height:50%;
        height:50vh;
        max-height: 100vh;
        white-space: nowrap;
        display: table;
        width: 100%;
        /*overflow-y: auto;*/
    }
    .table_item{
        height:100%;
    }
    .table_item .td_cell{
        padding:5px;margin:5px; 
    }
    .table_item .td_empty{
        height:100%;
    }
</style>

<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo"  id="printrpt">
        <div class="pull-right pad-btm-5 reportGeneration">
            <!-- <a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a> -->
            <a href="javascript:void(0)" class="btn btn_excel btn_gen_report" data-exporturl="<?php echo !empty($excel_url)?$excel_url:'';?>" data-exporttype="excel"><i class="fa fa-file-excel-o"></i></a>
            <a href="javascript:void(0)" class="btn btn_pdf2 btn_gen_report"  data-exporturl="<?php echo !empty($pdf_url)?$pdf_url:'';?>" data-exporttype="pdf" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
        </div>

        <div class="table-wrapper" id="tblwrapper">
            <table class="table_jo_header purchaseInfo">
                <tr>
                    <td></td>
                    <td class="text-center"><span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE ;?></span></td>
                    <td width="30%" class="text-right"><span style="text-align: right; white-space: nowrap;">म.ले.प.फा.नं ५२</span></td>
                </tr>
                <tr>
                    <td width="25%" rowspan="5"></td>
                    <td class="text-center"><span style="font-size: 18px;font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC ;?></span></td>
                    <td width="25%" rowspan="5" class="text-right"></td>
                </tr>
            <tr>
                <td class="text-center" style="font-size: 12px;"><h4 style="font-size: 12px !important;margin-top: 5px;margin-bottom: 0px;"> <span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></span>  </h4></td>
            </tr>
                <tr style="margin-top: 3px;">
                <td class="text-center"><span><?php echo LOCATION; ?></span></td>
            </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-center"><h4 style="margin-top: 0px;"><u><span class="<?php echo FONT_CLASS; ?>">खर्च भएर जाने जिन्सी मालसामानको खाता</span></u></h4></td>
                </tr>
            </table>

            <table class="jo_tbl_head" style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td><strong>जिन्सी सामानको नाम: </strong><?php echo !empty($item_name[0]->itli_itemname)?$item_name[0]->itli_itemname:''; ?> </td>
                </tr>
                <tr><td><strong>ईकाइ: </strong><?php echo !empty($unit_name[0]->unit_unitname)?$unit_name[0]->unit_unitname:''; ?></td></tr>
                <tr>
                    <td width="30%"><strong>
                        स्पेसीफिकेसन: 
                        </strong>
                    </td>
                    <td>
                        <strong>
                        सम्पति वर्गीकरण नम्बर :
                        </strong>
                    </td>
                </tr>
             <!--    <tr><td><strong>जिन्सी सामानको सम्पत्ति वर्गीकरण संकेत न.: </strong><?php echo !empty($item_name[0]->itli_itemcode)?$item_name[0]->itli_itemcode:''; ?> </td></tr> -->
            </table>

            <table class="jo_table itemInfo" style="width: 100%;border-collapse: collapse;margin-top: 20px;">
                <thead>
                    <tr>
                        <th rowspan="2" width="15px">क्र. सं.</th>
                        <th rowspan="2">मिति</th>
                        <th rowspan="2" style="white-space: nowrap;">दाखिला न /निकासी न</th>
                        <th colspan="3" style="white-space: nowrap;">आम्दानी</th>
                        <th colspan="3" style="white-space: nowrap;">खर्च</th>
                        <th colspan="3" style="white-space: nowrap;">बाँकी</th>
                        <th rowspan="2" style="white-space: nowrap; width: 100px;">कैफीयत</th>
                    </tr>
                    <tr>
                        <th>परिमाण </th>
                        <th>दर</th>
                        <th>रकम</th>
                        <th>परिमाण </th>
                        <th>दर</th>
                        <th>रकम</th>
                        <th>परिमाण </th>
                        <th>दर</th>
                        <th>रकम</th>
                    </tr>
                    <tr style="text-align: center;">
                        <th></th>
                        <th>१</th>
                        <th>२</th>
                        <th>३</th>
                        <th>४</th>
                        <th>५</th>
                        <th>६</th>
                        <th>७</th>
                        <th>८</th>
                        <th>९</th>
                        <th>१०</th>
                        <th>११</th>
                        <th>१२</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $blcamt=0;
                        $blcqty=0;    
                        $blnamt=0;    
                        if(!empty($ledger_report)):
                            foreach($ledger_report as $key=>$report):

                                $rec_purqty = $report->rec_purqty;
                                $issueQty = $report->issueQty;

                                $blcqty +=($rec_purqty-$issueQty);

                                $rec_amt = round($report->rec_amt,2);
                                $issuAmt = round($report->issuAmt,2);

                               $blcamt =($rec_amt-$issuAmt);
                            // if($blcamt<0)
                            // {
                            //  $blcamt=-($blcamt);
                            // }

                            $blnamt +=$blcamt;
                            
                            if($report->description=='Closing')
                            {
                                $date_np='-';
                            }
                            else
                            {
                                $date_np=$report->dates;
                            }
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td>
                            <?php
                                echo $date_np;
                            ?>    
                        </td>
                        <td><?php echo !empty($report->description)?$report->description:'';?></td>
                       
                        <td style="text-align: right;"><?php echo !empty($report->rec_purqty)?$report->rec_purqty:0;?></td>
                        <td style="text-align: right;"><?php echo !empty($report->rec_rate)?number_format($report->rec_rate,2):0;?></td>
                        <td style="text-align: right;"><?php echo !empty($report->rec_amt)?number_format($report->rec_amt,2):0;?></td>
                        
                        <td style="text-align: right;"><?php echo !empty($report->issueQty)?$report->issueQty:0;?></td>
                        <td style="text-align: right;"><?php echo  round($report->rec_rate,2); ?></td>
                        <td style="text-align: right;"><?php echo !empty($report->issuAmt)?number_format($report->issuAmt,2):0;?></td>

                        <td style="text-align: right;"><?php echo !empty($blcqty)?$blcqty:0;?></td>
                        <td style="text-align: right;" ><?php echo !empty($report->rec_rate)?number_format($report->rec_rate,2):0;?></td>
                        <td style="text-align: right;"><?php echo !empty($blnamt)?number_format($blnamt,2):0;?></td>
                        <td></td>
                    </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
            <table class="jo_footer" style="width: 100%;border-collapse: collapse;margin-top: 70px;">
                <tr>
                    <td width="33.333333333%" style="text-align: left;white-space: nowrap;">
                         <div style="display: inline-block; text-align: left;">
                         फांटवालाको दस्तखत<br />
                           <br>
                           <br>
                            मिति:<br />
                        </div>
                    </td>
                    <td width="33.333333333%" style="text-align: center;white-space: nowrap;">
                        <div style="display: inline-block; text-align: left;">
                           शाखा प्रमुखको दस्तखत<br />
                           <br>
                           <br>
                            मिति:<br />
                        </div>
                    </td>
                    <td width="33.333333333%" style="text-align: right;white-space: nowrap;">
                        <div style="display: inline-block; text-align: left;">
                          कार्यालय प्रमुखको दस्तखत<br />
                           <br>
                           <br>
                            मिति:<br />
                        </div>
                    </td>
                </tr>
              
            </table>
        </div>
    </div>
</div>