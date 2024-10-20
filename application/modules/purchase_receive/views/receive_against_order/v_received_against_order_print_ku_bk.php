<?php $mattypeid=!empty($mattypeid)?$mattypeid:''; ?>
<?php if($mattypeid=='1'): ?>
<style> 
    @page  {
        size: auto;   
        margin: 8mm;  
    } 
  h5 {
            margin: 0 0 10px;
            font-size: 14px;
            font-weight: 600;
        }
        h6 {
            font-size: 14px;
            font-weight: 600
        }
    .ku_details h6 {
        margin-bottom: 0rem
    }
    .ku_table td,
        .ku_table th {
            padding: 2px !important;
            font-size: 11px;
            border:0 !important;
        }
        .ku_table tbody td{
            font-size: 11px;
            line-height: 13px !important;
            white-space: invert !important;
            padding:2px !important;
            vertical-align:top !important;
        }
           .ku_table th {
            vertical-align: middle !important; 
            font-weight: 600;
        }
        .ku_table thead{
            border-color: black !important;
            border-bottom: 1.5px solid !important;
        }
        .ku_table tbody tr:not(:last-child){
            border-bottom: 1px solid !important;
        }
        .ku_table tfoot {
            border-top: 0px solid #000 !important
        }
        .ku_bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 3rem 7rem 0;
        }
        .ku_table tfoot th {
            text-align: right !important;
            font-size: 11px;
            padding:0rem 2px !important
        }
        .ku_bottom h6 {
            padding: .5rem 2rem 0;
            border-top: 1px solid;
            text-align: center;
            font-weight: normal;
            font-size: 14px;
            margin-top: 70px;
        }
         .ku_print_header {
           /* display: grid;
            grid-template-columns: 25% 50% 25%;*/
            margin-top: 10px;
            padding-bottom: 1rem;
            margin-bottom: .75rem;
            border-bottom: 1px solid #000;
        }
        .ku_print_header .logo {
            top:-25px !important;
        }
        .ku_print_header .title{
            text-align: center;
        }
         .ku_print_header .title h5{
            font-weight: 600;
            color: #000;
            font-size: 1.275rem;
            margin:0;
        }
        .ku_print_header .title span{
            text-transform: uppercase;
            font-weight: 600;
            color: #000;
        }
        .ku_details ,.ku_table-wrapper{
/*            padding-left:1rem;padding-right: 1rem;
*/        }
        .ku_print_header .date {
            text-align: right;
            align-self: flex-end;
        }
        .ku_details_individual{
            display: grid;
            grid-template-columns:70% 30%;
            align-items: center;
            padding: 0 10px;
        }
        .ku_details_individual h6 {
            font-size: 12px;
            font-weight: 600;
            display: grid;
            grid-template-columns:20% 3% 78%;
        }
        .ku_details_individual h6 .ku_value , .remarks, .received{
            text-transform: uppercase;
/*            font-weight: 400;
*/        }
        .ku_table tfoot th[colspan="4"]{
            text-align: center !important;
        }
         .ku_double h6{
             text-align: left;
             width: 70%;
            color: #000;
             font-weight: bold;
             margin: 0 auto;
             padding: 0;
         }
          h6.ku_double-border{
            padding-bottom: 2px;
             color: #000;
             font-weight: 600;
          }
         .ku_double-border {
            position: relative;
            border-bottom: 4px double #000 !important;
        }
</style>
<div class="jo_form organizationInfo">
    <div class="headerWrapper"  >
        <div class="ku_print_header">
        <?php 
            $header['report_no'] = '';
            $header['old_report_no'] = '';
            $header['report_title'] = 'CONSUMABLE ENTRY REPORT';
            $this->load->view('common/v_print_report_header',$header);
        ?>
        <div style="margin-top: -50px;">
             <!-- <div class="text-right" style="">Page No.: </div> -->
              <div class="text-right" style="font-size: 12px;font-weight: 600">Print Date : <span style="font-weight: 400"><?php echo CURDATE_NP.' '.date('h:i A');?></span></div> 
        </div>
    </div>
        <div class="ku_details">
        <div class="ku_details_individual">
            <h6>
                Supplier Name <span>:</span> 
                <span class="ku_value">
                    <?php echo !empty($req_detail_list[0]->dist_distributor)?$req_detail_list[0]->dist_distributor:'';  ?>
                </span>
            </h6>
             <h6 style="grid-template-columns:32% 3% 65% !important">
                AC Head<span>:</span> 
                <span class="ku_value" style="text-decoration: underline;">
                   <?php 
                    $budgetid=!empty($direct_purchase_master[0]->recm_budgetid)?$direct_purchase_master[0]->recm_budgetid:'';
                    if(!empty($budgetid)){
                        $budgethead=$this->general->get_tbl_data('*','budg_budgets',array('budg_budgetid'=>$budgetid));
                        if(!empty($budgethead)){
                            echo !empty($budgethead[0]->budg_budgetname)?$budgethead[0]->budg_budgetname:'';
                        }
                    } ?>
                </span>
            </h6>
            <div>

             <!--  <div style="font-weight: 600 !important;font-style: 12px !important;text-decoration:underline;margin:0 0 2px !important;padding:0 !important"><?php 
                    $budgetid=!empty($direct_purchase_master[0]->recm_budgetid)?$direct_purchase_master[0]->recm_budgetid:'';
                    if(!empty($budgetid)){
                        $budgethead=$this->general->get_tbl_data('*','budg_budgets',array('budg_budgetid'=>$budgetid));
                        if(!empty($budgethead)){
                            echo !empty($budgethead[0]->budg_budgetname)?$budgethead[0]->budg_budgetname:'';
                        }
                    } ?></div> -->
            
        </div>
        </div>
        <div class="ku_details_individual">
            <h6>
                Bill/Invoice No <span>:</span>
                <span class="ku_value">
                    <?php echo !empty($req_detail_list[0]->recm_supplierbillno)?$req_detail_list[0]->recm_supplierbillno:'';  ?>
                </span>
            </h6>
            <h6 style="grid-template-columns:55% 3% 42% !important">
            Inventory number  <span>:</span>
                <span class="ku_value">
                    <?php
                        if($req_detail_list){
                         echo !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';  
                        } else{
                        echo !empty($report_data['received_no'])?$report_data['received_no']:''; } ?>
                </span>
            </h6>

        </div>
         <div class="ku_details_individual">
            <h6>
                Bill Date <span>:</span>
                <span class="ku_value">
                    <?php 
                        if($req_detail_list)
                        {   
                            if(DEFAULT_DATEPICKER == 'NP'){
                                echo !empty($direct_purchase_master[0]->recm_supbilldatebs)?$direct_purchase_master[0]->recm_supbilldatebs:'';
                            }else{
                                echo !empty($direct_purchase_master[0]->recm_supbilldatead)?$direct_purchase_master[0]->recm_supbilldatead:'';
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
            </h6>

            <h6 style="grid-template-columns:42% 3% 55% !important">
                Received Date <span>:</span>
                <span class="ku_value">
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
            </h6>
        </div>
    </div>
    <div class="ku_table-wrapper" style="border-top:1px solid;margin-top: 8px">
    <table class="ku_table table table-borderless " width="100%" style="margin:5px 0 1rem">
        <thead>
            <tr>
                <th style="text-align: center;" width="5%">SN</th>
                <th>Code</th>
                <th width="30%">Description </th>
                <th width="7%">Unit</th>
                <th style="text-align: center;" width="8%">Qty</th>
                <th style="text-align: center;">Rate</th>
                <th style="text-align: right;">Amount</th>
                <th style="text-align: center !important;">VAT</th>
            </tr>
        </thead>
        <tbody>
            <?php 
             $sum_totalAmt =0;
          
                if($req_detail_list){
                    $sum= 0; $vatsum=0;
                    foreach ($req_detail_list as $key => $direct) { ?>
                        <tr>
                            <td align="center" class="td_cell">
                                <?php echo $key+1; ?>
                            </td>
                            <td class="td_cell" >
                                <!-- 0608000 -->
                                <?php
                                    // if(ITEM_DISPLAY_TYPE=='NP'){
                        //              echo !empty($direct->itli_itemnamenp)?$direct->itli_itemnamenp:$direct->itli_itemname;
                        //             }else{ 
                        //                 echo !empty($direct->itli_itemname)?$direct->itli_itemname:'';
                        //             }
                                ?>
                                <?php echo !empty($direct->itli_itemcode)?$direct->itli_itemcode:''; ?>
                            </td>
                            <td style="width:30%;">
                                 <?php
                                $description=!empty($direct->recd_description)?$direct->recd_description:'';
                                
                                $itemname=!empty($direct->itli_itemname)?$direct->itli_itemname:'';
                                echo !empty($description)?$description:$itemname;
                                ?>
                            </td>
                            <td class="td_cell">
                                <?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>
                            </td>
                            <td style="text-align: center;" class="td_cell"><?php echo number_format($direct->recd_purchasedqty,0); ?> 
                            </td>
                            <td style="text-align: center;" class="td_cell">
                                <?php 
                                    $unit_price = !empty($direct->recd_unitprice)?$direct->recd_unitprice:''; 
                                    echo number_format($unit_price,2);
                                ?>
                            </td>
                            <td class="td_cell" style="text-align: right">
                                <?php 
                                    $total_wo_vat = $direct->recd_purchasedqty*$direct->recd_unitprice; 
                                      $sum_totalAmt +=$total_wo_vat;
                                    echo number_format($total_wo_vat,2);
                                ?>
                            </td>
                            <td class="td_cell" style="text-align: center !important;">
                                <?php 
                                    echo $direct->recd_vatamt;
                                ?>
                            </td>
                        </tr>
                        <?php
                            $sum += $direct->recd_discountamt;
                            $vatsum += $direct->recd_vatamt;
                        }
                    }
                        $row_count = count($req_detail_list);
                        if($row_count < 11): ?>
                            <tr style="border-top: none !important">
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
            <tfoot>
                <tr>
                    <th colspan="8" style="padding:3px !important;text-align: left !important">
                     <strong>Remarks :</strong>  <?php echo !empty($req_detail_list[0]->recm_remarks)?$req_detail_list[0]->recm_remarks:'';  ?>  
                    </th>
                </tr>
                <tr>
                     <th align="center"  colspan="5" ></th>
                    <th style="border-top: 1px solid !important;border-bottom: 1px solid !important;" colspan="2"> <?php echo !empty($sum_totalAmt)?number_format($sum_totalAmt,2):0.00; ?></th>
                    <th style="text-align:center !important;"><?php echo !empty($vatsum)?number_format($vatsum,2):0.00; ?></th>
                </tr>
                <tr >
                    <th style="padding-top: 2px !important" colspan="3"></th>
                    <?php if(!empty($direct->recm_discount) && $direct->recm_discount != '0'): ?>
                    <th align="center" style="padding-top: 2px !important" colspan="2" class="ku_double"><h6 style="font-size: 11px !important;">Discount :</h6></th>
                   <!--  <th style="padding-top: 2px !important" colspan="2"><?php //echo !empty($sum)?number_format($sum,2):'0.00'; ?></th>  -->
                   <th style="padding-top: 2px !important" colspan="2"><?php echo !empty($direct->recm_discount)?number_format($direct->recm_discount,2):'0.00'; ?></th>
                   <?php else: ?>
                   <th></th>
                   <?php endif; ?> 
                    <th></th>
                </tr>
                 <tr >
                    <th style="padding-top: 2px !important" colspan="3"></th>
                     <?php  if(!empty($direct->recm_others) && $direct->recm_others != '0.00'): ?>
                    <th align="center" style="padding-top: 2px !important" colspan="2" class="ku_double"><h6 style="font-size: 11px !important;"><?php $other_desc= !empty($direct->recm_othersdescription)?$direct->recm_othersdescription:''; 
                        if(!empty($other_desc)){
                          echo $other_desc;
                        }else{
                            echo "Others";
                        }

                        ?>:</h6></th>
                   <th style="padding-top: 2px !important" colspan="2"><?php echo !empty($direct->recm_others)?number_format($direct->recm_others,2):'0.00'; ?></th>
                   <?php else: ?>
                   <th></th>
                   <?php endif; ?> 
                </tr>
                <tr>
                    <th colspan="3"></th>
                    <th align="center" colspan="2" class="ku_double"><h6 class="ku_double-border"style="font-size: 11px !important;font-weight: 600">Grand Total :</h6></th>
                    <th colspan="2"><h6 style="font-size: 11px !important;"class="ku_double-border"><?php echo !empty($total)?number_format($total,2):0.00; ?></h6></th>
                    <th></th>
                </tr>
            </tfoot>
    </table>
    </div>
    <div class="ku_bottom">
        <h6>Prepared by</h6>
        <h6>Checked by</h6>
    </div>
    </div>
</div>

<?php 
else:
?>
<style> 
    @page  {
        size: auto;   
        margin: 8mm;  
    } 
  h5 {
            margin: 0 0 10px;
            font-size: 14px;
            font-weight: 600;
        }
        h6 {
            font-size: 12px;
            font-weight: 600
        }
    .ku_details h6 {
        margin-bottom: 0rem
    }

    .ku_table td,
        .ku_table th {
            padding:2px !important;
            font-size: 11px;
            border:0 !important;
        }
        .ku_table tbody td{
            font-size: 11px;
            white-space: normal !important;
            padding:2px 3px !important;
            line-height: 13px !important;
            vertical-align:top !important;
        }
           .ku_table th {
            vertical-align: middle !important; 
            font-weight: 600;
        }
        .ku_table thead{
            border-color: black !important;
            border-bottom: 1.5px solid !important;
        }
        .ku_table tbody tr:not(:last-child){
            border-bottom: 1px solid !important;
        }
        .ku_table tfoot {
            border-top: 0px solid #000 !important
        }
        .ku_bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 3rem 8rem 0;
        }
        .ku_table tfoot th {
            text-align: right !important;
                     font-size: 11px;
            padding: 2px !important
        }

        .ku_bottom h6 {
            padding: .5rem 2rem 0;
            border-top: 1px solid;
            font-size: 14px;
            text-align: center;
            font-weight: 600;
            margin-top: 70px;
        }
         .ku_print_header {
           /* display: grid;
            grid-template-columns: 25% 50% 25%;*/
            padding-bottom: .75rem;
            margin-bottom: .5rem;
            border-bottom: 1px solid #000;
        }
        .ku_print_header .title{
            text-align: center;
        }
         .ku_print_header .title h5{
            font-weight: 600;
            color: #000;
            font-size: 1.275rem;
            margin:0;
        }
        .ku_print_header .title span{
            text-transform: uppercase;
            font-weight: 600;
            color: #000;
        }
        .ku_details ,.ku_table-wrapper{
/*            padding-left:1rem;padding-right: 1rem;
*/        }
        .ku_print_header .date {
            text-align: right;
            align-self: flex-end;
        }
        .ku_details_individual{
            display: grid;
            grid-template-columns:72% 28%;
            grid-column-gap: 1em;
            align-items: center;

        }
        .ku_details_individual h6 {
            display: grid;

            font-size: 12px;
            font-weight: 600;
            grid-template-columns:17% 3% 80%;
        }
        .ku_details_individual h6 .value , .remarks, .received{
            text-transform: uppercase;
        }
        .ku_table tfoot th[colspan="4"]{
            text-align: center !important;
        }
         .ku_double h6{
             text-align: left;
             width: 70%;
            color: #000;
            font-size: 11px !important;
             font-weight: 600;
             margin: 0 auto;
         }
          h6.ku_double-border{
            padding-bottom: 2px;
             color: #000;
             font-size: 11px !important;
             font-weight: 600;
          }
         .ku_double-border {
            position: relative;
            border-bottom: 4px double #000 !important;
        }
</style>
<div class="jo_form organizationInfo">
    <div class="headerWrapper"  >
        <div class="ku_print_header">
        <?php 
            $header['report_no'] = '';
            $header['old_report_no'] = '';
            $header['report_title'] = 'INVENTORY ENTRY REPORT';
            $this->load->view('common/v_print_report_header',$header);
        ?>
        <div style="margin-top: -120px;">
             <div class="text-right" style="margin-bottom: 45px;padding-right: 40px">Page No.: </div>
              <div class="text-right">Print Date: <?php echo CURDATE_NP.' '.date('h:i A');?></div> 
        </div>
    </div>
        <div class="ku_details">
        <div class="ku_details_individual">
            <h6>
                Supplier Name <span>:</span> 
                <span class="ku_value">
                    <?php echo !empty($direct_purchase_master[0]->dist_distributor)?$direct_purchase_master[0]->dist_distributor:'';  ?>
                </span>
            </h6>
            <h6 style=" grid-template-columns:30% 3% 67%;">
                A.C Head <span>:</span>
                <span class="ku_value">
                    <!-- COMPUTER MAINTENANCE -->
                    <?php 
                    $budgetid=!empty($direct_purchase_master[0]->recm_budgetid)?$direct_purchase_master[0]->recm_budgetid:'';
                    if(!empty($budgetid)){
                        $budgethead=$this->general->get_tbl_data('*','budg_budgets',array('budg_budgetid'=>$budgetid));
                        if(!empty($budgethead)){
                            echo !empty($budgethead[0]->budg_budgetname)?$budgethead[0]->budg_budgetname:'';
                        }
                    }

                     ?>
                </span>
            </h6>
        </div>
        <div class="ku_details_individual">
            <h6>
                Bill / Invoice <span>:</span>
                <span class="ku_value">
                    <?php echo !empty($req_detail_list[0]->recm_supplierbillno)?$req_detail_list[0]->recm_supplierbillno:'';  ?>
                </span>
            </h6>
            <h6 style=" grid-template-columns:30% 3% 67%;">
                Entry No <span>:</span>
                <span class="ku_value">
                    <?php
                        if($req_detail_list){
                         echo !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';  
                        } else{
                        echo !empty($report_data['received_no'])?$report_data['received_no']:''; } ?>
                </span>
            </h6>
        </div>
        <div class="ku_details_individual">
            <h6>
                Date <span>:</span>
                <span class="ku_value">
                    <?php 
                        if($req_detail_list)
                        {   
                            if(DEFAULT_DATEPICKER == 'NP'){
                                echo !empty($direct_purchase_master[0]->recm_supbilldatebs)?$direct_purchase_master[0]->recm_supbilldatebs:'';
                            }else{
                                echo !empty($direct_purchase_master[0]->recm_supbilldatead)?$direct_purchase_master[0]->recm_supbilldatead:'';
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
            </h6>
            <h6 style=" grid-template-columns:30% 3% 67%;">
                Date <span>:</span>
                <span class="ku_value">
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
            </h6>
        </div>
    </div>
    <div class="ku_table-wrapper" style="border-top:1px solid;margin-top:1rem">
    <table class="ku_table table table-borderless " width="100%" style="margin:5px 0 1.5rem">
        <thead>
            <tr>
                <th width="6%">Inv No</th>
                <th style="text-align: left;" width="30%">Description</th>
                <th style="text-align: center;">Unit</th>
                <th width="6%" style="text-align: center;">Qty</th>
                <th style="text-align: center;">Rate</th>
                <th width="10%" style="text-align: right;">Amount</th>
                <th style="text-align: center !important;">VAT</th>
                <th style="text-align: center;" width="20%">Remarks</th>
                <th style="text-align: center" width="15%">Received By</th>
            </tr>
        </thead>
        <tbody>
            <?php 
             $sum_totalAmt=0;
                if($req_detail_list){
                    $sum= 0; $vatsum=0;
                    foreach ($req_detail_list as $key => $direct) { ?>
                        <tr>
                            <td class="td_cell">
                                <?php echo !empty($direct->itli_itemcode)?$direct->itli_itemcode:''; ?>
                            </td>
                            <td style="width:30%;">
                              
                                <?php
                                $description=!empty($direct->recd_description)?$direct->recd_description:'';
                                
                                $itemname=!empty($direct->itli_itemname)?$direct->itli_itemname:'';
                                echo !empty($description)?$description:$itemname;
                                ?>
                            </td>
                            <td class="td_cell">
                                <?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>
                            </td>
                            <td style="text-align: center;" class="td_cell">
                                <?php echo number_format($direct->recd_purchasedqty,0); ?>
                            </td>
                            <td style="text-align: center;" class="td_cell">
                                <?php 
                                    $unit_price = !empty($direct->recd_unitprice)?$direct->recd_unitprice:''; 
                                    echo number_format($unit_price,2);
                                ?>
                            </td>
                            <td class="td_cell" style="text-align: right">
                                <?php 
                                    $total_wo_vat = $direct->recd_purchasedqty*$direct->recd_unitprice; 
                                    $sum_totalAmt +=$total_wo_vat;
                                    echo number_format($total_wo_vat,2);
                                ?>
                            </td>
                            <td class="td_cell" style="text-align: center !important;">
                                <?php 
                                    echo number_format($direct->recd_vatamt,2);
                                ?>
                            </td>
                             <td style="text-align: center;" class="td_cell ku_remarks">
                                 <?php 

                                $schoolid=!empty($direct_purchase_master[0]->recm_school)?$direct_purchase_master[0]->recm_school:'';
                                 $departmentid=!empty($direct_purchase_master[0]->recm_departmentid)?$direct_purchase_master[0]->recm_departmentid:'';
                                 // echo "&nbsp;";
                                if(!empty($schoolid)){
                                    $schoolname=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$schoolid));
                                    if(!empty($schoolname)){
                                        $locationname= !empty($schoolname[0]->loca_name)?$schoolname[0]->loca_name:'';
                                    }
                                }
                               // echo "-";
                                //  if(!empty($departmentid)){
                                //     $depname=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$departmentid));
                                //     if(!empty($depname)){
                                //         echo !empty($depname[0]->dept_depname)?$depname[0]->dept_depname:'';
                                //     }
                                // }
                                
                                 $reqdepartment=!empty($direct_purchase_master[0]->recm_departmentid)?$direct_purchase_master[0]->recm_departmentid:'';
                                 if(!empty($reqdepartment)):
                                $check_parentid=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$reqdepartment),'dept_depname','ASC');
                                $dep_parent_dep_name='';
                                $sub_depname='';
                                
                                if(!empty($check_parentid)){
                                  $dep_parentid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
                                  $dep_parent_dep_name=!empty($check_parentid[0]->dept_depname)?$check_parentid[0]->dept_depname:'';

                                  if($dep_parentid!=0){
                                  $sub_department=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$dep_parentid),'dept_depname','ASC');
                                  if(!empty($sub_department)){
                                   $sub_depname=!empty($sub_department[0]->dept_depname)?$sub_department[0]->dept_depname:'';
                                  }
                                  }   
                                }

                                if(!empty($sub_depname)){
                                  echo $sub_depname.'('.$dep_parent_dep_name.')';
                                }else{
                                  echo $locationname.'-</br>'.$dep_parent_dep_name;
                                }
                            endif;
                            ?>
                            </td>
                            
                            <td  style="text-align: center" class="td_cell ku_received">
                                 <!-- recm_departmentid -->
                                 <!-- recm_school
                                 recm_receivedby --> 
                                 <?php echo !empty($direct_purchase_master[0]->recm_receivedby)?$direct_purchase_master[0]->recm_receivedby:''; ?>

                            </td>
                        </tr>
                        <?php
                            $sum += $direct->recd_discountamt;
                            $vatsum += $direct->recd_vatamt;
                        }
                    }
                        $row_count = count($req_detail_list);
                        if($row_count < 11): ?>
                            <tr style="border-top: none !important">
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
            <tfoot>
                <tr>
                    <th colspan="10" style="padding:3px !important"></th>
                </tr>
                <tr>
                        <th></th>
                     <th align="center" style="padding-top:2px !important" colspan="3" class="ku_double"><h6 class="ku_double-border">Total Amount :</h6></th>
                    <th style="border-top: 1px solid !important;border-bottom: 1px solid !important;" colspan="2"> <?php echo !empty($sum_totalAmt)?number_format($sum_totalAmt,2):'0.00'; ?></th>
                    <th style="text-align: center !important;"><?php echo !empty($vatsum)?number_format($vatsum,2):'0.00'; ?></th>
                </tr>
                <?php $transportation_fee=!empty($direct_purchase_master[0]->recm_transportcourier)? number_format($direct_purchase_master[0]->recm_transportcourier,2):'0.00'; 
                if($transportation_fee>'0.00'):
                ?>
                <tr >
                    <th style="padding-top:5px !important" colspan=""></th>
                    <th align="center" style="padding-top:5px !important" colspan="3" class="ku_double"><h6 style="margin:0 auto!important;padding:0 !important;">Transportation Fee :</h6></th>
                    <th style="padding-top:5px !important" colspan="2"><?php echo !empty($direct_purchase_master[0]->recm_transportcourier)? number_format($direct_purchase_master[0]->recm_transportcourier,2):'0.00'; ?></th>
                </tr>
            <?php endif; ?>
                <tr >
                    <th style="padding-top:2px !important" colspan=""></th>
                    <?php if (!empty($direct->recm_discount) && $direct->recm_discount != '0'): ?>
                    <th align="center" style="padding-top:2px !important" colspan="3" class="ku_double"><h6 style="margin:0 auto!important;padding:0 !important;">Discount :</h6></th>
                    <!-- <th style="padding-top:2px !important" colspan="2"><?php //echo !empty($sum)?number_format($sum,2):'0.00'; ?></th> -->
                    <th style="padding-top: 2px !important" colspan="2"><?php echo !empty($direct->recm_discount)?number_format($direct->recm_discount,2):'0.00'; ?></th>
                    <?php else: ?>
                        <th></th>
                    <?php endif;?>
                </tr>
                <tr >
                    <th style="padding-top: 2px !important" colspan=""></th>
                     <?php  if(!empty($direct->recm_others) && $direct->recm_others != '0.00'): ?>
                    <th align="center" style="padding-top: 2px !important" colspan="3" class="ku_double"><h6 style="font-size: 11px !important;margin:0 auto!important;padding:0 !important;"><?php $other_desc= !empty($direct->recm_othersdescription)?$direct->recm_othersdescription:''; 
                        if(!empty($other_desc)){
                          echo $other_desc;
                        }else{
                            echo "Others";
                        }

                        ?>:</h6></th>
                   <th style="padding-top: 2px !important" colspan="2"><?php echo !empty($direct->recm_others)?number_format($direct->recm_others,2):'0.00'; ?></th>
                   <?php else: ?>
                   <th></th>
                   <?php endif; ?> 
                </tr>
                <tr>
                    <th style="padding-top:2px !important"></th>
                    <th style="padding-top:2px !important" align="center" colspan="3" class="ku_double"><h6 style="padding:0 !important;margin:0 auto !important" class="ku_double-border">Grand Total :</h6></th>
                    <th style="padding-top:2px !important" colspan="2"><h6  class="ku_double-border" style="padding:0 !important;margin:0 auto !important"><?php echo !empty($total)?number_format($total,2):'0.00'; ?></h6></th>
                </tr>
            </tfoot>
    </table>
    </div>
    <div class="ku_bottom">
        <h6>Prepared by</h6>
        <h6>Checked by</h6>
    </div>
    </div>
</div>
<?php
endif; ?>