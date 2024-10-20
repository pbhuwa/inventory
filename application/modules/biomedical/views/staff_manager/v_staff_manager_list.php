
<!--  <table id="Dtable" class="table table-striped menulist" >
<thead>
    <tr>              <th width="7%"> Sn.no</th>
                  
                       <th width="10%">Code</th>
                      <th width="13%">Staff Name</th>
                      <th width="20%">Address</th>
                      <th width="10%">Mobile NO</th>
                      <th width="15%">Department</th>
                      <th width="18%">Room</th>
                      <th width="14%">Action</th>    
    </tr>
</thead>
<tbody> 
     <?php
            if($staff_manager_all):
                $i=1;
                foreach ($staff_manager_all as $kpc => $staff): //echo "<pre>"; print_r($this->data['staff_manager_all']);
      //  die();
        ?>
            <tr id="listid_<?php echo $staff->stin_staffinfoid; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $staff->stin_code; ?></td>
           
            <td><?php echo $staff->stin_fname.' '.$staff->stin_mname.' '.$staff->stin_lname; ?></td>
            <td><?php echo $staff->stin_address1; ?></td>
            <td><?php echo $staff->stin_mobile; ?></td>
            <td><?php echo $staff->dept_depname; ?></td>
            <td><?php echo $staff->rode_roomname; ?></td>
            
           
            <td>
              <a href="javascript:void(0)" data-id='<?php echo $staff->stin_staffinfoid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a> |
              <a href="javascript:void(0)" data-id='<?php echo $staff->stin_staffinfoid; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>|
              <a href="javascript:void(0)" data-id='<?php echo $staff->stin_staffinfoid; ?>' class="btnView"><i class="fa fa-eye"></i> </a> 
            </td>
            </tr>
        <?php
        $i++;
        endforeach;
    endif;
     ?>
 </tbody>
</table> -->


<!-- v distributers lists -->

    <h3 class="box-title">List of Staffs  <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
    <div class="pad-5">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped ">
                <thead>
                    <tr>
                       <th width="7%"> S.N.</th>
                      <th width="10%">Code</th>
                      <th width="13%">Staff Name</th>
                      <th width="20%">Address</th>
                      <th width="10%">Mobile NO</th>
                      <th width="15%">Department</th>
                      <th width="18%">Room</th>
                      <th width="14%">Action</th> 
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
<script type="text/javascript">
  $(document).ready(function(){
    //var frmDate=$('#frmDate').val();
    //var toDate=$('#toDate').val();  
    var rslt='<?php echo !empty($result)?$result:''; ?>';
    var orgid='<?php echo !empty($org_id)?$org_id:''; ?>';

    var dataurl = base_url+"biomedical/staff_manager/staff_list/"+rslt+'/'+orgid;
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';
    // alert(showview);
    if(showview=='N')
    {
      message="<p class='text-danger'>Permission Denial</p>";
    }
    else
    {
      message="<p class='text-danger'>No Record Found!! </p>";
    }
 

 
    var dtablelist = $('#myTable').dataTable({
      "sPaginationType": "full_numbers"  ,
      
      "bSearchable": false,
      "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
      'iDisplayLength': 15,
      "sDom": 'ltipr',
      "bAutoWidth":false,
    
      "autoWidth": true,
      "aaSorting": [[0,'desc']],
      "bProcessing":true,
      "bServerSide":true,    
      "sAjaxSource":dataurl,
      "oLanguage": {
         "sEmptyTable":message  
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 0,7 ]
      }
      ],      
      "aoColumns": [
       { "data": "stin_staffinfoid" },
       { "data": "code" },
       { "data": "name" },
       { "data": "address1" },
       { "data": "mobile" },
       { "data": "department" },
       { "data": "room" },
       { "data": "action" }
      ],
      // "fnServerParams": function (aoData) {
      //   aoData.push({ "name": "frmDate", "value": frmDate });
      //   aoData.push({ "name": "toDate", "value": toDate });
      // },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
             var oSettings = dtablelist.fnSettings();
            var tblid= oSettings._iDisplayStart+iDisplayIndex +1

        $(nRow).attr('id', 'listid_'+tblid);
      },
    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ 
      {type: null},
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: null },
     
      ]
    });

});
</script>

  