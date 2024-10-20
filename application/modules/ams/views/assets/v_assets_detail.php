<style type="text/css">

   .bg-gray .search_pm_data ul.pm_data li label{

   min-width: 117px !important;

   }

   .bg-gray{

   background-color: #e6f0ec;

   }

   .bg-gray .pm_data_body{

   background: transparent !important;

   border:0px !important;

   column-count:unset !important;

   }

   .bg-gray .pm_data li{

   width: 100% !important;

   }

   .asset_details >li >a{

   padding: 10px 12px  !important;

   }

   img{

    height: 50px;

    

   }

</style>

<div class="search_pm_data bg-gray">

   <!-- <ul class="pm_data pm_data_body space"> -->

   <div class="row">

      <div class="col-md-6">

        <input type="hidden" name="depr_type" id="depr_type" value="<?php echo !empty($assets_detail[0]->asen_depreciation)?$assets_detail[0]->asen_depreciation:'';?>">

         <ul class="pm_data pm_data_body space">

            <li>

               <label><?php echo $this->lang->line('assets_code'); ?></label>

               <span><?php echo !empty($assets_detail[0]->asen_assetcode)?$assets_detail[0]->asen_assetcode:'';?></span>

            </li>

            <li>

               <label>Assets Category</label>

               <span>

                <?php  echo !empty($assets_detail[0]->eqca_category)?$assets_detail[0]->eqca_category:'';?>

               </span>

            </li>

            <li>

               <label>Item Name</label>

               <span><?php echo !empty($assets_detail[0]->itli_itemname)?$assets_detail[0]->itli_itemname:'';?></span>

            </li>
              <li>

               <label><?php echo $this->lang->line('description'); ?></label>
               <span><?php echo !empty($assets_detail[0]->asen_desc)?$assets_detail[0]->asen_desc:'';?></span>

            </li>

            <li>

               <label><?php echo $this->lang->line('manufacture'); ?></label>

               <span> <?php echo !empty($assets_detail[0]->manu_manlst)?$assets_detail[0]->manu_manlst:'';?></span>

            </li>

            <li>

               <label><?php echo $this->lang->line('brand'); ?></label>

               <span> <?php echo !empty($assets_detail[0]->asen_brand)?$assets_detail[0]->asen_brand:'';?></span>

            </li>

            <li>

               <label><?php echo $this->lang->line('model_no'); ?></label>

               <span><?php echo !empty($assets_detail[0]->asen_modelno)?$assets_detail[0]->asen_modelno:'';?></span>

            </li>

         </ul>

      </div>

      <div class="col-md-6">

         <ul class="pm_data pm_data_body space">

            <li>

               <label><?php echo $this->lang->line('serial_no'); ?></label>

               <span><?php echo !empty($assets_detail[0]->asen_serialno)?$assets_detail[0]->asen_serialno:'';?></span>

            </li>

            <li>

               <label><?php echo $this->lang->line('assets_status'); ?></label>

               <span><?php echo !empty($assets_detail[0]->asst_statusname)?$assets_detail[0]->asst_statusname:'';?></span>

            </li>

            <li>

               <label><?php echo $this->lang->line('assets_condition'); ?></label>

               <span><?php echo !empty($assets_detail[0]->asco_conditionname)?$assets_detail[0]->asco_conditionname:'';?></span>

            </li>
            <li>

               <label><?php echo $this->lang->line('purchase_date'); ?></label>

               <span><?php echo !empty($assets_detail[0]->asen_purchasedatebs)?$assets_detail[0]->asen_purchasedatebs.' (B.S)':'';?></span>

            </li> 
            <li>

               <label><?php echo $this->lang->line('purchase_value'); ?></label>

               <span><?php echo !empty($assets_detail[0]->asen_purchaserate)?$assets_detail[0]->asen_purchaserate:'';?></span>

            </li>
            <?php if (ORGANIZATION_NAME=='KU'): ?>
            <li>

               <label>School</label>

               <span><?php echo !empty($assets_detail[0]->schoolname)?$assets_detail[0]->schoolname:'';?></span>

            </li>
            <li>

               <label>Department</label>
               <?php
                $parentdep=!empty($assets_detail[0]->depparent)?$assets_detail[0]->depparent:'';
                if(!empty($parentdep)){
                   $depname = $assets_detail[0]->depparent.'/'.$assets_detail[0]->dept_depname;  
                  }else{
                     $depname = $assets_detail[0]->dept_depname;  
                  }?>
               <span><?php echo $depname;?></span>


            </li>

            <li>

               <label>Received By</label>
               <?php
               $receiver_name = '';
               if(empty($assets_detail[0]->asen_staffid)){
                  $str = strtoupper($assets_detail[0]->asen_desc);
                  if(strpos($str, "RECEVIED BY") || strpos($str, "RECEVIED BY"))
                  {
                  $replace_rec_var = substr($str,strpos($str, "RECEVIED BY"), -1);
                  $replace_rec = str_replace('RECEVIED BY', '', $replace_rec_var);
                  $receiver_name = $replace_rec;
                  }
               }else{
                  $fname =!empty($assets_detail[0]->stin_fname)?$assets_detail[0]->stin_fname:'';
                  $mname =!empty($assets_detail[0]->stin_mname)?$assets_detail[0]->stin_mname:'';
                  $lname =!empty($assets_detail[0]->stin_lname)?$assets_detail[0]->stin_lname:'';
                  $receiver_name = $fname.' '.$mname.' '.$lname;
               }
               ?>
               <span><?php echo $receiver_name;?></span>


            </li>
            <?php endif ?>

         </ul>

      </div>

      </div>
      <div class="row">
         <div class="col-md-6">
            <div id="AssetTag_Reprint">
            <?php   
             $this->load->view('ams/asset_sync/'.REPORT_SUFFIX.'/v_assets_code_reprint', $this->data); ?>
            </div>
         </div>
         <div col-md-1>
           <button class="btn btn-success " id="reprint_asset_code" data-viewdiv="AssetTag_Reprint">Reprint</button>
         </div>
      </div>
    </div>

    <script type="text/javascript">
       $(document).off('click','#reprint_asset_code');
       $(document).on('click','#reprint_asset_code',function(){
         let displayDiv = $(this).data('viewdiv');
         $('#'+displayDiv).printThis();
       });
    </script>
