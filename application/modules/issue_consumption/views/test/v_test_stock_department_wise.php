<div class="searchWrapper">
    <form id="purchase_mrn_search_form">
        <div class="form-group">
            <div class="row">
                 <!-- <?php echo $this->general->location_option(1,'locationid'); ?> -->
            <div class="col-md-2 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('department'); ?>:<span class="required">*</span>:</label>
                <select id="depid" name="depid"  class="form-control required_field select2" >
                    <?php if($this->session->userdata(USER_GROUPCODE)=='SA'){?>
                          <option value="">All</option>
                         <?php } ?>
                    <?php 
                        if($department):
                            foreach ($department as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->apde_invdepid; ?>" ><?php echo $dep->apde_departmentname; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
      <div class="col-md-2 col-sm-3 col-xs-12">
            <label>Inventory Item </label>
                <select id="itemid" name="itemid"  class="form-control required_field select2" >
                    <option value="">All</option>
                    <?php 
                        if($items_name):
                            foreach ($items_name as $km => $item):
                    ?>
                    <option value="<?php echo $item->itli_itemlistid; ?>" ><?php echo $item->itli_itemname; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div> 
         <!--    <div class="col-md-3">
                  <label>Inventory Item </label>
                  <select name="itemid" class="form-control select2 " id="itemid">
                    <option value="">All</option>
                </select>

            </div>
 -->

             <!--    <div class="col-md-1">
                    <label><?php echo $this->lang->line('from'); ?></label>
                    <input type="text" id="fromdate" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to'); ?></label>
                    <input type="text" id="todate" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
 -->
        

                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/test/department_wise_stock"><?php echo $this->lang->line('search'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>

<script type="text/javascript">

    

//     $(document).on('change','#depid',function() {

//         var apidepid = $(this).val(); 
// // alert(apidepid);
//         var action = base_url+'/issue_consumption/test/get_test_item_list';

//         $.ajax({

//           type: "POST",

//           url: action,

//           data:{apidepid:apidepid},

//           dataType: 'json',

//           success: function(datas) 

//           {

//            console.log(datas);

//            var opt='';

//            opt='<option value="">ALL</option>';

//            $.each(datas,function(i,k)

//            {

//               opt += '<option value='+k.tema_testnameid+'>'+k.telo_testname+'</option>';

//           });

//            $('#testitem_name').html(opt);

//        }

//    });

//     })

   //  $(document).on('change','#depid',function() {

   //      var apidepid = $(this).val(); 
   //       // alert(testitemid);

   //      var action = base_url+'/issue_consumption/test/get_test_item_list_inventory';

   //      $.ajax({

   //        type: "POST",

   //        url: action,

   //        data:{apidepid:apidepid},

   //        dataType: 'json',

   //        success: function(datas) 

   //        {

   //         console.log(datas);

   //         var opt='';

   //         opt='<option value="">All</option>';

   //         $.each(datas,function(i,k)

   //         {

   //            opt += '<option value='+k.tema_invitemid+'>'+k.itli_itemname+'</option>';

   //        });

   //         $('#itemid').html(opt);

   //     }

   // });

   //  })

</script>