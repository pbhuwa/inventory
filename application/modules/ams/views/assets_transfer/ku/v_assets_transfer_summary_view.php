<style>

    .mcolor{

        background: #FF8C00 !important;

    }

</style>

<?php
$transfertype=$assets_transfer_master[0]->astm_transfertypeid;
$transfer_type='Inter School';
?>

<div class="form-group white-box pad-5 bg-gray">

    <div class="row">

        <div class="col-sm-4 col-xs-6">

            <label>Fiscal Year</label>: 

            <span> <?php echo !empty($assets_transfer_master[0]->astm_fiscalyrs)?$assets_transfer_master[0]->astm_fiscalyrs:''; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Transfer No:</label> 

            <span><?php echo !empty($assets_transfer_master[0]->astm_transferno)?$assets_transfer_master[0]->astm_transferno:'0'; ?></span>

        </div>

         <div class="col-sm-4 col-xs-6">

            <label for="example-text">Manual No:</label> 

            <span><?php echo !empty($assets_transfer_master[0]->astm_manualno)?$assets_transfer_master[0]->astm_manualno:'0'; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Transfer Type:</label> 

            <span><?php echo $transfer_type?></span>

        </div>

       

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Transfer From:</label>
 <?php

              $school_id=!empty($assets_transfer_master[0]->astm_fromschoolid)?$assets_transfer_master[0]->astm_fromschoolid:'';

               $school_result=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$school_id),'loca_name','ASC'); 

               if(!empty($school_result)){

                echo !empty($school_result[0]->loca_name)?$school_result[0]->loca_name:'';

               }

              ?>
 <?php 



            $reqdepartment=!empty($assets_transfer_master[0]->astm_from)?$assets_transfer_master[0]->astm_from:'';

            $check_parentid=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$reqdepartment),'dept_depname','ASC');

            $dep_parent_dep_name='';

            $sub_depname='';
if(!empty($check_parentid)){

              $dep_parentid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';

              $dep_parent_dep_name=!empty($check_parentid[0]->dept_depname)?$check_parentid[0]->dept_depname:'';



              if($dep_parentid!=0){

              $sub_department=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$dep_parentid),'dept_depname','ASC');

              if(!empty($sub_department)){

               $sub_depname=!empty($sub_department[0]->dept_depname)?$sub_department[0]->dept_depname:'';

              }

              }   

            }



            if(!empty($sub_depname)){

              echo $sub_depname.'('.$dep_parent_dep_name.')';

            }else{

              echo $dep_parent_dep_name;

            }

        ?>
          

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">To:</label> 
            <?php

              $school_id=!empty($assets_transfer_master[0]->astm_toschoolid)?$assets_transfer_master[0]->astm_toschoolid:'';

               $school_result=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$school_id),'loca_name','ASC'); 

               if(!empty($school_result)){

                echo !empty($school_result[0]->loca_name)?$school_result[0]->loca_name:'';

               }

              ?>
 <?php 



            $reqdepartment=!empty($assets_transfer_master[0]->astm_to)?$assets_transfer_master[0]->astm_to:'';

            $check_parentid=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$reqdepartment),'dept_depname','ASC');

            $dep_parent_dep_name='';

            $sub_depname='';
            if(!empty($check_parentid)){
              $dep_parentid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
              $dep_parent_dep_name=!empty($check_parentid[0]->dept_depname)?$check_parentid[0]->dept_depname:'';

              if($dep_parentid!=0){
              $sub_department=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$dep_parentid),'dept_depname','ASC');
              if(!empty($sub_department)){
               $sub_depname=!empty($sub_department[0]->dept_depname)?$sub_department[0]->dept_depname:'';
                }
              }   
            }

             if(!empty($sub_depname)){
              echo $sub_depname.'('.$dep_parent_dep_name.')';

            }else{

              echo $dep_parent_dep_name;

            }

        ?>
          
        </div>


        <div class="col-sm-4 col-xs-6">
            <label>Received By</label>:
            <?php echo !empty($assets_transfer_master[0]->astm_receivedby)?$assets_transfer_master[0]->astm_receivedby:''; ?>
         </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text">Date</label>: 
            <span class="inline_block">
            <b><?php echo !empty($assets_transfer_master[0]->astm_transferdatebs)?$assets_transfer_master[0]->astm_transferdatebs:''; ?></b> BS -- <b><?php echo !empty($assets_transfer_master[0]->astm_transferdatead)?$assets_transfer_master[0]->astm_transferdatead:''; ?></b> AD
            </span>
        </div>
         <div class="col-sm-6 col-xs-6">
            <label>Remarks</label>
            <?php echo !empty($assets_transfer_master[0]->astm_remark)?$assets_transfer_master[0]->astm_remark:''; ?>
         </div>

          <div class="col-sm-6">
             <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/ams/assets_transfer/re_print_transfer') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($assets_transfer_master[0]->astm_assettransfermasterid)?$assets_transfer_master[0]->astm_assettransfermasterid:''; ?>">



                <?php echo $this->lang->line('reprint'); ?>



            </button>

          </div>





         

    </div>

</div> 



<div class="form-group">

    <div class="row">

        <div class="table-responsive col-sm-12">

            <table style="width:100%;" class="table purs_table dataTable con_ttl">

                <thead>

                    <tr>

                        <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>

                        <th width="8%">Assets Code </th>
                        <th width="8%">Item Name</th>

                        <th width="6%">Description</th>

                        <th width="6%">Original Cost</th>

                        <th width="5%">Prev. Receiver</th>

                        <th width="5%"><?php echo $this->lang->line('remarks'); ?></th>

                    </tr>

                </thead>

                

                <tbody id="purchaseDataBody">

                    <?php 

                    // echo "<pre>";

                    // print_r($stock_requisition);

                    // die();

                        if(!empty($assets_transfer_detail)) { 

                            // $grandtotal=0;

                            foreach ($assets_transfer_detail as $key => $odr) 

                            { 

                                // $qty = $odr->wode_qty;

                                // $unitprice = $odr->wode_rate;

                                // $sub_total_amt = $qty * $unitprice;

                

                    ?>

                    <tr class="orderrow" id="orderrow_<?php echo $key+1 ?>" data-id='<?php echo $key+1 ?>'>

                        <td><?php echo $key+1; ?></td>

                        <td><?php echo $odr->asen_assetcode ?></td>
                          <td><?php echo $odr->itli_itemname ?></td>

                        <td><?php echo $odr->asen_desc ?></td>

                        <td align="right"><?php echo $odr->astd_originalamt ?></td>

                        <td align="right"><?php echo $odr->astd_prev_staffname ?></td>

                        <td><?php echo $odr->astd_remark; ?></td>

                    </tr>

                <?php

                    } 

                    } 

                ?>

                </tbody>

                   <!--  <tfoot>

                        <tr>

                    <th  colspan="6">

                        <h5 align="right" colspan="8" style="color: #333; padding-top: 0px; font-size: 12px;"><strong>Estimated Cost:</strong></h5>

                        <td align="right" style="color: #333; padding-top: 22px; font-size: 13px;"><strong>

                            <?php echo number_format($grandtotal,2) ?></strong>

                        </td>

                    </th>

                </tr>

                <?php if($grandtotal >'0.00'): ?>

                <tr>

                    <td colspan="7"><strong><?php echo $this->lang->line('in_words'); ?>: <?php echo $this->general->number_to_word($grandtotal); ?></strong></td>

                </tr>

            <?php endif; ?>

            </tfoot> -->



                

            </table>

        </div>

    </div>

</div>

<div id="FormDiv_Reprint" class="printTable"></div>    