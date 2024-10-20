<table id="Mytable" class="table table-striped menulist" >
  <thead>
    <tr>
      <th><?php echo $this->lang->line('sn'); ?></th>
      <th><?php echo $this->lang->line('unit_name'); ?></th>
      <th><?php echo $this->lang->line('post_date'); ?></th>
      <th><?php echo $this->lang->line('status'); ?></th>
      <th><?php echo $this->lang->line('action'); ?></th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<script>
  $(document).ready(function(){
   
    var dataurl = base_url+"biomedical/units/units_list";
    var message='';
 
    var dtablelist = $('#Mytable').dataTable({
        "sPaginationType": "full_numbers"  ,
      
      "bSearchable": false,
      "lengthMenu": [[10, 30, 45, 60,100,200,500, -1], [10, 30, 45, 60,100,200,500, "All"]],
      'iDisplayLength': 10,
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
        "aTargets": [ 0,3 ]
      }
      ],      
      "aoColumns": [
       { "data": "unit_unitid" },
       { "data": "unit_unitname" },
        { "data": "unit_postdatebs" },
        { "data": "unit_isactive" },
        {"data":"action"},
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
     
      { type:null },
      { type:null}
     
      ]
    });

    });
</script>






