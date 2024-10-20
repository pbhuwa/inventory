  <div class="panel">
    <div class="container">
      <div class="col-sm-2"></div>
      <div class="notifications_detail col-sm-8">
        <div class="section-heading user-form-title margin-15">Notification Detail</div>
        

        <h4>Message Description:</h4>
         <p><?php   echo !empty($notification_data[0]->mess_title)?$notification_data[0]->mess_title:'' ?> </p>
         <br>

        <ul class="status_ul">
         <li>Posted at: <span><?php echo $notification_data[0]->mess_postdatead.' '.$notification_data[0]->mess_posttime;?></span></li>

          <li><a href="javascript:void(0)" class="btn btn-sm btn-danger btndelete_notification" data-id='<?php echo $message_id;?>'><i class="fa fa-trash" aria-hidden="true"></i></a></li>

       </ul>
       <br> <br> <br> <br> <br> 
    
         <div class="col-sm-7">
          <div id="notificationResponse" class="text-center"></div>
        </div>

     </div>
     <div class="col-sm-2"></div>
   </div>

 </div>

<script type="text/javascript">
 $(document).ready(function()
{
$(document).on('click','.btndelete_notification',function()
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