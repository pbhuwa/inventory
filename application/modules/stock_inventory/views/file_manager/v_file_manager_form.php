<form method="post" id="formfilemanager" action="<?php echo base_url('stock_inventory/file_manager/save_file'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/file_manager/index/reload'); ?>' enctype="multipart/form-data" accept-charset="utf-8">
  <input type="hidden" name="id" value="<?php echo !empty($file_manager_data[0]->fire_filerecordid) ? $file_manager_data[0]->fire_filerecordid : '';  ?>">

  <div class="form-group">
    <div class="col-md-12">
      <label for="example-text">File Type <span class="required">*</span>:</label>

      <?php $ftypeid = !empty($file_manager_data[0]->fire_filetypeid) ? $file_manager_data[0]->fire_filetypeid : '' ?>
      <select name="fire_filetypeid" id="fire_filetypeid" class="form-control required_field ">
        <option value="">---select---</option>
        <?php
        if ($file_type) :
          foreach ($file_type as $kfy => $ftype) :
        ?>
            <option value="<?php echo $ftype->fity_filetypeid; ?>" <?php if ($ftypeid == $ftype->fity_filetypeid) echo "selected=selected"; ?>><?php echo $ftype->fity_typename; ?></option>
        <?php
          endforeach;
        endif;
        ?>
      </select>

    </div>
    <div class="col-md-12">
      <label>File No.</label>
      <?php $fileno = !empty($file_manager_data[0]->fire_file_no) ? $file_manager_data[0]->fire_file_no : '' ?>
      <input type="text" name="fire_file_no" class="form-control" value="<?php echo $fileno; ?>">
    </div>
    <div class="col-md-12">
      <label>Date</label>
      <?php
      if (DEFAULT_DATEPICKER == 'NP') {
        $fdate = !empty($file_manager_data[0]->fire_datebs) ? $file_manager_data[0]->fire_datebs : DISPLAY_DATE;
      } else {
        $fdate = !empty($file_manager_data[0]->fire_datead) ? $file_manager_data[0]->fire_datead : DISPLAY_DATE;
      }
      ?>
      <input type="text" name="filedate" class="form-control <?php echo DATEPICKER_CLASS; ?>" id="datefield" value="<?php echo $fdate; ?>">
    </div>

    <div class="table-responsive col-sm-12">
      <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">
        <thead>
          <tr>
            <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
            <th scope="col" width="10%"> <?php echo $this->lang->line('code'); ?> </th>
            <th scope="col" width="25%"> <?php echo $this->lang->line('particular'); ?> </th>
            <th scope="col" width="10%"> <?php echo $this->lang->line('qty'); ?> </th>
            <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>
          </tr>
        </thead>
        <tbody id="orderBody">
          <?php
          $j = 1;
          if (!empty($file_manager_detail)) :
            foreach ($file_manager_detail as $key => $fmd) :
          ?>
              <tr class="orderrow" id="orderrow_<?php $j; ?>" data-id="<?php echo $j; ?>">
                <td data-label="S.No.">
                  <input type="hidden" name="frde_filerecorddetailid[]" class="reqdetailid" id="reqdetailid_<?php echo $j; ?>" value="<?php echo !empty($fmd->frde_filerecorddetailid) ? $fmd->frde_filerecorddetailid : ''; ?>" />
                  <input type="text" class="form-control sno" id="s_no_<?php echo $j; ?>" value="<?= $j; ?>" readonly />
                </td>
                <td data-label="Code">
                  <div class="dis_tab">
                    <input type="text" class="form-control itemcode enterinput" id="itemcode_<?php echo $j; ?>" name="rede_code[]" data-id="<?php echo $j; ?>" data-targetbtn='view' value="<?php echo !empty($fmd->frde_itemcode) ? $fmd->frde_itemcode : ''; ?>">
                    <input type="hidden" class="itemid" name="rede_itemsid[]" data-id="<?php echo $j; ?>" value="<?php echo !empty($fmd->frde_itemsid) ? $fmd->frde_itemsid : ''; ?>" id="itemid_<?php echo $j; ?>">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id="<?php echo $j; ?>" id="view_<?php $j; ?>"><strong>...</strong></a>
                  </div>
                </td>
                <td data-label="Particular">
                  <input type="text" class="form-control itemname" id="itemname_<?php echo $j; ?>" name="" data-id="<?php echo $j; ?>" readonly>
                </td>
                <td data-label="Quantity">
                  <input type="text" class="form-control float rede_qty calculateamt rede_qty" name="rede_qty[]" id="rede_qty_<?php echo $j; ?>" data-id="<?php echo $j; ?>" value="<?php echo !empty($fmd->frde_qty) ? $fmd->frde_qty : ''; ?>">
                </td>
                <td data-label="Action">
                  <div class="actionDiv acDiv2" id="acDiv2_<?php echo $j; ?>"></div>

                  <?php
                  if (count($file_manager_detail) > 1) :
                  ?>
                    <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="<?php echo $j; ?>" id="addRequistion_<?php echo $j; ?>"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
                  <?php
                  endif;
                  ?>

                </td>
              </tr>
            <?php
              $j++;
            endforeach;
          else : ?>
            <tr class="orderrow" id="orderrow_1" data-id='1'>
              <td data-label="S.No.">
                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly />
              </td>
              <td data-label="Code">
                <div class="dis_tab">
                  <input type="text" class="form-control itemcode enterinput" id="itemcode_1" name="rede_code[]" data-id='1' data-targetbtn='view' value="">
                  <input type="hidden" class="itemid" name="rede_itemsid[]" data-id='1' value="" id="itemid_1">
                  <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                </div>
              </td>
              <td data-label="Particular">
                <input type="text" class="form-control itemname" id="itemname_1" name="" data-id='1' readonly>
              </td>
              <td data-label="Quantity">
                <input type="text" class="form-control float rede_qty calculateamt rede_qty" name="rede_qty[]" id="rede_qty_1" data-id='1'>
              </td>
              <td data-label="Action">
                <div class="actionDiv acDiv2" id="acDiv2_1"></div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
        <tbody>
          <tr class="resp_table_breaker">
            <td colspan="7">
              <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1" id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
              <div class="clearfix"></div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-md-12">
      <label>Attachement</label>
      <input type="file" name="fire_attachement">
    </div>
    <?php
    if (!empty($file_manager_data[0]->fire_attachement)) {
      $attachment = $file_manager_data[0]->fire_attachement;
      $exp =  explode('.', $attachment);
      $mimes = ['png', 'jpg', 'gif', 'jpeg'];
      if (in_array($exp[1], $mimes)) : ?>
        <input type="hidden" name="old_attachment" value="<?= $attachment; ?>">
        <img src="<?php echo base_url(FORM_FILE_ATTACHMENT_PATH . "/$attachment"); ?>" alt="" width="50%" height="150px">
      <?php else : ?>
        <a href="<?php echo base_url(FORM_FILE_ATTACHMENT_PATH . "/$attachment"); ?>" target="_blank"><?= $attachment; ?></a>
    <?php
      endif;
    }
    ?>

    <div class="col-md-12">
      <label>Remarks</label>
      <textarea class="form-control" name="fire_remarks"><?php echo !empty($file_manager_data[0]->fire_remarks) ? $file_manager_data[0]->fire_remarks : ""; ?></textarea>
    </div>

    <div class="form-group">
      <div class="col-md-12">

        <button type="submit" class="btn btn-info save " data-operation='<?php echo !empty($file_manager_data) ? 'update' : 'save' ?>' id="btnSubmit"><?php echo !empty($file_manager_data) ? 'Update' : 'Save' ?></button>

      </div>
      <div class="col-sm-12"> 
        <div class="alert-success success"></div>
        <div class="alert-danger error"></div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
  $(document).off('click', '.btnAdd');
  $(document).on('click', '.btnAdd', function() {
    var id = $(this).data('id');
    var itemid = $('#itemid_' + id).val();
    var trplusOne = $('.orderrow').length + 1;
    var trpluOne = $('.orderrow').length;
    var itemid = $('#itemid_' + id).val();
    var code = $('#itemname_' + trplusOne).val();
    // alert(itemid);
    var newitemid = $('#itemid_' + trpluOne).val();
    var reqqty = $('#rede_qty_' + trpluOne).val();

    if (newitemid == '') {
      $('#itemcode_' + trpluOne).focus();
      return false;
    }
    if (reqqty == 0 || reqqty == '' || reqqty == null) {
      $('#rede_qty_' + trpluOne).focus();
      return false;
    }

    var storeid = $("#rema_reqtodepid option:selected").val();
    setTimeout(function() {
      $('.btnitem').attr('data-storeid', storeid);
      $('.btnitem').data('storeid', storeid);
    }, 500);

    if (trplusOne == 2) {
      $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
    }
    var template = '';
    template = '<tr class="orderrow" id="orderrow_' + trplusOne + '" data-id="' + trplusOne + '"><td data-label="S.No."><input type="text" class="form-control sno" id="s_no_' + trplusOne + '" value="' + trplusOne + '" readonly/></td><td data-label="Code"> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_' + trplusOne + '" name="rede_code[]" data-id="' + trplusOne + '" data-targetbtn="view" readonly /> <input type="hidden" class="itemid" name="rede_itemsid[]" data-id="' + trplusOne + '" id="itemid_' + trplusOne + '" ><a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="List of Item" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition '); ?>" data-id="' + trplusOne + '" id="view_' + trplusOne + '" ><strong>...</strong></a></div></td><td data-label="Particular"> <input type="text" class="form-control itemname" id="itemname_' + trplusOne + '" name="" data-id="' + trplusOne + '" readonly></td><td data-label="Quantity"><input type="text" class="form-control float rede_qty calculateamt" name="rede_qty[]" id="rede_qty_' + trplusOne + '" data-id=' + trplusOne + ' ></td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_' + trplusOne + '"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="' + trplusOne + '"  id="addRequistion_' + trplusOne + '"><span class="btnChange" id="btnChange_' + trplusOne + '"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';
    // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
    // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
    $('#itemcode_' + trplusOne).focus();
    $('#orderBody').append(template);
  });
  $(document).off('click', '.btnRemove');
  $(document).on('click', '.btnRemove', function() {
    var id = $(this).data('id');
    var whichtr = $(this).closest("tr");
    var conf = confirm('Are Your Want to Sure to remove?');
    if (conf) {
      var trplusOne = $('.orderrow').length + 1;
      whichtr.remove();

      setTimeout(function() {
        $(".orderrow").each(function(i, k) {
          var vali = i + 1;
          $(this).attr("id", "orderrow_" + vali);
          $(this).attr("data-id", vali);
          $(this).find('.sno').attr("id", "s_no_" + vali);
          $(this).find('.sno').attr("value", vali);
          $(this).find('.itemcode').attr("id", "itemcode_" + vali);
          $(this).find('.itemcode').attr("data-id", vali);
          $(this).find('.itemid').attr("id", "itemid_" + vali);
          $(this).find('.itemid').attr("data-id", vali);
          $(this).find('.itemname').attr("id", "itemname_" + vali);
          $(this).find('.itemname').attr("data-id", vali);
          $(this).find('.rede_qty').attr("id", "rede_qty_" + vali);
          $(this).find('.rede_qty').attr("data-id", vali);
          $(this).find('.acDiv2').attr("id", "acDiv2_" + vali);
          // $(this).find('.acDiv2').attr("data-id",vali);
          $(this).find('.btnAdd').attr("id", "addOrder_" + vali);
          $(this).find('.btnAdd').attr("data-id", vali);
          $(this).find('.btnRemove').attr("id", "addOrder_" + vali);
          $(this).find('.btnRemove').attr("data-id", vali);
          $(this).find('.btnChange').attr("id", "btnChange_" + vali);
        });
      }, 600);
      setTimeout(function() {
        var trlength = $('.orderrow').length;
        // alert(trlength);
        if (trlength == 1) {
          $('#acDiv2_1').html('');
        }
      }, 800);



    }
  });
  $(document).off('click', '.itemDetail');
  $(document).on('click', '.itemDetail', function() {
    var rowno = $(this).data('rowno');

    var rate = $(this).data('rate');
    var itemcode = $(this).data('itemcode');
    var itemname = $(this).data('itemname_display');

    var itemid = $(this).data('itemid');
    var stockqty = $(this).data('issueqty');
    var unitname = $(this).data('unitname');
    var purrate = $(this).data('purrate');
    var unitid = $(this).data('unitid');
    $('#itemcode_' + rowno).val(itemcode);
    // $('#itemcode_'+rowno).val(itemcode);
    $('#itemid_' + rowno).val(itemid);
    $('#itemname_' + rowno).val(itemname);
    $('#myView').modal('hide');
    $('#rede_qty_' + rowno).focus();
    return false;
  })
</script>