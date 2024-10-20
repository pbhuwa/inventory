<div class="row wb_form">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title">Preventive Maintenance Data</h3>
            <div  id="FormDiv_PmdataForm" class="formdiv frm_bdy">
            <?php $this->load->view('pm_data/v_pm_dataform');?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
     <div class="white-box">
         <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
            <?php $this->load->view('pm_data/v_pm_data_list');?>
          </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).off('click','.isCompletePm');
    $(document).on('click','.isCompletePm',function(){
        $('#pmCompletedModal').modal('show');
      var equipid = $(this).data('equipid'); 
      var pmtaid = $(this).data('pmtaid');
      // alert(equipid);
      // return false;
      $('#equiPid').val(equipid);
      $('#pmtatable').val(pmtaid);
      $.ajax({
        type: "POST",
        url: base_url + 'biomedical/pm_data/get_pm_data_detail',
        data:{equipid:equipid, pmtaid:pmtaid},
        dataType: 'html',
        success: function(data) {
            datas = jQuery.parseJSON(data);   
          if(datas.status=='success') {
             
              $('#equipmentdetail').html(datas.template);
          }
        }
      })
  })
</script>

                    


                    


                    



                    

