<?php 
$sess_usercode = $this->session->userdata(USER_GROUPCODE);
?>
<table id="dytable" class="table flatTable tcTable" >
  <thead>
    <tr>
      <th width="5%">S.n.</th>
      <th width="10%">Date(AD)</th>
      <th width="10%">Date(BS)</th>
      <th width="10%">Request No.</th>
      <th width="10%">Time</th>
      <th width="35%">Comments</th>
      <th width="25%">Comment By</th>
      <th width="10%">Status</th>
      <th width="5%">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if($equip_comment):
        $i=1;
        foreach ($equip_comment as $kc => $com):
          if($com->eqco_comment_status == 0)
          {
            $penf = "Pending"; 
            $class='label-warning';
            $row_class = 'bg-warning text-white ';
          }
          if($com->eqco_comment_status == 1){ 
            $penf = "Completed"; 
            $class='label-success';
            $row_class = 'bg-success text-white ';
          }
          if($com->eqco_comment_status == 2){ 
            $penf = "Seen"; 
            $class='label-info';
            $row_class = 'bg-info text-white ';
          }
          if($com->eqco_comment_status == 3){ 
            $penf = "Cancelled"; 
            $class='label-danger';
            $row_class = 'bg-danger text-white ';
          }
          if($com->eqco_comment_status == 4){ 
            $penf = "In Progress"; 
            $class='label-primary';
            $row_class = 'bg-primary text-white ';
          }
    ?>
        <tr id="listid_<?php echo $com->eqco_equipmentcommentid; ?>" class="<?=$row_class?>">
        <td><?php echo $i; ?></td>
        <td><?php echo $com->eqco_postdatead; ?></td>
        <td><?php echo $com->eqco_postdatebs; ?></td>
        <td><?php echo $com->eqco_requestno; ?></td>
        <td><?php echo $com->eqco_posttime; ?></td>
        <td><?php echo $com->eqco_comment; ?></td>
        <td><?php echo $com->usma_fullname; ?></td>
        <td><a href="javascript:void(0)" class=" label <?php echo $class; ?> btn-xs"><?php echo $penf  ?> </a></td>
        <?php     if(($sess_usercode == 'SA') || ($sess_usercode == 'AD')){ ?>
        <td>
        <a href="javascript:void(0)" title="Cancel" data-id='<?php echo $com->eqco_equipmentcommentid; ?>' class="btnDelete"><i class="fa fa-times" aria-hidden="true"></i></a>
        </td>
        <?php } else{ echo "<td></td>" ; } ?>
        </tr>
    <?php
        $i++;
        endforeach;
        else:
    ?>
    <?php
    endif;
    ?>
  </tbody>
</table>


<script type="text/javascript">
$('#dytable').dataTable();
</script>