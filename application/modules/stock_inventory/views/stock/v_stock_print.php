<style> 
    .table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
    .table_jo_header { width:100%; vertical-align: top; font-size:12px; }
    .table_jo_header td.text-center { text-align:center; }
    .table_jo_header td.text-right { text-align:right; }
    h4 { font-size:18px; margin:0; }
    .table_jo_header u { text-decoration:underline; padding-top:15px; }

    .jo_table { border-right:1px solid #333; border-bottom:1px solid #000; margin-top:5px; margin-bottom:15px; }
    .jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

    .jo_table tr th { padding:5px 3px;}
    .jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
    
    .jo_footer { vertical-align: top; }
    .jo_footer td { padding:4px 8px;    }
</style>
<div class="jo_form organizationInfo printBox">
        <table class="table_jo_header purchaseInfo">
            <tr>
                <td width="25%" rowspan="5"></td>
                <td class="text-center"><h3><?php echo ORGNAME;?></h3></td>
            </tr>
            <tr>
                <td class="text-center"><h4><?php echo ORGNAMEDESC;?></h4></td>
            </tr>
            <tr>
                <td class="text-center"><?php echo LOCATION;?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="text-center"><h4><u>खरिद </u></h4></td>
            </tr>
        </table>

        <table class="jo_tbl_head">
            <tr>
                <td></td>
                <td width="17%" class="text-right">मिति : <?php echo CURDATE_NP;?></td>
            </tr>
            <tr>
                <td colspan="2">श्री ....................................................................................................................................................................................लाई</td>
            </tr>
        </table>
        <table class="jo_tbl_head" style="width: 100%; margin-bottom: 10px; font-size: 12px;">
            <tr>
                <td>
                 <label for="example-text">Dispatch Date<span class="required">*</span>: </label>
                    <?php echo !empty($report_data[0]->trma_dispatch_date)?$report_data[0]->trma_dispatch_date:''; ?></td>
                <td>
                    <label for="example-text">From Store<span class="required">*</span>:</label>
                    <?php echo !empty($fromdep[0]->eqty_equipmenttype)?$fromdep[0]->eqty_equipmenttype:''; ?></td>
                <td>
                    <label for="example-text">To Store <span class="required">*</span>:</label>
                    <?php echo !empty($tostore[0]->eqty_equipmenttype)?$tostore[0]->eqty_equipmenttype:''; ?></td>
                <td>
                    <label for="example-text">Dispatch By<span class="required">*</span>:</label>
                    <?php echo $report_data['trma_reqby'];?></td>
            </tr>
            <tr>
                <td><label for="example-text">Dispatch To:</label>
                    <?php echo $report_data['trma_toby'];?>
                </td>
                <td>
                    <label for="example-text">Req No:<span class="required">*</span>:</label></td>
                    <?php echo $report_data['rema_reqno'];?>
                </td>
               <td>
                    <label for="example-text">Transfer Number :</label>
                    <?php echo $report_data['transfer_number']; ?>
                </td>
               <td>
                    <label for="example-text">Fiscal Year :</label>
                    <?php echo $report_data['sama_fyear'];?>
                </td>
            </tr>
        </table>

    <table  class="jo_table itemInfo">
        <thead>
            <tr>
                <th width="5%"> S.No. </th>
                <th width="10%">Item Code</th>
                <th width="15%">Item Name</th>
                <th width="5%">Stock</th>
                <th width="15%">Dispatch Qty.</th>
                <th width="30%">Remarks</th>
                <th width="15%">Expire Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $itemid = !empty($report_data['itemid'])?$report_data['itemid']:'';
            if(!empty($itemid)):
             foreach ($itemid as $key => $value) { ?>
        <tr>
             <td>
                 <?php echo $key+1; ?>
            </td>
            <td>
                <?php echo !empty($report_data['itemcode'][$key])?$report_data['itemcode'][$key]:''; ?>"
            </td>
            <td> 
                <?php
                echo !empty($item_name[$key]->itli_itemname)?$item_name[$key]->itli_itemname:'';
                ?>
            </td>
            <td> 
                <?php echo !empty($report_data['itemstock'][$key])?$report_data['itemstock'][$key]:''; ?>
            </td>
            <td> 
                <?php echo !empty($report_data['dis_qty'][$key])?$report_data['dis_qty'][$key]:''; ?>
            </td>
            <td> 
                <?php echo !empty($report_data['remarks'][$key])?$report_data['remarks'][$key]:''; ?>
            </td>
            <td> 
                <?php echo !empty($report_data['expdate'][$key])?$report_data['expdate'][$key]:''; ?> 
            </td>
        </tr>
        <?php } endif; ?>  
        </tbody>
    </table>
