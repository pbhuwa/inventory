
 <?php if (isset($tab_type)) $this->load->view('assets/v_assets_common')?>

<div class="row wb_form">
    <div class="col-sm-7">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('assign_equipment'); ?></h3>
            <div  id="FormDiv_PmdataForm" class="formdiv frm_bdy">
            <?php $this->load->view('assign_assets/v_assign_assets_form');?>
            </div>
        </div>
    </div>
 <div class="col-sm-5 no-pad-left">
        <?php $this->load->view('assign_assets/v_assign_assets_activity') ;?>
      </div>
   
</div>

 <div class="modal fade" id="equipAssign" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content xyz-modal-123">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('assign_assets'); ?></h4>
            </div>
            
            <div class="modal-body pad-5 scroll vh80 displyblock">

            
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
 $(document).on('change','#departwithequip',function()
  {
    var assetsid=$(this).val();
    // alert(assetsid);
    // exit();
    var action=base_url+'ams/assign_assets/get_assets_desc_from_assets_type';
     $.ajax({
          type: "POST",
          url: action,
          data:{assetsid:assetsid},
          dataType: 'html',
          beforeSend: function() {
      $('.overlay').modal('show');
    },
   success: function(jsons) //we're calling the response json array 'cities'
    {
        data = jQuery.parseJSON(jsons);   
        if(data.status=='success')
        {
            $('#equipment_list').html(data.tempform);
            $('#bmin_roomid').html(data.room_template);
 
        }
        $('.overlay').modal('hide');
    }
      
      });
  })
</script>


<script type="text/javascript">
  $(document).off('click','.btnAssign');
  $(document).on('click','.btnAssign',function(){
    // $('#equipAssign').modal('show');
    // get_equipment_detail

      var assetsid=$(this).data('assetsid');
      var assetstypeid=$(this).data('assetstypeid');
      var assetsdesid=$(this).data('assetsdesid');

    // alert(id);
    //   exit();



      var action=base_url+'ams/assign_assets/get_assets_detail';
      // alert(url);

      $('#equipAssign').modal('show');

        $.ajax({
          type: "POST",
          url: action,
          data:{assetsid:assetsid,assetstypeid:assetstypeid,assetsdesid:assetsdesid},
          dataType: 'html',
          beforeSend: function() {
            $('.overlay').modal('show');
          },
        success: function(jsons) 
          {

         data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
        
          $('.displyblock').html(data.tempform);
        }  
       
       else{
        alert(data.message);
       }
       $('.overlay').modal('hide');
     }
       });

  });

</script>



                    
<script type="text/javascript">
    $(document).on('click',".chkboxall",function () {

     $('input:checkbox').not(this).prop('checked', this.checked);
 });
</script>

<script type="text/javascript">
    $(document).off('click','.btnMultipleAssign');
    $(document).on('click','.btnMultipleAssign',function(){
      var departmentid=$(this).data('departmentid');
    var action=base_url+'ams/assign_assets/assets_assign_multiple';
    var val = [];
        $('input:checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
        if(val=='')
        {
          alert('Please check atleast one Assets !!!');
          return false;
        }

         $('#equipAssign').modal('show');

        $.ajax({
          type: "POST",
          url: action,
          data:{id:val,depid:departmentid},
          dataType: 'html',
          beforeSend: function() {
            $('.overlay').modal('show');
          },
        success: function(jsons) 
          {
              data = jQuery.parseJSON(jsons);   
            $('.displyblock').html('');

            if(data.status=='success')
            {

                $('.displyblock').html(data.tempform);
            } 
            else{
        alert(data.message);
       }
          $('.overlay').modal('hide');
   }
    })
    });
</script>
