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
   
        .sub-header td {
        padding:2px 5px;
        vertical-align: top;
        display: inline-flex;
        align-items: baseline;
        font-size: 12px
    }
    .sub-header td strong {
        padding-right: 3px
    }
    .sub-header-div {
        margin:0px 0 10px !important;
        padding:8px 5px;
        background: #eaeaea;
        border-top: 1px solid;
    }

</style>
<?php 
if($print_active=='active'): ?>
<script>window.print();</script>
<?php endif; ?>
        <?php $this->load->view('common/v_report_header');?>
           <div class="sub-header-div">
          <table style="width: 100%" class="organizationInfo sub-header">
          <tbody>
              <tr>
                <td width="30%">Fiscal Year:<?php echo !empty($handover_master_data[0]->ashm_fyear)?$handover_master_data[0]->ashm_fyear:''; ?></td>
                <td width="35%">Refno:<?php echo !empty($handover_master_data[0]->ashm_refno)?$handover_master_data[0]->ashm_refno:''; ?></td>
                <td width="30%">Handover Date:<?php echo !empty($handover_master_data[0]->ashm_handoverdatebs)?$handover_master_data[0]->ashm_handoverdatebs:''; ?></td>

              </tr>
               <tr>
                <td width="30%">Handover From:<?php echo !empty($handover_master_data[0]->ashm_fromstaffname)?$handover_master_data[0]->ashm_fromstaffname:''; ?></td>
                <td width="35%">Handover To:<?php echo !empty($handover_master_data[0]->ashm_tostaffname)?$handover_master_data[0]->ashm_tostaffname:''; ?></td>
                <td width="30%">No.of Assets:<?php echo !empty($handover_master_data[0]->ashm_assetcount)?$handover_master_data[0]->ashm_assetcount:''; ?></td>

              </tr>
          </tbody>
          </table>
    </div>
    
        <table class="table  alt_table">
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


    <table class="jo_footer" style="width: 100%;border-collapse: collapse;margin-top: 10px;">
                <tr>
                    <td width="33.333333333%" style="text-align: left;white-space: nowrap;">
                         <div style="display: inline-block; text-align: left;">
                        Prepared By<br />
                           <br>
                           <br>
                            Date:<br />
                            <br>
                           <br>
                           --------------------------------------------------
                        </div>
                    </td>
                    <td width="33.333333333%" style="text-align: center;white-space: nowrap;">
                        <div style="display: inline-block; text-align: left;">
                           Handover From :<strong><?php echo !empty($handover_master_data[0]->ashm_fromstaffname)?$handover_master_data[0]->ashm_fromstaffname:''; ?></strong><br />
                           <br>
                           <br>
                            Date:<br />
                              <br>
                           <br>
                           --------------------------------------------------
                        </div>
                    </td>
                    <td width="33.333333333%" style="text-align: right;white-space: nowrap;">
                        <div style="display: inline-block; text-align: left;">
                         Handover To:<strong><?php echo !empty($handover_master_data[0]->ashm_tostaffname)?$handover_master_data[0]->ashm_tostaffname:''; ?><br />
                           <br>
                           <br>
                            Date:<br />
                              <br>
                           <br>
                           --------------------------------------------------
                        </div>
                    </td>
                </tr>
              
            </table>

