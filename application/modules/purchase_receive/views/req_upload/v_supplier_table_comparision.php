<style type="text/css">
    .bgclass
    {
        background: #d0caca;
    }
    .min_style
    {
        background: #000000;
        color:#ffffff;
    }
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        
        <?php $this->load->view('common/v_report_header');?>
        <table class="alt_table">
               <thead>
                <tr>
                <th width="5%">S.n</th>
                <th width="15%">Item Name</th>
                <th width="15%">Comp./Man.</th>
                <th width="5%">Qty.</th>
                <th width="5%">Size</th>
                <?php echo $th_sup; ?>
            </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($itemwise_quotation_rate)):
                    $i=0;
                    foreach ($itemwise_quotation_rate as $kiq => $qrate ):
                        $minrate=$qrate->minrate;
                    ?>
                    <tr>
                        <td><?php echo $kiq+1;  ?></td>
                        <td><?php echo $qrate->ured_itemname;  ?></td>
                        <td><?php echo $qrate->ured_manufacturer;  ?></td>
                        <td><?php echo $qrate->ured_qty; ?></td>
                         <td><?php echo $qrate->ured_size; ?></td>
                        
                        <?php
                        if(!empty($distinct_supplier))
                         {
                            $j=0;
                            $comprat='';
                            $tmp='';
                            foreach ($distinct_supplier as $kds => $sup) {
                                $sup_rate=('sup'.$j);
                                $main_sup_rate=$qrate->{$sup_rate}; 
                                $bgclass='';
                                if($main_sup_rate== $minrate)
                                {
                                    $bgclass='bgclass';
                                }
                                ?>
                                <td align="right" class="<?php echo $bgclass; ?>"><?php echo $qrate->{$sup_rate} ?></td>
                                <?php
                                $j++;
                            }
                          }
                        ?>
                        

                    </tr>
                    <?php
                endforeach;
                $i++;
                endif; 
                ?>
            </tbody>
            <tr>
                <td colspan="5">Total</td>
                <?php echo $sumtemp; ?> 
            </tr>
              
        </table>
    </div>
    </div>
</div>
