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
                        <th width="20%">Item Name</th>
                        <th width="5%">Qty</th>
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
                    foreach ($report_result as $key => $value):
                    ?>  
                   <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $value->pure_reqdatebs; ?></td>           
                        <td><?php echo $value->pure_reqdatead; ?></td>           
                        <td><?php echo $value->pure_reqno; ?></td>           
                        <td><?php echo "$value->itli_itemcode-$value->itli_itemname</br>($value->unit_unitname)"; ?></td>           
                        <td><?php echo $value->purd_qty; ?></td>           
                        <td><?php echo $value->user; ?></td>           
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
    <?php endif;?>
    </div>
</div>