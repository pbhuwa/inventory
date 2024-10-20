$(document).off('click',"#btnDeptment");
$(document).on('click',"#btnDeptment",function(){

$("#FormDepartment").validate({
     errorClass:'text-danger',
     errorElement: 'span', 
     highlight: function (element, errorClass, validClass) { 
                  $(element).parents("div.form-group div").addClass('has-error').removeClass('has-success');
              }, 
             unhighlight: function (element, errorClass, validClass) { 
           $(element).parents("div.form-group div").removeClass('has-error').addClass('has-success');
                 $(element).parents(".text-danger").removeClass('has-error').addClass('has-success'); 
             },
      rules: {
            dept_depcode:{required:true},
            dept_depname: {
                    required: true,
                   
          },
         
       },
       errorPlacement: function(error, element) {
          error.insertAfter(element);
         },
          submitHandler: function(form) {
            form.submit();
        }
    });
});