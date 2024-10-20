<style>
    .purs_table tbody tr td{
    border: none;
    vertical-align: center;
    }
</style>


   <div class="searchWrapper">  
    <form id="purchase_receive_report_search_form">       
    <div class="row">          
        <div class="col-md-3 col-sm-4">

            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
            <select name="fiscalyear" class="form-control select2" id="fiscalyear" >
                <option value="">---select---</option>
                    <?php
                        if($fiscal):
                            foreach ($fiscal as $km => $fy):
                    ?>
                <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="Supplier"><?php echo $this->lang->line('supplier_name'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">
                <?php
                    $supplierid = !empty($upload_data[0]->reum_supplierid)?$upload_data[0]->reum_supplierid:'';
                ?>
                <select id="supplierid" name="supplierid" class="form-control required_field select2" >
                    <option value="">---select---</option>
                    <?php
                        if(!empty($supplier_all)):
                            foreach ($supplier_all as $ks => $supp):
                        ?>
                    <option value="<?php echo $supp->dist_distributorid; ?>" 
                        <?php echo ($supplierid == $supp->dist_distributorid)?'selected="selected"':''; ?> 
                        >
                        <?php echo $supp->dist_distributor; ?> 
                    </option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
                
            </div>
        </div>

              
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('upload_no'); ?><span class="required">*</span>: </label>

            <div class="dis_tab">
                <input type="text" name="req_no" class="form-control number enterinput required_field"  placeholder="Enter Requisition Upload Number" value="" id="requisitionNumber" data-targetbtn="btnSearchReqno">
                
                <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchReqno"><i class="fa fa-search"></i></a>&nbsp;

             
            </div>
            <span class="errmsg"></span>
        </div>
    </div>
</form>
</div>
<div class="clearfix"></div>

<div id="displayReportDiv">
    
</div>


   

<script>
    $(document).off('click','#btnSearchReqno');
    $(document).on('click','#btnSearchReqno',function(e){
        var requisitionno = $("#requisitionNumber").val();
        var fiscalyear = $("#fiscalyear").val();
        var supplierid=$('#supplierid').val();
        var action=base_url+'purchase_receive/req_upload/search_supply_rate_correction';
        $.ajax({
            type: "POST",
            url: action,
            data:{requisitionno:requisitionno,fiscalyear:fiscalyear,supplierid:supplierid},
            dataType: 'html',
             beforeSend: function() {
              // $(this).prop('disabled',true);
              // $(this).html('Saving..');
              $('.overlay').modal('show');
            },
            success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                // console.log(data);
                // return false;
                $('#displayReportDiv').html('');
                if(data.status=='success')
                {
                  $('#displayReportDiv').html(data.template);
                }
                if(data.status=='error')
                {
                    alert(data.message);
                    $("#requisitionNumber").focus();
                    $('#displayReportDiv').html('');

                
                }
                $('.overlay').modal('hide');
            }
        });
    })
</script>

