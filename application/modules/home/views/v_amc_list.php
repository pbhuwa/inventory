<div class="white-box">

    <h3 class="box-title"><?php echo $this->lang->line('assets_amc');?><a href="javascript:void(0)" class="commentRefresh" data-tableid="amctable"><i class="fa fa-refresh pull-right"></i></a></h3>
    <div class="pad-5">
        <div class="table-responsive">
            <table id="amctable" class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn');?></th>
                        <th width="10%"><?php echo $this->lang->line('assets_code');?></th>
                        <th width="30%"><?php echo $this->lang->line('description');?></th>
                        <th width="15%"><?php echo $this->lang->line('manufacturer');?></th>
                        <th width="15%"><?php echo $this->lang->line('amc_date_AD');?></th>
                        <th width="15%"><?php echo $this->lang->line('amc_date_BS');?></th>
                        <th width="5%"><?php echo $this->lang->line('status');?></th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl_rr = base_url+"home/get_amc_assets";
    var message='';
    
      message="<p class='text-danger'>No Record Found!! </p>";
    
   var dtablelist = $('#amctable').dataTable({
      "sPaginationType": "full_numbers"  ,
      
      "bSearchable": false,
      "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
      'iDisplayLength': 5,
      "sDom": 'ltipr',
      "bAutoWidth":false,
            "fnDestroy":true,
            "Destroy":true,
      "autoWidth": true,
      "aaSorting": [[0,'desc']],
      "bProcessing":true,
      "bServerSide":true,    
      "sAjaxSource":dataurl_rr,
      "oLanguage": {
        "sEmptyTable":   message,
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 0,1,2,3,4,5,6 ]
      }
      ],      
      "aoColumns": [
       { "data": "amcid"},
       { "data": "assetcode" },
       { "data": "description" },
       { "data": "manufacture" },
       { "data": "amcdatead" },
       { "data": "amcdatebs" },
       { "data": "status" },
      
       
      ],
      "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
      },
     
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ {type: null},
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
     
     
      ]
    });
  });
</script>