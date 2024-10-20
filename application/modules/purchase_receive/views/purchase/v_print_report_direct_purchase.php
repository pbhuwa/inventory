<style> 
    @page  {
        size: auto;   
        margin: 5mm 5mm 5mm 10mm;  
        /*size: landscape;*/
    } 

    .table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
    .table_jo_header { width:100%; vertical-align: top; font-size:12px; }
    .table_jo_header td.text-center { text-align:center; }
    .table_jo_header td.text-right { text-align:right; }
    h4 { font-size:18px; margin:0; }
    .table_jo_header u { text-decoration:underline; padding-top:15px; }

    .jo_table { border-right:1px solid #333; margin-top:5px; }
    .jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

    .jo_table tr th { padding:5px 3px;}
    .jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
    
    .jo_footer {vertical-align: top; }
    .jo_footer td { padding:8px 8px;}

    .preeti{
        font-family: preeti;
        }
    .bb{border-bottom:1px dashed #333;}
    .bold{ font-weight: bold; }
    .jo_table tr td{border-bottom: 1px solid #333;}
    .dakhila_form_footer {border: 1px solid #212121;border-top: 0px;padding: 5px 15px;}
    .officer_detailTable tr th{text-align: left; font-weight: 500;margin-bottom: 5px;font-size: 12px;}
    .officer_detailTable tr td{font-size: 12px;}    
        .preeti{
        font-family: preeti;
    }
    .bordertblone{border-bottom: 1px dashed #333; } 
    .purchaserecive{border-collapse: collapse;}
    .purchaserecive-table tr th{border-bottom: 1px solid #ddd;padding: 4px;}
    .purchaserecive-table tr td{border-bottom: 1px solid #ddd;padding: 4px;}
    .purchaserecive-table tr:last-child td{border-bottom: 0px;}
    .jo_table tr.total-amount td{border-bottom: 0px !important;}
    .jo_table tr.total-amount td:last-child{border-left: 0px;}
    .jo_table tr.total-amount td:nth-child(2){border: 0px;}
    /*.jo_table tr:last-child td:nth-child(2){border: 0px;}*/
    /*.jo_table tr:last-child td:last-child{border-left: 0px;}*/
    .tableWrapper{
        min-height:40%;
        height:40vh;
        max-height: 100vh;
        white-space: nowrap;
        display: table;
        width: 100%;
        /*overflow-y: auto;*/
    }
    .itemInfo{
        height:100%;
    }

    .itemInfo .td_cell{
        padding:5px;
        margin:5px; 
        font-size: 8px;
    }

    .itemInfo th.td_cell {
        padding:5px;
        margin:5px; 
        text-align: center;
        font-size: 10px;
    }

    th.td_cell{
        font-size: 10px;
        font-weight: bold;
    }

    .itemInfo .td_cell_num{
        font-size: 7px;
        /*text-align: left;*/
    }

    .itemInfo .td_empty{
        height:100%;
    }
    .jo_table tbody tr td:nth-child(3){
        width: 100% !important;
    }
    .tableWrapper tr th{
        word-wrap: break-word;
        white-space: initial;
    }

    .amount-table{
        border-collapse: collapse;
        border:1px solid #000;
        border-top: 0px;
        margin: 0px;
        margin-top: 15px;
    
    }
    .amount-table tbody tr td{
        border-bottom:1px solid #000;
        font-size: 12px;
        padding: 5px 15px;
    }
    .amount-table tbody tr td span{
        font-size: 12px;
        display: inline-block;
        margin:0px;
        padding: 0px;
    }
    .amount-table tbody tr td:first-child{
        border: 1px solid #000;
        border-top:0px;
    }
    .footerWrapper{
        page-break-inside: avoid;
    }
</style>

<div class="jo_form organizationInfo">
    <div class="headerWrapper" style="margin-bottom: -25px " >
        <?php 
            $header['report_no'] = 'म.ले.प.फारम.नं ४०३';
            $header['old_report_no'] = 'साबिकको फारम न. ४६';
            $header['report_title'] = 'दाखिला प्रतिबेदन फारम';
            $this->load->view('common/v_print_report_header',$header);
        ?>

        <table class="jo_tbl_head" >
            <tr>
                <td></td>
                <td width="20%" class="text-left " style="white-space: nowrap;">
                    <strong>दाखिला मिति: </strong>
                    <span class="bb"> 
                        <?php 
                            if($req_detail_list)
                            {   
                                if(DEFAULT_DATEPICKER == 'NP'){
                                    echo !empty($direct_purchase_master[0]->recm_receiveddatebs)?$direct_purchase_master[0]->recm_receiveddatebs:'';
                                }else{
                                    echo !empty($direct_purchase_master[0]->recm_receiveddatead)?$direct_purchase_master[0]->recm_receiveddatead:'';
                                }
                            } else{
                                if(DEFAULT_DATEPICKER == 'NP'){
                                    echo CURDATE_NP;    
                                }else{
                                    echo CURDATE_EN;
                                }
                            } 
                        ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td></td>
                <td width="20%" class="text-left " style="white-space: nowrap;">
                    <!-- <span style="font-size: 12px; margin: 0; padding: 0" class="text-left">  -->
                        <strong>दाखिला प्रतिबेदन नं: </strong> 
                    <!-- </span> -->
                    <span class="bb" style="margin: 0; padding: 0;"> 
                        <?php
                        if($req_detail_list){
                         echo !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';  
                        } else{
                        echo !empty($report_data['received_no'])?$report_data['received_no']:''; } ?>
                    </span>
                </td>

                <?php
                    if(!empty($challan_no)):
                ?>
                    <td>
                        <span style="font-size: 12px;" class=""> चलान न: </span>
                        <span class="bb"> 
                        <?php 
                            $challanno = array();
                            foreach($challan_no as $ch){
                                $challanno[] = $ch->chma_challanmasterid;
                            }
                            echo implode(',',$challanno);
                        ?>
                        </span>
                    </td>
                <?php
                    endif;
                ?>
            </tr>
        </table>
    </div>
    
    <div class="tableWrapper">
        <table class="jo_table itemInfo" style="border-bottom: 1px solid #333; width: 100%;table-layout: fixed;text-align: center;">
            <thead>
                <tr>
                    <th width="4%" rowspan="2" class="td_cell">क्र. सं.</th>
                    <th width="10%" rowspan="2" class="td_cell">खरिद आदेश/ हस्तान्तरण फारम नं </th>
                    <th width="10%" rowspan="2" class="td_cell">जिन्सी करण संकेत नं</th>
                    <th width="10%" rowspan="2" class="td_cell">जिन्सी खाता पा. नं</th>
                    <th width="10%" rowspan="2" class="td_cell">सामानको नाम </th>
                    <th width="8%" rowspan="2" class="td_cell">स्पेसीफिकेसन</th>
                    <th width="8%" rowspan="2" class="td_cell">सामानको पहिचान नं</th>
                    <th width="5%" rowspan="2" class="td_cell">मोडल नं</th>
                    
                    <th width="45%"  colspan="6" class="td_cell">मूल्य(बिल विजक अनुसार)</th>
                    <th width="8%" rowspan="2" class="td_cell">अन्य खर्च </th>
                    <th width="8%" rowspan="2" class="td_cell">अन्य खर्च समेत जम्मा रकम </th>
                    <th width="10%" rowspan="2" class="td_cell">कैफियत </th>
                </tr>
                <tr>
                    <th class="td_cell">एकाइ </th>
                    <th class="td_cell">परिमाण</th>
                    <th class="td_cell">दर</th>
                    <th class="td_cell">जम्मा मू अ कर बाहेक</th>
                    <th class="td_cell">मू अ कर</th>
                    <th class="td_cell">सामानको जम्मा मूल्य </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="td_cell td_cell_num">१</span></td>
                    <td><span class="td_cell td_cell_num">२</span></td>
                    <td><span class="td_cell td_cell_num">३</span></td>
                    <td><span class="td_cell td_cell_num">४</span></td>
                    <td><span class="td_cell td_cell_num">५</span></td>
                    <td><span class="td_cell td_cell_num">६</span></td>
                    <td><span class="td_cell td_cell_num">७</span></td>
                    <td><span class="td_cell td_cell_num">८</span></td>
                    <td><span class="td_cell td_cell_num">९</span></td>
                    <td><span class="td_cell td_cell_num">१०</span></td>
                    <td><span class="td_cell td_cell_num">११</span></td>
                    <td><span class="td_cell td_cell_num">१२</span></td>
                    <td><span class="td_cell td_cell_num">१३</span></td>
                    <td><span class="td_cell td_cell_num">१४</span></td>
                    <td><span class="td_cell td_cell_num">१५</span></td>
                    <td><span class="td_cell td_cell_num">१६</span></td>
                    <td><span class="td_cell td_cell_num">१७</span></td>
                </tr>

                <?php 
                    if($req_detail_list){
                        $sum= 0; $vatsum=0;
                        foreach ($req_detail_list as $key => $direct) { ?>
                            <tr style="border-bottom: 1px solid #212121;">
                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                                    <?php echo $key+1; ?>
                                </td>
                                <td class="td_cell"></td>
                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                                    <?php echo !empty($direct->eqca_jinsicode)?$direct->eqca_jinsicode:''; ?>
                                </td>
                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                                    <?php echo !empty($direct->itli_itemcode)?$direct->itli_itemcode:''; ?>
                                </td>
                                <td width="500px" class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                                    <?php
                                        if(ITEM_DISPLAY_TYPE=='NP'){
                                            echo !empty($direct->itli_itemnamenp)?$direct->itli_itemnamenp:$direct->itli_itemname;
                                        }else{ 
                                            echo !empty($direct->itli_itemname)?$direct->itli_itemname:'';
                                        }
                                    ?>
                                </td>
                                <td class="td_cell"></td>
                                <td class="td_cell"></td>
                                <td class="td_cell"></td>
                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                                    <?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>
                                </td>

                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                                    <?php echo number_format($direct->recd_purchasedqty); ?>
                                </td>

                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
                                    <?php 
                                        $unit_price = !empty($direct->recd_unitprice)?$direct->recd_unitprice:''; 
                                        echo number_format($unit_price,2);
                                    ?>
                                </td>
                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                                    <?php 
                                        $total_wo_vat = $direct->recd_purchasedqty*$direct->recd_unitprice; 
                                        echo number_format($total_wo_vat,2);
                                    ?>
                                </td>
                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
                                    <?php 
                                        echo $direct->recd_vatamt;
                                    ?>
                                </td>
                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: right;">
                                    <?php echo $direct->recd_amount; ?>
                                </td>
                                <td class="td_cell"></td>
                                <td class="td_cell"></td>
                                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                                    <?php echo $direct->recd_description; ?>
                                </td>
                            </tr>
                        <?php
                            $sum += $direct->recd_discountamt;
                            $vatsum += $direct->recd_vatamt;
                        }
                
                        $row_count = count($req_detail_list);
                        if($row_count < 11): ?>
                            <tr>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                                <td class="td_empty"></td>
                            </tr>
                        <?php endif;?>
                    <?php 
                        $total = $direct->recm_clearanceamount;
                    ?>
            </tbody>
        </table>
    </div>

    <table width="100%" class="amount-table">
        <tbody>
            <tr margin>
                <td width="75.7%" style="text-align: right;">
                    <span class="">कूल  जम्मा </span>:
                </td>
                <td style="border-right: 1px solid;">
                    <?php echo !empty($total)?number_format($total,2):''; ?>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="17" style="overflow-wrap: break-word;white-space: nowrap;text-align: center;"><strong>शब्दमा : </strong> 
                    <?php 
                        if($req_detail_list){
                            echo $this->general->number_to_word($total);
                        }else{
                            echo $this->general->number_to_word($report_data['clearanceamt']);
                        } 
                    ?> 
                </td>
            </tr>
        </tbody>
    </table>

    <!-- <div class="footerWrapper">
        <table class="jo_footer" style="width: 100%;border: 1px solid #333;">
            <tfoot>
                <tr>
                    <td style="padding: 10px;">
                        <span class="<?php echo CURDATE_NP;?>">माथि उल्लेखित मालसमानहरु खरिद आदेश न. </span> 
                        <span class="<?php echo CURDATE_NP;?>"> </span>
                        <span class="bb">
                        <?php 
                            if($req_detail_list)
                            {
                                echo !empty($req_detail_list[0]->recm_purchaseorderno)?$req_detail_list[0]->recm_purchaseorderno:'';
                            }else{
                                echo !empty($report_data['orderno'])?$report_data['orderno']:'';
                            }   
                        ?>
                        </span> मिति 
                        <span class="bb">
                            <?php 
                                if($req_detail_list){
                                    if(DEFAULT_DATEPICKER == 'NP'){
                                echo !empty($direct_purchase_master[0]->recm_receiveddatebs)?$direct_purchase_master[0]->recm_receiveddatebs:'';
                            }else{
                                echo !empty($direct_purchase_master[0]->recm_receiveddatead)?$direct_purchase_master[0]->recm_receiveddatead:'';
                            }
                                } else{ 
                                    echo !empty($report_data['received_date'])?$report_data['received_date']:'';
                                }
                            ?>
                        </span> अनुसार श्री  
                        <span class="bb">
                            <?php 
                                if($req_detail_list)
                                {
                                    echo !empty($req_detail_list[0]->dist_distributor)?$req_detail_list[0]->dist_distributor:'';
                                } else{
                                    $supid =  !empty($report_data['supplierid'])?$report_data['supplierid']:'';
                                    $supname = $this->general->get_tbl_data('*','dist_distributors',array('dist_distributorid'=>$supid),'dist_distributor','ASC'); echo  !empty($supname[0]->dist_distributor)?$supname[0]->dist_distributor:''; }
                                ?> 
                        </span> को बिल न. 
                        <span class="bb">
                            <?php
                                echo !empty($direct_purchase_master[0]->recm_supplierbillno)?$direct_purchase_master[0]->recm_supplierbillno:'';
                            ?>
                        </span>
                        मिति 
                        <span class="bb">
                        <?php 
                            if($req_detail_list){
                                if(DEFAULT_DATEPICKER == 'NP'){
                            echo !empty($direct_purchase_master[0]->recm_supbilldatebs)?$direct_purchase_master[0]->recm_supbilldatebs:'';
                        }else{
                            echo !empty($direct_purchase_master[0]->recm_supbilldatead)?$direct_purchase_master[0]->recm_supbilldatead:'';
                        }
                            } else{ 
                                echo !empty($report_data['received_date'])?$report_data['received_date']:'';
                            }
                        ?>
                        </span>
                        बाट प्राप्त हुन आएको हुँदा जाची गन्ती गरी हेरी ठीक दुरुस्त भएकोले  खाता आम्दानी बाँदि प्रमाणित गरिएको छ ।
                    </td> 
                </tr> 
            </tfoot>
        </table> -->
    
        <table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
            <tr>
                <td colspan="3">उपर्युक्तअनुसार दाखिला प्रतिवेदन तयार गर्ने, जाँच गर्ने र स्वीकृत गर्ने:</td>
            </tr>
            <tr>
                <th style="padding-top: 30px;">फांटवालाको दस्तखत </th>
                <th style="padding-top: 30px;">भण्डार प्रमुखको दस्तखत </th>
                <th style="padding-top: 30px;">प्रमाणित गर्नेको दस्तखत</th>
            </tr>
            <tr>
                <td>नाम:</td>
                <td>नाम:</td>
                <td>नाम:</td>
            </tr>
            <tr>
                <td>पद:</td>
                <td>पद:</td>
                <td>पद:</td>
            </tr>
            <tr>
                <td>मिति: </td>
                <td>मिति: </td>
                <td>मिति: </td>
            </tr>
        </table>
    </div>
</div>