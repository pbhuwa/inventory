<form method="post" id="FormRoom" action="<?php echo base_url('settings/room/save_room'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/room/form_room'); ?>'>
<input type="hidden" name="id" value="<?php echo!empty($room_data[0]->rode_roomdepartmentid)?$room_data[0]->rode_roomdepartmentid:'';  ?>">
                                <div class="form-group">
                                <div class="col-md-12">
                                 <label for="example-text">Department:<span class="required">*</span>:
                                    </label>
                                    </label>
                                    <?php $depid=!empty($room_data[0]->rode_departmentid)?$room_data[0]->rode_departmentid:''; ?>
                                    <select name="rode_departmentid" class="form-control" autofocus="true">
                                    	<option value="">----select---</option>
                                    	<?php if($department_all):
                                    	foreach ($department_all as $kd => $kdep):?>
                                    	<option value="<?php echo $kdep->dept_depid; ?>" <?php if($depid==$kdep->dept_depid) echo 'selected=selected'; ?> ><?php echo $kdep->dept_depname; ?></option>
                                    <?php endforeach; endif; ?>
                                    </select>
                                      <?=form_error('rode_departmentid')?>

                                </div>
                              <div class="col-md-12">
                                 <label for="example-text">Room Name<span class="required">*</span>:
                                    </label>
                                     <input type="text"  name="rode_roomname" class="form-control" placeholder="Room Name" value="<?php echo !empty($room_data[0]->rode_roomname)?$room_data[0]->rode_roomname:''; ?>" >
                                      <?=form_error('rode_roomname')?>

                                </div>
                                <div class="col-md-12">
                                 <label for="example-text">Active<span class="required">*</span>:
                                    </label>
                                    <?php $isactive=!empty($room_data[0]->rode_isactive)?$room_data[0]->rode_isactive:''; ?>
                                   <select class="form-control" name="rode_isactive">
                                        <option value="Y" <?php if($isactive=='Y') echo "selected=selected" ?> >Yes</option>
                                         <option value="N"<?php if($isactive=='N') echo "selected=selected" ?>  >No</option>
                                   </select>
                                   <?=form_error('rode_isactive')?>
                                </div>
                            </div>

                                <div class="form-group">
                                    <div class="col-sm-12">

                                                             <?php 
                                $add_edit_status=!empty($edit_status)?$edit_status:0;
                                $usergroup=$this->session->userdata(USER_GROUPCODE);
                                // echo $add_edit_status;
                                if((empty($room_data)) || (!empty($room_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
                                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($room_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($room_data)?'Update':'Save' ?></button>
                                  <?php
                                   endif; ?>
                                        
                                    </div>
                                    <div class="col-sm-12">
                                        <div  class="alert-success success"></div>
                                        <div class="alert-danger error"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                
                                <!-- <button type="reset" class="btn btn-inverse waves-effect waves-light">Reset</button> -->
                                

                            </form>