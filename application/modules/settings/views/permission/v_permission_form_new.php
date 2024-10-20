<?php
// echo $groupid;
$groupid=!empty($groupid)?$groupid:'';
// die();
?>
 <input type="checkbox" name="check_box" id="checkall">All
<?php
                    echo $this->general->menu_premission_main(0,0,false,false,true,$groupid);

?>