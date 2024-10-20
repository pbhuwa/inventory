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
         $this->load->view('assets_report/v_asset_report_common_header'); ?>
        <?php if (!empty($report_result)):
              $tot_all_sum=0;
                foreach ($report_result as $key => $result):
        ?>
    <div style="padding: 10px">
    <h5 ><strong><?=$result['item_name']?>&nbsp;(<?=$result['item_unit']?>)</strong></h5>
    <?php if(count($result['item_details'])):?>
    <div class="table-responsive">
        <table class="table  alt_table">
            <thead>
                <tr>
                     <th width="3%">S.N</th>
                     <th width="8%">Pur. Date</th>
                    <th width="5%">Entry No.</th>
                     <th width="5%">Bill No.</th>
                    <th width="20%">Detail</th>
                    <th width="5%">Unit.</th>
                    <th width="5%">Qty.</th>
                    <th width="7%">Unit Price.</th>
                    <th width="10%">Total</th>
                    <th width="15%">Supplier</th>
                    <th width="20%">Location</th>
                    <th width="10%">Received By</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                $tot_asscnt = $tot_prate = $tot_gtot = $tot_qty = 0;
                foreach($result['item_details'] as $kd => $det):?>
                    <tr>
                    <td><?=$kd+1?></td>
                    <td><?=$det->asen_purchasedatebs?></td>
                    <td><?=$det->recm_invoiceno?></td>
                    <td><?=$det->recm_supplierbillno?></td> 
                    <td><?=$det->asen_desc?></td>
                     <td><?php echo $det->unit_unitname; ?></td>

                     <td><?php echo $det->cnt; ?></td>
                        
                        <td><?php $prate=$det->asen_purchaserate; echo number_format($prate,2); ?></td>
                    <td><?php  $total_price=($det->cnt)*($det->asen_purchaserate); echo number_format($total_price,2); ?></td>
                    <td><?php echo $det->dist_distributor; ?></td>
                    
                    <td>
                            <?php echo $det->schoolname.'-'; ?>
                            <?php if(!empty($det->depparent)) echo $det->depparent.'/'.$det->dept_depname; else echo $det->dept_depname; ?>
                        </td>     
                        <td><?php echo $det->stin_fname.' '.$det->stin_mname.' '.$det->stin_lname; ?></td>                      
                   
                    <?php 
                        $tot_asscnt += !empty($det->cnt) ? $det->cnt : 0;
                        $tot_prate += !empty($det->asen_purchaserate) ? $det->asen_purchaserate : 0;
                        $tot_all_sum += $total_price;
                    ?>
                 
                   
                <?php endforeach;?>
                 <tr>
                        <td colspan="6"><strong>Grand Total</strong></td>
                        <td><strong><?=number_format($tot_asscnt,2)?></strong></td>
                        <td></td>
                          <td><strong><?=number_format($tot_all_sum,2)?></strong></td>
                        <td colspan="3"></td>
                    </tr>
            </tbody>

        </table>
    </div>
    </div>

    <?php endif;endforeach;endif;?>

</div>  
</div>  
        