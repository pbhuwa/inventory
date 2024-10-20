    <style>
    .table>tbody>tr>td, .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important;
}
    @media print {
      @page {
        margin:8mm;
      }
    }
    .table>tbody>tr:last-child td {
        font-weight:bold;
    }
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
          <?php 
       $this->load->view('v_common_report_head.php'); 
       ?>

    <?php if (!empty($report_result)):
            foreach ($report_result as $key => $result):
    ?>
    <div style="padding: 10px">
    <h5 ><strong style="border-bottom: 1px dotted black;"><?=$result['invoice_data']?></strong></h5>
    <?php if(count($result['invoice_details'])):?> 
    <div class="table-responsive">
        <table class="table alt_table">
            <thead>
                <tr>
                    <th width="2%">S.N</th>
                    <th width="4%">Item Code</th>
                    <th width="4%">Item Name</th>
                    <th width="5%">Unit</th>
                    <th width="5%">Issue Qty</th>
                    <th width="5%">Unit Rate</th>
                    <th width="8%">Total Amt.</th>
                    <th width="8%">Department</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                $j=1;
                $tot_amt = $tot_vat = $tot_gtot = $tot_qty = 0;
                foreach($result['invoice_details'] as $kd => $det):

                    ?>
                    <tr>
                    <td><?=$kd+1?></td>
                    <td><?=$det->itli_itemcode?></td>
                    <td><?=$det->itli_itemname?></td>
                    <td><?=$det->unit_unitname?></td>
                    <td align="right"><?=sprintf('%g',$det->sade_qty)?></td>
                    <td align="right"><?=number_format($det->sade_unitrate,2)?></td>
                    <td align="right"><?=number_format($det->issueamt,2)?></td>
                     <td style="word-wrap: normal;">          
                        <?php
                            if (!empty($det->parent_dep)) {
                                $department = !empty($det->schoolname) ? $det->schoolname.' - '.$det->parent_dep.'/'.$det->sama_depname : $det->parent_dep.'/'.$det->sama_depname;
                            }else{
                                $department = !empty($det->schoolname) ? $det->schoolname.' - '.$det->sama_depname : $det->sama_depname;
                            }

                            echo ltrim($department,'-') ;
                        ?>  
                        </td> 
                     <?php
                $tot_amt +=$det->sade_unitrate;
                $tot_gtot += $det->issueamt; 
                $tot_qty += $det->sade_qty; 

                ?>
                    </tr>
                <?php endforeach;?>
               
                <tr>
                    <td colspan="4" align="center">Grand Total</td>
                    <td align="right"><?=sprintf('%g',$tot_qty)?></td>
                    <!-- <td align="right"><?=number_format($tot_amt,2)?></td> -->
                    <td align="right"></td>
                    <td align="right"><?=number_format($tot_gtot,2)?></td>
                  
                </tr>
            </tbody>

        </table>
    </div>
    </div>

    <?php endif;endforeach;endif;?>

</div>  
</div>  
        