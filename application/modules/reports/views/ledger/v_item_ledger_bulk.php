<style>
    @media print {
    .table-wrapper {
        display:block;
        height:auto;
        page-break-after: always;
        overflow:visible
    }
    .jo_table tr {
        border-bottom: 1px solid #333;
    }
    .jo_table tr th {
        border-top: 1px solid #333;
        border-bottom: 1px solid #333;
        border-left: 1px solid #333;
    }
    .jo_table tr td {
            padding: 5px 3px;
    height: 15px;
    border-left: 1px solid #333;
    font-size: 12px;
    }
    .jo_table {
    border-right: 1px solid #333;
    border-bottom: 1px solid #000;
    }
    .jo_table tr th {
    padding: 5px 3px;
    font-weight: bold;
    text-align: center;
}
}
</style>

  <div >
  <?php
    $header['report_no'] = 'म.ले.प.फा.नं ४०८';
    $header['old_report_no'] = 'साबिकको फारम न. ४७';
    if(ORGANIZATION_NAME == 'ARMY'){
        $header['report_no'] = 'सै.क.काे.ष फा.नं २५';
    }
    $header['report_title'] = 'जिन्सी सामानको खाता';

    $this->load->view('stock_report/v_stock_report_header',$header);
    ?>
    <!-- <table class="table_jo_header purchaseInfo">
                <tr>
                    <td></td>
                    <td class="text-center"><span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE ;?></span></td>
                    <td width="30%" class="text-right"><span style="text-align: right; white-space: nowrap;">
                        <?php 
                        if (ORGANIZATION_NAME == 'ARMY') {
                           echo 'सै.क.काे.ष फा.नं २५';}else{
                           echo 'म.ले.प.फा.नं ४०८';
                        }?> 
             </span></td>
                </tr>
                <tr>
                    <td width="25%" rowspan="5"></td>
                    <td class="text-center"><span style="font-size: 18px;font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></span></td>
                    <td width="25%" rowspan="5" class="text-right"></td>
                </tr>
            <tr>
                <td class="text-center" style="font-size: 12px;"><h4 style="font-size: 12px !important;margin-top: 5px;margin-bottom: 0px;"> <span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></span>  </h4></td>
            </tr>
                <tr style="margin-top: 3px;">
                <td class="text-center"><span><?php echo LOCATION; ?></span></td>
            </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-center"><h4 style="margin-top: 0px;"><u><span class="<?php echo FONT_CLASS; ?>">जिन्सी सामानको खाता</span></u></h4></td>
                </tr>
            </table> -->

<table class="jo_tbl_head" style="width: 100%;border-collapse: collapse; margin-top: 20px;">
    <tr>
        <td><strong>जिन्सी सामानको नाम: </strong><?php echo $itemname=!empty($item_name[0]->itli_itemname)?$item_name[0]->itli_itemname:''; ?> </td>
    </tr>
    <tr><td><strong>ईकाइ: </strong><?php echo !empty($unit_name[0]->unit_unitname)?$unit_name[0]->unit_unitname:''; ?></td></tr>
    <tr><td><strong>जिन्सी सामानको सम्पत्ति वर्गीकरण संकेत न.: </strong><?php  echo $itemcode =!empty($item_name[0]->itli_itemcode)?$item_name[0]->itli_itemcode:''; ?> </td></tr>
</table>

<table class=" table table-striped alt_table" style="width: 100%;border-collapse: collapse;margin-top: 20px;">
    <thead>
        <tr>
            <th rowspan="2">क्र. सं.</th>
            <th rowspan="2">मिति</th>
            <th rowspan="2" style="white-space: nowrap;">दाखिला निकासी न</th>
            <th rowspan="2" style="white-space: nowrap;">स्पेसीफिकेसन</th>
            <th colspan="4" style="white-space: nowrap;">विवरण </th>
            <th colspan="3" style="white-space: nowrap;">आमदानी</th>
            <th colspan="2" style="white-space: nowrap;">खर्च</th>
            <th colspan="2" style="white-space: nowrap;">बाकी</th>
            <th rowspan="2" style="white-space: nowrap; width: 100px;">कैफीयत</th>
        </tr>
        <tr>
            <th>उत्पादन गर्नेदेश वा कम्पनीको नाम</th>
            <th>साईज</th>
            <th>अनुमानि आयु</th>
            <th style="width: 80px;">अनुमानि प्राप्त भएको  साव</th>
            <th>परिमाण </th>
            <th>प्रति एकाइ मल्य</th>
            <th>जम्मा परल मुल्य</th>
            <th>परिमाण </th>
            <th>जम्मा परल मुल्य</th>
            <th>परिमाण </th>
            <th>जम्मा परल मुल्य</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $balance_qty = 0;
        $balance_amt = 0;
        $total_balance_amt = 0;
        $key = 1;
        $db_array = [];
        if(!empty($ledger_report)):
            foreach($ledger_report as $report):
                $income_qty = $report->inc_qty;
                $expense_qty = $report->exp_qty;

                $balance_qty +=($income_qty-$expense_qty);
                $income_amt = 0;
                $expense_amt = 0;
                if($income_qty > 0){
                    $income_amt = round($report->total_amt,2);
                }
                if($expense_qty > 0){
                    $expense_amt = round($report->total_amt,2);
                }

                $balance_amt = $income_amt - $expense_amt;
                if($balance_amt < 0)
                {
                    $balance_amt = -($balance_amt);

                }
                $total_balance_amt += $balance_amt;

                ?>
                <tr <?php if($key == 1){echo "style='font-weight:bold;background: #c3c3c3;'";} ?>>
                    <td><?php echo $key; ?></td>
                    <td>
                        <?php

                        if(DEFAULT_DATEPICKER == 'NP'){
                            echo !empty($report->datebs)?$report->datebs:'';
                        }else{
                            echo !empty($report->datead)?$report->datead:'';
                        }
                        ?>    
                    </td>
                    <td><?php echo !empty($report->refno)?$report->refno:'';?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo !empty($report->inc_qty)? sprintf("%g",$report->inc_qty):0;?></td>
                    <td style="text-align: right;"><?php echo !empty($report->rate)?number_format($report->rate,2):0;?></td>
                    <td style="text-align: right;"><?php echo !empty($income_amt)?number_format($income_amt,2):0;?></td>
                    <td><?php echo !empty($report->exp_qty)?sprintf("%g",$report->exp_qty):0;?></td>
                    <td style="text-align: right;"><?php echo !empty($expense_amt)?number_format($expense_amt,2):0;?></td>
                    <td style="text-align: right;"><?php echo !empty($balance_qty)?$balance_qty:0;?></td>
                    <?php // $this->ledger_mdl->check_auto_bulk_ledger($itemcode,$itemname,$balance_qty) ?>
                    <td style="text-align: right;"><?php echo !empty($balance_amt)?number_format($balance_amt,2):0;?></td>
                    <td><?php echo $report->type; ?></td>
                </tr>
                <?php 
                $key++;
            endforeach;
             $db_array = array(
                            'item_id' => $item_name[0]->itli_itemlistid ?? '',
                            'item_code' => $item_name[0]->itli_itemcode ?? '', 
                            'item_name' => $item_name[0]->itli_itemname ?? '',
                            'balance' => $balance_qty
                        ); 
             if(!empty($db_array)){
                $this->db->insert('item_ledger_balance',$db_array);
             }
            ?>
            <tr style="font-weight:bold;background: #c3c3c3;">
                <td><?php echo $key; ?></td>
                <td>-</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td style="text-align: right;"><?php echo $balance_qty; ?></td>
                <td style="text-align: right;"><?php echo number_format($balance_amt,2);?></td>
                <td>Closing</td>
            </tr>
            <?php 
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