
<?php
	$commentStatus = !empty($comment[0]->eqco_comment_status)?$comment[0]->eqco_comment_status:'';
	if($commentStatus == 1){
		$status = 'Approved';
		$btn = 'btn-success';
	}else{
		$status = 'Approve';
		$btn = 'btn-warning';
	}
?>
<div class="pop_radio_group text-center">
    <span>Problem Type</span>
	<label for="internal" class="radio_btn">
		<input type="radio"  name="problemtype"  value="In" class="problemtype" checked="checked" > Internal
	</label>
	<label for="external" class="radio_btn">
		<input type="radio"  name="problemtype"  value="Ex" class="problemtype"> External
	</label>
    <?php if($commentStatus!= '3'){ ?>
 
    <button type="button" id="cancel_button" class="btn-default pull-right">Cancel</button>
<?php }else{ ?>
   <p class="btn-default pull-right">This comment was cancelled!!</p>
<?php } ?>

</div>
<!-- <div>
    <button type="button" id="cancel_button" class="btn-default pull-right">Cancel</button>
</div> -->
<input type="hidden" name="equipcommentid" value="<?php echo $commentid; ?>" id="equipcommentid">
<ul class="pm_data cols3 pm_data_body">
    <?php if($org_id=='2'){ ?>
    <li>
    <label>Assets Code</label>
        <?php echo $comment[0]->asen_assetcode; ?>
    </li>
     <li>
        <label> Description</label>
        <?php echo !empty($comment[0]->itli_itemname)?$comment[0]->itli_itemname:'';?>
     </li>
       <li>
        <label>Model Number</label>
        <?php echo !empty($comment[0]->asen_modelno)?$comment[0]->asen_modelno:'';?>
    </li>
    <li>
        <label>Serial Number</label>
        <?php echo !empty($comment[0]->asen_serialno)?$comment[0]->asen_serialno:'';?>
    </li>
    <?php }else{ ?>
	<li>
	<label>Equipment Key</label>
		<?php echo $comment[0]->bmin_equipmentkey; ?>
	</li>
	 <li>
	 	<label> Description</label>
	 	<?php echo !empty($comment[0]->eqli_description)?$comment[0]->eqli_description:'';?>
	 </li>
	   <li>
        <label>Model Number</label>
        <?php echo !empty($comment[0]->bmin_modelno)?$comment[0]->bmin_modelno:'';?>
    </li>
    <li>
        <label>Serial Number</label>
        <?php echo !empty($comment[0]->bmin_serialno)?$comment[0]->bmin_serialno:'';?>
    </li>
    <?php } ?>
    <li>
        <label>Department</label>
        <?php echo !empty($comment[0]->dein_department)?$comment[0]->dein_department:'';?>
    </li>
    <?php if($org_id=='2'){ ?>
     <li>
        <label>Brand</label>
        <?php echo !empty($comment[0]->asen_brand)?$comment[0]->asen_brand:'';?>
    </li>
    <?php }else{ ?>
    <li>
        <label>Room</label>
        <?php echo !empty($comment[0]->rode_roomname)?$comment[0]->rode_roomname:'';?>
    </li>
    <?php } ?>
	<li>
		<label>Comment By: </label>
		<?php echo $comment[0]->usma_fullname;?>
	</li>
		<li>
		<label>Comment Date: </label>
		<?php  echo $comment[0]->eqco_postdatebs.'(AD)/'.$comment[0]->eqco_postdatead .'(BS)'; ?>
	</li>
		<li>
		<label>Comment Time: </label>
		<?php echo $comment[0]->eqco_posttime;?>
	</li>
	
</ul>
<div class="row">
	<div class="col-md-6">
		<label for=""><strong>Previous Comment</strong></label>
		<div class="scroll h155">
			<table class="table table-striped dataTable">
				<thead>
					<tr>
						<th width="10%"><strong>Date(AD)</strong></th>
						<th width="10%"><strong>Date(BS)</strong></th>
						<th width="30%"><strong>Comment</strong></th>
						<th width="10%"><strong>Status</strong></th>
						<th width="15%"><strong>Dept Ap?</strong></th>
						<th width="15%"><strong>Head Ap?</strong></th>
					</tr>
				</thead>
				
			<?php
				if(!empty($previousComment)):
                   // echo "<pre>"; print_r($previousComment); die;
					foreach($previousComment as $prev):

						$status = ($prev->eqco_comment_status == 1)?"Viewed":"Not Viewed";
						$depapproved = ($prev->eqco_isdepapproved == 1)?"Yes":"No";
						$headapproved = ($prev->eqco_isdepheadapproved == 1)?"Yes":"No";
						echo '<tr>';
						echo '<td>'.$prev->eqco_postdatead.'</td>';
						echo '<td>'.$prev->eqco_postdatebs.'</td>';
						echo '<td>'.$prev->eqco_comment.'</td>';
						echo '<td>'.$status.'</td>';
						echo '<td>'.$depapproved.'</td>';
						echo '<td>'.$headapproved.'</td>';
						echo '</tr>';



					endforeach;
				endif;
			?>
			</table>
		</div>
	</div>

	

	<div class="col-md-6">
		<label for=""><strong>Previous Repair Request</strong></label>
		<div class="scroll h155">
			<table class="table table-striped dataTable">
				<thead>
					<tr>
						<th width="10%"><strong>Date(AD)</strong></th>
						<th width="10%"><strong>Date(BS)</strong></th>
						<th width="30%"><strong>Problem</strong></th>
						<th width="10%"><strong>Action</strong></th>
						<th width="15%"><strong>Technician</strong></th>
						<th width="15%"><strong>Report By</strong></th>
					</tr>
				</thead>
				
			<?php
				if(!empty($previousRepairReq)):
                   // echo "<pre>"; print_r($previousRepairReq); die;
					foreach($previousRepairReq as $req):
						echo '<tr>';
						echo '<td>'.$req->rere_postdatead.'</td>';
						echo '<td>'.$req->rere_postdatebs.'</td>';
						echo '<td>'.$req->rere_problem.'</td>';
						echo '<td>'.$req->rere_action.'</td>';
						echo '<td>'.$req->rere_technician.'</td>';
						echo '<td>'.$req->rere_reported_by.'</td>';
						echo '</tr>';
					endforeach;
				endif;
			?>
			</table>
		</div>
	</div>
</div>
<hr>
<div id="internalform">
<form id="repair_req" action="<?php echo base_url('home/save_repair_information_comment')?>" method="POST">
	<input type="hidden" name="id" value="<?php echo!empty($comment[0]->eqco_equipmentcommentid)?$comment[0]->eqco_equipmentcommentid:'';  ?>">
		<input type="hidden" name="equipid" value="<?php echo!empty($comment[0]->eqco_eqid)?$comment[0]->eqco_eqid:'';  ?>">
		<input type="hidden" name="rere_problemtype" value="In" >
                    <div class="modal-body pad-0">
                        
                        
                        <div class="form-group">
                            <label for="rere_problem">Describe Problem <span class="required">*</span>:</label>
                            <textarea name="rere_problem" id="" cols="15" rows="2" class="form-control" style="height:50px;" ><?php echo !empty($comment[0]->eqco_comment)?$comment[0]->eqco_comment:'';?></textarea>
                        </div>
                        <?php if($org_id!='2'){ ?>
                        <div class="form-group">
                            <div class="rere_problem">
                                    <div class="ttl form-group">The following to be completed by Biomedical Engineering Staff</div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" value="Y" name="rere_manufcontacted">Distributer / Manufacturer must be contacted
                                                    </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" value="Y" name="rere_cannotmove">Cannot Be Moved
                                                    </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" value="Y" name="rere_warranty">Under Warrenty
                                                    </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="checkbox-inline">
                                                         <input type="checkbox" value="Y" name="rere_onsite">Can be Repaired on Site
                                                    </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" value="Y" name="rere_moved"> Moved to Biomedical Eng. Workshop
                                                    </label>
                                                </div>
                                                 <div class="col-sm-6">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" value="Y" name="rere_undermaintance">Under Maintantenence Contract
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="rere_notes">Notes</label>
                                            <textarea name="rere_notes" id="" cols="30" rows="2" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="rere_action">Action Taken:</label>
                                <textarea name="rere_action" id="" cols="30" rows="1" class="form-control"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label for="rere_parts">Parts/Material Used:</label><input type="radio" name="rere_ispartsused" value="N" class="isparts" checked="checked"> No <input type="radio" name="rere_ispartsused" value="Y" class="isparts"> Yes  
                              
            <div id="is_partsused" style="display: none">
                <a href="javascript:void(0)" class="btn btn-sm btn-primary btnAddParts"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <table class="table flatTable tcTable compact_Table">
                <thead>
                    <tr>
                        <th>Parts Name</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbl_parts">
                    <tr class="parts_dtl" id="parts_dtl_1">
                        <td><input type="text" name="parts_name[]" class="form-control"></td>
                        <td><input type="text" name="qty[]" data-tblid='1' class="form-control number cal " id="qty_1"></td>
                        <td><input type="text" name="rate[]" data-tblid='1' class="form-control float cal" id="rate_1"></td>
                        <td><input type="text" name="total[]" class="form-control total" id="total_1" readonly="true"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        </div>

                            </div>
                            
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label for="example-text">Outside Technical Cost:
                                </label>
                                 <input type="text" name="rere_techcost" class="form-control float calcost" id="technicalcost" placeholder="Technical Cost">
                            </div>
                            <div class="col-md-2">
                                <label for="example-text">Parts/Material Cost:
                                </label>
                                <br>
                                 <u><span id="material_cost"></span></u><input type="hidden" id="matcost" name="rere_partcost" class="calcost">
                            </div>
                            <div class="col-md-2">
                                <label for="example-text">Other Cost:
                                </label>
                                 <input type="text" name="rere_othercost" class="form-control float calcost" id="othercost">
                            </div>
                            <div class="col-md-2">
                                <label for="example-text">Total Cost :
                                </label>
                                 <br>
                                <input type="hidden" id="rere_totalcost" name="rere_totalcost" class="form-control float" placeholder="Total Cost" readonly="true"><span id="grandtotal"></span>
                            </div>
                       
                            <div class="col-md-2">
                                <label for="example-text">Expected Days <span class="required">*</span>:
                                </label>
                                <input type="text" name="rere_expecteddays" class="form-control float" placeholder="Expected Days" required>
                            </div>
                            <div class="col-md-2">
                                <label for="example-text">Technician:
                                </label>
                                <?php
                                 $this->load->model('biomedical/service_techs_mdl');
                                    $technician=$this->service_techs_mdl->get_all_service_techs();
                                    // echo "<pre>";
                                    // print_r($technician);
                                    // die();

                                ?>
                                <select name="rere_technician" class="form-control">
                                    <option value="">---select---</option>
                                    <?php
                                   
                                    if($technician):
                                        foreach ($technician as $kt => $tech):
                                        ?>
                                        <option value="<?php echo $tech->sete_techid; ?>"><?php echo $tech->sete_name; ?></option>
                                        <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                       <div class="clearfix"></div>
                    </div>
                     <?php if($commentStatus!= '3'): ?>
                    <div class="modal-footer">
                        <div id="ResponseSuccess_repair_req" class="alert-success success"></div>
                        <div id="ResponseError_repair_req" class=" alert-danger error"></div>
                        <button class="btn btn_site savelist" data-isdismiss="Y">Save</button>

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                      <?php endif; ?>
                </form>
            </div>

            <div id="externalform" style="display: none">
            	<form id="repair_reqext" action="<?php echo base_url('home/save_repair_information_comment')?>" method="POST">
	<input type="hidden" name="id" value="<?php echo!empty($comment[0]->eqco_equipmentcommentid)?$comment[0]->eqco_equipmentcommentid:'';  ?>">
		<input type="hidden" name="equipid" value="<?php echo!empty($comment[0]->eqco_eqid)?$comment[0]->eqco_eqid:'';  ?>">
                    <div class="modal-body pad-0">
                        <input type="hidden" name="rere_problemtype" value="Ex" >
                        <div class="form-group">
                            <label for="rere_problem">Describe Problem <span class="required">*</span>:</label>
                            <textarea name="rere_problem" id="" cols="15" rows="2" class="form-control" style="height:50px;" ><?php echo !empty($comment[0]->eqco_comment)?$comment[0]->eqco_comment:'';?></textarea>
                        </div>
                          <div class="form-group row">
                            <div class="col-md-2">
                            	 <label for="example-text">Dispatch Type:<span class="required">*</span></label>
                            	 <select class="form-control" name="rere_dispatchtype">
                            	 	<option value="company">Companay </option>
                            	 	<option value="person">Person </option>
                            	 </select>
                            </div>
                             <div class="col-md-2">
                             	 <label for="example-text">Dispatch To:<span class="required">*</span></label>
                            	 <input type="text" name="rere_dispatchto" class="form-control" placeholder="Company Or Person">
                            </div>
                            <div class="col-md-2">
                             	 <label for="example-text">Contact No:</label>
                            	 <input type="text" name="rere_dispatchcontactno" class="form-control" placeholder="Contact No">
                            </div>
                            <div class="col-md-2">
                            	 <label for="example-text">Dispatch Date: <span class="required">*</span></label>
                            	 <input type="text" name="dispatchdate" class="form-control <?php echo DATEPICKER_CLASS ;?> " id="" placeholder="Dispatch Days" value="<?php echo DISPLAY_DATE; ?>">
                            </div>
                            <div class="col-md-2">
                             	 <label for="example-text">Expected Cost <span class="required">*</span>:
                                </label>
                                <input type="text" name="rere_disexpcost" class="form-control float" placeholder="Expected Cost" required>

                            </div>
                             <div class="col-md-2">
                             	 <label for="example-text">Expected Days <span class="required">*</span>:
                                </label>
                                <input type="text" name="rere_expecteddays" class="form-control float" placeholder="Expected Days" required>

                            </div>
                    </div>
                    
 
                     <div class="modal-footer">
                        <div id="ResponseSuccess_repair_reqext" class="alert-success success"></div>
                        <div id="ResponseError_repair_reqext" class=" alert-danger error"></div>
                        <button class="btn btn_site savelist" data-isdismiss="Y">Save</button>

                        <button type="button" class="btn btn-default btncancel" data-dismiss="modal">Close</button>
                  
                    </div>
                </form>

            </div>

<script>
    $(document).off('click','#cancel_button');
   $(document).on('click','#cancel_button',function(){
    var conf = confirm('Are Your Want to Sure to Cancel?');
  if(conf)
  {

    var equipcommentid= $('#equipcommentid').val();
    //alert(equipcommentid);
     $.ajax({
        type: "POST",
        url: base_url + 'home/cancel_comment',
        data:{equipcommentid:equipcommentid},
        dataType: 'html',
        success: function(data) {
            datas = jQuery.parseJSON(data);   
          if(datas.status=='success') {
             //$('#myModalRepair').modal('hide');
            $('#myModal1').modal('hide');

             //$('#btncancel').trigger('click');
              // $('#equipmentdetail').html(datas.template);
          }
        }
      })
    }
})

</script>


	
