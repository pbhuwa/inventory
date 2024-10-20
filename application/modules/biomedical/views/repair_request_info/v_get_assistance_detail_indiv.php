<div class="search_pm_data">
    <ul class="pm_data pm_data_body">
    
    <li>
        <label> Date(AD)</label>
        <?php echo !empty($part_list[0]->rere_postdatead)?$part_list[0]->rere_postdatead:'';?>
    </li>
    <li>
        <label> Date(BS)</label>
        <?php echo !empty($part_list[0]->rere_postdatebs)?$part_list[0]->rere_postdatebs:'';?>
    </li>
    <li>
        <label> Time</label>
        <?php echo !empty($part_list[0]->rere_posttime)?$part_list[0]->rere_posttime:'';?>
    </li>
    <li>
        <label> Equipment ID</label>
        <?php echo !empty($part_list[0]->bmin_equipmentkey)?$part_list[0]->bmin_equipmentkey:'';?>
    </li>
     <li>
        <label> Department</label>
        <?php echo !empty($part_list[0]->dein_department)?$part_list[0]->dein_department:'';?>
    </li>
    <li>
        <label> Room</label>
        <?php echo !empty($part_list[0]->rode_roomname)?$part_list[0]->rode_roomname:'';?>
    </li>
     <!-- <li>
        <label> Problem Type</label>
        <?php echo !empty($part_list[0]->rere_postdatead)?$part_list[0]->rere_postdatead:'';?>
    </li> -->
    <li>
        <label> Problem</label>
        <?php echo !empty($part_list[0]->rere_problem)?$part_list[0]->rere_problem:'';?>
    </li>
     <li>
        <label> Action Taken</label>
        <?php echo !empty($part_list[0]->rere_action)?$part_list[0]->rere_action:'';?>
    </li>


</ul>
</div>
