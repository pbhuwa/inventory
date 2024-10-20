 <script src="<?php echo base_url('assets/common/ckeditor/ckeditor.js'); ?>"></script>
<form method="post" id="Formfaqlist" action="<?php echo base_url('faq/insert_faq_list'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('faq/faq/form_faq_list'); ?>' >
	<input type="hidden" name="id" value="<?php echo!empty($item_data[0]->fali_faqlistid)?$item_data[0]->fali_faqlistid:'';  ?>">
	<div>
		<div class="form-group">
			<div class="col-md-4">
				<label for="example-text"><?php echo $this->lang->line('faq_category'); ?> <span class="required">*</span>:</label>
				<?php
				//$fali_catid= $this->input->post('fali_catid');
				$db_cat_id=!empty($item_data[0]->fali_catid)?$item_data[0]->fali_catid:'';
				
				$sel_cat=!empty($category_id)?$category_id:$db_cat_id;
				?>
				<select class="form-control" name="fali_catid">
					<option value="">---select---</option>
					<?php
					foreach ($faq_list as $value) { ?>
					<option value="<?php echo $value->faca_faqcatid ?>" <?php if($value->faca_faqcatid == $db_cat_id) echo "selected=selected"; ?> ><?php echo $value->facq_catname ?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="example-text"><?php echo $this->lang->line('title'); ?>:<span class="required">*</span>:</label>
				<?php $title=!empty($item_data[0]->fali_title)?$item_data[0]->fali_title:''; ?>
				<input type="text" class="form-control" name="fali_title"  value="<?php echo $title; ?>">
			</div>
			<div class="col-md-4">
				<label for="example-text"><?php echo $this->lang->line('title'); ?> <?php echo $this->lang->line('in_nepali'); ?>:<span class="required">*</span>:</label>
				<?php $titlenp=!empty($item_data[0]->fali_titlenp)?$item_data[0]->fali_titlenp:''; ?>
				
				<input type="text" class="form-control" name="fali_titlenp"  value="<?php echo $titlenp; ?>">
			</div>
		</div>

		<div class="clearfix"></div>

		<div class="form-group">
			<div class="col-md-6">
				<label><?php echo $this->lang->line('faq'); ?> <?php echo $this->lang->line('description'); ?></label>
				<?php $description=!empty($item_data[0]->fali_description)?$item_data[0]->fali_description:''; ?>
				<textarea rows="3" name="fali_description" id="fali_description" class="form-control ckeditor"><?php echo $description;?></textarea>
			</div>
			<div class="col-md-6">
				<label><?php echo $this->lang->line('faq'); ?> <?php echo $this->lang->line('description'); ?> <?php echo $this->lang->line('in_nepali'); ?></label>
				<?php $descriptionnp=!empty($item_data[0]->fali_descriptionnp)?$item_data[0]->fali_descriptionnp:''; ?>
				<textarea rows="3" name="fali_descriptionnp" id="fali_descriptionnp" class="form-control ckeditor"><?php echo $descriptionnp;?></textarea>
			</div>
		</div>

		<div class="clearfix"></div>

		<div class="form-group" style="margin-top: 2%">
			<div class="col-md-4">
				<button type="submit" class="btn btn-info  save"  data-hasck="Y" data-operation='<?php echo !empty($item_data)?'update':'save' ?>'><?php echo !empty($item_data)?'Update':'Save' ?></button>
			</div>
			<div class="col-sm-12">
				<div  class="alert-success success"></div>
				<div class="alert-danger error"></div>
			</div>
		</div>
	</div>
</form>

<script>
	var desc1 = CKEDITOR.replace('fali_description');
	
	var desc2 = CKEDITOR.replace('fali_descriptionnp');
</script>