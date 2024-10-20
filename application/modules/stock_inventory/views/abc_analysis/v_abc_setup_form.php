<div class="searchWrapper">
    <div class="row">
        <form id="formAbcSetup" action="<?php echo base_url('stock_inventory/abc_analysis/save_absvalue'); ?>" data-reloadurl='<?php echo base_url('stock_inventory/abc_analysis/form_abc'); ?>'>
            <fieldset>
                <legend><?php echo $this->lang->line('item_class'); ?></legend>
                <div class="col-sm-4">
                    <fieldset>
                        <legend><?php echo $this->lang->line('class_a'); ?> :</legend>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6 text-right">
                                    <label class="single_line_lbl"><?php echo $this->lang->line('consumption'); ?></label>
                                </div>
                                <input type="hidden" name="id[]" value="<?php echo  !empty($absabcsetup[0]->abse_abcsetupid)?$absabcsetup[0]->abse_abcsetupid:''; ?>"/>
                                <div class="col-sm-4">
                                    <input type="text" name="consumptionA[]" id="classAconsumption" class="form-control " value="<?php echo  !empty($absabcsetup[0]->abse_consumption)?$absabcsetup[0]->abse_consumption:''; ?>"/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="single_line_lbl"> 20 %</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 text-right">
                                    <label class="single_line_lbl"><?php echo $this->lang->line('revenue'); ?></label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="revenueA[]" id="classArevenue" class="form-control classArevenue" value="<?php echo  !empty($absabcsetup[0]->abse_revenu)?$absabcsetup[0]->abse_revenu:''; ?>"/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="single_line_lbl"> 80 %</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-sm-4">
                    <fieldset>
                        <legend><?php echo $this->lang->line('class_b'); ?> :</legend>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6 text-right">
                                    <label class="single_line_lbl"><?php echo $this->lang->line('consumption'); ?></label>
                                </div>
                                <input type="hidden" name="id[]" value="<?php echo  !empty($absabcsetup[1]->abse_abcsetupid)?$absabcsetup[1]->abse_abcsetupid:''; ?>"/>
                                <div class="col-sm-4">
                                    <input type="text" name="consumptionA[]" id="classBconsumption" class="form-control " value="<?php echo  !empty($absabcsetup[1]->abse_consumption)?$absabcsetup[1]->abse_consumption:''; ?>"/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="single_line_lbl">30 %</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 text-right">
                                    <label class="single_line_lbl"><?php echo $this->lang->line('revenue'); ?></label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="revenueA[]" id="classBrevenue" class="form-control classArevenue" value="<?php echo  !empty($absabcsetup[1]->abse_revenu)?$absabcsetup[1]->abse_revenu:''; ?>"/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="single_line_lbl">30 %</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-sm-4">
                    <fieldset>
                        <legend><?php echo $this->lang->line('class_c'); ?>:</legend>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6 text-right">
                                    <label class="single_line_lbl"><?php echo $this->lang->line('consumption'); ?></label>
                                </div>
                                <input type="hidden" name="id[]" value="<?php echo  !empty($absabcsetup[2]->abse_abcsetupid)?$absabcsetup[2]->abse_abcsetupid:''; ?>"/>
                                <div class="col-sm-4">
                                    <input type="text"  name="consumptionA[]" id="classCconsumption" class="form-control classAconsumption " value="<?php echo  !empty($absabcsetup[2]->abse_consumption)?$absabcsetup[2]->abse_consumption:''; ?>"/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="single_line_lbl">50 %</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 text-right">
                                    <label class="single_line_lbl"><?php echo $this->lang->line('revenue'); ?></label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="revenueA[]" id="classCrevenue" class="form-control classArevenue" value="<?php echo  !empty($absabcsetup[2]->abse_revenu)?$absabcsetup[2]->abse_revenu:''; ?>"/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="single_line_lbl">5 %</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label id="Consumption"> </label>
                                </div>
                                <div class="col-sm-12">
                                    <label id="grandtotal"> </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            <div class="col-md-12">
                <?php
                $save_var=$this->lang->line('save');
                $update_var=$this->lang->line('update');
                ?>

                <button type="submit" class="btn btn-info  save" data-operation='<?php //echo !empty($absabcsetup)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($absabcsetup)?$update_var:$save_var; ?></button>
            </div>    
        </fieldset>
        <div  class="waves-effect waves-light m-r-10 text-success success"></div>
        <div class="waves-effect waves-light m-r-10 text-danger error"></div>
    </form>
    </div>
    <div class="clear"></div>
</div>

<script>
    
    $(document).ready(function(){
        var revenuea =0,revenueb=0,totalb=0,revenuec=0,totalc=0;
        $(document).on('keyup','.classArevenue',function(){
            var trid=$(this).data('id');
            revenuea = $('#classArevenue').val();
            revenueb = $('#classBrevenue').val();
            revenuec = $('#classCrevenue').val(); 
            //console.log();
            if(revenuea == '' || revenuea == NaN)
            {
                $('#classArevenue').focus();
            }
            if(revenueb == '' || revenueb == NaN)
            {
                $('#classBrevenue').focus();
                //alert('You Must Enter B Value!');
            }
            if(revenuec == '' || revenuec == NaN)
            {
                $('#classCrevenue').focus();
                //alert('You Must Enter C Value!');
            }
            totalc = parseFloat(parseFloat(revenuea) + parseFloat(revenueb) + parseFloat(revenuec));
            if(totalc < 100)
            {
                setTimeout(function(){
                  alert('Sum Of Revenue Percent Cannot Be Less Than 100%!');
                  $('#classBrevenue').focus();
                },1000);
                
            }
            if(totalc > 100)
            {  
               $('#classCrevenue').focus(); 
                setTimeout(function(){
                    alert('Sum Of Revenue  Percent Cannot Exceed More Than 100%!');
                },2000);

            }
            else{
                totalc = parseFloat(parseFloat(revenuea) + parseFloat(revenueb) + parseFloat(revenuec));  
            }  
        });
    });
    $(document).ready(function(){
        var consumptiona=0,revenuea =0,totala=0,consumptionb=0 ,revenueb=0,totalb=0,consumptionc=0,revenuec=0,totalc=0;
        $(document).on('keyup','.classAconsumption',function(){
           
            var stotal = 0;
            var netrate = 0;
            var trid=$(this).data('id');

            Aconsumption = $('#classAconsumption').val();
            bconsumption = $('#classBconsumption').val();
            cconsumption = $('#classCconsumption').val();
           // Arevnue = $('#classArevenue').val();
            
            var totala = 0;
                if(Aconsumption == '' || Aconsumption == NaN)
                {
                    $('#classAconsumption').focus();
                }
                if(bconsumption == '' || bconsumption == NaN)
                {
                    $('#classBconsumption').focus();
                    //alert('You Must Enter B Value!');
                }
                if(cconsumption == '' || cconsumption == NaN)
                {
                    $('#classCconsumption').focus();
                    //alert('You Must Enter C Value!');
                }
            totala = parseFloat(parseFloat(Aconsumption) + parseFloat(bconsumption) + parseFloat(cconsumption));
            if(totala < 100)
            {
                setTimeout(function(){
                    alert('Sum Of Consumption Percent Cannot Be Less Than 100%!');
                },800);
                $('#classBconsumption').focus(); 
            }else if(totala > 100)
            {   setTimeout(function(){
                    alert('Sum Of Consumption  Percent Cannot Exceed More Than 100%!');
                },800);
                $('#classCconsumption').focus();
            }
            else{
                totala = parseFloat(parseFloat(Aconsumption) + parseFloat(bconsumption) + parseFloat(cconsumption));  
            }
        });
    });
</script>