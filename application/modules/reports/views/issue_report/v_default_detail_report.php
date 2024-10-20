
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
        if(!empty($report_result)):
        $this->load->view('v_common_report_head');
       ?>

        <div class="table-responsive">
            <table class="table alt_table">
                <thead>
                    <tr>
                        <th width="2%">S.N</th>
                        <th width="5%">Issue No.</th>
                        <th width="10%">Issue Date(B.S)</th>
                        <th width="10%">Issue Date(A.S)</th>
                        <th width="7%">Item Code</th>
                        <th width="20%">Item Name</th>
                        <th width="15%">Department</th>
                        <th width="5%">Issued By</th>
                        <th width="5%">Received By</th>
                        <th width="5%">Qty</th>
                        <th width="5%">Rate</th>
                        <th width="8%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tot_amt = $tot_qty = 0;
                    
                    foreach ($report_result as $key => $sum):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $sum->sama_invoiceno; ?></td>           
                        <td><?php echo $sum->sama_billdatebs; ?></td>           
                        <td><?php echo $sum->sama_billdatead; ?></td>           
                        <td><?php echo $sum->itli_itemcode; ?></td>           
                        <td><?php echo $sum->itli_itemname; ?></td>  
                        <td style="word-wrap: normal;">
                        <?php
                            if (!empty($sum->parent_dep)) {
                                $department = $sum->schoolname.' -'.$sum->parent_dep.'/'.$sum->sama_depname;
                            }else{
                                $department = $sum->schoolname.' -'.$sum->sama_depname;
                            }

                            echo $department;
                        ?>
                    </td>         
                        <td><?php echo $sum->sama_username; ?></td>           
                        <td><?php echo $sum->sama_receivedby; ?></td>           
                        <td style="text-align: right;"><?php echo number_format($sum->sade_qty,2); ?></td>           
                        <td style="text-align: right;"><?php echo number_format($sum->sade_unitrate,2); ?></td>
                        <td style="text-align: right;"><?php echo number_format($sum->issueamt,2); ?></td>        
                    </tr>
                    <?php 
                        $tot_amt += !empty($sum->issueamt) ? $sum->issueamt : 0;
                        $tot_qty += !empty($sum->sade_qty) ? $sum->sade_qty : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='9' style="text-align: center;">Total</td>
                        <td style="text-align: right;"><?=number_format($tot_qty,2)?></td>
                        <td></td>
                        <td style="text-align: right;"><?=number_format($tot_amt,2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
    </div>
</div>