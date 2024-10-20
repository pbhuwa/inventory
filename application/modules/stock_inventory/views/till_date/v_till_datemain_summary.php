<div class="searchWrapper">
    <form id="TillDateSummary" action="" class="form-material form-horizontal form">
        <div class="row">
            <div class="form-group">
                <?php echo $this->general->location_option(2,'locationid'); ?>

                <div class="col-md-2 col-sm-4 col-xs-12">
                    <label for="example-text"><?php echo $this->lang->line('store'); ?> 
                        <span class="required">*</span>:
                    </label>
                    <select name="eqty_equipmenttypeid" class="form-control select2 storeSummaryChange" id="store_id" data-action="<?php echo base_url('stock_inventory/stock_check/change_data_summary');?>">
                        <option value="">---All---</option>
                        <?php
                            if($store_type):
                                foreach ($store_type as $km => $eq):
                        ?>
                            <option value="<?php echo $eq->eqty_equipmenttypeid; ?>"><?php echo $eq->eqty_equipmenttype; ?></option>
                        <?php
                                endforeach;
                            endif;
                        ?>
                    </select>
                </div>
                
                <div id="resultDateRangeSummary"></div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="stock_inventory/stock_check/stock_till_date_summary_search">
                        <?php echo $this->lang->line('search'); ?>
                    </button>
                </div>
            </div> 
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>

<script type="text/javascript">
    $(document).on('change','.storeSummaryChange',function(){
        var attrid=$(this).attr('id');
        var id=$(this).val();
        var srchurl=$(this).data('action'); 
        $.ajax({
            type: "POST",
            url: srchurl,
            data:{id:id},
            dataType: 'html',
            beforeSend: function() {
                $('.overlay').modal('show');
            },
            success: function(jsons)
            {
                // console.log(jsons);
                var jsondata=jQuery.parseJSON(jsons);   
                // return false;
                // console.log(jsondata.data);
                if(jsondata.status=='success')
                {
                    $('#resultDateRangeSummary').html(jsondata.template);
                    $('.overlay').modal('hide');
                }
                else
                {
                    $('#result_'+attrid).html('');
                }
            }
        })
    })

    $(document).on('click','.tillDateSearch',function() {
        var rpttype=$(this).val();
        var action = base_url+'stock_inventory/stock_check/stock_till_date_summary_search';
        $.ajax({
        type: "POST",
            url: action,
            data:$('#TillDateSummary').serialize(),
            dataType: 'html',
            beforeSend: function() {
                $('.overlay').modal('show');
            },
            success: function(jsons) //we're calling the response json array 'cities'
            {
                console.log(jsons);

                data = jQuery.parseJSON(jsons);   
                //alert(data.status);
                if(data.status=='success')
                {
                    // $('#Subtype').html(data.template);
                    $('#tillDateSummrySearchResult').html(data.template);
                    $('.overlay').modal('hide');
                }
                else
                {
                    // alert(data.message);
                }
            }
        });
        return false;
    })
    
    $(document).off('click','.summaryprit');
    $(document).on('click','.summaryprit',function(){
        $('#tillDateSummrySearchResult').printThis();
    })

    $(document).off('click','.pdftillDateSummary');
    $(document).on('click','.pdftillDateSummary',function(){
        var store_id=$('#store_id').val();
        var masterid= $('#masterid').val(); 
        var redirecturl=base_url+'stock_inventory/stock_check/tilldate_summary_pdf';
        $.redirectPost(redirecturl, {store_id:store_id,masterid:masterid});
    })

    $(document).off('click','.tillDateSummary');
    $(document).on('click','.tillDateSummary',function(){
        var store_id=$('#store_id').val();
        var masterid= $('#masterid').val(); 
        var redirecturl=base_url+'stock_inventory/stock_check/excel_tilldate_summary';
        $.redirectPost(redirecturl, {store_id:store_id,masterid:masterid});
    })
</script>