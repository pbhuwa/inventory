<?php
$frontend = $this->uri->segment(1);
$mid =  $this->session->userdata(USER_ID);
if (!empty($mid) && $frontend != 'frontend') { ?>
    <div class="chat_frame">
        <?php include_once 'assets/plugins/chat/chat.php'; ?>
        <button type="button" class="btn btn-round custom-bg" id="open_chat_list"><span
                class="fa fa-comments"></span></button>
        <div class="panel b0" id="chat_list">
            <div class="panel-heading custom-bg">
                <div class="">
                    <?= lang('users') . ' ' . lang('list') ?>
                    <div class="pull-right chat-icon">
                        <!--                    <i data-toggle="tooltip" data-placement="top" title="-->
                        <? //= lang('add_more_to_chat') ?><!--"-->
                        <!--                       class="fa fa-plus" aria-hidden="true"></i>-->
                        <!--                    <a data-toggle="tooltip" data-placement="top" title="-->
                        <? //= lang('settings') ?><!--"-->
                        <!--                       href=""> <i class="fa fa-cog" aria-hidden="true"></i></a>-->
                        <i data-toggle="tooltip" data-placement="top" title="<?= lang('close') ?>" id="close_chat_list"
                           class="fa fa-times"
                           aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <ul class="nav b bt0">
                <li>
                    <?php
                    $users = $this->general->get_tbl_data('*','usma_usermain');
                    // echo "<pre>";
                    // print_r($users);
                    // die();

                    if (!empty($users)) {
                        foreach ($users as $key => $v_users) {
                          
                                    ?>
                                    <!-- START User status-->
                                    <a href="#" data-user_id="<?= $v_users->usma_userid ?>"
                                       class="media-box p pb-sm pt-sm bb mt0 start_chat">
                                        <?php
                                        if ($key == '1') {
                                            ?>
                                            <span class="pull-right">
                                 <span class="circle circle-success circle-lg"></span>
                              </span>
                                        <?php } else {
                                            ?>
                                            <span class="pull-right">
                                 <span class="circle circle-warning circle-lg"></span>
                              </span>
                                        <?php } ?>
                                        <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img
                                     src="https://xelwel.com.np/hrm/uploads/default_avatar.jpg"
                                     alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                                        <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong class="text-sm"><?= ($v_users->usma_fullname) ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <span class="pull-left">
                                        <?= ($v_users->usma_fullname) ?></span>
                                        <span class="pull-right"><?php
                                           ?></span>
                                    </small>
                                 </span>
                              </span>
                                    </a>
                                    <?php
                                
                        }
                    } ?>
                </li>
            </ul>
        </div>
        <div id="chat_box"></div>
        <audio id="chat-tune" controls="">
            <source src="<?= base_url() ?>assets/plugins/chat/chat_tune.mp3" type="audio/mpeg">
        </audio>
    </div><!--End live_chat_section-->
<?php } ?>
