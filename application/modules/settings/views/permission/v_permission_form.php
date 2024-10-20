<?php 
if ( ! function_exists('humanize'))
{
  /**
   * Humanize
   *
   * Takes multiple words separated by the separator and changes them to spaces
   *
   * @param string  $str    Input string
   * @param   string  $separator  Input separator
   * @return  string
   */
  function humanize($str, $separator = '_')
  {
    return ucwords(preg_replace('/['.$separator.']+/', ' ', trim(MB_ENABLED ? mb_strtolower($str) : strtolower($str))));
  }
}

error_reporting(0);
  if(!function_exists('repeatmod'))
  {   
    function repeatmod(&$o,$m,&$i,&$grp,$p,$repeat=false)
    {             
  ?>
      <tr><td <?php if($repeat) echo "style='background:#cde'"; ?> ><?=$i?>
        <?php //form_hidden('module_id[]',$m->module_id);?>
        </td><td <?php if($repeat) echo "style='background:#cde'"; ?>><?=$m->modu_displaytext?></td>
        <?php foreach($grp as $g): ?>
          <td <?php if($repeat) echo "style='background:#cde'"; ?> >
            <?php // form_hidden('user_group[]',$g->user_group); ?>
            <?php
              // print_r($p[$m->modu_moduleid]);
              if(array_key_exists($g->usgr_usergroupid,$p[$m->modu_moduleid]) && $p[$m->modu_moduleid][$g->usgr_usergroupid])
                $val='1';
              else
                $val='0';
            ?>
            <?=form_checkbox('has_access[]',1,$val=='1'?"checked='checked'":'',
                "class='perm-check' data-module_id='$m->modu_moduleid' data-user_group='$g->usgr_usergroup' data-user_groupid='$g->usgr_usergroupid' "); ?>
          </td>
        <?php endforeach; ?>
      </tr>
  <?php 
      $i++; 
      // if($m->modu_parentmodule)
      // { 
      //   $cm=$o->menu->model->get(array('parent_module'=>$m->modu_moduleid));      
        
      //   if(count($cm))
      //   { 
      //     foreach($cm as $ccm)
      //     { 
      //       repeatmod($o,$ccm,$i,$grp,$p,true); 
      //     }     
      //   }
      // }           
    } 
  }
?>

<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Permission Management</h3>
                            <div class="actual_form">
                              <?php $this->load->view('v_permission_list');?>
                            </div>


  </div>
                    </div>
                </div>

<script>
  $(document).on('change','#parent_module_id',function(e){
    // alert('test');
    $('.actual_form').load('<?php  echo base_url() ?>/settings/permission/get_actual_form',{modid:$('#parent_module_id').val()});
  });
  
  $('.actual_form').load('<?php  echo base_url() ?>/settings/permission/get_actual_form',{modid:$('#parent_module_id').val()});
  
</script>
<script>
   $(document).off('change','.perm-check');
  $(document).on('change','.perm-check',function(e){
   
    var add=$(this).is(':checked');
    var modid=$(this).data('module_id');
    var ugrp=$(this).data('user_group');
    var ugrpid=$(this).data('user_groupid');
    var h=$(document).height();
    var w=$(document).width();
    if(add==true)
      add='true';
    else
      add='false';
    // $('.coverdiv').addClass('overlay').css('height',h).css('width',w).show();
    $.post('<?php  echo base_url() ?>settings/permission/save_per',{module_id:modid,user_group:ugrp,actionadd:add,ugrpid:ugrpid},function(datas){
        // alert(msg);
        if(datas.status=='success')
        { 
          alert(datas.message);
        }
        // $('.coverdiv').hide();
      });
  });
</script>
