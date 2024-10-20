<div class="my_account">
      <div class="panel">
            <div class="panel-heading panel-heading-01">
                  <i class="fa fa-key"></i><?php echo $title; ?>
            </div>
            <div class="change_p panel-body panel-body-02">
                  <form method="post" action="" id="changePasswordForm" novalidate="novalidate">
                        <div class="col-sm-12">
                              <div class="form-group row">
                                    <label>Old Password</label>
                                    <input type="password" name="password" class="form-control">
                                    <?=form_error('password');?>
                              </div>
                              <div class="form-group row">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" id="newPassword" class="form-control">
                                    <?=form_error('new_password');?>
                              </div>
                              <div class="form-group row">
                                    <label>Confirm Password</label>
                                    <input type="password" name="re_new_password" class="form-control">
                                    <?=form_error('re_new_password');?>

                              </div>
                               <div class="form-group row">
                               <button type="submit" name="button" class="submit_btn" id="changePasswordBtn">Update</button>     
                               <div id="changePasswordResponse" class="alert alert-danger" style="display:none"> </div>
                               <div id="changePasswordResponsesucess" class="alert alert-success" style="display:none"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                              </div>
                        </div>
                  </form>
            </div>
      </div>
</div>
<script>
      $(document).on('click','#changePasswordBtn',function() {
    // alert(site_url);
    $("#changePasswordForm").validate({
        // alert(urlChangePassword);
        //          return false;
        errorElement: 'p',
        errorClass: 'text-danger',
        //validClass:'success',
        highlight: function(element, errorClass, validClass) {
            $(element).parents("div.form-group").addClass('has-error').removeClass('has-success');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents("div.form-group").removeClass('has-error');
            $(element).parents(".error").removeClass('has-error').addClass('has-success');
        },
        rules: {
            password: {
                required: true,
            },
            new_password: {
                required: true,
                minlength : 6
            },
            re_new_password: {
                required: true,
                equalTo: "#newPassword"
            },
        },
        messages: {
            password: {
                required: 'Password Field is required',
            },
            new_password: {
                required: 'Password Field is required',
                //minlength :errorMessage.text_required,
            },
            re_new_password: {
                required: 'Password Field is required',
                equalTo : 'Re-password Must be Same with new password'
            },
        },
        submitHandler: function(form) {
            jQuery.ajax({
                type: "POST",
                url: base_url+'settings/users/save_change_pasword',
                datatype: 'json',
                data: $('form#changePasswordForm').serialize(),
                beforeSend: function(){
                    $('#changePasswordBtn').html('Update...');
                    $('#changePasswordBtn').attr('disabled',true);
                },
                success: function(jsons) {
                    //console.log(json);
                    data = jQuery.parseJSON(jsons);
                    $('#changePasswordBtn').html('Update');
                    $('#changePasswordBtn').removeAttr('disabled');
                    if (data.status == 'success') {
                        $('#changePasswordResponsesucess').css('display','block');
                        $('#changePasswordResponsesucess').removeClass('error').addClass('success');
                        $('#changePasswordResponsesucess').html(data.message);
                        $("#changePasswordForm").trigger('reset');
                        setTimeout(function(){
                            //remove class and html contents
                            $("#changePasswordResponse").html('');
                            $("#changePasswordResponse").css("display", "none");
                            //redirect to home page.
                            window.location.href = site_url;
                        },2000);
                    } else {
                        $('#changePasswordResponse').css('display','block');
                        $('#changePasswordResponse').removeClass('success').addClass('error');
                        $('#changePasswordResponse').html(data.message);
                    }
                    setTimeout(function(){
                        //remove class and html contents
                        $("#changePasswordResponse").html('');
                        $("#changePasswordResponse").css("display", "none");
                    },2000);
                }
            });
            return false;
        }
    });
});     
</script>
