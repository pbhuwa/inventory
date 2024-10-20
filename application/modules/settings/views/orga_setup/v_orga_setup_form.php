
<form method="post" id="FormMenu" action="<?php echo base_url('settings/orga_setup/save_orga_setup'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/orga_setup/form_orga_setup'); ?>'>
<input type="hidden" name="id" value="<?php echo!empty($orga_setup_data[0]->orga_orgid)?$orga_setup_data[0]->orga_orgid:'';  ?>">
                                <div class="form-group">
                                <div class="col-md-4">
                                 <label for="example-text">Organization Name:
                                    </label>
                                    <input type="text" id="example-text" name="orga_organame" class="form-control" placeholder="Organization Name" value="<?php echo !empty($orga_setup_data[0]->orga_organame)?$orga_setup_data[0]->orga_organame:''; ?>">

                                </div>
                                 <div class="col-md-4">
                                 <label for="example-text">Email:
                                    </label>
                                    <input type="text" id="example-text" name="orga_email" class="form-control" placeholder="Oranization Email" value="<?php echo !empty($orga_setup_data[0]->orga_email)?$orga_setup_data[0]->orga_email:''; ?>">

                                </div>
                                <div class="col-md-4">
                                 <label for="example-text">Address 1:
                                    </label> <input type="text" id="example-text" name="orga_orgaddress1" class="form-control" placeholder="Address" value="<?php echo !empty($orga_setup_data[0]->orga_orgaddress1)?$orga_setup_data[0]->orga_orgaddress1:''; ?>">

                                </div>
                                 <div class="col-md-4">
                                 <label for="example-text">Address 2:
                                    </label> <input type="text" id="example-text" name="orga_orgaddress2" class="form-control" placeholder="Address" value="<?php echo !empty($orga_setup_data[0]->orga_orgaddress2)?$orga_setup_data[0]->orga_orgaddress2:''; ?>">

                                </div>

                            
                                 <div class="col-md-4">
                                 <label for="example-text">Contact No:
                                    </label>
                                    <input type="text" id="example-text" name="orga_contactno" class="form-control number" placeholder="Contact Number" value="<?php echo !empty($orga_setup_data[0]->orga_contactno)?$orga_setup_data[0]->orga_contactno:''; ?>">

                               </div>
                                 <div class="col-md-4">
                                 <label for="example-text">Website:
                                    </label>
                                    <input type="text" id="example-text" name="orga_website" class="form-control" placeholder="Website" value="<?php echo !empty($orga_setup_data[0]->orga_website)?$orga_setup_data[0]->orga_website:''; ?>">

                               </div>
                                
                               
                                  <div class="col-md-4">
                                 <label for="example-text">Software:
                                    </label>
                                    <input type="text" id="example-text" name="orga_software" class="form-control " placeholder="Software" value="<?php echo !empty($orga_setup_data[0]->orga_software)?$orga_setup_data[0]->orga_software:''; ?>">

                               </div>


                                <div class="col-md-4">
                                 <label for="example-text">Is Active :
                                    </label>
                                    <?php $is_active=!empty($orga_setup_data[0]->orga_isactive)?$orga_setup_data[0]->orga_isactive:''; ?>
                                    <input type="radio" name="orga_isactive" value="Y" <?php if($is_active=='Y') echo "checked='checked'"; ?>>Yes
                                    <input type="radio" name="orga_isactive" value="No" <?php if($is_active=='No') echo "checked=checked";?>>No
                                
                                </div>
                                <div class="col-md-4">
                                 <label for="example-text">Is User Access :
                                    </label>
                                    <?php $is_active=!empty($orga_setup_data[0]->orga_isuseraccess)?$orga_setup_data[0]->orga_isuseraccess:''; ?>
                                    <input type="radio" name="orga_isuseraccess" value="Y" <?php if($is_active=='Y') echo "checked='checked'"; ?>>Yes
                                    <input type="radio" name="orga_isuseraccess" value="No" <?php if($is_active=='No') echo "checked=checked";?>>No
                                
                                </div>
                                     <div class="clearfix">  </div>
                                <div class="col-md-4">
                                 <label for="example-text"> Logo Image: </label>
                                 <input type="file" name="orga_image" >
                               <?php
                                $orga_image_db=!empty($orga_setup_data[0]->orga_image)?$orga_setup_data[0]->orga_image:'';
                               if($orga_image_db): ?>
                               <img class="img-polaroid" src="<?php echo base_url(LOGO_PATH.$orga_image_db); ?>" style="widt146px;height: 98px;">
                               <input type="hidden" name="old_images1" value="<?php echo $orga_image_db; ?>">
                               <?php endif;?>
                             

                          </div>
                          <div class="col-md-4">
                                 <label for="example-text">Header Image: </label>
                                 <input type="file" name="orga_headerimg" >
                               <?php
                                $orga_headerimg_db=!empty($orga_setup_data[0]->orga_headerimg)?$orga_setup_data[0]->orga_headerimg:'';
                               if($orga_headerimg_db): ?>
                               <img class="img-polaroid" src="<?php echo base_url(HEADER_PATH.$orga_headerimg_db); ?>" style="widt146px;height: 98px;">
                               <input type="hidden" name="old_images2" value="<?php echo $orga_image_db; ?>">
                               <?php endif;?>
                             

                          </div>
                          <div class="col-md-4">
                                 <label for="example-text">Footer Image: </label>
                                 <input type="file" name="orga_footerimg" >
                               <?php
                                $orga_footerimg_db=!empty($orga_setup_data[0]->orga_footerimg)?$orga_setup_data[0]->orga_footerimg:'';
                               if($orga_footerimg_db): ?>
                               <img class="img-polaroid" src="<?php echo base_url(FOOTER_PATH.$orga_footerimg_db); ?>" style="widt146px;height: 98px;">
                               <input type="hidden" name="old_images3" value="<?php echo $orga_image_db; ?>">
                               <?php endif;?>
                             

                          </div>


                               



                      

                                </div>
                                <br>	<br>	


        <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($orga_setup_data)) || (!empty($orga_setup_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($orga_setup_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($orga_setup_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>

                                
                                <div id="ResponseSuccess" class="waves-effect waves-light m-r-10 text-success"></div>
                                 <div id="ResponseError" class="waves-effect waves-light m-r-10 text-danger"></div>

                            </form>