<div class="searchWrapper">
    <div class="">
        <form>
            <div class="col-md-3 col-sm-4">
                  <label for="example-text"><?php echo $this->lang->line('from_date'); ?>: </label>
                  <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo CURMONTH_DAY1; ?>">
                  </div>
               
               <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('to_date'); ?>: </label>
                    <input type="text" name="toDate" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>">
              </div>

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
   
    <div class="clear"></div>
</div>

<div class="clearfix"></div>
 <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="biomedical/contractmanagement/contractmanagement_list" data-location="biomedical/contractmanagement/generate_excel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="biomedical/contractmanagement/contractmanagement_list" data-location="biomedical/contractmanagement/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>

    </div>
    <div class="clearfix"></div>

<div class="pad-5 mtop_10">
   
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead><tr>
                   <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('contract_type'); ?> </th>
                    <th width="20%"><?php echo $this->lang->line('distributor'); ?> </th>
                    <th width="20%"><?php echo $this->lang->line('title'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('start_date'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('end_date'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('value'); ?></th>
                    <th width="15%"<?php echo $this->lang->line('action'); ?>></th>
                    </tr>
            </thead>
            <tbody>
                      
            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>
<!--modal-->
<div id="myModal1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Contract Detail</h4>
            </div>
            <div class="modal-body">
                <div class="white-box list">
                    <form method="post" id="FormContract" action="<?php echo base_url('biomedical/contractmanagement/save_renew_contract'); ?>" class="form-material form-horizontal form">
                        <div class="resultrComment">
                        </div>
                        <div class="form-group mbtm_0">
                            <div class="col-md-12">
                                <label>Contract ID: </label>
                                <span id="contractId"></span>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-6">
                                <label><?php echo $this->lang->line('contract_type'); ?>: </label>
                                <span id="conType"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Name: </label>
                                <span id="contractName"></span>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-6">
                                <label>Title: </label>
                                <span id="conTitle"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Value: </label>
                                <span id="conValue"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Start Date: </label>
                                <span id="contractStartDate"></span>
                            </div>
                            <div class="col-md-6">
                                <label>End Date: </label>
                                <span id="contractEndDate"></span>
                            </div>
                            <div class="clear"></div>
                             <div class="col-md-6">
                                <label>Renew Type: </label>
                                <span id="contractRenew"></span>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-12">
                                <label>Description: </label>
                                <span id="contractDescription"></span>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-12">
                                <label>Download Attachments: </label>
                                <span id="conAttachments"></span>
                            </div>
                            <div class="clear"></div>
                            <div id="ResponseSuccess_FormComments" class="waves-effect waves-light m-r-10 text-success"></div>
                            <div id="ResponseError_FormComments" class="waves-effect waves-light m-r-10 text-danger"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl = base_url+"biomedical/contractmanagement/get_contractmgmt";
     var showview='<?php echo MODULES_VIEW; ?>';
    // alert(showview);
    if(showview=='Y')
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
      'iDisplayLength': 20,
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
       { "data": "coin_contractinformationid" },
       { "data": "contracttype" },
       { "data": "distributor" },
       { "data": "contracttitle" },
       { "data": "contractstartdate" },
       { "data": "contractenddate" },
       { "data": "contractvalue" },
       { "data": "action" }
     
    
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
      "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
           var oSettings = dtablelist.fnSettings();
          var tblid = oSettings._iDisplayStart+iDisplayIndex +1

        $(nRow).attr('id', 'listid_'+tblid);
      },
    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ {type: null},
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: null },
     
      ]
    });
     $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            dtablelist.fnDraw();
        });

});
</script>
<script type="text/javascript">
    $(document).off('click','.myModalCall');
    $(document).on('click','.myModalCall',function(){
      
      var contractid = $(this).data('id');
      $.ajax({
        type: "POST",
        url: base_url+'biomedical/contractmanagement/get_contractmgmt_data',
        data:{contractid:contractid},
        dataType: 'json',
        success: function(datas) {
          if(datas.status=='success') {
            console.log(datas);
            $('#contractId').html(datas.contractId);
            $('#conType').html(datas.contractType);            
            $('#contractName').html(datas.contractName);
            $('#conTitle').html(datas.contractTitle);
            $('#contractStartDate').html(datas.contractStartDate);
            $('#contractEndDate').html(datas.contractEndDate);
            $('#conValue').html(datas.contractValue);
            $('#contractRenew').html(datas.contractRenew);
            $('#contractDescription').html(datas.contractDescription);
            $('#conAttachments').html(datas.download);
          }
        }
      });
      $('#myModal1').modal({
        show: true
      });
    })
    
    
</script>