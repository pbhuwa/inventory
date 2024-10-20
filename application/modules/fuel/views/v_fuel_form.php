<form method="post" id="Formfuellist" action="<?php echo base_url('fuel/save_fuel'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('fuel/fuel/form_fuel_list'); ?>' >
	<div>
		
		<div class="form-group">
			<div class="col-md-4">
				<label for="example-text">Fuel Type:</label>
			
				<select class="form-control" name="fuel_typeid">
					<option value="">---select---</option>
					<?php
					foreach ($fuel_list as $value) { ?>
						<option value="<?php echo $value->futy_typeid ?>" ><?php echo $value->futy_name ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="example-text">Month:</label>
				<select class="form-control" name="fuel_month">
					<option value="">---select---</option>
					<?php
					foreach ($month as $value) { ?>
						<option value="<?php echo $value->mona_monthid ?>" ><?php echo $value->mona_namenp ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col-md-4 ">
				<?php $fuel_fyear = !empty($fuel_data[0]->fuel_fyear)?$fuel_data[0]->fuel_fyear:CUR_FISCALYEAR; ?>
				<label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :</label>
				<!--  <input type="text" class="form-control" name="fuel_fyear" id="fiscal_year" value="<?php echo $fuel_fyear; ?>" placeholder="Fiscal Year" > -->
				<select name="fuel_fyear" class="form-control required_field" id="fyear">
					<?php
					if($fiscal_year): 
						foreach ($fiscal_year as $kf => $fyrs):
							?>
							<option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
						<?php endforeach; endif; ?>
					</select>
				</div>
				<div class="col-md-4">
					<label for="example-text">No of Coupen:</label>
					
					<input type="text" class="form-control number" name="fuel_noofcoupen"  value="" id="noofcoupen">
				</div>
				<div class="col-md-4 ">
				
					<label for="example-text">Generate date<span class="required">*</span> :</label>
					<input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="fuel_gendate" value="" id="gendate" placeholder="YYYY/MM/DD ">
				</div>
				<div class="col-md-4">
				
					<label for="example-text"> Coupen Valid date<span class="required">*</span> :</label>
					<input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="fuel_expdate" value="" id="expdate" placeholder="YYYY/MM/DD ">
				</div>
			</div>
			
			<div class="clearfix"></div>
			<?php $lastid=$next_id+1; ?>
	       <input type="hidden" id="insertid" value="<?php echo $lastid; ?>">


			<div class="form-group" style="margin-top: 2%">
				<div class="col-md-4">
					<button type="submit" id="genCoupen" class="btn btn-info  save"  data-hasck="Y" data-operation='save'>Generate Coupen</button>
				</div>
				 <div class="col-sm-12">
					<div  class="alert-success success"></div>
					<div class="alert-danger error"></div>
				</div>
			</div>
		</div>
	</form>
	<!-- <div id="CoupenGenerate">
	</div> -->
 	 
<!-- <script>
    $(document).off('click','#genCoupen');
    $(document).on('click','#genCoupen',function(){
    	
       var id =$('#insertid').val();
         // alert (id);
         // return false;

    
        $.ajax({
            type: "POST",
            url: base_url+'fuel/fuel/get_coupen_generate',
            data: {id:id},
            dataType: 'json',
            beforeSend: function() {
                $('.overlay').modal('show');
            },
            success: function(datas) {
                  // alert(datas.tempform);
                // console.log(datas);
                if(datas.status == 'success'){
                    $('#CoupenGenerate').html(datas.tempform);
                }
                $('.overlay').modal('hide');
            }
        });
    }); 
    
</script> -->


