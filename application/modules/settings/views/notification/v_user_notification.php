  <div class="panel clearfix">
    <div class="container">
      <div class="col-sm-2"></div>
      <div class="notifications_listing col-sm-8 ">
        <div class="section-heading user-form-title margin-15">Notifications ALl</div>
         <div class="col-sm-8">
          <div id="notificationResponse" class="text-center"></div>
        </div>
       <br><br>
        <ul>
          <?php if($notification): 

            foreach($notification as $key => $noti):
             
            ?>
          <li class="<?php if($noti->mess_status=='R') echo "seen" ?>">
            <p style="">
              <a class="" href="<?php echo base_url('settings/notification/user_notification_detail').'/'.$noti->mess_messageid; ?>"  ><?php echo !empty($noti->mess_message)?$noti->mess_message:'' ?></a>
            </p>
            <span>
             <i class="fa fa-clock-o"></i>
              <?php echo $noti->mess_postdatead.' '.$noti->mess_posttime;?> </span>
              <span><a href="javascript:void(0)" class="btn btn-sm btn-danger btndelete_notification_all" data-id='<?php echo $noti->mess_messageid;?>'><i class="fa fa-trash" aria-hidden="true"></i></a></span>
         </li>
         <!--  <li><a href="javascript:void(0)" class="btn btn-sm btn-danger btndelete_notification_all" data-id='<?php echo $noti->message_id;?>'><i class="fa fa-trash" aria-hidden="true"></i></a></li> -->

       <?php endforeach; ?>
       <?php else: ?>
        <li>NO RECORD FOUND !!!</li>

       <?php endif; ?>
     </ul>
     </div>
    
       <div class="col-sm-2"></div>
     </div>
   </div>
   <script type="text/javascript">
 $(document).ready(function()
{
$(document).on('click','.btndelete_notification_all',function()
{
  var conf = confirm('Are You Sure to delete Notification?');

  if(conf)
  {
    var id=$(this).data('id');
  // alert(id);
  // return false;
  var urldid=base_url +'settings/notification/delete_notification';
  $.ajax({
            type: "POST",
            url: urldid,
            data: {id:id},//naappstatus =not approved status
             dataType: 'html',
            //  beforeSend: function() {
            //  $('#loaderModel').modal('show'); 
            // },
           success: function(jsons) //we're calling the response json array 'cities'
            {
              console.log(jsons);

                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                if(data.status=='success')
                {
                  
                 $("#notificationResponse").show();
                $("#notificationResponse").html('<span class="alert alert-success">'+data.message+'</span>');
                  
                }        
                else
                {
                  $("#notificationResponse").show();
               $("#notificationResponse").html('<span class="alert alert-danger">'+data.message+'</span>');
                }


              setTimeout(function(){
              //remove class and html contents
              $("#notificationResponse").html('');
              $("#notificationResponse").hide();
               window.location.replace(base_url+"/settings/notification/user_notification_all");
            },2000);
            
          
            }
         }); 
  }

});
});
</script>



