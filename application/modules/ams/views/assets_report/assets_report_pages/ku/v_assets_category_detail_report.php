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
            $this->load->view('assets_report/v_asset_report_common_header'); 
        ?>
        <?php if (!empty($report_result)):
              $tot_all_sum=0;
                foreach ($report_result as $key => $result):
        ?>
    <div style="padding: 10px">
    <h5 ><strong><?=$result['equipment_name']?></strong></h5>
    <?php if(count($result['equipment_details'])):?>
    <div class="table-responsive">
        <table class="table  alt_table">
            <thead>
                <tr>
                    <th width="3%">S.N</th>
                    <th width="5%">Pur.Date</th>
                    <th width="8%">Item</th>
                    <th width="25%">Detail</th>
                    <th width="5%">Inv No.</th>
                    <th width="5%">Bill No.</th>
                    <th width="8%">Supplier</th>
                    <th width="4%" style="text-align: center;">Qty</th>
                    <th width="4%">Unit Price</th>
                    <th width="5%">Amount</th>
                    <th width="18%">Location</th>
                    <th width="12%" align="right">Received By</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                $tot_asscnt = $tot_prate = $tot_gtot = $tot_qty = 0;
                foreach($result['equipment_details'] as $kd => $det):?>
                    <tr>
                    <td><?=$kd+1?></td>
                    <td><?=$det->asen_purchasedatebs?></td>
                    <td><?=$det->itli_itemname?></td>
                    <td><?=$det->asen_desc?></td>
                    <td><?=$det->recm_invoiceno?></td>
                    <td><?=$det->recm_supplierbillno?></td>
                    <td><?php echo $det->dist_distributor; ?></td>
                    <td><?php echo $det->cnt; ?></td>    
                    <td><?php echo number_format($det->asen_purchaserate,2); ?></td>
                    <td><?php  $total_price=($det->cnt)*($det->asen_purchaserate); echo number_format($total_price,2) ?></td>
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
                        <td colspan="7">Total</td>
                        <td><?=$tot_asscnt?></td>
                        <td></td>
                        <td><?=number_format($tot_all_sum,2)?></td>
                        <td colspan="4"></td>
                    </tr>
            </tbody>

        </table>
    </div>
    </div>

    <?php endif;endforeach;endif;?>

</div>  
</div>  
        