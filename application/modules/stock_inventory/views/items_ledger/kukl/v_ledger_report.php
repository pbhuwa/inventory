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
                    <td width="30%" class="text-right"><span style="text-align: right; white-space: nowrap;"></span></td>
                </tr>
                <tr>
                    <td width="25%" rowspan="5"></td>
                    <td class="text-center"><span style="font-size: 12px;font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></span></td>
                    <td width="25%" rowspan="5" class="text-right"></td>
                </tr>
            <tr>
                <td class="text-center" style="font-size: 12px;"><h4 style="font-size: 12px;margin-top: 5px;margin-bottom: 0px;"> <span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></span>  </h4></td>
            </tr>
                <tr style="margin-top: 3px;">
                <td class="text-center"><span><?php echo LOCATION; ?></span></td>
            </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-center"><h4 style="margin-top: 0px;"><u><span class="<?php echo FONT_CLASS; ?>"> सामान लेजर</span></u></h4></td>
                </tr>
            </table>

            <table class="jo_tbl_head" style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td><strong>Item Name: </strong><?php echo !empty($item_name[0]->itli_itemname)?$item_name[0]->itli_itemname:''; ?> </td>
                </tr>
                <tr>
                    <td><strong>Item Category: </strong><?php  $catcode=!empty($itemcat_name[0]->eqca_code)?$itemcat_name[0]->eqca_code:''; $catname=!empty($itemcat_name[0]->eqca_category)?$itemcat_name[0]->eqca_category:''; echo $catcode.'('.$catname.')'; ?> </td>
                </tr>
                <tr><td><strong>Unit: </strong><?php echo !empty($unit_name[0]->unit_unitname)?$unit_name[0]->unit_unitname:''; ?></td></tr>
                <tr><td><strong>Item Code.: </strong><?php echo !empty($item_name[0]->itli_itemcode)?$item_name[0]->itli_itemcode:''; ?> </td></tr>
            </table>

            <table class="jo_table itemInfo" style="width: 100%;border-collapse: collapse;margin-top: 20px;">
                <thead>
                    <tr>
                        <th rowspan="3">S.n.</th>
                        <th rowspan="3">Date</th>
                        <th colspan="11" style="white-space: nowrap;">आम्दानी</th>
                        <th colspan="11" style="white-space: nowrap;">खर्च</th>
                        <th colspan="2" rowspan="2" style="white-space: nowrap;">बाकी</th>
                        <th rowspan="2" style="white-space: nowrap; width: 100px;">कैफीयत</th>
                    </tr>

                    <tr>
                        <td colspan="3"><strong>हस्तान्तरण</strong> </td>
                        <td colspan="3"><strong>जिन्सी </strong> </td>
                        <td colspan="3"><strong>स्टाेर केडिटनाेट </strong></td>
                        <td colspan="2"><strong>जम्मा</strong></td>
                        <td colspan="3"><strong>जि नि सू बाट</strong>  </td>
                        <td colspan="3"><strong>हस्तान्तरण </strong></td>
                        <td colspan="3"><strong>बिक्री </strong></td>
                        <td colspan="2"><strong>जम्मा</strong></td>

                    </tr>

                    <tr>
                        <th>परि. </th>
                        <th>दर</th>
                        <th>रकम</th>
                        <th>परि. </th>
                        <th>दर</th>
                        <th>रकम</th>
                        <th>परि. </th>
                        <th>दर</th>
                        <th>रकम</th>
                        <th>परि. </th>
                        <th>रकम</th>
                        <th>परि. </th>
                        <th>दर</th>
                        <th>रकम</th>
                        <th>परि. </th>
                        <th>दर</th>
                        <th>रकम</th>
                        <th>परि. </th>
                        <th>दर</th>
                        <th>रकम</th>
                        <th>परि. </th>
                        <th>रकम</th>
                        <th>परि. </th>
                        <th>रकम</th>
                        <th></th>

                    </tr>
                </thead>
             <tbody>
                   <?php 
                   $i=1;
                    $blnqty_update=0.00;
                    $blnamt_update=0.00;
                   if(!empty($ledger_report) && is_array($ledger_report)):
                    $size_of_arr =sizeof($ledger_report);
                    foreach($ledger_report as $lr):
                    ?>
                    <?php 
                    if($lr->description=='Opening'): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>Opening</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                         <td>-</td>
                        <td>-</td>
                        <td><?php  $blnqty_update=$blnqty_update+$lr->pqty; echo number_format($lr->pqty,2); ?></td>
                        <td><?php $blnamt_update=$blnamt_update+$lr->recamt; echo number_format($lr->recamt,2); ?></td>
                       <td></td>

                    </tr>
                <?php else:  ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php 
                         echo $lr->date; ?></td>
                      
                        <td><?php echo $lr->hqty; ?></td>
                         <td><?php 
                            $hrrate =0.00; 
                            if($lr->hqty>0){ 
                            $hrrate= $lr->hdr_amount/$lr->hqty;
                            } 
                            echo number_format($hrrate,2); ?></td>
                         <td>
                        <?php 
                         $hramount=$lr->hdr_amount; echo number_format($hramount,2); 
                         ?></td>
                         <td>
                         <?php echo $lr->pqty; ?>
                         </td>
                         <td><?php 
                            $pu_rate =0.00; 
                            if($lr->pqty>0){ 
                            $pu_rate= $lr->recamt/$lr->pqty;
                            } 
                            echo number_format($pu_rate,2); ?></td>
                         <td>
                         <?php $puramount= $lr->recamt; echo number_format($puramount,2); ?>
                         </td>
                         <td>
                         <?php echo $lr->ret_qty; ?>
                         </td>
                         <td><?php 
                            $ret_rate =0.00; 
                            if($lr->ret_qty>0){ 
                            $ret_rate= $lr->ret_amount/$lr->ret_qty;
                            } 
                            echo number_format($ret_rate,2); ?></td>
                         <td>
                         <?php $pur_ret_amount= $lr->ret_amount; echo number_format($pur_ret_amount,2); ?>
                         </td>
                          <td><?php $total_income_qty= $lr->hqty+$lr->pqty+$lr->ret_qty; echo number_format($total_income_qty,2) ?></td>
                         <td><?php $total_income_amt= $lr->hdr_amount+$lr->recamt+$lr->ret_amount; echo number_format($total_income_amt,2) ?></td>

                         <td>
                         <?php echo $lr->hoqty; ?>
                         </td>
                         <td>
                         <?php echo $lr->iss_qty; ?>
                         </td>
                         <td><?php 
                            $iss_rate =0.00; 
                            if($lr->iss_qty>0){ 
                            $iss_rate= $lr->iss_amt/$lr->iss_qty;
                            } 
                            echo number_format($iss_rate,2); ?></td>
                         <td>
                       
                         <?php $iss_amt= $lr->iss_amt; echo number_format($iss_amt,2); ?>
                         </td>
                         <td><?php 
                            $hor_rate =0.00; 
                            if($lr->hoqty>0){ 
                            $hor_rate= $lr->hrdo_amount/$lr->hoqty;
                            } 
                            echo number_format($hor_rate,2); ?></td>
                         <td>
                       
                         <?php $exp_hrdo_amount= $lr->hrdo_amount; echo number_format($exp_hrdo_amount,2); ?>
                         </td>
                        
                         <td>0.00</td>
                         <td>0.00</td>
                         <td>0.00</td>
                         <td><?php 
                         $total_exp_qty=$lr->hoqty+$lr->iss_qty;
                         echo number_format($total_exp_qty,2);

                         ?></td>
                         <td><?php 
                            $total_exp_amt=$exp_hrdo_amount+$iss_amt;
                            echo number_format($total_exp_amt,2);
                         ?></td>
                         <td>
                             <?php 

                             $blnqty=$total_income_qty-$total_exp_qty;
                             $blnqty_update=$blnqty_update+$blnqty;
                             echo number_format($blnqty_update,2);
                              ?>
                         </td>
                         <td>
                              <?php 
                             
                             $blnamt=$total_income_amt-$total_exp_amt;

                               
                             $blnamt_update=$blnamt_update+$blnamt;
                              echo number_format( $blnamt_update,2);
                              ?>
                         </td>
                        
                         <td></td> 

                    </tr>
                    <?php
                endif;
                    $i++;
                    endforeach;
                    endif;
                   ?>
                   <tr>
                       <td><?php echo $i; ?></td>
                       <td>Closing</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                         <td>-</td>
                        <td>-</td>
                        <td><?php  $blnqty_update=$blnqty_update; echo number_format($blnqty_update,2); ?></td>
                        <td><?php $blnamt_update=$blnamt_update; echo number_format($blnamt_update,2); ?></td>
                       <td></td>

                   </tr>
            </table>
            <table class="jo_footer" style="width: 100%;border-collapse: collapse;margin-top: 70px;">
                <tr>
                    <td width="33.333333333%" style="text-align: left;white-space: nowrap;">
                         <div style="display: inline-block; text-align: left;">
                         स्टोर प्रमुखको  दस्तखत<br />
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