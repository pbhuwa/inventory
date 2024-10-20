<style type="text/css">
    table tr:last-child{
        font-weight: 700;
    }
  .alt_table tbody tr td {
    white-space: normal;
}
</style>

<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');
         $this->load->view('assets_report/v_asset_report_common_header'); ?>
  <div class="table-responsive">
   <?php 
        $grand_assets_cnt=0;
        $grand_prate_items=0;
        if (!empty($report_result['category'])):
         $tot_asscnt_items=0;
         $tot_prate_items=0;
        ?>

         <?php
                    foreach ($report_result['category'] as $kde => $itm):
                       
                    ?>
                     <?php 
                        $tot_asscnt_items += !empty($itm->cnt) ? $itm->cnt : 0;
                        $tot_prate_items  += !empty($itm->prate) ? $itm->prate : 0;
                    ?>
                   
                  
                 
                    <?php
                     // if($is_per=='Y'){
                        $sub_cat_items_asset_rec=$this->assets_report_mdl->get_category_wise_items_info($itm->asen_assettype);
                        // echo $this->db->last_query();

                        // echo "<pre>";
                        // print_r($sub_cat_items_asset_rec);
                        // // die();
                        if($sub_cat_items_asset_rec):
                              $tot_asscnt_cat=0;
                             $tot_prate_cat=0;
                            ?>
                           
                         <table class="table table-striped alt_table" style="margin-top: 5px;">
                            <thead>
                                <tr style="background: #e0e0e0;">
                                <td colspan="5" style="text-align: left">
                                     <strong><?php
                                      if($itm->eqca_category==''){
                                        echo "Unknown Category";
                                      }else{
                                          echo $itm->eqca_category; 
                                      }

                                      
                                   
                                     ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <th>S.N</th>
                                <th width="15%" >Item Code</th>
                                <th width="30%" >Item Name</th>
                                <th>No.of Assets</th>
                                <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $j=1;
                            foreach ($sub_cat_items_asset_rec as $ksda => $itm):
                        ?>
                        
                        <tr>
                            <td><?php echo $j ?>.</td>
                            <td><?php if($itm->itli_itemcode=='') echo "-"; else echo  $itm->itli_itemcode; ?></td>
                            <td><?php if($itm->itli_itemname=='') echo "-"; else echo  $itm->itli_itemname; ?></td>
                            <td><?php echo $itm->cnt; ?></td>
                           <td><?php echo number_format($itm->prate,2); ?></td>

                        </tr>
                         <?php 
                        $tot_asscnt_cat += !empty($itm->cnt) ? $itm->cnt : 0;
                        $tot_prate_cat  += !empty($itm->prate) ? $itm->prate : 0;

                       
                    ?>
                        
                        <?php
                         $j++;
                        endforeach;
                        $grand_assets_cnt +=$tot_asscnt_cat;
                        $grand_prate_items += $tot_prate_cat;
                        ?>
                         <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td><?=number_format($tot_asscnt_cat,2) ?></td>
                            <td><?=number_format($tot_prate_cat,2) ?></td>
                         </tr>
                         </tbody>
                         </table>
                        
                     
                        <?php
                        endif;
                    
                     ?>

                <?php endforeach; ?>
               
            <?php endif; 
         
         ?> 
          <table class="table table-striped alt_table" style="margin-top: 5px ">
                             <tbody>
                             <tr style="background: black">

                                <td colspan="2" width="50%" style=" font-size: 14px;color: white">Grand Total</td>
                                <td width="20%" style=" font-size: 14px;color: white;padding-left: 38px;"><?php echo number_format($grand_assets_cnt,2); ?></td>
                                <td style=" font-size: 14px;color: white"><?php echo number_format($grand_prate_items,2); ?></td>
                             </tr>
                             </tbody>
                         </table>

    </div>
    </div>
</div>