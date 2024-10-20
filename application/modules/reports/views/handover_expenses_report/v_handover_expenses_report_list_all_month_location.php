<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php  $this->load->view('common/v_report_header',$this->data); ?> 
        <table class="alt_table" width="100%">
            <thead>
                <tr>
                    <th>महिना</th>
                    <?php 
                    $gtotal_all=0;
                        if(!empty($location_list)): 
                            foreach($location_list as $loc):
                                // $sum_loc ='sum_loc'.$loc
                                $sum_loc_{$loc->loca_locationid}=0;

                    ?>
                    <th><?php echo $loc->loca_name; ?></th>
                    <?php 
                        endforeach;
                        endif; 
                    ?>
                     <th>जम्मा</th>
                   
                </tr>
            </thead>
            
            <tbody>
                <?php 
                if(!empty($handover_exp_rpt)): 
                foreach($handover_exp_rpt as $hexrp):
                $month_total = 0.00;
                ?>
                <tr>
                <td><?php echo $hexrp->fyrs; ?></td>
                 <?php 
                    if(!empty($location_list)): 
                        foreach($location_list as $loc):
                            // handexploc_
                        $loc_exp= 'handexploc_'.$loc->loca_locationid;
                    ?>
                    <td><?php echo $loc_total=!empty($hexrp->{$loc_exp})?$hexrp->{$loc_exp}:'0.00'; 
                        $month_total +=$loc_total;
                        $sum_loc_{$loc->loca_locationid} +=$loc_total;
                    ?></td>
                    <?php 
                    endforeach;
                    endif; 
                ?>
                <td><?php echo $month_total;  $gtotal_all+= $month_total;?></td>
            </tr>
            <?php 
                endforeach;
                endif; 
            ?>
            <tr>
                    <td><strong>G.Total</strong></td>
                     <?php 
                    if(!empty($location_list)): 
                        foreach($location_list as $loc):
                    ?>
                    <td><?php echo $sum_loc_{$loc->loca_locationid}; ?></td>
                    <?php
                        endforeach;
                        endif;

                    ?>
                    <td><?php echo $gtotal_all; ?></td>
                </tr>
            </tbody>
            
                
       
        </table>
    </div>
</div>