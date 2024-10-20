<div class="white-box pad-5 mtop_10 pdf-wrapper ">
  <div class="jo_form organizationInfo" id="printrpt">
    <?php $this->load->view('common/v_report_header'); ?>
    <table class="alt_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('sn'); ?></th>
          <th><?php echo $this->lang->line('equipment_code'); ?></th>
          <th><?php echo $this->lang->line('equipment_description'); ?></th>
          <th><?php echo $this->lang->line('department'); ?></th>
          <th><?php echo $this->lang->line('room'); ?></th>
          <th><?php echo $this->lang->line('problem'); ?></th>
          <th><?php echo $this->lang->line('solution'); ?></th>
          <th><?php echo $this->lang->line('maintained_by'); ?></th>
          <th><?php echo $this->lang->line('posted_time'); ?></th>
          <th><?php echo $this->lang->line('posted_date'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
          if(!empty($searchResult))
            {
         
            foreach($searchResult as $key=>$iue):
        ?>
        <tr>
          <td><?php echo $key+1; ?></td>
          <td><?php echo $iue->bmin_equipmentkey; ?></td>
          <td><?php echo $iue->eqli_description; ?></td>
          <td><?php echo $iue->dept_depname;?></td>
          <td><?php echo $iue->rode_roomname;?></td>
          <td><?php echo $iue->malo_comment;?></td>
          <td><?php echo $iue->malo_remark;?></td>
          <td><?php echo $iue->usma_username;?></td>
          <td><?php echo $iue->malo_posttime;?></td>
          <td><?php echo $iue->malo_postdatebs;?></td>
       
          </tr>
        <?php
            endforeach;
          }
          else
          {
            ?>
            <tr>
                <td colspan="10" style="text-align: center"><font color="red">No record Found</font></td>
            </tr>
        <?php
          }
        ?>
       
      </tbody>
    </table>
  </div>
</div>