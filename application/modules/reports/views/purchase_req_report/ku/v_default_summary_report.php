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
    /*.table>tbody>tr:last-child td {
        font-weight:bold;
    }*/
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header');?>
    <?php 
        if(!empty($report_result['summary'] )):
        // $this->load->view('v_common_report_head.php'); 
    ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="5%">Req.Date (B.S)</th>
                        <th width="5%">Req.Date (A.D)</th>
                        <th width="5%">Req. No.</th>
                        <th width="5%">Dem. No.</th>
                        <th width="5%">Requisted By</th>
                        <th width="5%">Requested To</th>
                        <th width="5%">Approved?</th>
                        <th width="5%">Approved By</th>
                        <th width="5%">Approved Date</th>
                        <th width="5%">Material Type</th>
                        <th width="25%">Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    foreach ($report_result['summary'] as $key => $value):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $value->pure_reqdatebs; ?></td>           
                        <td><?php echo $value->pure_reqdatead; ?></td>           
                        <td><?php echo $value->pure_reqno; ?></td>           
                        <td><?php echo $value->pure_streqno; ?></td>           
                        <td><?php echo $value->pure_requser; ?></td>           
                        <td><?php echo $value->pure_requestto; ?></td>           
                        <td><?php echo $value->pure_isapproved; ?></td>           
                        <td><?php echo $value->usma_username; ?></td>           
                        <td><?php echo $value->pure_approveddatebs; ?></td>              
                        <td><?php echo $value->maty_material; ?></td>           
                        <td>
                        <?php 
                            $frm_dep = !empty($value->fromdept)?$value->fromdept:'';
                            $schoolname=!empty($value->schoolname)?$value->schoolname:'';
                            $depparent=!empty($value->deptparent)?$value->deptparent:'';
                            if(!empty($depparent)){
                               echo $schoolname.'-'.$depparent.'/'.$frm_dep;    
                            }else{
                                echo !empty($frm_dep) ? "$schoolname-$frm_dep" : $schoolname;
                            }?></td>           
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            if (!empty($report_result['material_type'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Material Category</th>
                        <th>Req. Qty.</th>
                        <th>Issued Qty.</th>
                        <th>Remaning Qty.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['material_type'] as $key => $value):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $value->maty_material; ?></td>           
                         <td><?php echo $value->rede_qty; ?></td>           
                        <td><?php echo ($value->rede_qty - $value->rede_remqty); ?></td>           
                        <td><?php echo $value->rede_remqty; ?></td>  
                    </tr>      
                     <?php endforeach;?>     
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            $tot_qty = $tot_cnt = 0;
            if (!empty($report_result['department'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Department</th>
                        <th>Item Cnt</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['department'] as $key => $value):
                        $tot_cnt += $value->cnt;
                        $tot_qty += $value->qty;
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td>
                        <?php 
                            $frm_dep = !empty($value->fromdept)?$value->fromdept:'';
                            $schoolname=!empty($value->schoolname)?$value->schoolname:'';
                            $depparent=!empty($value->deptparent)?$value->deptparent:'';
                            if(!empty($depparent)){
                               echo $schoolname.'-'.$depparent.'/'.$frm_dep;    
                            }else{
                                echo !empty($frm_dep) ? "$schoolname-$frm_dep" : $schoolname;
                            }?>        
                        </td>           
                        <td><?php echo $value->cnt; ?></td>               
                        <td><?php echo $value->qty; ?></td>                   
                    </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td><?=$tot_cnt?></td>
                        <td><?=$tot_qty?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
     <?php 
            if (!empty($report_result['demand_date'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Demand Date</th>
                        <th>Req. Qty.</th>
                        <th>Issued Qty.</th>
                        <th>Remaning Qty.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['demand_date'] as $key => $value):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo "$value->rema_reqdatebs (B.S) - $value->rema_reqdatead (A.D)"; ?></td>           
                         <td><?php echo $value->rede_qty; ?></td>           
                        <td><?php echo ($value->rede_qty - $value->rede_remqty); ?></td>           
                        <td><?php echo $value->rede_remqty; ?></td>  
                    </tr>      
                     <?php endforeach;?>     
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
    
    <?php 
            if (!empty($report_result['requested_by'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Requested By</th>
                        <th>Req. Qty.</th>
                        <th>Issued Qty.</th>
                        <th>Remaning Qty.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['requested_by'] as $key => $value):
                    ?>  
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo ucfirst($value->rema_reqby); ?></td>           
                         <td><?php echo $value->rede_qty; ?></td>           
                        <td><?php echo ($value->rede_qty - $value->rede_remqty); ?></td>           
                        <td><?php echo $value->rede_remqty; ?></td>  
                    </tr>      
                     <?php endforeach;?>     
                </tbody>
            </table>
        </div>
    <br>
    <?php endif;?>
    </div>
</div>