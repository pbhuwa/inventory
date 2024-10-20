<h3 class="box-title"><?php echo $this->lang->line('amc_detail'); ?><a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
<div style="margin: 10">
<a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="biomedical/amc_data/amc_detail" data-location="biomedical/amc_data/exportToExcelDirect/detail" data-tableid="#amcdatatable"><i class="fa fa-file-excel-o"></i></a>

<a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="biomedical/amc_data/amc_detail" data-location="biomedical/amc_data/generate_pdfDirect/detail" data-tableid="#amcdatatable"><i class="fa fa-print"></i></a>
</div>
  <div class="pad-5">
      <div class="table-responsive scroll">
           <table id="amcdatatable" class="table table-striped dataTable">
              <thead>
                  <tr>
      
                    <?php $org_id=$this->session->userdata(ORG_ID); ?>
                      <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                       <?php if($org_id=='2'){ ?>
                      <th width="5%"><?php echo $this->lang->line('assets_code'); ?></th>
                      <?php }else{ ?>
                      <th width="5%"><?php echo $this->lang->line('equipment_id'); ?></th>
                      <?php } ?>
                       <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                      <?php if($org_id=='2'){ ?>
                      <th width="10%"><?php echo $this->lang->line('brand'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('condition'); ?></th>
                      <?php }else{ ?>
                      <th width="10%"><?php echo $this->lang->line('room'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('risk'); ?></th>
                      <?php } ?>
                      <th width="10%"><?php echo $this->lang->line('manufacture'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('distributor'); ?></th>
                      <th width="5%"> <?php echo $this->lang->line('amc_date_AD'); ?></th>
                      <th width="5%"> <?php echo $this->lang->line('amc_date_BS'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('complete_by'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('amc_status'); ?></th>
                    
                    
                  </tr>
              </thead>
              <tbody>
                        
              </tbody>
          </table>
      </div>
  </div> 
<script type="text/javascript">
$(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl = base_url+"biomedical/amc_data/get_amc_detail";//alert(dataurl);
    var dtablelist = $('#amcdatatable').dataTable({
      "sPaginationType": "full_numbers" ,
      
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
        "sEmptyTable":   "<p class='text-danger'>No Record Found!! </p>"
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 0,11 ]
      }
      ],      
      "aoColumns": [
      { "data": "equipid"},
      { "data": "equipmentkey"},
      { "data": "equidesc"},
      { "data": "department" },
       { "data": "room" },
      { "data": "risk_val" },
      { "data": "manufacture" },
      { "data": "distributor" },
        { "data": "date_ad" },
      { "data": "date_bs" },
      { "data": "completedby" },
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
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: null },
      {type: null},
      ]
    });
  });
</script>