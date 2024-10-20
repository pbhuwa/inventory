<?php $sess_usercode = $this->session->userdata(USER_GROUPCODE);
if (($sess_usercode == 'SA')) {
?>
  <div class="searchWrapper">

    <div class="row">
      <form>

        <?php echo $this->general->location_option(3); ?>

        <?php

        ?>
        <div class="col-md-3">
          <label><?php echo $this->lang->line('department'); ?></label>
          <select class="form-control select2" id="departmentid">
            <option value="">---Select---</option>
            <?php
            if ($department_all) :
              foreach ($department_all as $kd => $dep) :
            ?>
                <option value="<?php echo $dep->dept_depid; ?>"><?php echo $dep->dept_depname; ?></option>
            <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>
        <div class="col-md-3">
          <label><?php echo $this->lang->line('user_group'); ?> </label>
          <select class="form-control select2" id="groupid">

            <option value="">---Select---</option>
            <?php

            if (!empty($group_all)) :
              foreach ($group_all as $kd => $group) :
            ?>
                <option value="<?php echo $group->usgr_usergroupid; ?>"><?php echo $group->usgr_usergroup . ' | ' . $group->loca_name; ?></option>
            <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>

        <div class="col-md-3">
          <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
        </div>

        <div class="sm-clear"></div>

        <div class="clearfix"></div>
      </form>

    </div>
    <div class="pull-right">
      <a href="javascript:void(0)" class="btn btn-danger  generate_export_file" id="excel" data-type="excel" data-dataurl="settings/users/get_user_list" data-location="settings/users/exportToExcelReqlist" data-tableid="#userListTable"><i class="fa fa-file-excel-o"></i></a>

      <a href="javascript:void(0)" class="btn btn-info  generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="settings/users/get_user_list" data-location="settings/users/generate_pdfReqlist" data-tableid="#userListTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
  </div>

<?php } ?>
<div class="table-responsive">
  <table id="userListTable" class="table table-striped ">
    <thead>
      <tr>
        <th><?php echo $this->lang->line('sn'); ?></th>
        <th><?php echo $this->lang->line('username'); ?></th>
        <th><?php echo $this->lang->line('full_name'); ?></th>
        <th><?php echo $this->lang->line('department'); ?></th>
        <th><?php echo $this->lang->line('user_group'); ?></th>
        <th><?php echo $this->lang->line('post_date'); ?>(BS)</th>
        <th><?php echo $this->lang->line('post_date'); ?>(AD)</th>
        <th><?php echo $this->lang->line('action'); ?></th>
      </tr>
    </thead>

    <tbody>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var locationid = $('#locationid').val();
    var departmentid = $('#departmentid').val();
    var groupid = $('#groupid').val();
    var dataurl = base_url + "settings/users/get_user_list";
    var message = '';
    var showview = '<?php echo MODULES_VIEW; ?>';
    // alert(showview);

    if (showview == 'N') {
      message = "<p class='text-danger'>Permission Denial</p>";
    } else {
      message = "<p class='text-danger'>No Record Found!! </p>";
    }
    var dtablelist = $('#userListTable').dataTable({
      "sPaginationType": "full_numbers",

      "bSearchable": false,
      "lengthMenu": [
        [15, 30, 45, 60, 100, 200, 500, -1],
        [15, 30, 45, 60, 100, 200, 500, "All"]
      ],
      'iDisplayLength': 15,
      "sDom": 'ltipr',
      "bAutoWidth": false,
      "autoWidth": true,
      "aaSorting": [
        [0, 'desc']
      ],
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": dataurl,
      "oLanguage": {
        "sEmptyTable": message
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 7]
      }],
      "aoColumns": [{
          "data": "sno"
        },
        {
          "data": "usma_username"
        },
        {
          "data": "usma_fullname"
        },
        {
          "data": "usma_departmentid"
        },
        {
          "data": "usma_usergroupid"
        },
        {
          "data": "usma_postdatebs"
        },
        {
          "data": "usma_postdatead"
        },
        {
          "data": "action"
        }
      ],
      "fnServerParams": function(aoData) {

        aoData.push({
          "name": "departmentid",
          "value": departmentid
        });
        aoData.push({
          "name": "groupid",
          "value": groupid
        });
        aoData.push({
          "name": "locationid",
          "value": locationid
        });
      },
      "fnRowCallback": function(nRow, aData, iDisplayIndex) {
        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
        return nRow;
      },
      "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
        var oSettings = dtablelist.fnSettings();
        var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

        $(nRow).attr('id', 'listid_' + tblid);
      },
    }).columnFilter({
      sPlaceHolder: "head:after",
      aoColumns: [{
          type: null
        },
        {
          type: "text"
        },
        {
          type: "text"
        },
        {
          type: "text"
        },
        {
          type: "text"
        },
        {
          type: "text"
        },
        {
          type: "text"
        },
        {
          type: null
        },

      ]
    });

    $(document).off('click', '#searchByDate')
    $(document).on('click', '#searchByDate', function() {
      // alert(asdf);
      groupid = $('#groupid').val();
      departmentid = $('#departmentid').val();
      locationid = $('#locationid').val();
      type = $('#searchByType').val();
      dtablelist.fnDraw();
    });

  $(document).off("click", ".generate_export_file");
  $(document).on("click", ".generate_export_file", function() {
    // alert(test);
    console.log('export');
    var dataurlLink = $(this).data("dataurl");
    var moduleLocation = $(this).data("location");
    var tableid = $(this).data("tableid");
    var type = $(this).data("type");
    var page_orientation = $('#page_orientation').val();
    var dataurl = base_url + dataurlLink;
    if (type == "excel") {
        window.location = base_url + moduleLocation + "/?" + $.param($(tableid).DataTable().ajax.params());
    } else if (type == "pdf") {
        window.open(base_url + moduleLocation + "/?" + $.param($(tableid).DataTable().ajax.params()) + "&page_orientation=" + page_orientation, "_blank");
    }
  });

  });
</script>