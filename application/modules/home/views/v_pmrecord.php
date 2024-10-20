<table class="table table-border table-striped table-site-detail dataTable">
    <thead>
        <tr>
            <th width="15%">Date (AD)</th>
            <th width="15%">Date (BS)</th>
            <th width="55%">Remarks</th>
            <th width="15%">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($history as $data):
                $newDate = !empty($data->pmta_pmdatead)?$data->pmta_pmdatead:'';
                $curdate = CURDATE_EN;
                if($newDate < $curdate){
                    $style = "color:#d00";
                    $status = "Completed";
                    $display = "display:none;";
                }else{
                    $style = "color:#0f0";
                    $status = "Available";
                    $display = "display:inline-block;";
                }
            $pmtableid = !empty($data->pmta_pmtableid)?$data->pmta_pmtableid:'';
            //$pmtableid = !empty($data->pmta_ispmcompleted)?$data->pmta_ispmcompleted:'';
        ?>
        <tr id="listid_<?php echo $pmtableid; ?>">
          
            <td>
                <?php echo !empty($data->pmta_pmdatead)?$data->pmta_pmdatead:'';?>
            </td>
            <td>
                <?php echo !empty($data->pmta_pmdatebs)?$data->pmta_pmdatebs:'';?>
            </td>
            <td>
                <?php echo !empty($data->pmta_remarks)?$data->pmta_remarks:'';?>
            </td>
            <td style="<?php echo $style; ?>"><?php echo $status; ?></td>

        </tr>
        <?php endforeach;?>
    </tbody>
</table>