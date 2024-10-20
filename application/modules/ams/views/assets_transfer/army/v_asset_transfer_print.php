<style>
.table_jo_header,
.jo_tbl_head,
.jo_table,
.jo_footer {
    width: 100%;
    font-size: 12px;
    border-collapse: collapse;
}
.table_jo_header {
    width: 100%;
    vertical-align: top;
    font-size: 12px;
}
.table_jo_header td.text-center {
    text-align: center;
}
.table_jo_header td.text-right {
    text-align: right;
}
h4 {
    font-size: 18px;
    margin: 0;
}
.table_jo_header u {
    text-decoration: underline;
    padding-top: 15px;
}
.jo_table {
    border-right: 1px solid #333;
    margin-top: 5px;
}
.jo_table tr th {
    border-top: 1px solid #333;
    border-bottom: 1px solid #333;
    border-left: 1px solid #333;
}
.jo_table tr th {
    padding: 5px 3px;
}
.jo_table tr td {
    padding: 3px 3px;
    height: 15px;
    border-left: 1px solid #333;
}
.jo_footer {
    border: 1px solid #333;
    vertical-align: top;
}
.jo_footer td {
    padding: 8px 8px;
}
.preeti {
    font-family: preeti;
}
\---------- my-codes----\\ .organizationInfo .footerWrapper {
    margin: 0px 0 0 0;
}
.footerWrapper th {
    padding: 10px 0 10px 4px;
}
tbody.upper-section,
.lower-section {
    text-align: left;
    border-bottom: 1px solid#000;
}
.jo_footer td {
    padding: 5px 0 5px 5px !important;
}
.tableWrapper {
    min-height: 20%;
    height: 20vh;
    max-height: 20vh;
    white-space: nowrap;
    display: table;
    width: 100%;
    /*overflow-y: auto;*/
    /*margin-top: -5px !important; */
}
.itemInfo thead tr:first-child {
    text-align: left;
}
\---------- my-codes----\\ .itemInfo {
    height: 100%;
}
.itemInfo .td_cell {
    padding: 5px;
    margin: 5px;
}
.itemInfo .td_empty {
    height: 100%;
}
.jo_table tr td {
    border-bottom: 1px solid #000;
    padding: 0px 4px;
}
    /*.itemInfo tr:last-child td{border:0px !important;}
    .itemInfo {border-bottom: 0px;}*/
    .footerWrapper {
        page-break-inside: avoid;
    }
    .dateDashedLine {
        min-width: 100px;
        display: inline-block;
        border: 1px dashed #333;
    }
    .signatureDashedLine {
        min-width: 170px;
        display: inline-block;
        border: 1px dashed #333;
    }
    .jo_footer img {
        margin-top: -15px;
        margin-left: 10px;
    }
    img.signatureImage {
        width: 70px;
    }
    .bold_title {
        font-weight: bold;
    }
</style>
<div class="jo_form organizationInfo">
    <div class="headerWrapper">
        <?php
        $header['report_no'] = '';
        $header['report_title'] = 'निकासी फाराम';
        $this->load->view('common/v_print_report_header', $header);
        ?>
        
    </div>
    <div class="tableWrapper" style="margin-top: 10px;">
        <table class="jo_table itemInfo" style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <thead>
                <tr>
                    <?php
                    $location = !empty($transfer_data[0]->loca_name) ? $transfer_data[0]->loca_name . ", " : '';
                    ?>
                    <td colspan="2"><strong>मागको प्रकारः</strong>: जिम्मेवारी</td>
                    <td colspan="2" rowspan="2">माग पेश गर्नेः
                        <?php
                      
                      echo !empty($transfer_data[0]->fromschoolname) ? $transfer_data[0]->fromschoolname : '';
                        ?>
                    </td>
                    <td rowspan="2" colspan="3">निकासी गर्नेेः
                        <?php
                        echo !empty($transfer_data[0]->toschoolname) ? $transfer_data[0]->toschoolname : '';
                        ?>
                        <br>
                        मितिः <?php echo !empty($transfer_data[0]->astm_transferdatebs) ? $transfer_data[0]->astm_transferdatebs : ''; ?> गते ।
                    </td>
                    <td colspan="4">निकाशी नं. : <?php echo !empty($transfer_data[0]->astm_transferno) ? $transfer_data[0]->astm_transferno : ''; ?>
                </td>
            </tr>
            <tr>
                <td colspan="4">माग नम्बर : _______</td>
                <td colspan="4">सामान राखेको ठाउँ: </td>
            </tr>
            <tr>
                <td colspan="5">अख्तियारीः त्यस कलेजको माग फारमको श्री कार्यकारी निर्देशक ज्युबाट स्वीकृती भए बमोजिम</td>
                <td colspan="6">सामान आवश्यकताको कारण: त्यस महाविद्यालयको प्रयोजनको लागी</td>
            </tr>
                <tr>
                    <th width="5%" class="td_cell" style="text-align: center">खाता पाना नं.</th>
                    <th width="10%" class="td_cell" style="text-align: center">सेक्सन क्याट/पार्ट फेडरल स्टक नंं</th>
                    <th width="30%" class="td_cell" style="text-align: center">सामानको विवरण </th>
                    <th width="5%" class="td_cell" style="text-align: center">मागेको</th>
                    <th width="5%" class="td_cell" style="text-align: center">इकाई</th>
                    <th width="5%" class="td_cell" style="text-align: center">स्वीकृति दिएको</th>
                    <th width="5%" class="td_cell" style="text-align: center">निकाशी गरेको</th>
                    <th width="5%" class="td_cell" style="text-align: center">पछि दिने</th>
                    <th width="10%" class="td_cell" style="text-align: center">मुल्य प्रति इकाई भ्याट सहित</th>
                    <th width="10%" class="td_cell" style="text-align: center">जम्मा</th>
                    <th width="30%" class="td_cell" style="text-align: center">कैफियत</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($transfer_data) {
                    $gtotal = 0;
                    foreach ($transfer_data as $key => $products) :
                        ?>
                        <tr>
                            <td class="td_cell" style="text-align: center">
                                <?php //echo $key + 1; 
                                ?>
                                <?php echo $products->itli_itemcode; ?>
                            </td>
                            <td></td>
                            <td class="td_cell" style="text-align: center">
                                <?php
                                if (ITEM_DISPLAY_TYPE == 'NP') {
                                    echo !empty($products->itli_itemnamenp) ? $products->itli_itemnamenp : $products->itli_itemname;
                                } else {
                                    echo !empty($products->itli_itemname) ? $products->itli_itemname : '';
                                }
                                echo "<br>";
                                $assets_list=!empty($products->asid_assetid)?$products->asid_assetid:'';
                                $unit_prate=0;
                                if(!empty($assets_list)){
                                    $list_assets=explode(',', $assets_list);
                                   
                                    $this->db->select('asen_assetcode,asen_purchaserate');
                                    $this->db->from('asen_assetentry');
                                    $this->db->where_in('asen_asenid',$list_assets);
                                    $asset_result=$this->db->get()->result();
                                    $temp_assets_code='';
                                    if(!empty($asset_result)){
                                        $unit_prate=!empty($asset_result[0]->asen_purchaserate)?$asset_result[0]->asen_purchaserate:'0.00';
                                        
                                      
                                    }

                                    

                                }
                                   echo '<strong>('.$products->asen_assetcode.')</strong>';
                                
                                ?>
                            </td>
                            <td class="td_cell">
                                1
                            </td>
                            <td class="td_cell" style="text-align: right;">
                                <?php $unit = !empty($products->unit_unitname) ? $products->unit_unitname : ''; ?>
                                <?php echo $unit; ?>
                            </td>
                            <td class="td_cell" style="text-align: right;">
                                 1
                            </td>
                            <td class="td_cell" style="text-align: center">
                               1
                            </td>
                           
                        <td class="td_cell" style="text-align: right;">
                           0
                        </td>
                        <td class="td_cell" style="text-align: right;">
                          
                            <?php echo $products->astd_originalamt; ?>
                               
                            </td>
                        <td class="td_cell" style="text-align: right;">
                            <?php 
                                $stotal=1*$products->astd_originalamt; 
                                $gtotal+=$stotal; 
                                if($stotal>0): echo number_format($stotal,2); endif; ?>
                        </td>
                            <td class="td_cell" style="text-align: center">
                                <?php $p_remarks = !empty($products->astd_remark) ? $products->astd_remark : ''; ?>
                                <?php echo $p_remarks; ?>
                            </td>
                        </tr>
                        <?php
                        
                    endforeach;
                    ?>
                    <?php
                    $products = array();
                    $row_count = count($products);
                    if ($row_count < 10) :
                        ?>
                        <tr>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                            <td class="td_empty" style="text-align: center"></td>
                        </tr>
                    <?php endif ?>
                <?php } ?>
                    
                   
                   
       
       
<tr style="height:350px;">
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
    <td style="text-align: center"></td>
</tr>
<tr>
    <td colspan="7"><span style="font-size: 12px;" class="bold_title"> अक्षरेपी : </span> <?php echo $this->general->number_to_word($gtotal); ?> </td>
    <td colspan="3" style="text-align: right;">
        <span style="font-size: 12px;" class="bold_title">कुल जम्मा :
        </span>
        <?php echo !empty($gtotal) ? number_format($gtotal,2) : '0'; ?>
    </td>
    <td></td>
</tr>
</tbody>
</table>
</div>
<div class="footerWrapper" style="margin-top:5px;">
    <table class="jo_footer" style="padding-top: 10px;padding-bottom: 10px;border: 1px solid #000;border-top: 1px solid black;page-break-inside: avoid !important;margin: 0px 0 0 0;">
        <tbody class="upper-section">
            <tr>
                <th colspan="5" style="border-right: 1px solid#000;">अड्डा प्रमुखको दस्तखत
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->demander . '(' . $user_list_for_issue_report[0]->demander_userid . ')';
                            ?> -->
                        </th>
                        <th colspan="5" style="border-right: 1px solid#000;">श्रेस्ता चढाउनेको सही
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->receiver;
                            ?> -->
                        </th>
                        <th colspan="5" style="border-right: 1px solid#000;">सामान बुझिलिनेको सही
                        <!-- <?php
                                echo $get_branch_manager_name[0]->usma_fullname;
                            ?> -->
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->storekeeper . '(' . $user_list_for_issue_report[0]->storekeeper_userid . ')';
                            ?> -->
                        </th>
                    </tr>
                    <tr>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                    </tr>
                </tbody>
                <tbody class="upper-section">
                    <tr>
                        <th colspan="5" style="border-right: 1px solid#000;">
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->demander . '(' . $user_list_for_issue_report[0]->demander_userid . ')';
                            ?> -->
                        </th>
                        <th colspan="5" style="border-right: 1px solid#000;">ग्रुपवालाको सहीः
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->receiver;
                            ?> -->
                        </th>
                        <th colspan="5" style="border-right: 1px solid#000;">
                        <!-- <?php
                                echo $get_branch_manager_name[0]->usma_fullname;
                            ?> -->
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->storekeeper . '(' . $user_list_for_issue_report[0]->storekeeper_userid . ')';
                            ?> -->
                        </th>
                    </tr>
                    <tr>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                    </tr>
                </tbody>
                <tbody class="lower-section">
                    <tr>
                        <th colspan="5" style="border-right: 1px solid#000;">
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->storekeeper . '(' . $user_list_for_issue_report[0]->storekeeper_userid . ')';
                            ?> -->
                        </th>
                        <th colspan="5" style="border-right: 1px solid#000;">
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->storekeeper . '(' . $user_list_for_issue_report[0]->storekeeper_userid . ')';
                            ?> -->
                        </th>
                        <!-- <th colspan="4" style="border-right: 1px solid#000;">निकासी गर्ने  :- -->
                    <!-- <?php
                            echo $user_list_for_issue_report[0]->storekeeper . '(' . $user_list_for_issue_report[0]->storekeeper_userid . ')';
                        ?> -->
                        <!-- </th> -->
                        <th colspan="5" style="border-right: 1px solid#000;">मितिः_________ गते ।
                        <!-- <?php
                                echo $user_list_for_issue_report[0]->supervisor . '(' . $user_list_for_issue_report[0]->supervisor_userid . ')';
                            ?> -->
                        </th>
                    </tr>
                    <tr>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                        <td colspan="5" style="border-right: 1px solid#000;"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>