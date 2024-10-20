<?php if (!empty($file_data[0])) : ?>
    <div class="white-box distributordata">
        <div class="pad-5">
            <div class="form-group row resp_xs">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label for="example-text">File type</label>:
                    <?php echo $file_data[0]->fity_typename; ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label for="example-text">File No.</label>:
                    <?php echo $file_data[0]->fire_file_no; ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label for="example-text">Date </label>:
                    <?php echo $file_data[0]->fire_datebs; ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label for="example-text">Remarks </label>:
                    <?php echo $file_data[0]->fire_remarks; ?>
                </div>


                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label for="example-text">Attachement </label>:

                    <?php
                    if(!empty($file_data[0]->fire_attachement)):
                    if (file_exists(FCPATH.FORM_FILE_ATTACHMENT_PATH . "/" . $file_data[0]->fire_attachement)) : 
                    ?>
                        <img src="<?php echo base_url(FORM_FILE_ATTACHMENT_PATH . '/' . $file_data[0]->fire_attachement); ?>">
                    <?php 
                    endif;
                    endif; ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>