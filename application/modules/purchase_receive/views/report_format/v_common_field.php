<div class="clearfix"></div>
<div id="displayReportDiv"></div>


<script type="text/javascript">
    $(document).off('click','.view_detail_rpt');
    $(document).on('click','.view_detail_rpt',function(e){
        var viewreport=$(this).data('viewreport');
         var displayid = $(this).data('displayid');
        var formurl = $(this).data('url');
        // alert(formurl);

        var action=base_url+formurl;
        $.ajax({
          type: "POST",
          url: action,
          data:{inp_data:viewreport},
          dataType: 'html',
          beforeSend: function() {
            $('.overlay').modal('show');
          },
          success: function(jsons) 
          {
            console.log(jsons);

            data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                // alert(data.template);
                if(data.status=='success')
                {
                  $('#'+displaydiv).html(data.template);
                  
                }
                else
                {
                 $('#'+displaydiv).html('<span class="col-sm-12 alert alert-danger text-center">'+data.message+'</span>');
                    // alert(data.message);
                  }
                  $('.overlay').modal('hide');
                }
              });
        return false;
    });
</script>