<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                  <!--   <tr>
                        <th colspan="12" align="center" style="text-align: center;">
                            <strong><?php echo $this->lang->line('purchase'); ?></strong>
                        </th>
                    </tr> -->
                    <tr>
                        <th width="4%"><?php echo $this->lang->line('order_no'); ?></th>
                        <th width="4%"><?php echo $this->lang->line('receipt_no'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('receive_date'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('supplier_bill_date'); ?></th>
                        <th width="4%"><?php echo $this->lang->line('bill_no'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('purchase_amount'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('cc'); ?><!-- cc amount --></th>
                        <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('vat_amount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('balance'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('user'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $total_purchase_amount = 0;
                    $total_purchase_discount = 0;
                    $total_purchase_vat = 0;
                    $total_purchase_balance = 0;
                    
                    if($pur_analysis_list):
                        foreach ($pur_analysis_list as $ksm => $supp):
                            $supp_data=$this->purchase_analysis_mdl->get_purchase_analysis(array('rm.recm_invoiceno'=>$supp->recm_invoiceno));
                            // echo $this->db->last_query();
                            // echo"<br>";
                            if($supp_data): 
                ?>
                  
                <!--     <tr>
                        <td colspan="11"> <strong><?php echo $supp->recm_invoiceno;  ?></strong></td>
                   
                    </tr> -->
                    <?php
                        if($supp_data): 
                            $rm_amt=0;
                            $rm_dis=0;
                            $rm_tax=0;
                            $rm_cleamt=0;

                            foreach ($supp_data as $km => $mlist):
                                $rm_amt += !empty($mlist->recm_amount)?$mlist->recm_amount:0;
                                $rm_dis += !empty($mlist->recm_discount)?$mlist->recm_discount:0;
                                $rm_tax += !empty($mlist->recm_taxamount)?$mlist->recm_taxamount:0;
                                $rm_cleamt += !empty($mlist->recm_clearanceamount)?$mlist->recm_clearanceamount:0;

                                if(DEFAULT_DATEPICKER == 'NP'){
                                    $received_date = !empty($mlist->recm_receiveddatebs)?$mlist->recm_receiveddatebs:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatebs)?$mlist->recm_supbilldatebs:'';
                                }else{
                                    $received_date = !empty($mlist->recm_receiveddatead)?$mlist->recm_receiveddatead:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatead)?$mlist->recm_supbilldatead:'';
                                }
                    ?>
                        <tr>
                            <td><?php echo !empty($mlist->recm_purchaseorderno)?$mlist->recm_purchaseorderno:'D'; ?></td>
                            <td><?php echo !empty($mlist->recm_invoiceno)?$mlist->recm_invoiceno:''; ?></td>
                            <td><?php echo $received_date; ?></td>
                            <td><?php echo !empty($mlist->dist_distributor)?$mlist->dist_distributor:'';; ?></td>
                            <td><?php echo $supplier_date; ?></td>
                            <td><?php echo !empty($mlist->recm_supplierbillno)?$mlist->recm_supplierbillno:'' ?></td>
                            <td align="right">
                                <?php
                                    $recm_amt = !empty($mlist->recm_amount)?$mlist->recm_amount:0;
                                    echo number_format($recm_amt,2) ?>
                            </td>
                            <td align="center"><?php echo '-' ?></td>
                            <td align="right">
                                <?php
                                    $recm_dis = !empty($mlist->recm_discount)?$mlist->recm_discount:0;
                                    echo number_format($recm_dis,2);
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_tax = !empty($mlist->recm_taxamount)?$mlist->recm_taxamount:0; 
                                    echo number_format($recm_tax,2); 
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_clearanceamt = !empty($mlist->recm_clearanceamount)?$mlist->recm_clearanceamount:0; 
                                    echo number_format($recm_clearanceamt,2); 
                                ?>
                            </td>
                            <td><?php echo !empty($mlist->recm_postusername)?$mlist->recm_postusername:''; ?></td>
                        </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                        <!-- <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right"><strong><?php echo number_format($rm_amt,2); ?></strong></td>
                            <td></td>
                            <td align="right"><strong><?php echo number_format($rm_dis,2); ?></strong></td>
                            <td align="right"><strong><?php echo number_format($rm_tax,2); ?></strong></td>
                            <td align="right"><strong><?php echo number_format($rm_cleamt,2); ?></strong></td>
                            <td></td>
                        </tr> -->
                    <?php 
                            $total_purchase_amount += $rm_amt;
                            $total_purchase_discount += $rm_dis;
                            $total_purchase_vat += $rm_tax;
                            $total_purchase_balance += $rm_cleamt;
                            endif; 
                        endforeach; 
                    endif; 
                ?>
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="6" align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_amount,2);?></strong></td>
                        <td align="center">-</td>
                        <td align="right"><strong><?php echo number_format($total_purchase_discount,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_vat,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_balance,2);?></strong></td>
                        <td></td>
                    </tr>
                    <tr class="borderBottom">
                        <td colspan="12" class="text-center" align="center">
                            <strong><?php echo $this->lang->line('in_words').': '.$this->general->number_to_word($total_purchase_balance); ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

       <!--  <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <?php
                        $total_return_amount = 0;
                        $total_return_discount = 0;
                        $total_return_vat = 0;
                         $pd_amt = 0;
                            $pd_dis = 0;
                            $pd_tax = 0;
                        if($return_data):
                            foreach($pur_analysis_list as $ret_key=>$ret_sup):
                                $return_data = $this->purchase_analysis_mdl->get_mrn_return_analysis(array('pr.purr_supplierid'=>$ret_sup->supplierid));
                                if($return_data):
                    ?>
                        <tr>
                            <th colspan="11" align="center" style="text-align: center;">
                                <strong><?php echo $this->lang->line('return'); ?></strong>
                            </th>
                        </tr>
                        <tr>
                            <th width="5%"><?php echo $this->lang->line('return_no'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('invoice_no'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('return_date'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('discount'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('vat_amount'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('return_by'); ?></th>
                        </tr>
                </thead>
                <tbody>
                        <tr>
                             <td colspan="11"> <strong><?php echo $pur_analysis_list[0]->dist_distributor;  ?></strong></td>
                        </tr>
                        <?php
                            foreach($return_data as $rd_key=>$rd_data):
                                if(DEFAULT_DATEPICKER == 'NP'){
                                    $return_date = !empty($rd_data->purr_returndatebs)?$rd_data->purr_returndatebs:'';
                                }else{
                                    $return_date = !empty($rd_data->purr_returndatead)?$rd_data->purr_returndatead:'';
                                }

                                $pd_amt += !empty($rd_data->purr_returnamount)?$rd_data->purr_returnamount:0;
                                //echo $pd_amt; die;
                                $pd_dis += !empty($rd_data->purr_discount)?$rd_data->purr_discount:0;
                                $pd_tax += !empty($rd_data->purr_vatamount)?$rd_data->purr_vatamount:0;
                        ?>
                        <tr>
                            <td><?php echo !empty($rd_data->purr_returnno)?$rd_data->purr_returnno:'';?></td>
                            <td><?php echo !empty($rd_data->purr_invoiceno)?$rd_data->purr_invoiceno:'';?></td>
                            <td><?php echo $return_date;?></td>
                            <td align="right"><?php echo $rd_data->purr_returnamount;?></td>
                            <td align="right"><?php echo $rd_data->purr_discount;?></td>
                            <td align="right"><?php echo $rd_data->purr_vatamount;?></td>
                            <td><?php echo $rd_data->purr_operator;?></td>
                        </tr>
                        <?php
                            endforeach;
                        ?>
                    <?php
                                $total_return_amount += $pd_amt;
                                $total_return_discount += $pd_dis;
                                $total_return_vat += $pd_tax;
                                endif;
                            endforeach;
                        
                    ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right"><strong><?php echo number_format($pd_amt,2); ?></strong></td>
                            <td align="right"><strong><?php echo number_format($pd_dis,2); ?></strong></td>
                            <td align="right"><strong><?php echo number_format($pd_tax,2); ?></strong></td>
                            <td></td>
                        </tr>
                </tbody>
                
                <tbody>
                    <tr>
                        <td colspan="3" align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_return_amount,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_return_discount,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_return_vat,2);?></strong></td>
                        <td></td>
                    </tr>

                    <tr class="borderBottom">
                        <td colspan="9" class="text-center" align="center">
                            <strong><?php echo $this->lang->line('in_words').': '.$this->general->number_to_word($total_return_amount); ?></strong>
                        </td>
                    </tr>
                </tbody>
            <?php endif; ?>
            </table>
        </div> -->
    </div>
</div>