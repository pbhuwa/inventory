 <link href="<?php echo base_url().PLUGIN_DIR.'/treeview' ?>/styles.css" rel="stylesheet">
 <script src="<?php echo base_url().PLUGIN_DIR.'/treeview' ?>/checktree.js"></script>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('permission_management'); ?></h3>
            <div class="pad-10">
                <div class="width_70">
                    <div class="row">
                        <div class="col-sm-3">
                            <label><?php echo $this->lang->line('groups'); ?><span class="required">*</span> :</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control" id="grp_id">
                                <option value="">---select--</option>
                                    <?php
                                    if(!empty($group_all)):
                                    foreach ($group_all as $kg => $grp):
                                    ?>
                                    <option value="<?php echo  $grp->usgr_usergroupid ?>"><?php echo $grp->usgr_usergroup; ?></option>
                                    <?php
                                    endforeach;
                                    endif; 
                                    ?>
                                </option>
                            </select>
                        </div>
                    </div>



                    <div class="white-box pad-10 mtop_15 actual_form">
                    <?php 
                    $this->load->view('permission/v_permission_form_new');


                    ?>
                    </div>
                </div>
            </div>
      
        </div>
    
    </div>
</div>
</div>
</div>
		<script>
	$(function(){
		// $("ul.checktree").checktree();
	});
	</script>
    
<script type="text/javascript">
    $(document).off('change','#grp_id');
    $(document).on('change','#grp_id',function(){
        var grpid=$(this).val();
      $('.actual_form').load(base_url+'/settings/permission/module_form',{grpid:grpid});
    });


$(document).off('change','.perm-check');
  $(document).on('change','.perm-check',function(e){
     var modid=$(this).data('module_id');
    var status = $(this).is(":checked") ? true : false;
    $(".chkbox_"+modid).prop("checked",status);
    // return false;
    var grpid=$('#grp_id').val();
    var user_group=$('#grp_id option:selected').html();
    // alert(user_group);
    if(grpid=='')
    {
      alert('You nee to select group!!');
      return false;
    }
    var add=$(this).is(':checked');
    var modid=$(this).data('module_id');
    var ugrpid=grpid
    var h=$(document).height();
    var w=$(document).width();
    if(add==true)
      {
        add='true';
         // $(this).closest('inline-check').find(':checkbox').prop('checked', "true");
    }
    else
      {
        add='false';
    }
    // $('.coverdiv').addClass('overlay').css('height',h).css('width',w).show();
    $.post('<?php  echo base_url() ?>settings/permission/save_per',{module_id:modid,actionadd:add,user_group:user_group,ugrpid:ugrpid},function(datas){
        // alert(msg);
        
          alert(datas);
        
        // $('.coverdiv').hide();
      });
  });

$(document).off('change','.operation');
$(document).on('change','.operation',function(){
    var module_id=$(this).data('module_id');
    var operation=$(this).data('operation');
    var add=$(this).is(':checked');
     var grpid=$('#grp_id').val();
    if(grpid=='')
    {
      alert('You nee to select group!!');
      return false;
    }

      if(add==true)
      {
        add='true';
       }
    else
      {
        add='false';
     }
      $.post('<?php  echo base_url() ?>settings/permission/update_per_operation',{module_id:module_id,actionadd:add,ugrpid:grpid,operation:operation},function(datas){
        // alert(msg);
        
          alert(datas);
        
        // $('.coverdiv').hide();
      });

    // alert(module_id);

    return false;

})
</script>