	   <div class="row">
	   	<div class="white-box">
	   		<form id="FormConstantset" action="<?php echo base_url('settings/constant_set/update_constant'); ?>"  method="post"  data-reloadurl='<?php echo base_url('settings/constant_set/reload_constant_set_list'); ?>' >
	   			<h3 class="box-title">Constant List <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh no-pos" ><i class="fa fa-refresh" aria-hidden="true"></i></a></h3>
	   			<a href="javascript:void(0)"  data-displaydiv="Addconstant" data-viewurl="<?php echo base_url('settings/constant_set/add_group_popup'); ?>" class="view btn-primary btn-xxs" data-heading="Add Constant Form"><i class="fa fa-plus" aria-hidden="true"></i>Add New</a>
	   			<div class="table-responsive dtable_pad scroll " >
	   				<input type="hidden" id="ListUrl" value="<?php echo base_url('/settings/constant_set/reload_constant_set_list'); ?>" >
	   				<div id="TableDiv">           
	   					<?php $this->load->view('constant_set/v_constant_set_list') ;?>
	   				</div>
	   			</div>
	   			<button type="submit" class="btn btn-info  save" data-operation='<?php echo 'update' ?>' id="btn_constant" >Update</button>

	   		</form>

	   		<div  class="alert-success success"></div>
	   		<div class="alert-danger error"></div>

	   	</div>
	   </div>