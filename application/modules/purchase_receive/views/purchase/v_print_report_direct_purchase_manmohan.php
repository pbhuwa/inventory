<style> 
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
    .bb{border-bottom:1px dotted #333;}
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
    .jo_table tr:last-child td:nth-child(2){border: 0px;}
    .jo_table tr:last-child td:last-child{border-left: 0px;}
    .tableWrapper{
        min-height:57%;
        height:57vh;
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
    }
    .itemInfo .td_empty{
        height:100%;
    }  
    .footerWrapper{
        page-break-inside: avoid;
    }
    img.signatureImage{
        width: 70px;
    }
    .borderbottom { 
        border-bottom: 1px dashed #333; padding-bottom: 0px;
    }
    .dateDashedLine{
        min-width: 100px;display: inline-block; border:1px dashed #333;
    }
    .signatureDashedLine {
        min-width: 130px;display: inline-block; border:1px dashed #333;
    }
</style>

<div class="jo_form organizationInfo">
    <div class="headerWrapper">
        <?php 
            $header['report_no'] = 'म.ले.प.फा.नं ४६';
            $header['report_title'] = 'दाखिला प्रतिबेदन फारम';
            $this->load->view('common/v_print_report_header',$header);
        ?>

        <table class="jo_tbl_head">
            <tr>
                <td><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> दाखिला   प्रतिबेदन न </span> :
                    <span class="bb"> 
                    <?php 
                    if($req_detail_list){
                     echo !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';  
                    } else{
                    echo !empty($report_data['suplier_bill_no'])?$report_data['suplier_bill_no']:'';
                    } ?>  
                    </span>
                </td>
                <td width="17%" class="text-right " style="white-space: nowrap;">मिति : 
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
        </table>
    </div>
        
    <div class="tableWrapper">
        <table  class="jo_table itemInfo" style="border-bottom: 1px solid #333; width: 100%;table-layout: fixed;vertical-align: middle;">
            <thead>
                <tr>
                    <th width="5%"  rowspan="2" class="td_cell">क्र. सं.</th>
                    <th width="10%" rowspan="2" class="td_cell">जिन्सी वर्गीकरण संकेत नं</th>
                    <th width="12%" rowspan="2" class="td_cell">सामानको नाम </th>
                    <th width="12%" rowspan="2" class="td_cell">स्पेसीफिकेसन</th>
                    <th width="5%"  rowspan="2" class="td_cell">एकाइ </th>
                    <th width="7%"  rowspan="2" class="td_cell">परिमाण</th>
                    <th width="39%"  colspan="5" class="td_cell">मूल्य(इन्भ्वाइस अनुसार)</th>
                    <th width="10%" rowspan="2" class="td_cell">कैफियत </th>
                </tr>
                <tr>
                    <th width="20%" class="td_cell"> प्रती इकाई दर(%)</th>
                    <th width="20%" class="td_cell"> मू अ कर (%)</th>
                    <th width="20%" class="td_cell">  इकाई  मुल्य</th>
                    <th width="20%" class="td_cell">  अंय खर्च </th>
                    <th width="20%" class="td_cell">  जम्मा </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>१</td>
                    <td>२</td>
                    <td>३</td>
                    <td>४</td>
                    <td>५</td>
                    <td>६</td>
                    <td>७</td>
                    <td>८</td>
                    <td>९</td>
                    <td>१०</td>
                    <td>११</td>
                    <td>१२</td>
                </tr>
                <?php if($req_detail_list){ //echo "<pre>"; print_r($req_detail_list);die;
                    $sum= 0; $vatsum=0;
                    foreach ($req_detail_list as $key => $direct) { ?>
                <tr style="border-bottom: 1px solid #212121;">
                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php echo $key+1; ?>
                    </td>
                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php echo !empty($direct->itli_itemcode)?$direct->itli_itemcode:''; ?>
                    </td>
                    <td width="500px" class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                         <?php 
                          if(ITEM_DISPLAY_TYPE=='NP')
                            {
                                 echo !empty($direct->itli_itemnamenp)?$direct->itli_itemnamenp:$direct->itli_itemname;
                            }
                            else
                            {
                                 echo  !empty($direct->itli_itemname)?$direct->itli_itemname:'';
                            } 
                         ?>
                    </td>
                      <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                    </td>
                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>
                    </td>

                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php echo $direct->recd_purchasedqty; ?>
                    </td>

                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php echo !empty($direct->recd_unitprice)?$direct->recd_unitprice:''; ?>
                    </td>
                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php echo $direct->recd_discountamt; ?>
                    </td>
                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php 
                        $vat=($direct->recd_unitprice * $direct->recd_vatpc)/100;
                        $withvat=($direct->recd_unitprice + $vat);
                         echo $withvat;
                        ?>
                    </td>
                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;"></td>
                    <td class="td_cell" style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php echo $direct->recd_amount; ?>
                    </td>
                    <td style=" text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                        <?php echo $direct->recd_description; ?>
                    </td>
                </tr>
                <?php
                        $sum += $direct->recd_discountamt;
                        $vatsum += $direct->recd_vatamt;
                    }
                    $row_count = count($req_detail_list);
                    if($row_count < 12): ?>
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
                </tr>
            <?php endif;
                $total = $direct->recm_clearanceamount;
            ?> 
                <tr>
                    <td colspan="10"  style="text-align: right">
                        <span style="font-size: 12px;font-weight: 600;" class="<?php echo FONT_CLASS; ?>">कुल छूट रकम</span>: 
                    </td>
                    <td><?php echo !empty($sum)?number_format($sum,2):''; ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="10"  style="text-align: right">
                         <span style="font-size: 12px;font-weight: 600;" class="<?php echo FONT_CLASS; ?>">कूल  भ्याट रकम </span>:
                    </td>
                    <td><?php echo !empty($vatsum)?number_format($vatsum,2):''; ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="10"  style="text-align: right;overflow: hidden; text-overflow: ellipsis;">
                        <span style="font-size: 12px;font-weight: 600;" class="<?php echo FONT_CLASS; ?>">कूल  जम्मा </span>:
                    </td>
                    <td colspan="2">
                        <?php echo !empty($total)?number_format($total,2):''; ?>
                    </td>
                </tr>
                <?php }
                 else { ?>
                    <?php 
                    $itemid = !empty($report_data['itemsid'])?$report_data['itemsid']:'';
                    if(!empty($itemid)): // echo"<pre>";print_r($itemid);die;
                    $sumt= 0;
                    foreach($itemid as $key=>$products):
                ?>
                <tr>
                    <td class="td_cell">
                        <?php echo $key+1; ?>
                    </td>

                    <td class="td_cell">
                        <?php echo !empty($report_data['puit_barcode'][$key])?$report_data['puit_barcode'][$key]:''; ?>
                    </td>
                    <td class="td_cell">
                        <?php 
                            $itemid = !empty($report_data['trde_itemsid'][$key])?$report_data['trde_itemsid'][$key]:'';
                            $itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');    
                        ?>
                         <?php 
                          if(ITEM_DISPLAY_TYPE=='NP')
                            {
                                 echo !empty($itemname[0]->itli_itemnamenp)?$itemname[0]->itli_itemnamenp:$itemname[0]->itli_itemname;
                            }
                            else
                            {
                                 echo  !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';
                            } 
                         ?>
                    </td>
                    <td class="td_cell">
                      
                    </td>
                    <td class="td_cell">
                        <?php 
                           echo !empty($report_data['unit'][$key])?$report_data['unit'][$key]:'';
                        ?>
                    </td>
                    <td class="td_cell">
                        <?php echo !empty($report_data['puit_qty'][$key])?$report_data['puit_qty'][$key]:''; ?>
                    </td>
                    <td class="td_cell">
                        <?php echo !empty($report_data['puit_unitprice'][$key])?$report_data['puit_unitprice'][$key]:''; ?>
                    </td>
                    <td class="td_cell">
                        <?php echo !empty($report_data['vat'][$key])?$report_data['vat'][$key]:''; ?>
                    </td>
                    <td class="td_cell">
                        <?php   $unittotal = ($report_data['puit_unitprice'][$key] * $report_data['vat'][$key]) /100;

                        echo !empty($report_data['puit_unitprice'][$key])?$report_data['puit_unitprice'][$key]+number_format($unittotal):''; ?>
                    </td>
                    <td class="td_cell">   
                    </td>
                    <td class="td_cell">
                        <?php
                         echo !empty($report_data['totalamt'][$key])?$report_data['totalamt'][$key]:''; ?>
                    </td>
                    <td class="td_cell">
                         <?php $itemName = !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';
                            $desc = !empty($report_data['description'][$key])?$report_data['description'][$key]:'';
                            echo !empty($report_data['description'])?$itemName.''. $desc:'';
                            ?>
                    </td>
                </tr>
                <?php $sumt += !empty($report_data['amount'][$key])?$report_data['amount'][$key]:'';
                    endforeach;
                    endif;
                ?>
                <?php $row_count = count($report_data['itemsid']);
                    if($row_count < 12): ?>
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
                </tr>
                <?php endif;?>
                <tr>
                    <td colspan="10"  style="text-align: right">
                        <span class="<?php echo FONT_CLASS; ?>">कुल छूट रकम</span>: 
                    </td>
                    <td><?php echo !empty($report_data['discountamt'])?number_format($report_data['discountamt'],2):''; ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="10"  style="text-align: right">
                         <span class="<?php echo FONT_CLASS; ?>">कूल  भ्याट रकम </span>:
                    </td>
                    <td><?php echo !empty($report_data['taxamt'])?number_format($report_data['taxamt'],2):''; ?></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="10"  style="text-align: right">
                        <span class="<?php echo FONT_CLASS; ?>">कूल  जम्मा </span>:
                    </td>
                    <td>
                        <?php echo !empty($report_data['clearanceamt'])?number_format($report_data['clearanceamt'],2):''; ?>
                    </td>
                    <td></td>
                </tr>
                <?php } ?>
                <tr>
                   <!--  <td colspan="4"></td> -->
                 <!--    <td colspan="12" style="white-space: nowrap;text-align: center;">शब्दमा : 
                        <?php 
                            if($req_detail_list){
                                //echo $this->general->number_to_word($total);
                            }else{
                                //echo $this->general->number_to_word($report_data['clearanceamt']);
                            } 
                        ?> 
                    </td> -->
                    <!-- <td colspan="6"></td> -->
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="footerWrapper">
        <table class="jo_footer" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;page-break-inside: avoid;">
            <tfoot>
                <tr>
                    <td style="padding: 10px;">
                        <span class="<?php echo CURDATE_NP;?>">माथि उल्लेखित मालसमानहरु खरिद आदेश नम्बर </span> /
                        <span class="<?php echo CURDATE_NP;?>">हस्तान्तरण फारम नम्बर </span><span class="bb">
                            <?php 
                                if($req_detail_list)
                                {
                                    echo !empty($req_detail_list[0]->recm_purchaseorderno)?$req_detail_list[0]->recm_purchaseorderno:'';
                                }else{
                                    echo !empty($report_data['orderno'])?$report_data['orderno']:'';
                                }   
                            ?>
                        </span> मिति <span class="bb">
                            <?php if($req_detail_list){
                            echo !empty($req_detail_list[0]->recd_postdatebs)?$req_detail_list[0]->recd_postdatebs:'';
                        } else{ 
                            echo !empty($report_data['received_date'])?$report_data['received_date']:'';
                        }?>
                            </span> अनुसार श्री  <span class="bb">
                        <?php if($req_detail_list)
                        {
                        echo !empty($req_detail_list[0]->dist_distributor)?$req_detail_list[0]->dist_distributor:'';
                        } else{
                        $supid =  !empty($report_data['supplier'])?$report_data['supplier']:'';
                     $supname = $this->general->get_tbl_data('*','dist_distributors',array('dist_distributorid'=>$supid),'dist_distributor','ASC'); echo  !empty($supname[0]->dist_distributor)?$supname[0]->dist_distributor:''; }?> </span> बाट प्राप्त हुन आएको हुँदा जाची गन्ती गरी हेर्दा ठीक दुरुस्त भएकोले  खाता आम्दानी बाँघेको प्रमाणित गर्दछु । </span>
                </td> 
            </tr>
            </tfoot>
            
        </table>

        <?php
            if(DEFAULT_DATEPICKER == 'NP'){
                $recv_date = !empty($direct_purchase_master[0]->recm_receiveddatebs)?$direct_purchase_master[0]->recm_receiveddatebs:'';
            }else{
                $recv_date = !empty($direct_purchase_master[0]->recm_receiveddatead)?$direct_purchase_master[0]->recm_receiveddatead:'';
            }
        ?>

       <table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
            <tr>
                <th>फांटवालाको दस्तखत 
                    <div>
                        <?php
                            if(!empty($user_signature->usma_signaturepath)):
                        ?>
                        <img src="<?php echo base_url(SIGNATURE_UPLOAD_PATH).'/'.$user_signature->usma_signaturepath; ?>" alt="" class="signatureImage">
                        <?php
                            else:
                        ?>
                        <span class="signatureDashedLine" style="margin-top: 30px;"></span>
                        <?php
                            endif;
                        ?> 
                    </div>
                </th>
                <th>शाखा प्रमुखको दस्तखत 
                    <div> 
                        <span class="signatureDashedLine" style="margin-top: 30px;"></span>
                    </div>
                </th>
                <th>कार्यालय प्रमुखको दस्तखत
                    <div> 
                        <span class="signatureDashedLine" style="margin-top: 30px;"></span>
                    </div>
                </th>
            </tr>
            <tr>
                <td>नाम:
                    <span class="borderbottom">
                        <?php echo !empty($user_signature->usma_fullname)?$user_signature->usma_fullname: '';?>
                    </span> 
                </td>

                <td>नाम:
                    <?php
                        if(!empty($store_head_signature->usma_fullname)):
                    ?>
                    <span class="borderbottom">
                        <?php echo !empty($store_head_signature->usma_fullname)?$store_head_signature->usma_fullname: '';?>
                    </span> 
                    <?php
                        else:
                    ?>
                        <span class="dateDashedLine"></span>
                    <?php
                        endif;
                    ?>
                </td>

                <td>नाम:
                    <?php
                        if(!empty($approver_signature->usma_fullname)):
                    ?>
                    <span class="borderbottom">
                        <?php echo !empty($approver_signature->usma_fullname)?$approver_signature->usma_fullname: '';?>
                    </span> 
                    <?php
                        else:
                    ?>
                        <span class="dateDashedLine"></span>
                    <?php
                        endif;
                    ?>
                </td>
            </tr>
            <tr>
                <td>पद:
                    <span class="borderbottom">
                        <?php echo !empty($user_signature->usma_designation)?$user_signature->usma_designation: '';?>
                    </span> 
                </td>
                <td>पद:
                    <?php
                        if(!empty($store_head_signature->usma_designation)):
                    ?>
                    <span class="borderbottom">
                        <?php echo !empty($store_head_signature->usma_designation)?$store_head_signature->usma_designation: '';?>
                    </span> 
                    <?php
                        else:
                    ?>
                        <span class="dateDashedLine"></span>
                    <?php
                        endif;
                    ?>
                </td>
                <td>पद:
                    <?php
                        if(!empty($approver_signature->usma_designation)):
                    ?>
                    <span class="borderbottom">
                        <?php echo !empty($approver_signature->usma_designation)?$approver_signature->usma_designation: '';?>
                    </span> 
                    <?php
                        else:
                    ?>
                        <span class="dateDashedLine"></span>
                    <?php
                        endif;
                    ?>
                </td>
            </tr>
            <tr>
                <td>मिति: 
                    <span class="borderbottom">
                        <?php echo $recv_date; ?>
                    </span>
                </td>
                <td>मिति: 
                    <span class="borderbottom">
                        <?php echo $recv_date; ?>
                    </span>
                </td>
                <td>मिति: 
                    <span class="borderbottom">
                        <?php echo $recv_date; ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
</div>