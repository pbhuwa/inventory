<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>

        <table class="table_jo_header purchaseInfo">
            <tr>
            <!-- <td class="text-center"><h4><u>
                    <?php 
                    // if(!empty($equipmenttype[0]->maty_material))
                    {
                       // echo $equipmenttype[0]->maty_material;
                    }
                    // else{
                       // echo $this->lang->line('all_store');
                    //}
                    ?>
            </u></h4></td> -->
            </tr>
        </table>

        <table id="" class="format_pdf" width="100%">
            <thead>
                <tr>
                    <th width="10%" style="text-align: center;"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="30%" style="text-align: center;"><?php echo $this->lang->line('store'); ?> </th>
                    <th width="20%" style="text-align: center;"><?php echo $this->lang->line('stock_value'); ?></th>
                    <th width="20%" style="text-align: center;"><?php echo $this->lang->line('in_transaction_value'); ?></th>
                    <th width="20%" style="text-align: center;"><?php echo $this->lang->line('total_stock_value'); ?></th>
                </tr>
            </thead>
            
            <tbody>
                <?php 
                    if($purchase): 
                        $i=1; $sum = $sumintransaction = $suminstock = 0;
                        foreach ($purchase as $key => $stock):
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo !empty($stock->eqty_equipmenttype)?$stock->eqty_equipmenttype:'';?></td>
                    <td style="text-align: right;"><?php echo !empty($stock->instock)?number_format($stock->instock,2):'';?></td>
                    <td style="text-align: right;"><?php echo !empty($stock->intransaction)?number_format($stock->intransaction,2):'';?></td>
                    <td style="text-align: right;"><?php echo !empty($stock->totalstockval)?number_format($stock->totalstockval,2):'';?></td>
                    <?php 
                        $sum += $stock->totalstockval; 
                        $sumintransaction += $stock->intransaction;
                        $suminstock += $stock->instock;
                    ?>
                </tr>
                <?php
                        $i++;
                        endforeach;
                    endif;
                ?>
                
                <tr class="total">
                    <td width="10%">
                    <td style="text-align:center"><b><?php echo $this->lang->line('grand_total'); ?></b></td>
                    <td style="text-align: right;"><b><?php echo number_format($suminstock,2);?></b></td>
                    <td style="text-align: right;"><b><?php echo number_format($sumintransaction,2);?></b></td>
                    <td style="text-align: right;"><b><?php echo number_format($sum,2);?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>