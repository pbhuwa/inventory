<div class="">
    <div class="row">
<form method="post" id="FormMenu" action="<?php echo base_url('stock_inventory/change_supplier/save_change_supplier'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/change_supplier/form_change_supplier'); ?>'>
    <input type="hidden" name="id" value="">
    <div class="bg-gray col_btm_gap">
            <div class="form-group">
                <div class="col-md-4">
                    <label for="example-text"><?php echo $this->lang->line('receipt_no'); ?>: <span class="required">*</span>:</label>
                    <input type="text" class="form-control" name="receipt_no" id="receipt_no">
                </div>
                <div class="col-md-4">
                    <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?>: <span class="required">*</span>:</label><br>
                    <select name="fiscal_yrs" class="select2 form-control" id="fiscalyrs">
                        <option value="">----Select----</option>
                        <?php
                        if($fiscal_year):
                        foreach ($fiscal_year as $kf => $fyr):
                        ?>
                        <option value="<?php echo $fyr->fiye_name;?>" <?php if($fyr->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fyr->fiye_name;?></option>
                        <?php
                        endforeach;
                        endif;
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <div>
                        <a href="javscript:void(0)" class="btn paddingright-10 btn-success margintop3" id="btnSrch" style="padding-right: 10px;"><?php echo $this->lang->line('search'); ?></a>
                    </div>
                </div>
            </div>
            <div id="detailrec" style="display: none">
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="example-text">Purchase Date.: <span class="required">*</span>:</label>
                        <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="purchase_date" id="purchase_date" value="<?php echo DISPLAY_DATE; ?>">
                    </div>
                    <div class="col-md-9">
                        <label for="example-text">Select Actual Supplier .: <span class="required">*</span>:</label><br>
                        <select class="select2" name="supplierid" id="supplierid" style="width: 70%">
                            <option value="">---select---</option>
                            <?php
                            if($distributor_list):
                            foreach ($distributor_list as $kd => $dis):
                            ?>
                            <option value="<?php echo $dis->dist_distributorid; ?>"><?php echo $dis->dist_distributor; ?></option>
                            <?php
                            endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="example-text">Select Bill Date .: <span class="required">*</span>:</label>
                        <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="billdate" id="billdate"  value="<?php echo DISPLAY_DATE; ?>"  >
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-info  save" data-operation='save' id="btnSubmit" >Save</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    
                    <div class="alert-danger error"></div>
                    <div  class="alert-success success"></div>
                </div>
            </div>
    </div>
</form>
</div>
</div>
    <script type="text/javascript">
        $(document).off('click','#btnSrch');
        $(document).on('click','#btnSrch',function(){
        var receipt_no=$('#receipt_no').val();
        var fiscalyrs=$('#fiscalyrs').val();
        var action=base_url+'stock_inventory/change_supplier/checkinovice';
        // alert(fiscalyrs);
        $.ajax({
        type: "POST",
        url: action,
        data:{receipt_no:receipt_no,fiscal_yrs:fiscalyrs},
        dataType: 'html',
        beforeSend: function() {
        // $(this).prop('disabled',true);
        // $(this).html('Saving..');
        $('.overlay').modal('show');
        },
        success: function(jsons) //we're calling the response json array 'cities'
        {
        // console.log(jsons);
        var datas = jQuery.parseJSON(jsons);
        var dat=datas.data;
        // alert(data.status);
        if(datas.status=='success')
        {
        $('#detailrec').show();
        $('#purchase_date').val(dat.recm_receiveddatebs);
        setTimeout(function(){
        $('#supplierid').val(dat.recm_supplierid).trigger('change');
        //   $("#supplierid option[text="+dat.recm_supplierid+"]").attr('selected', 'selected');
        },500);
        
        $('#billdate').val(dat.recm_receiveddatebs);
        }
        else
        {
        $('#detailrec').hide();
        $('.error').html(datas.message);
        $('.error').addClass('alert');
        }
        $('.overlay').modal('hide');
        
        setTimeout(function(){
        $('.error').html('');
        $('.error').removeClass('alert');
        $('.success').html('');
        $('.success').removeClass('alert');
        },3000);
        }
        });
        })
        $('.select2').select2();
    </script>