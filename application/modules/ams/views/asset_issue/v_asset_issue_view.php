<button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-id="<?php echo !empty($id)?$id:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>
<div id="FormDiv_Reprint" class="printTable"></div>

<script>
    $(document).off('click','.ReprintThis');
    $(document).on('click','.ReprintThis',function(){
    var print =$(this).data('print');
    var iddata=$(this).data('id');
    var id=$('#id').val();
    var action = $(this).data('actionurl');
    var showdiv = $(this).data('viewdiv');
    if(action){
        printurl = action;
        printdiv = showdiv;
    }else{
        printurl = base_url+'/ams/asset_issue/reprint_asset_issue_details';
        printdiv = 'FormDiv_Reprint';
    }
    if(iddata)
    {
      id=iddata;
    }
    else
    {
      id=id;
    }
    $.ajax({
        type: "POST",
        url:  printurl,
        data:{id:id},
        dataType: 'html',
        beforeSend: function() {
          $('.overlay').modal('show');
        },
        success: function(jsons) //we're calling the response json array 'cities'
        {
           data = jQuery.parseJSON(jsons);   
            // alert(data.status);
            if(data.status=='success')
            {
                $('#'+printdiv).html(data.tempform);
                $('.printTable').printThis();
            }
            else
            {
              alert(data.message);
            }
            setTimeout(function(){
                $('.newPrintSection').hide();
                $('#myView').modal('hide');
            },2000);
            $('.overlay').modal('hide');
        }
      });
    })
</script>