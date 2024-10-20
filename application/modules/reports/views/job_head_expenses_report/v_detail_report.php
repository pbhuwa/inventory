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
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <?php 
        if(!empty($report_result) && !empty($budget_head)):
    ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                       <th>Category</th>
                       <?php 
                       $grand_total = array();
                       $bh_count = count($budget_head);
                        foreach($budget_head as $bud):
                            $grand_total[] = 0;
                       ?>
                       <th><?php echo $bud->buhe_headtitle;?></th>
                    <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result as $key => $value):?>
                    <tr>
                        <td><?php echo $value['name']; ?></td>        
                       <?php foreach ($budget_head as $bk => $bh) {
                            if( array_key_exists($bh->buhe_bugetheadid, $value['details'])){ 
                                $grand_total[$bk] += $value['details'][$bh->buhe_bugetheadid];
                                echo '<td style="text-align:right;">'. number_format($value['details'][$bh->buhe_bugetheadid],2).'</td>';
                            }  
                       } ?>        
                    </tr>
                    <?php endforeach;?>
                    <tr style="text-align:right">
                       <td>Total</td>
                        <?php 
                        for ($i = 0; $i < $bh_count; $i++):
                        ?>
                       <td><?php echo number_format($grand_total[$i],2);?></td>
                        <?php endfor; ?>
                    </tr>
                </tbody>
                
            </table>
        </div>
    <br>
    <?php endif;?>
     </div> 