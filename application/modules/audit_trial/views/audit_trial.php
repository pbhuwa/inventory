<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">Audit Trails</h3>
            <div class="pad-10">
                <div class="">
                    <div class="row mbtm_15">
                     <?php 
                    $this->load->view('audit_trial_form');
                    ?>  

                    </div>

                    <div class="white-box pad-10 mtop_15 actual_form" style="overflow-y: scroll;" id="audit_reponse">
                    <?php 
                    $this->load->view('audit_trial_list');
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>



<script type="text/javascript">
	$(document).off('click','.btnSearch');
	$(document).on('click','.btnSearch',function() {
	var action=base_url+'/audit_trial/generate_report_audit_trial';
    $.ajax({
    type: "POST",
    url: action,
    data:$('#formAudittrial').serialize(),
     dataType: 'html',
     beforeSend: function() {
      $('.overlay').modal('show');
    },
   success: function(jsons) //we're calling the response json array 'cities'
    {
      console.log(jsons);

        data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
          
        $('#audit_reponse').html(data.template);
            
        }
        else
        {
           
        }
         $('.overlay').modal('hide');

       }
    });
    return false;
    })
</script>