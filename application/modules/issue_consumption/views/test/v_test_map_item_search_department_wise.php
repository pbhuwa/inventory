<div class="white-box">
    <div class="searchWrapper">
        <div class="pad-5">
            <form id="asset_search_form">

                <div class="form-group">

                    <div class="row">
                        
                        <div id="datediv">
                            <div class="col-md-3">
                                <label><?php echo $this->lang->line('from_date'); ?></label>
                                <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                            </div>

                            <div class="col-md-3">
                                <label><?php echo $this->lang->line('to_date'); ?></label>
                                <input type="text" name="toDate" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                         <label>Department</label>
                         <select name="tema_apidepid" class="form-control select2" id="tema_apidepid">
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
                    
                <!--     <div class="col-md-3">
                       <label>Test Item</label>
                       <select name="testitem_name" class="form-control select2" id="testitem_name">
                        <option value="">All</option>
                    </select>

                </div>
                <div class="col-md-3">
                  <label>Inventory Item </label>
                  <select name="invitem_name" class="form-control select2 " id="invitem_name">
                    <option value="">All</option>
                </select>

            </div> -->


            <div class="col-md-2">
                <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/test/search_test_item_department_wise"><?php echo $this->lang->line('search'); ?></button>
            </div>
        </div>
    </div>
</form>
</div></div>
<div class="clearfix"></div>
<div id="displayReportDiv"></div>
</div>
</div>
</div>
</div>

<script type="text/javascript">

    

    $(document).on('change','#tema_apidepid',function() {

        var apidepid = $(this).val(); 
// alert(apidepid);
        var action = base_url+'/issue_consumption/test/get_test_item_list';

        $.ajax({

          type: "POST",

          url: action,

          data:{apidepid:apidepid},

          dataType: 'json',

          success: function(datas) 

          {

           console.log(datas);

           var opt='';

           opt='<option value="">ALL</option>';

           $.each(datas,function(i,k)

           {

              opt += '<option value='+k.tema_testnameid+'>'+k.telo_testname+'</option>';

          });

           $('#testitem_name').html(opt);

       }

   });

    })

    $(document).on('change','#testitem_name',function() {

        var testitemid = $(this).val(); 
         // alert(testitemid);

        var action = base_url+'/issue_consumption/test/get_item_list';

        $.ajax({

          type: "POST",

          url: action,

          data:{testitemid:testitemid},

          dataType: 'json',

          success: function(datas) 

          {

           console.log(datas);

           var opt='';

           opt='<option value="">All</option>';

           $.each(datas,function(i,k)

           {

              opt += '<option value='+k.tema_invitemid+'>'+k.itli_itemname+'</option>';

          });

           $('#invitem_name').html(opt);

       }

   });

    })

</script>

