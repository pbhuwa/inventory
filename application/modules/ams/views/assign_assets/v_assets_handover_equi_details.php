
<form method="post" id="Formpmdata" action="<?php echo base_url('biomedical/pm_data/save_pm_data'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/pm_data/form_pm_data'); ?>'>
    <input type="hidden" name="id" value="<?php echo !empty($pmdata[0]->riva_riskid)?$pmdata[0]->riva_riskid:'';  ?>">
    <input type="hidden" name="pmtableid" value="<?php echo !empty($pmdata[0]->pmta_pmtableid)?$pmdata[0]->pmta_pmtableid:''; ?>">
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="pm_data_body">
        <div id="FormDiv_PmData" class="search_pm_data">
        </div>
    </div>
    <div class="clearfix"></div>
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</form>
<div class="form-group"> 
      <h3 class="box-title"><?php echo $this->lang->line('assign_history'); ?></h3>
      <div class="table-responsive">
    <table class="table table-border table-striped table-site-detail dataTable">
        <thead>
            <tr>
                <th width="10%">Ass.Date (AD)</th>
                <th width="10%">Ass.Date (BS)</th>
                <th width="10%">Ent.Date(AD)</th>
                <th width="10%">Ent.Date(BS)</th>
                <th width="20%">Assign To</th>
                <th width="20%">Assign By</th>
                <th width="20%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(isset($equip_assign)){
                foreach ($equip_assign as $eak => $assign):
                ?>
                <tr>
                    <td><?php echo $assign->eqas_assigndatead; ?></td>
                    <td><?php echo $assign->eqas_assigndatebs; ?></td>
                    <td><?php echo $assign->eqas_postdatead; ?></td>
                    <td><?php echo $assign->eqas_postdatebs; ?></td>
                    <td><?php echo $assign->stin_fname.' '.$assign->stin_lname; ?></td>
                    <td><?php echo $assign->usma_username; ?></td>
                    <td>

                        <?php if($assign->eqas_ishandover=='N'): ?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-success btnHandover" data-eqas_equipmentassignid="<?php echo $assign->eqas_equipmentassignid; ?>" data-equipid="<?php echo $assign->eqas_equipid; ?>" data-equipdepid="<?php echo $assign->eqas_equipdepid; ?>" data-equiproomid="<?php echo $assign->eqas_equiproomid; ?>" data-staffcode="<?php echo $assign->stin_code; ?>" data-staffname="<?php echo $assign->stin_fname.' '.$assign->stin_lname; ?>"><?php echo $this->lang->line('handover'); ?></a>
                    <?php endif; ?>
                    </td>

                </tr>
                <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>
    </div>
</div>
