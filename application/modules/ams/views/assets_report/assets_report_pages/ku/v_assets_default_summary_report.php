<style type="text/css">
    table tr:last-child{
        font-weight: 600;
    }
  .alt_table tbody tr td {
    white-space: normal;
}
</style>

<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');
         $this->load->view('assets_report/v_asset_report_common_header'); ?>

        <?php 
             $tot_asscnt=0;
             $tot_prate=0;

            if (!empty($report_result['suppliers'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Supplier</th>
                        <th>No.of Assets</th>
                        <th>Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['suppliers'] as $key => $supp):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $supp->dist_distributor; ?></td>           
                        <td><?php echo $supp->cnt; ?></td>           
                        <td><?php echo number_format($supp->prate,2); ?></td>               
                    </tr>
                    <?php 
                        $tot_asscnt += !empty($supp->cnt) ? $supp->cnt : 0;
                        $tot_prate += !empty($supp->prate) ? $supp->prate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td><?=$tot_asscnt?></td>
                        <td><?=number_format($tot_prate,2)?></td>
                      
                    </tr>
                </tbody>

            </table>
        </div>
         <?php endif; ?>
    <br>
    <?php 
             $tot_asscnt_cat=0;
             $tot_prate_cat=0;

            if (!empty($report_result['category'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">Category</th>
                        <th>No.of Assets</th>
                        <th>Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['category'] as $key => $cat):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $cat->eqca_category; ?></td>           
                        <td><?php echo $cat->cnt; ?></td>           
                        <td><?php echo number_format($cat->prate,2); ?></td>               
                    </tr>
                    <?php 
                        $tot_asscnt_cat += !empty($cat->cnt) ? $cat->cnt : 0;
                        $tot_prate_cat  += !empty($cat->prate) ? $cat->prate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td><?=$tot_asscnt_cat ?></td>
                        <td><?=number_format($tot_prate_cat,2) ?></td>
                      
                    </tr>
                </tbody>

            </table>
        </div>
         <?php endif; ?>

          <br>
    <?php 
         $tot_asscnt_school=0;
         $tot_prate_school=0;
        if (!empty($report_result['school'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="30%">School</th>
                        <th>No.of Assets</th>
                        <th>Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['school'] as $key => $cat):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $cat->schoolname; ?></td>           
                        <td><?php echo $cat->cnt; ?></td>           
                        <td><?php echo number_format($cat->prate,2); ?></td>               
                    </tr>
                    <?php 
                        $tot_asscnt_school += !empty($cat->cnt) ? $cat->cnt : 0;
                        $tot_prate_school  += !empty($cat->prate) ? $cat->prate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td><?=$tot_asscnt_school ?></td>
                        <td><?=number_format($tot_prate_school,2) ?></td>
                      
                    </tr>
                </tbody>

            </table>
        </div>
         <?php endif; ?>


          <?php 
         $tot_asscnt_items=0;
         $tot_prate_items=0;
        if (!empty($report_result['items'])):
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th width="15%">Items</th>
                        <th width="30%">Detail</th>
                        <th>Unit</th>
                        <th style="text-align: right;">No.of Assets</th>
                        <th style="text-align: right;">Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['items'] as $key => $itm):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $itm->itemname; ?></td>     
                        <td><?php echo $itm->asen_desc; ?></td>     
                        <td><?php echo $itm->unit_unitname; ?></td>     
                        <td><?php echo $itm->cnt; ?></td>           
                        <td><?php echo number_format($itm->prate,2); ?></td>               
                    </tr>
                    <?php 
                        $tot_asscnt_items += !empty($itm->cnt) ? $itm->cnt : 0;
                        $tot_prate_items  += !empty($itm->prate) ? $itm->prate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="4">Total</td>
                        <td><?=$tot_asscnt_items ?></td>
                        <td><?=number_format($tot_prate_items,2) ?></td>
                      
                    </tr>
                </tbody>

            </table>
        </div>
         <?php endif; ?>  

        <?php 
        if (!empty($report_result['receiver'])):
         $tot_asscnt_items=0;
         $tot_prate_items=0;
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="15%">Receiver</th>
                        <th width="30%">Items</th>
                        <th width="8%" style="text-align: right;">No.of Assets</th>
                        <th width="10%" style="text-align: right;">Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['receiver'] as $key => $itm):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $itm->receiver_name; ?></td>     
                        <td><?php echo $itm->itemname; ?></td>     
                        <td><?php echo $itm->cnt; ?></td>           
                        <td><?php echo number_format($itm->prate,2); ?></td>               
                    </tr>
                    <?php 
                        $tot_asscnt_items += !empty($itm->cnt) ? $itm->cnt : 0;
                        $tot_prate_items  += !empty($itm->prate) ? $itm->prate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?=$tot_asscnt_items ?></td>
                        <td><?=number_format($tot_prate_items,2) ?></td>
                      
                    </tr>
                </tbody>

            </table>
        </div>
         <?php endif; ?>


        <?php 
        /*
        if (!empty($report_result['department'])):
         $tot_asscnt_items=0;
         $tot_prate_items=0;
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="15%">Department</th>
                        <th width="8%" style="text-align: right;">No.of Assets</th>
                        <th width="10%" style="text-align: right;">Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['department'] as $key => $itm):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php 
                        if (!empty($itm->fromdepparent)) {
                            echo "$itm->fromdepparent - $itm->dept_depname";
                        }else{

                            echo $itm->dept_depname; 
                        }
                        ?></td>     
                        <td ><?php echo $itm->cnt; ?></td>           
                        <td><?php echo $itm->prate; ?></td>               
                    </tr>
                    <?php 
                        $tot_asscnt_items += !empty($itm->cnt) ? $itm->cnt : 0;
                        $tot_prate_items  += !empty($itm->prate) ? $itm->prate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="2">Total</td>
                        <td><?=$tot_asscnt_items ?></td>
                        <td><?=$tot_prate_items ?></td>
                      
                    </tr>
                </tbody>

            </table>
        </div>
         <?php endif; 
            */
         ?> 

          <?php 
     
        if (!empty($report_result['department'])):
         $tot_asscnt_items=0;
         $tot_prate_items=0;
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="15%">Department</th>
                        <th width="8%" style="text-align: right;">No.of Assets</th>
                        <th width="10%" style="text-align: right;">Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($report_result['department'] as $kde => $itm):
                        $is_per=$itm->is_per;
                        $sub_dep=$itm->sub_dep;
                        if($is_per=='Y'){
                            $attrib="style='font-weight: bold;'";
                        }else{
                             $attrib='';
                        }
                    ?>
                     <?php 
                        $tot_asscnt_items += !empty($itm->cnt) ? $itm->cnt : 0;
                        $tot_prate_items  += !empty($itm->prate) ? $itm->prate : 0;
                    ?>
                    <tr <?php echo $attrib; ?>>
                        <td><?php echo $kde+1; ?></td>
                        <td><?php echo $itm->dept_depname ?></td>
                        <td><?php echo $itm->cnt; ?></td>
                        <td><?php echo number_format($itm->prate,2); ?></td>
                    </tr>
                    <?php
                     if($is_per=='Y'){
                        $sub_dep_asset_rec=$this->assets_report_mdl->get_sub_department_asset_data($sub_dep);
                        // echo "<pre>";
                        // print_r($sub_dep_asset_rec);
                        // // die();
                        if($sub_dep_asset_rec):
                            $j=1;
                            foreach ($sub_dep_asset_rec as $ksda => $sudp):
                        ?>
                        <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;&nbsp;<?php echo  $j.'. '.$sudp->dept_depname; ?></td>
                            <td><?php echo $sudp->cnt; ?></td>
                           <td><?php echo number_format($sudp->prate,2); ?></td>

                        </tr>
                        <?php
                         $j++;
                        endforeach;
                        endif;
                     }
                     ?>

                <?php endforeach; ?>
                
                <tr>
                        <td colspan="2">Total</td>
                        <td><?=$tot_asscnt_items ?></td>
                        <td><?=number_format($tot_prate_items,2) ?></td>
                      
                    </tr>
                    </tbody>
            </table>

            <?php endif; 
         
         ?> 




        <?php 
        if (!empty($report_result['purchase_date'])):
         $tot_asscnt_items=0;
         $tot_prate_items=0;
        ?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th width="2%">S.N</th>
                        <th width="5%">Pur. Date</th>
                        <th width="15%">Item Name</th>
                        <th width="8%" style="text-align: right;">No.of Assets</th>
                        <th width="10%" style="text-align: right;">Amount</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($report_result['purchase_date'] as $key => $itm):
                    ?>  
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?php echo $itm->asen_purchasedatebs; ?></td>     
                        <td ><?php echo $itm->itemname; ?></td>           
                        <td ><?php echo $itm->cnt; ?></td>           
                        <td><?php echo number_format($itm->prate,2); ?></td>               
                    </tr>
                    <?php 
                        $tot_asscnt_items += !empty($itm->cnt) ? $itm->cnt : 0;
                        $tot_prate_items  += !empty($itm->prate) ? $itm->prate : 0;
                    ?>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?=$tot_asscnt_items ?></td>
                        <td><?=number_format($tot_prate_items,2) ?></td>
                      
                    </tr>
                </tbody>

            </table>
        </div>
         <?php endif; ?>
    </div>
</div>