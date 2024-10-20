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
        if(!empty($report_result)):
        $this->load->view('v_common_report_head.php'); 
    ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="5%">Req. Date (B.S)</th>
                        <th width="5%">Req. Date (A.D)</th>
                        <th width="5%">Req. No.</th>
                        <th width="5%">Item Code</th>
                        <th width="10%">Item Name</th>
                        <th width="5%">Req. Qty.</th>
                        <th width="5%">Issued Qty.</th>
                        <th width="5%">Rem. Qty</th>
                        <th width="8%">Material Type</th>
                        <th width="5%">Req. By</th>
                        <th width="15%">Remarks</th>
                        <th width="25%">From</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    foreach ($report_result as $key => $value):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $value->rema_reqdatebs; ?></td>           
                        <td><?php echo $value->rema_reqdatead; ?></td>           
                        <td><?php echo $value->rema_reqno; ?></td>           
                        <td><?php echo $value->itli_itemcode; ?></td>           
                        <td><?php echo $value->itli_itemname; ?></td>           
                        <td><?php echo $value->rede_qty; ?></td>           
                        <td><?php echo ($value->rede_qty - $value->rede_remqty); ?></td>           
                        <td><?php echo $value->rede_remqty; ?></td>           
                        <td><?php echo $value->maty_material; ?></td>           
                        <td><?php echo $value->rema_reqby; ?></td>           
                        <td><?php echo $value->rede_remarks; ?></td>           
                        <td>
                        <?php 
                            $schoolname=!empty($value->schoolname)?$value->schoolname:'';
                            $depparent=!empty($value->deptparent)?$value->deptparent:'';
                            if(!empty($depparent)){
                               echo $schoolname.'-'.$depparent.'/'.$value->dept_depname;    
                            }else{
                                echo !empty($value->dept_depname) ? "$schoolname-$value->dept_depname" : $schoolname;
                            }?></td>            
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <?php endif;?>
    </div>
</div>