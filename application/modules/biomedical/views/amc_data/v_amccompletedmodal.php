<div id="amcCompletedModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <?php $org_id=$this->session->userdata(ORG_ID);
                    if($org_id=='2'){ ?>
                    <h4 class="modal-title">Assets AMC </h4>
                    <?php }else{ ?>
                    <h4 class="modal-title">Equipment AMC </h4>
                    <?php } ?>
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