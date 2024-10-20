
    <div class="row">
        <div class="col-sm-8">
            <div class="white-box">
                <h3 class="box-title">API Management For NAISH</h3>
                <div id="FormDiv" class="formdiv frm_bdy">
                <table id="Dtable" class="table table-striped apilist" >
                  <thead>
                  <tr>
                     
                      <th>S.n.</th>
                      <th>API Name</th>
                      <th>Remarks</th>
                      <th>Operation</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                if(!empty($api_rec)):
                $i=1; 
                  foreach ($api_rec as $kr => $val):
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $val['api_name']; ?></td>
                  <td><?php echo $val['api_remarks']; ?></td>
                  <td><a href="<?php echo $val['api_url']; ?>" target="_blank" class="btn btn-sm btn-warning">Run</a></td>
                </tr>
                <?php
                $i++;
                  endforeach;
                 endif; ?>
                </tbody>

              </table>

                </div>
            </div>
        </div>

      
    </div>


   
                    

<script type="text/javascript">
    $(document).off('click','.btnGenerateApi');
    $(document).on('click','.btnGenerateApi',function(e){
        var action=$(this).data('href');
        // alert(url);
        // return false;
    $.ajax({
    type: "POST",
    url: action,
     dataType: 'html',
     contentType:false,
      processData:false,
      data: {},
     beforeSend: function() {
      // $(this).prop('disabled',true);
      // $(this).html('Saving..');
      $('.overlay').modal('show');
    },
   success: function(jsons) //we're calling the response json array 'cities'
    {
      // console.log(jsons);

        data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
            alert(data.message);
            
        }
           $('.overlay').modal('hide');
    }

    });
    });
    
</script>