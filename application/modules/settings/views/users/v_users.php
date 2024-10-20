

    <div class="row">

        <div class="col-sm-5">

            <div class="white-box">

                <h3 class="box-title"><?php echo $this->lang->line('users_management'); ?></h3>

                <div id="FormDiv_users" class="formdiv frm_bdy">

               <?php 

               if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){

                $this->load->view('users/ku/v_usersform') ;

               }else{

               $this->load->view('users/v_usersform') ;  

               }

               ?>

                </div>

            </div>

        </div>



        <div class="col-sm-7">

            <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>

            <div class="white-box">

                <h3 class="box-title"><?php echo $this->lang->line('users_list'); ?></h3>

                <div class="table-responsive dtable_pad scroll">

                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >

                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >

                    <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

                    

                    <div id="TableDiv">

                        <?php echo $this->load->view('v_user_list'); ?>

                    </div>

                </div>

            </div>

        </div>

    </div>





<script type="text/javascript">

 $(document).off('click','.refresh_designation');

  $(document).on('click','.refresh_designation',function(e)

  {

    var targetid=$(this).data('targetid');

    var action=$(this).data('viewurl');

     $.ajax({

          type: "POST",

          url: action,

          data:{},

          dataType: 'json',

         success: function(datas) 

          {

             // $('#'+targetid).html('');

            $('#'+targetid).html(datas);

          }

      });

  });



  $(document).off('click','.view');

    $(document).on('click','.view',function(){

      var id=$(this).data('id');

      // alert(id);

      var action=$(this).data('viewurl');

      var heading=$(this).data('heading');

      var postdata={};

      // alert(action);

      var storeid=$(this).data('storeid');

      var location=$(this).data('locationid');

      var store_id=$(this).data('store_id');

      var fiscal_year=$(this).data('fyear');

      var yrs=$(this).data('yrs');

      var month=$(this).data('month');

      var appstatus=$(this).data('appstatus');

      var invoiceno = $(this).data('invoiceno');

      var fromDate=$(this).data('fromdate');

      var toDate=$(this).data('todate');

      var type=$(this).data('type');//this is for loading transfer data into popup



      if(storeid)

      {

        postdata={id:id,storeid:storeid,type:type};// In case of Store 

      }

      else

      {

        postdata={type:type,fromDate:fromDate,toDate:toDate,id:id,appstatus:appstatus,fiscal_year:fiscal_year,store_id:store_id,location:location,month:month,yrs:yrs, invoiceno:invoiceno};

      }

      $('#myView').modal('show');

      $('#MdlLabel').html(heading);



        $.ajax({

          type: "POST",

          url: action,

          data:postdata,

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

          console.log(data.tempform);

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



