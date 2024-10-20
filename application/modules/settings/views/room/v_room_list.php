<table id="Dtable" class="table table-striped menulist" >
<thead>
    <tr>
        <th>S.n.</th>
        <th>Department Name</th>
        <th>Room name</th>
        <th>Post Date</th>
        <th>Active</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
     <?php
    $showview= MODULES_VIEW;
                        if($showview=='N')
                        {
                            ?>
                            <td></td>
                            <td colspan="2" style="text-align:center">Permission Denial</td>
                            <td></td>
                            <td></td>
                        <?php 
                        } 
                        else {
            if($room_all):
                $i=1;
                foreach ($room_all as $kd => $rom):
        ?>
            <tr id="listid_<?php echo $rom->rode_roomdepartmentid; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $rom->dept_depname; ?></td>
            <td><?php echo $rom->rode_roomname; ?></td>
            <td><?php 
               if(DEFAULT_DATEPICKER=='NP')
                {
                    echo $rom->rode_postdatebs; 
                }
                else
                {
                    echo $rom->rode_postdatead; 
                }
                ?>
            </td>
            <td>
                <?php echo $rom->rode_isactive; ?>
            </td>

            <td>
            <a href="javascript:void(0)" title="Edit" data-id='<?php echo $rom->rode_roomdepartmentid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a> |
            <a href="javascript:void(0)"  title="Delete" data-id='<?php echo $rom->rode_roomdepartmentid; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>
            </td>
            </tr>
        <?php
        $i++;
        endforeach;
    endif;
}
     ?>
 </tbody>
</table>

