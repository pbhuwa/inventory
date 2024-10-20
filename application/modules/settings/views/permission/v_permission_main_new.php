 <link href="<?php echo base_url().PLUGIN_DIR.'/treeview' ?>/styles.css" rel="stylesheet">
 <script src="<?php echo base_url().PLUGIN_DIR.'/treeview' ?>/checktree.js"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('permission_management'); ?></h3>
            <div id="FormDiv" class="formdiv frm_bdy">
            <?php 
            $this->load->view('v_permission_main_form');
            ?>
</div>
</div>
    </div>
</div>
</div>
</div>
    
<script type="text/javascript">
    $(document).off('change','#grp_id');
    $(document).on('change','#grp_id',function(){
        var grpid=$(this).val();
      $('.actual_form').load(base_url+'/settings/permission/module_form',{grpid:grpid});
      if(grpid==''){
         $('#clonediv').hide();
          $('#btnClone').attr('data-id','');
      }
      else{
        $('#clonediv').show();
        $('#btnClone').attr('data-id',grpid);
      }
     
    });
</script>

<script type="text/javascript">
  $(document).off('change','#checkall');
  $(document).on('change','#checkall',function(e){
   if (this.checked) {
            $(".perm-check").each(function() {
                this.checked=true;
            });
             $(".operation").each(function() {
                this.checked=true;
            });
        } else {
          $(".operation").each(function() {
                this.checked=false;
            });
            $(".perm-check").each(function() {
                this.checked=false;
            });
        }
  });

$(document).off('change','.perm-check');
  $(document).on('change','.perm-check',function(e){
     

    var modid=$(this).data('module_id');
    var status = $(this).is(":checked") ? true : false;
    $('.chkmaster_'+modid).prop("checked",status);
    if(status)
    {
      $(".chkbox_"+modid).each(function() {
       this.checked=true;
       });
        $(".dropdown-submenu_"+modid).each(function() {
       this.checked=true;
       });
    }
    else
    {
      $(".chkbox_"+modid).each(function() {
       this.checked=false;
       });
       $(".dropdown-submenu_"+modid).each(function() {
       this.checked=false;
       });
    }
    
     // $(".chkbox_"+modid).prop("checked",status);
});
</script>

