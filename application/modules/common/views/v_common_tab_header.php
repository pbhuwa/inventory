<?php
$result=$this->general->get_current_common_tab();

// echo $this->db->last_query();
// die();

// echo "<pre>";
// print_r($result);
// die();

if(!empty($result)):
    ?>
<div class="self-tabs">
    <ul class="nav nav-tabs form-tabs">
    <?php
    foreach ($result as $kr => $val):
    $link=$val->modu_modulelink;
    if($this->session->userdata('lang')=='np')
    {
        $mod_display=$val->modu_displaytextnp;
    }
    else
    {
         $mod_display=$val->modu_displaytext;
    }

    ?>
    <li class="tab-selector <?php if($val->urlstatus=="cur") echo "active";?>"><a href="<?php echo site_url($link); ?>"><i class="<?php echo $val->modu_icon; ?>"></i> <?php echo  $mod_display; ?> </a></li>
    <?php 
    endforeach;
    endif;
     ?>
    </ul>
</div>
