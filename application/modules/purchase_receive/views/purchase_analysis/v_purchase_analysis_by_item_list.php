<?php 
    if(!empty($item_category)):
?>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>

        <?php
            if($item != 'All'):
        ?>
        <table class="alt_table" style="border: 0px;margin-bottom: -5px; padding: 0px;">
            <tr>
                <td class="header noborder"><?php echo $this->lang->line('opening_stock'); ?>: <?php echo !empty($opening_stock[0]->stockqty)?$opening_stock[0]->stockqty:0;?></td>
            </tr>
        </table>
        <?php
            endif;
        ?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="6%"><?php echo $this->lang->line('purchase_date'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('bill_no'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('mrn_no'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('order_no'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('total'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('discount'); ?></th>
                        <th width="3%"><?php echo $this->lang->line('vat_amount'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('grand_total'); ?></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($item_category):
                            $grandttlamt =0;
                            $granddis =0;
                            $grandvat =0;
                            $grandtotal =0;
                            $grandextra = 0;

                            foreach ($item_category as $ksm => $catid):
                                $itemcat=$this->purchase_analysis_mdl->get_purchase_by_item(array('rd.recd_itemsid'=>$catid->itemsid),false,false,'recm_receiveddatead','ASC');
                                if($itemcat): 
                    ?>
                    <tr>
                        <td colspan="12"> 
                            <?php
                                if($item == 'All'):
                            ?>
                            <strong>
                                Item name:
                            </strong>
                                <?php echo $catid->itli_itemname;?>
                            
                            <span class="pull-right">
                                <strong>Category: </strong>
                                <?php echo $catid->eqca_category;?>
                            </span>
                            <?php
                                else:
                            ?>
                                <?php echo $catid->eqca_category;?>
                            <?php 
                                endif; 
                            ?>
                        </td>
                    </tr>
                    <?php
                        if($itemcat): 
                            $i=1;
                            $newdis=0;
                            $newvat=0;
                            $newtotal=0;
                            $newttlamt=0;
                            
                            foreach ($itemcat as $km => $mlist):
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php 
                                if(DEFAULT_DATEPICKER=='NP') {
                                    echo $mlist->recm_receiveddatebs; }
                                else
                                {
                                    echo $mlist->recm_receiveddatead;
                                }
                            ?>
                        </td>
                        
                        <td>
                            <?php echo $mlist->dist_distributor; ?>
                        </td>
                        <td><?php echo $mlist->recm_supplierbillno; ?></td>
                        <td><?php echo $mlist->recm_invoiceno; ?></td>
                        <td>
                            <?php echo $mlist->recm_purchaseorderno; ?>
                        </td>
                   
                        <td>
                            <?php echo number_format($mlist->recd_purchasedqty,0) ?>
                        </td>
                        <td align="right" class="text-right">
                            <?php echo number_format($mlist->recd_unitprice,2); ?>
                        </td>
                        <td align="right" class="text-right">
                            <?php 
                                $ttlamt=($mlist->recd_purchasedqty) *($mlist->recd_unitprice);
                                echo number_format($ttlamt,2);
                            ?>
                        </td>
                        <td align="right" class="text-right">
                            <?php 
                                $disamt=$ttlamt* $mlist->recd_discountpc/100; 
                                echo number_format($disamt,2);    
                            ?>
                        </td>
                        <td align="right" class="text-right">
                            <?php 
                                $vatamt=($ttlamt-$disamt)* ($mlist->recd_vatpc/100); 
                                echo number_format($vatamt,2);
                            ?>
                        </td>
                        <td align="right" class="text-right">
                            <strong>
                                <?php 
                                    $gtotal= $ttlamt-$disamt+$vatamt;
                                    echo number_format($gtotal,2);
                                ?>
                            </strong>
                        </td>
                    </tr>
                        <?php
                            $newttlamt +=$ttlamt;
                            $newdis +=$disamt;
                            $newvat +=$vatamt;
                            $newtotal +=$gtotal;
                            $i++;
                            endforeach;
                        endif;
                        ?>
                    <tr class="borderBottom">
                        <td colspan="9" align="right" class="text-right">
                            <strong><?php echo number_format($newttlamt,2); ?></strong>
                        </td>
                        <td align="right" class="text-right">
                            <strong><?php echo number_format($newdis,2); ?></strong>
                        </td>
                        <td align="right" class="text-right">
                            <strong><?php echo number_format($newvat,2); ?></strong>
                        </td>
                        <td align="right" class="text-right">
                            <strong><?php  echo number_format($newtotal,2); ?></strong>
                        </td>   
                    </tr>
                <?php  
                        endif; 
                        $grandttlamt +=$newttlamt;
                        $granddis += $newdis;
                        $grandvat +=$newvat;
                        $grandtotal +=$newtotal;
                    endforeach;
                ?>

                    <tr>
                        <td colspan="9" class="header text-right" align="right"><?php echo $this->lang->line('total'); ?>:</td>
                        <td colspan="3"  class="header text-right" align="right">
                            <?php 
                                echo number_format($grandttlamt,2); 
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="9" class="header text-right" align="right"><?php echo $this->lang->line('discount'); ?>:</td>
                        <td colspan="3"  class="header text-right" align="right">
                            <?php echo number_format($granddis,2); ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="9" class="header text-right" align="right"><?php echo $this->lang->line('tax'); ?>:</td>
                        <td colspan="3"  class="header text-right" align="right">
                            <?php echo number_format($grandvat,2); ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="9" class="header text-right" align="right"><?php echo $this->lang->line('extra'); ?>:</td>
                        <td colspan="3"  class="header text-right" align="right">
                            <?php echo number_format($grandextra,2); ?>
                        </td>
                    </tr>

                    <tr class="borderBottom">
                        <td colspan="9" class="header text-right" align="right"><?php echo $this->lang->line('grand_total'); ?>:</td>
                        <td colspan="3"  class="header text-right" align="right">
                            <?php echo number_format($grandtotal,2); ?>
                        </td>
                    </tr>

                    <tr class="borderBottom">
                        <td colspan="12" class="text-center" align="center">
                            <strong><?php echo $this->lang->line('in_words').': '.$this->general->number_to_word($grandtotal); ?></strong>
                        </td>
                    </tr>
                    <?php
                        endif; 
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>