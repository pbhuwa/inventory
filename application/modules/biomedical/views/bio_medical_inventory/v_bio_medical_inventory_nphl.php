<div class="row wb_form">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title">NPHL Equipment Setup </h3>
            <div id="FormDiv_biomedicalinventory" class="formdiv frm_bdy">
            <?php $this->load->view('bio_medical_inventory/v_bio_medical_inventory_form_nphl') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
     <div class="white-box">
   <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
   <div id="TableDiv">
          <?php $this->load->view('bio_medical_inventory/v_bio_medical_list'); ?>
        </div>
        </div>
    </div>
</div>

<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Equipment Comment</h4>
      </div>
      <div class="modal-body"> 
        <div class="white-box list">
          <form method="post" id="FormComments" action="<?php echo base_url('biomedical/Bio_medical_inventory/save_comment'); ?>" class="form-material form-horizontal form">
            <div class="resultrComment">

            </div>
            <div class="form-group mbtm_0">
              <div id="equipmentdetail"></div>
              <div class="clear"></div>
              <div class="col-md-12">
                <label>Describe Problem: </label>
                <textarea style="width: 100% ;height: 75px" name="eqco_comment" class="form-control" autofocus="true"></textarea>
                <input type="hidden"  name="eqco_eqid" id="eqco_eqid"/>
              <div id="ResponseSuccess_FormComments" class="waves-effect waves-light m-r-10 text-success"></div>
              <div id="ResponseError_FormComments" class="waves-effect waves-light m-r-10 text-danger"></div>
              </div>

              <div class="col-sm-12">
                <button type="submit" class="btn btn-info savelist mtop_10" data-isdismiss='Y'>Save</button>
              </div>
              <div class="clear"></div>
              <hr/>
              <div class="col-sm-12">
                <strong>Previous Comments:</strong>
                <div id="TableDiv">
                <div class="repairHistory"></div>
              </div>
              </div>
              
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->
</div>
</div>


<script type="text/javascript">

  $(document).off('click','.myModalCall');
  $(document).on('click','.myModalCall',function(){
    var euipid = $(this).data('id');
    // alert(euipid);
    $.ajax({
      type: "POST",
      url: base_url+'biomedical/bio_medical_inventory/get_inventory_data',
      data:{euipid:euipid},
      dataType: 'json',
        beforeSend: function() {
      $('.overlay').modal('show');
    },

      success: function(datas) {
        if(datas.status=='success') {
            $('#equipmentdetail').html(datas.tempformequip);
            $('.repairHistory').html(datas.tempform);
            $('#eqco_eqid').val(euipid);
        }
          $('.overlay').modal('hide');
      }
    });
    // $('#myModal1').modal('show');
    $('#myModal1').modal({
      show: true
    });
  })
  

    $(document).off('click','.btnBarcode');
    $(document).on('click','.btnBarcode',function(){
        var equipid = $(this).data('id');
       
        // alert(dep);
        $.ajax({
            type: "POST",
            url: base_url+'biomedical/bio_medical_inventory/get_barcode',
            data:{equipid:equipid},
            dataType: 'json',
              beforeSend: function() {
        $('.overlay').modal('show');
          },
            success: function(datas) {
                // alert(datas.tempform);
                console.log(datas);
                $('.showBarcode').html(datas.tempform);
                  $('.overlay').modal('hide');
            }
        });
    }); 
    
</script>

<script type="text/javascript">
  $(document).on('change','#purchaseCost',function() {
    var valueSelected = $(this).val();
    // alert(valueSelected);

    if(valueSelected=='')
    {
        $('.donateCost').hide();
        $('#donatediv').hide();
    }
    else
    {
         if(valueSelected == "1" ){
         $('.donateCost').show();
          $('#donatediv').hide();
        }

        if(valueSelected != "1" && valueSelected !='' )
        {
        $('.donateCost').hide();
        $('#donateOrg').focus();
        $('#donatediv').show();
    }
    }
   
  });

  $(document).off('change','.equipmentdesc');
  $(document).on('change','.equipmentdesc',function() {
      var eqidescid=$(this).val();
      // alert(eqidescid);
      var action=base_url+'biomedical/bio_inventory_setting/get_primary_equipid';
      $.ajax({
          type: "POST",
          url: action,
          data:{eqidescid:eqidescid},
          dataType: 'html',
          beforeSend: function() {

            // $('.overlay').modal('show');
          },
      success: function(jsons) 
      {
        console.log(jsons);

        data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
          $('#equipmentid').val(data.equikey);
            
        }
        else
        {
           alert(data.message);
        }
      }
    });
  })


 


</script>
