<div class="my_account">
      <div class="panel">
            <div class="panel-heading panel-heading-01">
                  <i class="fa fa-user-o"></i><?php echo $title; ?>
            </div>
            <div class="change_p panel-body panel-body-02">
                  <?php  //echo"<pre>";print_r($usersall);die; ?>
                 
                        <div class="col-sm-12">
                              <div class="form-group row">
                                    <label>User Name</label>:
                                    <?php echo  $usersall[0]->usma_username; ?>
                                    
                              </div>
                              <div class="form-group row">
                                    <label>Email</label>:
                                    <?php echo  $usersall[0]->usma_email; ?>
                                   
                              </div>
                              <div class="form-group row">
                                    <label>Full Name</label>:
                                    <?php echo  $usersall[0]->usma_fullname; ?>
                                   

                              </div>
                                  <div class="form-group row">
                                    <label>Phone No.</label>:
                                    <?php  echo $usersall[0]->usma_phoneno; ?>
                                   

                              </div>
                                  <div class="form-group row">
                                    <label>User Type</label>:
                                    <?php  echo $usersall[0]->usma_usertype; ?>
                                   

                              </div>
                                  <div class="form-group row">
                                    <label>User Group</label>:
                                    <?php  echo $usersall[0]->usgr_usergroup; ?>
                                  
                              </div>
                               </div>
                           <!--        <div class="form-group row">
                                    <label>Department</label>:
                                    <?php  echo $usersall[0]->dept_depname; ?>
                                  
                              </div> -->
                             
            </div>
      </div>
</div>