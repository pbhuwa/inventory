<div class="resultrRepairComment search_pm_data">
    <strong><u>Information: </u></strong>
    <ul class="pm_data cols3">
    <li>
        <input type="hidden" name="id" value="<?php echo!empty($comment[0]->eqco_equipmentcommentid)?$comment[0]->eqco_equipmentcommentid:'';  ?>">
        <input type="hidden" name="equipid" value="<?php echo!empty($comment[0]->eqco_eqid)?$comment[0]->eqco_eqid:'';  ?>">
    </li>
    <li>
        <label>Equipment Key: </label>
        <?php echo $comment[0]->bmin_equipmentkey; ?>
    </li>
    <li>
        <label>Comments: </label>
        <?php echo $comment[0]->bmin_comments;?>
    </li>

    <li>
        <label>Department: </label>
        <?php echo $comment[0]->dein_department;?>
    </li>
    <li>
        <label>Risk: </label>
        <?php echo $comment[0]->riva_risk;?>
    </li>
    <li>
        <label>Comment By: </label>
        <?php echo $comment[0]->usma_fullname;?>
    </li>
    <!-- <li>
        <label>Manufacturer</label>
        <?php echo $comment[0]->manu_manlst;?>
    </li> 
    <li>
        <label>Distributer</label>
        <?php //echo $comment[0]->manu_manlst;?>
    </li>-->
</ul>
</div>

<div class="AllRequestData">
    <strong><u>Description: </u></strong>
    <div class="row">
        <div class="col-sm-6">
            <label class="checkbox-inline">
                <input type="checkbox" value="5" name="rere_manufcontacted" <?php echo !empty($repairStatus[0]->rere_manufcontacted)?'checked':''; ?> disabled="disabled">Distributer / Manufacture must be contaced
            </label>
        </div>
        <div class="col-sm-6">
            <label class="checkbox-inline">
                <input type="checkbox" value="2" name="rere_cannotmove" <?php echo !empty($repairStatus[0]->rere_cannotmove)?'checked':''; ?> disabled="disabled">Cannot Be Move
            </label>
        </div>
        <div class="col-sm-6">
            <label class="checkbox-inline">
                <input type="checkbox" value="1" name="rere_warranty" <?php echo !empty($repairStatus[0]->rere_warranty)?'checked':''; ?> disabled="disabled">Under Warrenty
            </label>
        </div>
        <div class="col-sm-6">
            <label class="checkbox-inline">
                 <input type="checkbox" value="3" name="rere_onsite" <?php echo !empty($repairStatus[0]->rere_onsite)?'checked':''; ?> disabled="disabled">Can be Repaired on Site
            </label>
        </div>
        <div class="col-sm-6">
            <label class="checkbox-inline">
                <input type="checkbox" value="4" name="rere_moved" <?php echo !empty($repairStatus[0]->rere_moved)?'checked':''; ?> disabled="disabled"> Moved to Biomed Eng. Workshop
            </label>
        </div>
         <div class="col-sm-6">
            <label class="checkbox-inline">
                <input type="checkbox" value="6" name="rere_repairid" <?php echo !empty($repairStatus[0]->rere_repairid)?'checked':''; ?> disabled="disabled">Under Maintantenence Contract
            </label>
        </div>
        <div class="clearfix"></div>
        <br/>
        <div class="col-sm-6">
            <label><strong><u>Problem</u></strong></label>
            <p>
                <?php echo !empty($repairStatus[0]->rere_problem)?$repairStatus[0]->rere_problem:''; ?>
            </p> 
        </div>

        <div class="col-sm-6">
            <label><strong><u>Action</u></strong></label>
            <p>
                <?php echo !empty($repairStatus[0]->rere_action)?$repairStatus[0]->rere_action:''; ?>
            </p>
        </div>
        <br/>
        <div class="col-sm-6">
            <label><strong><u>Notes</u></strong></label>
            <p>
                <?php echo !empty($repairStatus[0]->rere_notes)?$repairStatus[0]->rere_notes:''; ?>
            </p> 
        </div>

        <div class="col-sm-6">
            <label><strong><u>Parts/Material Used</u></strong></label>
            <p>
                <?php echo !empty($repairStatus[0]->rere_parts)?$repairStatus[0]->rere_parts:''; ?>
            </p>
        </div>
    </div>
</div>

<!-- <table class="table table-border table-striped table-site-detail dataTable">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Equipment ID</th>
            <th>Equipment Key</th>
            <th>Problem</th>
            <th>Action Taken</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(!empty($repairStatus)){
                foreach($repairStatus as $key=>$status){
        ?>
            <tr>
                <td><?php echo $key+1;?></td>
                <td><?php echo !empty($status->rere_equid)?$status->rere_equid:''; ?></td>
                <td><?php echo !empty($status->bmin_equipmentkey)?$status->bmin_equipmentkey:''; ?></td>
                <td><?php echo !empty($status->rere_problem)?$status->rere_problem:''; ?></td>
                <td><?php echo !empty($status->rere_action)?$status->rere_action:''; ?></td>
            </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table> -->
<div class="text-center confirm_box">
    <p>
        <strong>Do you want to confirm this repair request?</strong>
    </p>
    <a href="javascript:void(0)" class="btn btn-success confirmation" data-confirm="yes" data-repairid="<?php echo !empty($status->rere_repairrequestid)?$status->rere_repairrequestid:'';?>">Yes</a>
    <a href="javascript:void(0)" class="btn btn-danger confirmation" data-confirm="no" data-repairid="<?php echo !empty($status->rere_repairrequestid)?$status->rere_repairrequestid:'';?>">No</a>
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</div>

<script>
    $(document).off('click','.confirmation');
    $(document).on('click','.confirmation',function(){
        var dtablelist = $('#repairTableInfo').dataTable();
        var confirm = $(this).data('confirm');
        var repairid = $(this).data('repairid');

        // alert(confirm);
        if(confirm == 'yes'){
            $.ajax({
                type: "POST",
                url: base_url+'biomedical/repair_request_info/updateRepairStatus',
                data:{repairid:repairid},
                dataType: 'json',
                success: function(datas) {
                    // alert(datas.message);
                    if(datas.status=='success')
                    {
                        $('.success').html(datas.message);
                    }else{
                        $('.error').html(datas.message);
                    }
                    $('#myModal1').modal('hide');
                    dtablelist.fnDraw();
                }
            });
        }else{
            $('#myModal1').modal('hide');
            return false;
        }
    });
</script>