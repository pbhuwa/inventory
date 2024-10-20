
    <div class="row">
        <div class="col-sm-4">
            <div class="white-box">
                <h3 class="box-title">API Management</h3>
                <div id="FormDiv" class="formdiv frm_bdy">
                <?php $this->load->view('api/api/v_apiform') ;?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <div class="white-box">
                <h3 class="box-title">API List</h3>
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                    <div id="TableDiv">
                        <?php echo $this->load->view('api/api/v_api_list'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


   
                    

<script type="text/javascript">
    $(document).off('click','.btnGenerateApi');
    $(document).on('click','.btnGenerateApi',function(e){
        var action=$(this).data('href');
        // alert(url);
        // return false;
    $.ajax({
    type: "POST",
    url: action,
     dataType: 'html',
     contentType:false,
      processData:false,
      data: {},
     beforeSend: function() {
      // $(this).prop('disabled',true);
      // $(this).html('Saving..');
      $('.overlay').modal('show');
    },
   success: function(jsons) //we're calling the response json array 'cities'
    {
      // console.log(jsons);

        data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
            alert(data.message);
            
        }
           $('.overlay').modal('hide');
    }

    });
    });
    
</script>