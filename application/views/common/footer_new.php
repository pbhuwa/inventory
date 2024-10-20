 <div class="modal fade" id="myView" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content xyz-modal-123">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="MdlLabel"></h4>
            </div>
            
            <div class="modal-body scroll vh80 displyblock">
            
            </div>
        </div>
    </div>
</div>

 <div class="modal fade" id="myView2" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content xyz-modal-123">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="MdlLabel2"></h4>
            </div>
            
            <div class="modal-body scroll vh80 displyblock2">
            
            </div>
        </div>
    </div>
</div>


 <footer class="footer margin20 text-center"> <?php echo date('Y'); ?> &copy;  </footer>
    </div>
       
    </div>
 

    <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/common/datetimepicker/js/jquery.datetimepicker.full.js')?>"></script>
       <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="https://unpkg.com/popper.js@1.14.3/dist/umd/popper.js"></script>
     <!-- <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>bootstrap-3.3.7.min"></script>  -->
     <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>/jquery.slimscroll.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
   <!--  <script src="<?php //echo base_url().TEMPLATE_JS.'/'; ?>jquery.slimscroll.js"></script> -->
    <!--Wave Effects -->
    <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>waves.js"></script>
   
  <!--   <script src="<?php //echo base_url().TEMPLATE_JS.'/'; ?>/jquery.app.js"></script> -->
  
    <!-- Sparkline chart JavaScript -->
 
    
     <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>custom.min.js"></script>
   
    <!--Style Switcher -->
      <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>/datatables/jquery.dataTables.min.js"></script>
     <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>/datatables/jquery.dataTables.columnFilter.js"></script>
     <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>/datatables/dataTables.fixedColumns.min.js"></script>
      <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>common.js"></script>
    <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>bootstrap.min.js"></script>
   <!--  <script src="assets/js/jquery.app.js"></script> -->
   
    <!-- <script src="../compiled/flipclock.js"></script> -->

<script type="text/javascript">
  $(document).ready(function(){
    function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;
    
    setTimeout(showTime, 1000);
    
}

showTime();
  });
</script>
    <?php //$this->load->view('common/chat/chat_list') ?>
</body>


</html>
<script type="text/javascript">
   $('.engdatepicker').datepicker({
format: 'yyyy/mm/dd',
  autoclose: true
});

$(document).ready(function(){
  $('.nepdatepicker').nepaliDatePicker({
  npdMonth: true,
  npdYear: true,
  npdYearCount: 10 // Options | Number of years to show
});
})


// $('.modal-body .nav-tabs a').click(function(){
//     $(this).tab('show');
// })



</script>
<script type="text/javascript">
  $(document).off('click','.btn_language');
  $(document).on('click','.btn_language',function(e)
  {
    var url      = window.location.href;   
    
    var language=$(this).data('language');
    var action=base_url+'common/change_language';
    // alert(language);
    $.ajax({
    type: "POST",
    url: action,
     dataType: 'html',
      data: {language:language},
     beforeSend: function() {
      $('.overlay').modal('show');
    },
   success: function(jsons) //we're calling the response json array 'cities'
    {
       data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success'){
          $('.overlay').modal('hide');
          setTimeout(function(){
          window.location.href = url;
           }, 500);
          
        }

    }
    });

  });
</script>


<script type="text/javascript">
$(document).ready(function(){
  $('.navbar-nav  > li > .dropdown-toggle').click(function(){
    $('.navbar-nav  > li > .dropdown-toggle').each(function(){
          $(this).parent().removeClass('open');
     });
   
  });
});
</script>
<script type="text/javascript">
  $(document).ready(function(){

  });
</script>