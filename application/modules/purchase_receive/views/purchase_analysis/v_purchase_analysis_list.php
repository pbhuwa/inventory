<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>

        <?php
            if(!empty($pur_summary_supplier_wise)):
        ?>
        <!-- supplier wise -->
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th colspan="6" align="center" style="text-align: center;">
                            <strong><?php echo $this->lang->line('purchase_summary_supplier'); ?></strong>
                        </th>
                    </tr>
                    <tr>
                        <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('purchase_amount'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('cc'); ?><!-- cc amount --></th>
                        <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('vat_amount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('balance'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_purchase_amount = 0;
                        $total_purchase_discount = 0;
                        $total_purchase_vat = 0;
                        $total_purchase_balance = 0;
                        
                        if($pur_summary_supplier_wise):
                            foreach ($pur_summary_supplier_wise as $ksm => $supp):
                                $supp_data=$this->purchase_analysis_mdl->get_purchase_summary('supplier_wise',array('rm.recm_supplierid'=>$supp->recm_supplierid));
                                // echo $this->db->last_query();
                                // echo"<br>";
                                if($supp_data): 
                    ?>
                    <?php
                        if($supp_data): 
                            $rm_amt=0;
                            $rm_dis=0;
                            $rm_tax=0;
                            $rm_cleamt=0;

                            foreach ($supp_data as $km => $mlist):
                                $rm_amt += !empty($mlist->total_amount)?$mlist->total_amount:0;
                                $rm_dis += !empty($mlist->total_discount)?$mlist->total_discount:0;
                                $rm_tax += !empty($mlist->total_tax)?$mlist->total_tax:0;
                                $rm_cleamt += !empty($mlist->total_camount)?$mlist->total_camount:0;

                                if(DEFAULT_DATEPICKER == 'NP'){
                                    $received_date = !empty($mlist->recm_receiveddatebs)?$mlist->recm_receiveddatebs:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatebs)?$mlist->recm_supbilldatebs:'';
                                }else{
                                    $received_date = !empty($mlist->recm_receiveddatead)?$mlist->recm_receiveddatead:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatead)?$mlist->recm_supbilldatead:'';
                                }
                    ?>
                        <tr>
                            <td><?php echo !empty($mlist->dist_distributor)?$mlist->dist_distributor:'';; ?></td>

                            <td align="right">
                                <?php
                                    $recm_amt = !empty($mlist->total_amount)?$mlist->total_amount:0;
                                    echo number_format($recm_amt,2) ?>
                            </td>
                            <td align="center"><?php echo '-' ?></td>
                            <td align="right">
                                <?php
                                    $recm_dis = !empty($mlist->total_discount)?$mlist->total_discount:0;
                                    echo number_format($recm_dis,2);
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_tax = !empty($mlist->total_tax)?$mlist->total_tax:0; 
                                    echo number_format($recm_tax,2); 
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_clearanceamt = !empty($mlist->total_camount)?$mlist->total_camount:0; 
                                    echo number_format($recm_clearanceamt,2); 
                                ?>
                            </td>
                           
                        </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                       
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
                        <td colspan="1" align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_amount,2);?></strong></td>
                        <td align="center">-</td>
                        <td align="right"><strong><?php echo number_format($total_purchase_discount,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_vat,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_balance,2);?></strong></td>
                        
                    </tr>
                    <tr class="borderBottom">
                        <td colspan="6" class="text-center" align="center">
                            <strong><?php echo $this->lang->line('in_words').': '.$this->general->number_to_word($total_purchase_balance); ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
            endif;
        ?>

        <?php
            if(!empty($pur_summary_date_wise)):
        ?>
        <!-- date wise -->
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th colspan="6" align="center" style="text-align: center;">
                            <strong><?php echo $this->lang->line('purchase_summary_date'); ?></strong>
                        </th>
                    </tr>
                    <tr>
                        <th width="15%"><?php echo $this->lang->line('date'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('purchase_amount'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('cc'); ?><!-- cc amount --></th>
                        <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('vat_amount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('balance'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_purchase_amount = 0;
                        $total_purchase_discount = 0;
                        $total_purchase_vat = 0;
                        $total_purchase_balance = 0;
                        
                        if($pur_summary_date_wise):
                            foreach ($pur_summary_date_wise as $ksm => $supp):
                                $supp_data=$this->purchase_analysis_mdl->get_purchase_summary('date_wise',array('rm.recm_receiveddatebs'=>$supp->recm_receiveddatebs));
                                // echo $this->db->last_query();
                                // echo"<br>";
                                if($supp_data): 
                    ?>
                    <?php
                        if($supp_data): 
                            $rm_amt=0;
                            $rm_dis=0;
                            $rm_tax=0;
                            $rm_cleamt=0;

                            foreach ($supp_data as $km => $mlist):
                                $rm_amt += !empty($mlist->total_amount)?$mlist->total_amount:0;
                                $rm_dis += !empty($mlist->total_discount)?$mlist->total_discount:0;
                                $rm_tax += !empty($mlist->total_tax)?$mlist->total_tax:0;
                                $rm_cleamt += !empty($mlist->total_camount)?$mlist->total_camount:0;

                                if(DEFAULT_DATEPICKER == 'NP'){
                                    $received_date = !empty($mlist->recm_receiveddatebs)?$mlist->recm_receiveddatebs:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatebs)?$mlist->recm_supbilldatebs:'';
                                }else{
                                    $received_date = !empty($mlist->recm_receiveddatead)?$mlist->recm_receiveddatead:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatead)?$mlist->recm_supbilldatead:'';
                                }
                    ?>
                        <tr>
                            <td>
                                <?php echo !empty($mlist->recm_receiveddatebs)?$mlist->recm_receiveddatebs:'';; ?>
                                (<?php echo !empty($mlist->recm_receiveddatead)?$mlist->recm_receiveddatead:'';; ?>)
                            </td>

                            <td align="right">
                                <?php
                                    $recm_amt = !empty($mlist->total_amount)?$mlist->total_amount:0;
                                    echo number_format($recm_amt,2) ?>
                            </td>
                            <td align="center"><?php echo '-' ?></td>
                            <td align="right">
                                <?php
                                    $recm_dis = !empty($mlist->total_discount)?$mlist->total_discount:0;
                                    echo number_format($recm_dis,2);
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_tax = !empty($mlist->total_tax)?$mlist->total_tax:0; 
                                    echo number_format($recm_tax,2); 
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_clearanceamt = !empty($mlist->total_camount)?$mlist->total_camount:0; 
                                    echo number_format($recm_clearanceamt,2); 
                                ?>
                            </td>
                           
                        </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                       
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
                        <td colspan="1" align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_amount,2);?></strong></td>
                        <td align="center">-</td>
                        <td align="right"><strong><?php echo number_format($total_purchase_discount,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_vat,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_balance,2);?></strong></td>
                        
                    </tr>
                    <tr class="borderBottom">
                        <td colspan="6" class="text-center" align="center">
                            <strong><?php echo $this->lang->line('in_words').': '.$this->general->number_to_word($total_purchase_balance); ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
            endif;
        ?>

        <?php
            if(!empty($pur_summary_item_wise)):
        ?>
        <!-- item wise -->
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th colspan="7" align="center" style="text-align: center;">
                            <strong><?php echo $this->lang->line('purchase_summary_item'); ?></strong>
                        </th>
                    </tr>
                    <tr>
                        <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('qty'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('purchase_amount'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('cc'); ?><!-- cc amount --></th>
                        <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('vat_amount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('balance'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_qty = 0;
                        $total_purchase_amount = 0;
                        $total_purchase_discount = 0;
                        $total_purchase_vat = 0;
                        $total_purchase_balance = 0;
                        
                        if($pur_summary_item_wise):
                            foreach ($pur_summary_item_wise as $ksm => $supp):
                                $supp_data=$this->purchase_analysis_mdl->get_purchase_summary('item_wise',array('rd.recd_itemsid'=>$supp->itemsid));
                                // echo $this->db->last_query();
                                // echo"<br>";
                                if($supp_data): 
                    ?>
                    <?php
                        if($supp_data): 
                            $rm_qty = 0;
                            $rm_amt=0;
                            $rm_dis=0;
                            $rm_tax=0;
                            $rm_cleamt=0;

                            foreach ($supp_data as $km => $mlist):
                                $rm_qty += !empty($mlist->total_qty)?$mlist->total_qty:0;
                                $rm_amt += !empty($mlist->total_amount)?$mlist->total_amount:0;
                                $rm_dis += !empty($mlist->total_discount)?$mlist->total_discount:0;
                                $rm_tax += !empty($mlist->total_tax)?$mlist->total_tax:0;
                                $rm_cleamt += !empty($mlist->total_camount)?$mlist->total_camount:0;

                                if(DEFAULT_DATEPICKER == 'NP'){
                                    $received_date = !empty($mlist->recm_receiveddatebs)?$mlist->recm_receiveddatebs:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatebs)?$mlist->recm_supbilldatebs:'';
                                }else{
                                    $received_date = !empty($mlist->recm_receiveddatead)?$mlist->recm_receiveddatead:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatead)?$mlist->recm_supbilldatead:'';
                                }
                    ?>
                        <tr>
                            <td>
                                <?php echo !empty($mlist->itli_itemname)?$mlist->itli_itemname:'';; ?>
                            </td>

                            <td>
                                <?php 
                                    $recd_qty = !empty($mlist->total_qty)?$mlist->total_qty:''; 
                                    echo $recd_qty;
                                ?>
                            </td>

                            <td align="right">
                                <?php
                                    $recm_amt = !empty($mlist->total_amount)?$mlist->total_amount:0;
                                    echo number_format($recm_amt,2) ?>
                            </td>
                            <td align="center"><?php echo '-' ?></td>
                            <td align="right">
                                <?php
                                    $recm_dis = !empty($mlist->total_discount)?$mlist->total_discount:0;
                                    echo number_format($recm_dis,2);
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_tax = !empty($mlist->total_tax)?$mlist->total_tax:0; 
                                    echo number_format($recm_tax,2); 
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_clearanceamt = !empty($mlist->total_camount)?$mlist->total_camount:0; 
                                    echo number_format($recm_clearanceamt,2); 
                                ?>
                            </td>
                           
                        </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                       
                    <?php 
                            $total_qty += $rm_qty;
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
                        <td align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></td>
                        <td><strong><?php echo $total_qty;?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_amount,2);?></strong></td>
                        <td align="center">-</td>
                        <td align="right"><strong><?php echo number_format($total_purchase_discount,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_vat,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_balance,2);?></strong></td>
                        
                    </tr>
                    <tr class="borderBottom">
                        <td colspan="7" class="text-center" align="center">
                            <strong><?php echo $this->lang->line('in_words').': '.$this->general->number_to_word($total_purchase_balance); ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
            endif;
        ?>

        <?php
            if(!empty($pur_summary_category_wise)):
        ?>
        <!-- category wise -->
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th colspan="7" align="center" style="text-align: center;">
                            <strong><?php echo $this->lang->line('purchase_summary_category'); ?></strong>
                        </th>
                    </tr>
                    <tr>
                        <th width="15%"><?php echo $this->lang->line('category'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('qty'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('purchase_amount'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('cc'); ?><!-- cc amount --></th>
                        <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('vat_amount'); ?></th>
                        <th width="7%"><?php echo $this->lang->line('balance'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_qty = 0;
                        $total_purchase_amount = 0;
                        $total_purchase_discount = 0;
                        $total_purchase_vat = 0;
                        $total_purchase_balance = 0;
                        
                        if($pur_summary_category_wise):
                            foreach ($pur_summary_category_wise as $ksm => $supp):
                                $supp_data=$this->purchase_analysis_mdl->get_purchase_summary('category_wise',array('ec.eqca_equipmentcategoryid'=>$supp->eqca_equipmentcategoryid));
                                // echo $this->db->last_query();
                                // echo"<br>";
                                if($supp_data): 
                    ?>
                    <?php
                        if($supp_data): 
                            $rm_qty = 0;
                            $rm_amt=0;
                            $rm_dis=0;
                            $rm_tax=0;
                            $rm_cleamt=0;

                            foreach ($supp_data as $km => $mlist):
                                $rm_qty += !empty($mlist->total_qty)?$mlist->total_qty:0;
                                $rm_amt += !empty($mlist->total_amount)?$mlist->total_amount:0;
                                $rm_dis += !empty($mlist->total_discount)?$mlist->total_discount:0;
                                $rm_tax += !empty($mlist->total_tax)?$mlist->total_tax:0;
                                $rm_cleamt += !empty($mlist->total_camount)?$mlist->total_camount:0;

                                if(DEFAULT_DATEPICKER == 'NP'){
                                    $received_date = !empty($mlist->recm_receiveddatebs)?$mlist->recm_receiveddatebs:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatebs)?$mlist->recm_supbilldatebs:'';
                                }else{
                                    $received_date = !empty($mlist->recm_receiveddatead)?$mlist->recm_receiveddatead:'';
                                    $supplier_date = !empty($mlist->recm_supbilldatead)?$mlist->recm_supbilldatead:'';
                                }
                    ?>
                        <tr>
                            <td>
                                <?php echo !empty($mlist->eqca_category)?$mlist->eqca_category:'';; ?>
                            </td>

                            <td>
                                <?php 
                                    $recd_qty = !empty($mlist->total_qty)?$mlist->total_qty:''; 
                                    echo $recd_qty;
                                ?>
                            </td>

                            <td align="right">
                                <?php
                                    $recm_amt = !empty($mlist->total_amount)?$mlist->total_amount:0;
                                    echo number_format($recm_amt,2) ?>
                            </td>
                            <td align="center"><?php echo '-' ?></td>
                            <td align="right">
                                <?php
                                    $recm_dis = !empty($mlist->total_discount)?$mlist->total_discount:0;
                                    echo number_format($recm_dis,2);
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_tax = !empty($mlist->total_tax)?$mlist->total_tax:0; 
                                    echo number_format($recm_tax,2); 
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                    $recm_clearanceamt = !empty($mlist->total_camount)?$mlist->total_camount:0; 
                                    echo number_format($recm_clearanceamt,2); 
                                ?>
                            </td>
                           
                        </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                       
                    <?php 
                            $total_qty += $rm_qty;
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
                        <td align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></td>
                        <td><strong><?php echo $total_qty;?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_amount,2);?></strong></td>
                        <td align="center">-</td>
                        <td align="right"><strong><?php echo number_format($total_purchase_discount,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_vat,2);?></strong></td>
                        <td align="right"><strong><?php echo number_format($total_purchase_balance,2);?></strong></td>
                        
                    </tr>
                    <tr class="borderBottom">
                        <td colspan="7" class="text-center" align="center">
                            <strong><?php echo $this->lang->line('in_words').': '.$this->general->number_to_word($total_purchase_balance); ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
            endif;
        ?>
    </div>
</div>