<div class="row wb_form">
    <div class="col-sm-8">
        <div class="white-box">
            <h3 class="box-title">Assign Equipment</h3>
            <div  id="FormDiv_PmdataForm" class="formdiv frm_bdy">
            <?php $this->load->view('assign_equipement/v_assign_equipment_form');?>
            </div>
        </div>
    </div>

      <div class="col-sm-4 no-pad-left">
        <?php $this->load->view('assign_equipement/v_assign_equipment_activity') ;?>
      </div>
  
</div>

 <div class="modal fade" id="equipAssign" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content xyz-modal-123">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Assign Equipment</h4>
            </div>
            
            <div class="modal-body pad-5 scroll vh80 displyblock">

            
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
 $(document).on('change','#departwithequip',function()
  {
    var depid=$(this).val();
    var action=base_url+'biomedical/bio_medical_inventory/get_room_with_equip_from_depid';
    // alert(depid);
     $.ajax({
          type: "POST",
          url: action,
          data:{depid:depid},
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

 $(document).on('change','#bmin_roomid',function()
  {
    var roomid=$(this).val();
     var depid=$('#departwithequip').val();
    var action=base_url+'biomedical/bio_medical_inventory/get_equipment_with_room_and_depid';
    // alert(depid);
     $.ajax({
          type: "POST",
          url: action,
          data:{depid:depid,roomid:roomid},
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

      var id=$(this).data('equipid');
      var departmentid=$(this).data('departmentid');
      var roomid=$(this).data('roomid');
      var action=base_url+'biomedical/assign_equipement/get_equipment_detail';
      // alert(url);

      $('#equipAssign').modal('show');

        $.ajax({
          type: "POST",
          url: action,
          data:{id:id,departmentid:departmentid,roomid:roomid},
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
    var action=base_url+'biomedical/assign_equipement/equipment_assign_multiple';
    var val = [];
        $('input:checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
        if(val=='')
        {
          alert('Please check atleast one Equipment !!!');
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

                    



                    

