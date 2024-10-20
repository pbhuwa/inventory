 <table class="table table-border table-striped table-site-detail dataTable">
     
   <thead>
            
             <tr>
                <th>AMC Date(AD) </th>
                <th>AMC Date(BS) </th>
                <th>Remarks </th>
                <th>Status </th>
                <th>Is Comp. ?</th>
             <!--    <th>Action</th> --> 
            </tr>
        </thead>
        <tbody>
            <?php
              
                $j=1;
                foreach($amcdata as $data){ 
                    $newDate = !empty($data->amta_isamccompleted)?$data->amta_isamccompleted:'';
                    if($newDate == '1'){
                        $style = "color:#d00";
                        $status = "Completed";
                        $display = "display:none;";
                    }else{
                        $style = "color:#0f0";
                        $status = "Available";
                        $display = "display:inline-block;";
                    }
                $amctableid = !empty($data->amta_amctableid)?$data->amta_amctableid:'';
                //$amctableid = !empty($data->amta_isamccompleted)?$data->amta_isamccompleted:'';
            ?>
            <tr id="listid_<?php echo $amctableid; ?>">
                <td>
                    <?php echo !empty($data->amta_amcdatead)?$data->amta_amcdatead:'';?>
                </td>
                <td>
                    <?php echo !empty($data->amta_amcdatebs)?$data->amta_amcdatebs:'';?>
                </td>
                <td>
                    <?php echo !empty($data->amta_remarks)?$data->amta_remarks:'';?>
                </td>
                <td style="<?php echo $style; ?>"><?php echo $status; ?></td>
                <td>
                    <?php 
                    $isamccomplete=!empty($data->amta_isamccompleted)?$data->amta_isamccompleted:'0';
                    $completedatead=!empty($data->amta_completedatead)?$data->amta_completedatead:'';
                    $completedatebs=!empty($data->amta_completedatebs)?$data->amta_completedatebs:'';
                    if(DEFAULT_DATEPICKER=='NP')
                    {
                        $compdate=$completedatebs;
                    }
                    else
                    {
                        $compdate=$completedatead;
                    }
                    
                    if($isamccomplete=='1'):
                    echo '<label class="label label-success">Yes</label>';
                    echo '<br>'.$compdate;
                    else:
                    echo '<label class="label label-danger">No</label>';
                    endif;

                    ?>
                </td>
         
               <!--  <td><a href="javascript:void(0)" class="text-danger btnDelete" data-id="<?php echo $amctableid; ?>" data-deleteurl="<?php echo base_url('biomedical/amc_data/deleteamc_data');?>"><i class="fa fa-minus-square-o "></i></a>&nbsp;&nbsp;&nbsp;
                    <a href="javascript:void(0)" class="btnEditAMC" style="<?php echo $display;?>"  data-editid="<?php echo $amctableid; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                    <a href="javascript:void(0)" class="isCompleteAMC" style="<?php echo $display;?>"  data-equipid="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>" data-pmtaid="<?php echo $amctableid; ?>"><?php if($data->amta_isamccompleted == 0){ echo "Is Completed";}?></a>
                </td> -->
            </tr>
      
        
            </tbody>
                <?php } ?>
           
    </table>
   
