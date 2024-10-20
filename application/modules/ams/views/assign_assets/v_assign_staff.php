<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
        <div class="form-group row resp_xs">
            <input type="hidden" name="" id="equipid" value="<?php echo !empty($assetsid)?$assetsid:''; ?>">
            <input type="hidden" name="" id="staffid" value="">
            <input type="hidden" name="" id="staffdepid" value="">
            <input type="hidden" name="" id="staffroomid" value="">

            <div class="col-md-3">
                <label>Staff Code</label>
                <input type="text" name="" value="" id="staffcode" class="form-control" readonly="true">
                <!-- <select class="form-control changedropdown" name="eqas_staffid" id="staffcode" data-targetdd="staffname">

                    <option value="">---select---</option>
                                <?php 
                                    if($department_staff_list):
                                        foreach ($department_staff_list as $kcl => $staff):
                                ?>
                                <option value="<?php echo $staff->stin_code; ?>"> <?php echo $staff->stin_code; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                    </select> -->
            </div>
            
            <div class="col-md-3">
                <label>Staff name</label>
                <input type="text" name="" value="" id="staffname" class="form-control" readonly="true"> 
                <!--  <select name="asen_description" class="form-control" id="staffname">
                            <option value="">---select---</option>
                        </select> -->
            </div>
            
            <div class="col-md-3">
                <label>Assign Date</label>
                <input type="text" name="" class="form-control <?php echo DATEPICKER_CLASS;?> date" id="assigndate" value="<?php echo DISPLAY_DATE; ?>">
            </div>

            <div class="col-md-3">
                <label for="">&nbsp;</label>
                <div>
                    <button type="button" class="btn btn-info  mtop_0 btnsaveAssign" data-ismutiple='<?php echo !empty($is_multiple)?$is_multiple:'N' ?>' >Assign</button>
                </div>
            </div>
            
            <div class="col-md-3">
                <span class="text-success" id="ResponseSuccess"></span>
                <span class="text-alert" id="ResponseError"></span>
            </div>
        </div>
    </div>
</div>

<div class="site_modal_tab">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_same_dept" data-toggle="tab">Same Dept.</a></li>
        <li><a href="#tab_diff_dept" data-toggle="tab">Different Dept.</a></li>
    </ul>

    <div class="tab-content white-box pad-5">
        <div class="tab-pane active" id="tab_same_dept">
            <div class="list_c2 label_mw125">
                <div class="form-group row resp_xs">
                    <div class="col-md-12 col-xs-12">
                        <table class="table table-border table-striped table-site-detail dataTable" id="Dttable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php 
                                    if($same_department_staff_list):
                                        foreach ($same_department_staff_list as $sdep => $depstaff):
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox"  class="check_class" data-depid="<?php echo $depstaff->stin_departmentid ?>" data-romid="<?php echo $depstaff->stin_roomid; ?>" data-staffid="<?php echo $depstaff->stin_staffinfoid; ?>" data-staffcode="<?php echo $depstaff->stin_code; ?>" data-staffname="<?php echo $depstaff->stin_fname.' '.$depstaff->stin_lname; ?>" >
                                    </td>
                                    <td><?php echo $depstaff->stin_code; ?></td>
                                    <td><?php echo $depstaff->stin_fname.' '.$depstaff->stin_lname; ?></td>
                                    <td><?php echo $depstaff->stin_mobile; ?></td>
                                    <td><?php echo $depstaff->stin_phone; ?></td>
                                    <td><?php echo $depstaff->stin_email; ?></td>
                                </tr>

                                <?php 
                                        endforeach; 
                                    endif; 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
        </div>

        <div class="tab-pane" id="tab_diff_dept">
            <table class="table table-border table-striped table-site-detail dataTable" id="Ddtable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Phone</th>
                        <th>Email</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 
                        if($different_department_staff_list):
                            foreach ($different_department_staff_list as $sd_dep => $dif_dep_staff):
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox"  class="check_class" data-depid="<?php echo $dif_dep_staff->stin_departmentid ?>" data-romid="<?php echo $dif_dep_staff->stin_roomid; ?>" data-staffid="<?php echo $dif_dep_staff->stin_staffinfoid; ?>" data-staffcode="<?php echo $dif_dep_staff->stin_code; ?>" data-staffname="<?php echo $dif_dep_staff->stin_fname.' '.$dif_dep_staff->stin_lname; ?>" >
                        </td>
                        <td><?php echo $dif_dep_staff->stin_code; ?></td>
                        <td><?php echo $dif_dep_staff->stin_fname.' '.$dif_dep_staff->stin_lname; ?></td>
                        <td><?php echo $dif_dep_staff->stin_mobile; ?></td>
                        <td><?php echo $dif_dep_staff->stin_phone; ?></td>
                        <td><?php echo $dif_dep_staff->stin_email; ?></td>
                    </tr>

                    <?php 
                            endforeach; 
                        endif; 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 

<script>
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });
</script>

<script type="text/javascript">
    $('#Dttable').dataTable();
    $('#Ddtable').dataTable();

    $(document).off('click',".check_class");
    $(document).on('click',".check_class",function() {
        $('input.check_class').not(this).prop('checked', false);  
        var depid= $(this).data('depid');
        var romid= $(this).data('romid');
        var staffid= $(this).data('staffid');
        var staffcode= $(this).data('staffcode');
        var staffname= $(this).data('staffname');
        $('#staffid').val(staffid);
        $('#staffdepid').val(depid);
        $('#staffroomid').val(romid);
        $('#staffcode').val(staffcode);
        $('#staffname').val(staffname);
    });
</script>

<script type="text/javascript">
    $(document).off('click','.btnsaveAssign');
    $(document).on('click','.btnsaveAssign',function(){
        var savetype=$(this).data('ismutiple');
        var equipid =$('#equipid').val();
        var staffcode =$('#staffcode').val();
        var staffname =$('#staffname').val();
        var assigndate=$('#assigndate').val();
        var staffid =$('#staffid').val();
        var staffdepid =$('#staffdepid').val();
        var staffroomid =$('#staffroomid').val();

        var eqid = equipid.split(',');
        // alert(eqid[0]);
        // return false;


        if(staffcode =='')
        {
          $('#staffcode').focus();
          return false;
        }
        if(staffname =='')
        {
          $('#staffname').focus();
          return false;
        }
        if(assigndate =='')
        {
          $('#assigndate').focus();
          return false;
        }

        var action=base_url+'ams/assign_assets/save_assets_assign';
        $.ajax({
            type: "POST",
            url: action,
            data:{equipid:equipid,assigndate:assigndate,staffid:staffid,staffdepid:staffdepid,staffroomid:staffroomid,savetype:savetype},
            dataType: 'html',
            beforeSend: function() {
            $('.overlay').modal('show');
            },
            success: function(jsons) 
            {
            data = jQuery.parseJSON(jsons);   
            // alert(data.status);
            $('#ResponseSuccess').html('');
            if(data.status=='success')
            {
               $('#ResponseSuccess').html(data.message);
              for (var i = 0;i<= eqid.length; i++) {
                 // alert(eqid[i]);
                 $('#list_'+eqid[i]).remove();
               }

                setTimeout(function(){
                   $('#equipAssign').modal('hide');
                 },800);
              
            } 
            else{
            alert(data.message);
            } 
              $('.overlay').modal('hide');
            }
        });
    })
</script>

<script>
    $(document).off('click','.nepdatepicker');
    $(document).on('click','.nepdatepicker',function(){
        $('.nepdatepicker').nepaliDatePicker();
    });
</script>

<script type="text/javascript">
    $(document).on('change','#staffcode',function(){
        var staffcode=$(this).val();
        var action=base_url+'ams/assign_assets/get_staff';
        // alert(staffcode);
        $.ajax({
            type: "POST",
            url: action,
            data:{staffcode:staffcode},
            dataType: 'json',
            success: function(datas) {
            console.log(datas);
            var opteq='';
                // opteq='<option value="">---select---</option>';
                $.each(datas,function(i,k)
                {
                  // opteq += '<option value='+k.stin_fname+''+k.stin_lname+'</option>';
                   opteq += '<option value='+k.stin_staffinfoid+'>'+k.stin_fname+' '+k.stin_lname+ '</option>';

                  // alert(opteq);
                });



                $('#staffname').html(opteq);
            }
        });
    });
</script>