<div id="pmCompletedModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Equipment Preventive Maintenance  </h4>
                </div>
                <div class="modal-body">
                  <div id="equipmentdetail"></div>
                
            </div>

        </div>
    </div>
</div>
  
  <script type="text/javascript">
    $(document).on('change','#pmco_rslt',function(){
      var pmco_rslt=$(this).val();
      if(pmco_rslt=='comment')
      {
        $('#pmco_comments').show();
        $('#commentarea').focus();
      }
      else
      {
         $('#pmco_comments').hide();
      }
    })
  </script>