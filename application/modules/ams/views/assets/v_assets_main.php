<div class="row">
    
        <?php $this->load->view('assets/v_assets_common');?>
    

    <div class="row pad-5">
        <div class="col-sm-10">
            <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('assets_entry'); ?></h3>
                <div id="FormDiv" class="formdiv frm_bdy">
                    <?php $this->load->view('assets/v_assets_form') ;?>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="white-box">
                <?php //$this->load->view('assets/v_assets_dep_list') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </div>
</div>              
</div>
</div>
</div>
<!-- <script>
    $(document).off('click','.btnBarcode');
    $(document).on('click','.btnBarcode',function(){
        var asset_id = $(this).data('id');
       
        // alert(dep);
        $.ajax({
            type: "POST",
            url: base_url+'ams/assets/get_barcode',
            data:{asset_id:asset_id},
            dataType: 'json',
              beforeSend: function() {
        $('.overlay').modal('show');
          },
            success: function(datas) {
                // alert(datas.tempform);
                // console.log(datas);
                $('.showBarcode').html(datas.tempform);
                $('.overlay').modal('hide');
            }
        });
    }); 
    
</script> -->