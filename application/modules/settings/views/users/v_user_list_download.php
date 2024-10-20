<table width="100%" style="font-size:12px;">
<?php $this->load->view('common/v_report_header');?>
    <tr>
        <td style="width:45%">
            <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('user_list'); ?>  </u></b> </td>
        </table>
        <table id="" class="format_pdf" width="100%">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('sn'); ?></th>
                <th><?php echo $this->lang->line('username'); ?></th>
                <th><?php echo $this->lang->line('email'); ?></th>
                <th><?php echo $this->lang->line('full_name'); ?></th>
                <th><?php echo $this->lang->line('department'); ?></th>
                <th><?php echo $this->lang->line('user_group'); ?></th>
                <th><?php echo $this->lang->line('post_date'); ?>(AD)</th>
                <th><?php echo $this->lang->line('post_date'); ?>(BS)</th>

            </tr>
        </thead>

        <tbody>

            <?php
            $i=1;
            if($searchResult):
                foreach ($searchResult as $km => $user):
                    $deparray=explode(',', $user->usma_departmentid);
                    ?>
                    <tr id="listid_<?php echo $user->usma_userid; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $user->usma_username; ?></td>
                        <td><?php echo $user->usma_email; ?></td>
                        <td><?php echo $user->usma_fullname; ?></td>
                        <td><?php echo $this->users_mdl->get_userwise_dep($user->usma_userid,$deparray);?></td>
                        <td><?php echo $user->usgr_usergroup; ?></td>
                        <td><?php echo $user->usma_postdatebs; ?></td>
                        <td><?php echo $user->usma_postdatead; ?></td>

                    </tr>
                    <?php
                    $i++;
                endforeach;
            endif;

            ?>
        </tbody>
    </table>

