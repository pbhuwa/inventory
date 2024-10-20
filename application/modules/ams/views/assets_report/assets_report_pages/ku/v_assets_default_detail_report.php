<style type="text/css">
    table tr:last-child{
        font-weight: 700;
    }
    .table>tbody>tr>td, .table>tbody>tr>th {
        white-space: normal;
    }
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');
         $this->load->view('assets_report/v_asset_report_common_header'); 
        ?>
        <?php 
             $tot_asscnt=0;
             $tot_prate=0;
             $tot_all_sum=0;
             $extra_amount = [];
            if (!empty($report_result)):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="4%">S.N</th>
                        <th width="8%">Pur. Date</th>
                        <th width="5%">Entry No.</th>
                        <th  width="10%">Item Name</th>
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
                    foreach ($report_result as $krr => $rdata):
                    ?>  
                    <tr>
                        <td><?=$krr+1?></td>
                        <td><?php echo $rdata->asen_purchasedatebs; ?></td>           
                        <td><?php echo $rdata->recm_invoiceno; ?></td> 
                        <td><?php echo $rdata->itli_itemname; ?></td>
                        <td><?php echo $rdata->asen_desc; ?></td>
                        <td><?php echo $rdata->unit_unitname; ?></td>
                        <td><?php echo $rdata->cnt; ?></td>
                        
                        <td style="text-align: right"><?php echo number_format($rdata->asen_purchaserate,2); ?></td>
                         <td style="text-align: right"><?php $total_price = ($rdata->cnt)*($rdata->asen_purchaserate); 
                                echo number_format($total_price,2);
                         ?></td>
                         
                        <?php 
                            $extra_amount["key".$rdata->recm_receivedmasterid] = $rdata->recm_others;
                        ;?>
                        <td>
                            <?php echo $rdata->dist_distributor; ?>
                        </td>
                        <td>
                            <?php echo $rdata->schoolname.'-'; ?>
                            <?php if(!empty($rdata->depparent)) echo $rdata->depparent.'/'.$rdata->dept_depname; else echo $rdata->dept_depname; ?>
                        </td>     
                        <td><?php echo $rdata->stin_fname.' '.$rdata->stin_mname.' '.$rdata->stin_lname; ?></td>                      
                    </tr>
                    <?php 
                        $tot_asscnt += !empty($rdata->cnt) ? $rdata->cnt : 0;
                        $tot_prate += !empty($rdata->asen_purchaserate) ? $rdata->asen_purchaserate : 0;
                        $tot_all_sum += $total_price;
                        $total_extra_charge = 0;
                        if (count($extra_amount) > 0) {
                            foreach ($extra_amount as $value) {
                                $total_extra_charge += floatval($value);
                            }
                        }
                        $grand_sum_total = $tot_all_sum + $total_extra_charge;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="6"><strong>Total</strong></td>
                        <td></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"><strong><?=number_format($tot_all_sum,2)?></strong></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6"><strong>Extra Charge</strong></td>
                        <td></td>
                        <td style="text-align: right"></td>
                         <td style="text-align: right"><strong><?=number_format($total_extra_charge,2)?></strong></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6"><strong>Grand Total</strong></td>
                        <td><strong><?=$tot_asscnt?></strong></td>
                        <td style="text-align: right"></td>
                        <td style="text-align: right"><strong><?=number_format($grand_sum_total,2)?></strong></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </tbody>

            </table>
        </div>
         <?php endif; ?>
    <br>
    </div>
</div>