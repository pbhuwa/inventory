 <div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="8%"><?php echo $this->lang->line('return_no'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('date'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('bill_no'); ?></th>
                        <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('discount'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('vat_amount'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('net_amount'); ?> </th>
                        <th width="10%"><?php echo $this->lang->line('user'); ?></th>
                    </tr>
                </thead> 
                <tbody>             
                <?php
                    if($pur_ret_list): 
                        $rm_amt=0;
                        $rm_dis=0;
                        $rm_tax=0;
                        $net_amt=0;
                        foreach ($pur_ret_list as $km => $mlist):
                            $rm_amt += $mlist->purr_returnamount;
                            $rm_dis +=  $mlist->purr_discount;
                            $rm_tax += $mlist->purr_vatamount;
                            $net_amtamt =($mlist->purr_returnamount-$mlist->purr_discount+$mlist->purr_vatamount);
                            $net_amt+= $net_amtamt;
                ?>
                    <tr>
                        <td> <?php echo $mlist->purr_invoiceno; ?></td>
                        <td> <?php echo $mlist->purr_returndatebs ?></td>
                        <td> <?php echo $mlist->purr_remarks; ?></td>
                        <td> <?php echo $mlist->dist_distributor ?></td>
                        <td align="right"> <?php echo $mlist->purr_returnamount ?></td>
                        <td align="right"> <?php echo $mlist->purr_discount ?></td>
                        <td align="right"> <?php echo $mlist->purr_vatamount ?></td>
                        <td align="right"> <?php echo number_format($net_amtamt,2); ?></td>
                        <td> <?php echo $mlist->purr_returnby; ?></td>
                    </tr>
                <?php
                    endforeach;
                ?>
                    <tr>
                        <td colspan="4" align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></td>
                        <td align="right"><strong><?php echo number_format($rm_amt,2); ?></strong></td>
                        <td align="right"><strong><?php echo number_format($rm_dis,2); ?></strong></td>
                        <td align="right"><strong><?php echo number_format($rm_tax,2); ?></strong></td>
                        <td align="right"><strong><?php echo number_format($net_amt,2); ?></strong></td>
                        <td></td>
                    </tr>
                <?php  endif; ?>
                <tr class="borderBottom">
                    <td colspan="9" class="text-center" align="center">
                        <strong>
                            <?php 
                                echo $this->lang->line("in_words");
                            ?>: 
                            <?php echo $this->general->number_to_word($net_amt);?>
                        </strong>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="alt_table" style="margin:50px 0px; border: 0px; font-weight: bold;">
                <tr class="noborder">
                    <td class="noborder" align="left" style="text-align: left;"><?php echo $this->lang->line('prepared_by'); ?></td>
                    <td class="noborder" align="center" style="text-align: center;"><?php echo $this->lang->line('forwarded_by'); ?></td>
                    <td class="noborder" align="right" style="text-align: right;"><?php echo $this->lang->line('approved_by'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>