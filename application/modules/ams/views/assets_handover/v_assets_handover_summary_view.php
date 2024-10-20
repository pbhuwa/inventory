<style>

    .mcolor{

        background: #FF8C00 !important;

    }

</style>

<style type="text/css">

  .table>tbody>tr>td:not(:last-child), .table>tbody>tr>th {

    vertical-align: middle !important;

    white-space: normal !important;

}

.table-wrapper {
    overflow-y: inherit !important;
    height: auto !important;
    width: 100%  !important;
}

</style>

<div class="form-group white-box pad-5 bg-gray">

    <div class="row">

        <div class="col-sm-4 col-xs-6">

            <label>Fiscal Year</label>: 

            <span> <?php echo !empty($handover_master_data[0]->ashm_fyear)?$handover_master_data[0]->ashm_fyear:''; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Ref No:</label> 

            <span><?php echo !empty($handover_master_data[0]->ashm_refno)?$handover_master_data[0]->ashm_refno:''; ?></span>

        </div>

      

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Handover Date:</label> 

            <span><?php echo !empty($handover_master_data[0]->ashm_handoverdatebs)?$handover_master_data[0]->ashm_handoverdatebs:''; ?></span>

        </div>

       

          <div class="col-sm-4 col-xs-6">
            <label for="example-text">Handover From:</label>
            <span><?php echo !empty($handover_master_data[0]->ashm_fromstaffname)?$handover_master_data[0]->ashm_fromstaffname:''; ?></span>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text">Handover To:</label>
              <span><?php echo !empty($handover_master_data[0]->ashm_tostaffname)?$handover_master_data[0]->ashm_tostaffname:''; ?></span>
          </div>


        <div class="col-sm-4 col-xs-6">
            <label>No. of Assets</label>:
           <span><?php echo !empty($handover_master_data[0]->ashm_assetcount)?$handover_master_data[0]->ashm_assetcount:''; ?></span>
         </div>
        
        
         <div class="col-sm-6 col-xs-6">
            <label>Remarks</label>
            <?php echo !empty($handover_master_data[0]->ashm_remark)?$handover_master_data[0]->ashm_remark:''; ?>
         </div>

          <div class="col-sm-6">
            <?php $handover_master_id=!empty($handover_master_data[0]->ashm_id)?$handover_master_data[0]->ashm_id:''; ?>
             <a href="<?php echo base_url("/ams/assets_handover/re_print_assets_handover?mid=$handover_master_id");?>" class="btn btn-success" target="_blank">
                  <?php echo $this->lang->line('reprint'); ?>
             </a>

          </div>





         

    </div>

</div> 



<div class="form-group">

    <div class="row">

        <div class="table-responsive col-sm-12">

            <table style="width:100%;" class="table purs_table dataTable con_ttl">

                <thead>

                     <tr>
                    <th width="3%">S.n</th>
                    <th width="5%">System.ID</th>
                    <th width="8%">Assets Code</th>
                    <th width="8%" style="text-align: right;">Category</th>
                    <th width="10%" style="text-align: right;">Item Name</th>
                    <th width="10%" style="text-align: right;">Description</th>
                    <th width="5%" style="text-align: right;">Pur.Date</th>
                    <th width="5%" style="text-align: right;">Unit Price</th>
                    <th width="6%">School</th>
                    <th width="6%">Department</th>
                    <th width="6%">Supplier</th>
                    
                </tr>

                </thead>

                
  <tbody>
                <?php 
                if(!empty($handover_detail_data)):
                    $i=1;
                    foreach($handover_detail_data as $hdd):
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $hdd->ashd_assetsid ?></td>
                    <td><?php echo $hdd->asen_assetcode ?></td>
                    <td><?php echo $hdd->eqca_category ?></td>
                    <td><?php echo $hdd->itli_itemname ?></td>
                    <td><?php echo $hdd->asen_desc ?></td>
                    <td><?php echo $hdd->asen_purchasedatebs ?></td>
                    <td><?php echo $hdd->asen_purchaserate ?></td>
                    <td><?php echo $hdd->schoolname ?></td>
                    <td><?php
                                $parentdep=!empty($hdd->depparent)?$hdd->depparent:'';
                                 if(!empty($parentdep)){
                                     $depname = $hdd->depparent.'/'.$hdd->dept_depname;    
                                    }else{
                                        $depname = $hdd->dept_depname; 
                                    }
                                 
                               echo $depname;
                            ?></td>
                    <td><?php echo $hdd->dist_distributor ?></td>
                </tr>
                <?php
                    $i++;
                    endforeach;
                    endif;
                 ?>
            </tbody>
          </table>

        </div>

    </div>

</div>

