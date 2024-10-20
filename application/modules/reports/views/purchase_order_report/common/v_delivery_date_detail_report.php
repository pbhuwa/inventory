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
    <?php $this->load->view('common/v_report_header');
     $this->load->view('v_common_report_head.php'); ?>
   <?php if (!empty($report_result)):
        foreach ($report_result as $key => $result):
    ?>
        <div style="padding: 10px">
        <h5 ><strong><?=$result['name']?></strong></h5>
        <?php if(count($result['details'])):?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="7%">Order Date (B.S)</th>
                        <th width="7%">Order Date (A.D)</th>
                        <th width="5%">Order No.</th>
                        <th width="10%">Item </th>
                        <th width="20%">Supplier Name</th>
                        <th width="8%">Category</th>
                        <th width="8%">Material Type</th>
                        <th width="5%">Qty</th>
                        <th width="5%">Rate</th>
                        <th width="5%">Total Amt.</th>
                        <th width="5%">Req No.</th>
                        <th width="20%">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tot_qty = $tot_rate = $tot_amt = 0;
                    foreach ($result['details'] as $key => $value):
                        $tot_qty += !empty($value->quantity) ? $value->quantity : 0;
                        $tot_rate += !empty($value->rate) ? $value->rate : 0;
                        $tot_amt += !empty($value->amount) ? $value->amount : 0;
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>         
                        <td><?php echo $value->orderdatebs; ?></td>           
                        <td><?php echo $value->orderdatead; ?></td>           
                        <td><?php echo $value->orderno; ?></td>           
                        <td><?php echo "$value->itemcode - $value->itemname </br>($value->unit)"; ?></td>           
                        <td><?php echo $value->suppliername; ?></td>           
                        <td><?php echo $value->category; ?></td>           
                        <td><?php echo $value->materialname; ?></td>           
                        <td><?php echo sprintf('%g',$value->quantity); ?></td>           
                        <td><?php echo $value->rate; ?></td>           
                        <td><?php echo $value->amount; ?></td>           
                        <td><?php echo $value->requno; ?></td>           
                        <td><?php echo $value->pude_remarks; ?></td>                     
                    </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Total</td>
                        <td><?=$tot_qty?></td>
                        <td><?=number_format($tot_rate,2)?></td>
                        <td><?=number_format($tot_amt,2)?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif;endforeach; endif;?>
</div>