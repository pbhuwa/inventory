
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
       <?php 
       $this->load->view('v_common_report_head.php'); 
        if(!empty($report_result['suppliers'] )):
       ?>

        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Supplier</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
                    
                    foreach ($report_result['suppliers'] as $key => $supp):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $supp->suppliername; ?></td>           
                        <td><?php echo $supp->amount; ?></td>           
                        <td><?php echo $supp->discount; ?></td>           
                        <td><?php echo $supp->taxamount; ?></td>           
                        <td><?php echo $supp->refund; ?></td>           
                        <td><?php echo $supp->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($supp->amount) ? $supp->amount : 0;
                        $tot_dis += !empty($supp->discount) ? $supp->discount : 0;
                        $tot_tax += !empty($supp->taxamount) ? $supp->taxamount : 0;
                        $tot_refund += !empty($supp->refund) ? $supp->refund : 0;
                        $tot_gtotal += !empty($supp->recm_gtotal) ? $supp->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_refund?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['material'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Material Category</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['material'] as $key => $mat):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $mat->materialname; ?></td>           
                        <td><?php echo $mat->amount; ?></td>           
                        <td><?php echo $mat->discount; ?></td>           
                        <td><?php echo $mat->taxamount; ?></td>           
                        <td><?php echo $mat->refund; ?></td>           
                        <td><?php echo $mat->recm_gtotal; ?></td>
                    </tr>           
                    <?php 
                        $tot_amt += !empty($mat->amount) ? $mat->amount : 0;
                        $tot_dis += !empty($mat->discount) ? $mat->discount : 0;
                        $tot_tax += !empty($mat->taxamount) ? $mat->taxamount : 0;
                        $tot_refund += !empty($mat->refund) ? $mat->refund : 0;
                        $tot_gtotal += !empty($mat->recm_gtotal) ? $mat->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_refund?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['school'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">School</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['school'] as $key => $sch):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $sch->schoolname; ?></td>           
                        <td><?php echo $sch->amount; ?></td>           
                        <td><?php echo $sch->discount; ?></td>           
                        <td><?php echo $sch->taxamount; ?></td>           
                        <td><?php echo $sch->refund; ?></td>           
                        <td><?php echo $sch->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($sch->amount) ? $sch->amount : 0;
                        $tot_dis += !empty($sch->discount) ? $sch->discount : 0;
                        $tot_tax += !empty($sch->taxamount) ? $sch->taxamount : 0;
                        $tot_refund += !empty($sch->refund) ? $sch->refund : 0;
                        $tot_gtotal += !empty($sch->recm_gtotal) ? $sch->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_refund?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
                
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['department'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Department</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['department'] as $key => $dep):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $dep->departmentname; ?></td>           
                        <td><?php echo $dep->amount; ?></td>           
                        <td><?php echo $dep->discount; ?></td>           
                        <td><?php echo $dep->taxamount; ?></td>           
                        <td><?php echo $dep->refund; ?></td>           
                        <td><?php echo $dep->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($dep->amount) ? $dep->amount : 0;
                        $tot_dis += !empty($dep->discount) ? $dep->discount : 0;
                        $tot_tax += !empty($dep->taxamount) ? $dep->taxamount : 0;
                        $tot_refund += !empty($dep->refund) ? $dep->refund : 0;
                        $tot_gtotal += !empty($dep->recm_gtotal) ? $dep->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_refund?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_refund = $tot_gtotal = 0;
            if (!empty($report_result['budget_head'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Budget Head</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>Refund</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['budget_head'] as $key => $bud):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $bud->budgetname; ?></td>           
                        <td><?php echo $bud->amount; ?></td>           
                        <td><?php echo $bud->discount; ?></td>           
                        <td><?php echo $bud->taxamount; ?></td>           
                        <td><?php echo $bud->refund; ?></td>           
                        <td><?php echo $bud->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($bud->amount) ? $bud->amount : 0;
                        $tot_dis += !empty($bud->discount) ? $bud->discount : 0;
                        $tot_tax += !empty($bud->taxamount) ? $bud->taxamount : 0;
                        $tot_refund += !empty($bud->refund) ? $bud->refund : 0;
                        $tot_gtotal += !empty($bud->recm_gtotal) ? $bud->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_refund?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
            if (!empty($report_result['items'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Item Name</th>
                        <th>Qty.</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['items'] as $key => $bud):
                        $t_amount = $bud->amount*$bud->qty;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $bud->itemname; ?></td>           
                        <td><?php echo $bud->qty; ?></td>           
                        <td><?php echo $t_amount; ?></td>           
                        <td><?php echo $bud->discount; ?></td>           
                        <td><?php echo $bud->taxamount; ?></td>           
                        <td><?php echo $bud->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($t_amount) ? $t_amount : 0;
                        $tot_qty += !empty($bud->qty) ? $bud->qty : 0;
                        $tot_dis += !empty($bud->discount) ? $bud->discount : 0;
                        $tot_tax += !empty($bud->taxamount) ? $bud->taxamount : 0;
                        $tot_gtotal += !empty($bud->recm_gtotal) ? $bud->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_qty?></td>
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?>
     <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
            if (!empty($report_result['staff_info'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Staff Name</th>
                        <th>Qty.</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['staff_info'] as $key => $stin):
                        $t_amount = $stin->amount*$stin->qty;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $stin->stin_fname.' '.$stin->stin_mname. ' '.$stin->stin_lname; ?></td>           
                        <td><?php echo $stin->qty; ?></td>           
                        <td><?php echo $t_amount; ?></td>           
                        <td><?php echo $stin->discount; ?></td>           
                        <td><?php echo $stin->taxamount; ?></td>           
                        <td><?php echo $stin->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($t_amount) ? $t_amount : 0;
                        $tot_qty += !empty($stin->qty) ? $stin->qty : 0;
                        $tot_dis += !empty($stin->discount) ? $stin->discount : 0;
                        $tot_tax += !empty($stin->taxamount) ? $stin->taxamount : 0;
                        $tot_gtotal += !empty($stin->recm_gtotal) ? $stin->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><?=$tot_qty?></td>
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?> 

    <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
            if (!empty($report_result['received_date'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Received Date</th>
                   
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['received_date'] as $key => $rd):
                        $t_amount = $rd->amount*$rd->qty;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $rd->recm_receiveddatebs; ?></td>       
                        <td><?php echo $t_amount; ?></td>           
                        <td><?php echo $rd->discount; ?></td>           
                        <td><?php echo $rd->taxamount; ?></td>           
                        <td><?php echo $rd->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($t_amount) ? $t_amount : 0;
                      
                        $tot_dis += !empty($rd->discount) ? $rd->discount : 0;
                        $tot_tax += !empty($rd->taxamount) ? $rd->taxamount : 0;
                        $tot_gtotal += !empty($rd->recm_gtotal) ? $rd->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                      
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?>

    <?php 
            $tot_amt = $tot_dis = $tot_tax = $tot_gtotal = $tot_qty = 0;
            if (!empty($report_result['bill_date'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Bill Date</th>
                        <th>Qty.</th>
                        <th>S.Total</th>
                        <th>Discount</th>
                        <th>VAT</th>
                        <th>G.Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['bill_date'] as $key => $rd):
                        $t_amount = $rd->amount*$rd->qty;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $rd->recm_supbilldatebs; ?></td>           
                          
                        <td><?php echo $t_amount; ?></td>           
                        <td><?php echo $rd->discount; ?></td>           
                        <td><?php echo $rd->taxamount; ?></td>           
                        <td><?php echo $rd->recm_gtotal; ?></td>           
                    </tr>
                    <?php 
                        $tot_amt += !empty($t_amount) ? $t_amount : 0;
                      
                        $tot_dis += !empty($rd->discount) ? $rd->discount : 0;
                        $tot_tax += !empty($rd->taxamount) ? $rd->taxamount : 0;
                        $tot_gtotal += !empty($rd->recm_gtotal) ? $rd->recm_gtotal : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan='2'>Total</td>
                       
                        <td><?=$tot_amt?></td>
                        <td><?=$tot_dis?></td>
                        <td><?=$tot_tax?></td>
                        <td><?=$tot_gtotal?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif;?>
    </div>
</div>