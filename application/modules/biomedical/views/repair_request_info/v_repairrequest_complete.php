<div class="pad-5">
    <div class="resultrRepairComment search_pm_data">
        <strong><u>Information: </u></strong>
        <ul class="pm_data cols3">
        <li>
            <input type="hidden" name="id" value="<?php echo!empty($comment[0]->eqco_equipmentcommentid)?$comment[0]->eqco_equipmentcommentid:'';  ?>">
            <input type="hidden" name="equipid" value="<?php echo!empty($comment[0]->eqco_eqid)?$comment[0]->eqco_eqid:'';  ?>">
        </li>
        <li>
            <label>Equipment Id: </label>
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
</div>


<div class="AllRequestData">
    <strong class="col-sm-12"><u>Description: </u></strong>
    <div class="">
        <div class="col-sm-4">
            <label class="checkbox-inline">
                <input type="checkbox" value="5" name="rere_manufcontacted" <?php echo !empty($completeData[0]->rere_manufcontacted)?'checked':''; ?> disabled="disabled">Distributer / Manufacture must be contaced
            </label>
        </div>
        <div class="col-sm-4">
            <label class="checkbox-inline">
                <input type="checkbox" value="2" name="rere_cannotmove" <?php echo !empty($completeData[0]->rere_cannotmove)?'checked':''; ?> disabled="disabled">Cannot Be Move
            </label>
        </div>
        <div class="col-sm-4">
            <label class="checkbox-inline">
                <input type="checkbox" value="1" name="rere_warranty" <?php echo !empty($completeData[0]->rere_warranty)?'checked':''; ?> disabled="disabled">Under Warrenty
            </label>
        </div>
        <div class="col-sm-4">
            <label class="checkbox-inline">
                 <input type="checkbox" value="3" name="rere_onsite" <?php echo !empty($completeData[0]->rere_onsite)?'checked':''; ?> disabled="disabled">Can be Repaired on Site
            </label>
        </div>
        <div class="col-sm-4">
            <label class="checkbox-inline">
                <input type="checkbox" value="4" name="rere_moved" <?php echo !empty($completeData[0]->rere_moved)?'checked':''; ?> disabled="disabled"> Moved to Biomed Eng. Workshop
            </label>
        </div>
         <div class="col-sm-4">
            <label class="checkbox-inline">
                <input type="checkbox" value="6" name="rere_repairid" <?php echo !empty($completeData[0]->rere_repairid)?'checked':''; ?> disabled="disabled">Under Maintantenence Contract
            </label>
        </div>
        <div class="clear"></div>
        <br/>
        <div class="col-sm-6">
            <label><strong><u>Problem</u></strong></label>
            <p>
                <?php echo !empty($completeData[0]->rere_problem)?$completeData[0]->rere_problem:''; ?>
            </p> 
        </div>

        <div class="col-sm-6">
            <label><strong><u>Action</u></strong></label>
            <p>
                <?php echo !empty($completeData[0]->rere_action)?$completeData[0]->rere_action:''; ?>
            </p>
        </div>
        <br/>
        <div class="col-sm-6">
            <label><strong><u>Notes</u></strong></label>
            <p>
                <?php echo !empty($completeData[0]->rere_notes)?$completeData[0]->rere_notes:''; ?>
            </p> 
        </div>

        <div class="col-sm-6">
            <label><strong><u>Parts/Material Used</u></strong></label>
            <p>
                <?php echo !empty($completeData[0]->rere_parts)?$completeData[0]->rere_parts:''; ?>
            </p>
        </div>
    </div>
</div>

<div class="col-sm-12 table table-responsive">
    <strong><u>Completion Information: </u></strong>
    <table class="table table-border table-striped table-site-detail dataTable">
        <thead>
            <tr>
                <th width="5%">S.No.</th>
                <th width="5%">Equip. Key</th>
                <th width="5%">Req. Date(AD)</th>
                <th width="5%">Req. Date(BS)</th>
                <th width="5%">Com. Date(AD)</th>
                <th width="5%">Com. Date(BS)</th>
                <th width="5%">Exp. Days</th>
                <th width="5%">Comp. Days</th>
                <th width="5%">Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(!empty($completeData)){
                    foreach($completeData as $key=>$complete){
                        $postdate = new DateTime(!empty($complete->rere_postdatead)?$complete->rere_postdatead:'');
                        $repairdate = new DateTime(!empty($complete->rere_repairdatead)?$complete->rere_repairdatead:'');
                        $completedays = $repairdate->diff($postdate)->format("%a");
                        $expecteddays = !empty($complete->rere_expecteddays)?$complete->rere_expecteddays:'';
            ?>
                <tr>
                    <td><?php echo $key+1;?></td>
                    <td><?php echo !empty($complete->bmin_equipmentkey)?$complete->bmin_equipmentkey:''; ?></td>
                    <td><?php echo !empty($complete->rere_postdatead)?$complete->rere_postdatead:''; ?></td>
                    <td><?php echo !empty($complete->rere_postdatebs)?$complete->rere_postdatebs:''; ?></td>
                    <td><?php echo !empty($complete->rere_repairdatead)?$complete->rere_repairdatead:''; ?></td>
                    <td><?php echo !empty($complete->rere_repairdatebs)?$complete->rere_repairdatebs:''; ?></td>
                    <td><?php echo $expecteddays; ?></td>
                    <td><?php echo $completedays; ?></td>
                    <td><strong><?php echo ($expecteddays > $completedays)?"<span style='color:#0a0'>Ontime</span>":"<span style='color:#a00'>Late</span>";?></strong></td>
                </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
</div>
<div class="clearfix"></div>