<style>
    table.dataTable tr td:nth-child(4) {font-weight: bold}
        .table>tbody>tr>td:not(:last-child), .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important;
}
</style>
<div class="white-box">
   <div class="searchWrapper">
      <div class="">
            <div class="clearfix"></div>
            <div class="white-box">
               <div class="pad-10">
                  <div class="form-group resp_xs">
                     <div class="col-sm-2 col-xs-6">
                        <label for="example-text">Description:</label>
                        <select name="description_id" class="form-control select2" id="description_id">
                            <option value="">---Select---</option>
                            <?php
                            if($equipmentlist):  
                                foreach ($equipmentlist as $km => $st):
                                ?>
                                <option value="<?php echo $st->eqli_equipmentlistid; ?>"><?php echo $st->eqli_description; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                    <?php
                      $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
                       if(($this->sess_usercode == 'SA') || ($this->sess_usercode == 'AD')){
                    ?>
                     <div class="col-sm-2 col-xs-6">
                        <label for="example-text">Department:</label>
                        <select name="department_id" class="form-control select2" id="department_id">
                            <option value="">---Select---</option>
                            <?php
                            if($department):  
                                foreach ($department as $km => $st):
                                ?>
                                <option value="<?php echo $st->dept_depid; ?>"><?php echo $st->dept_depname; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                    <?php 
                    }
                    ?>
                     <div class="col-sm-2 col-xs-6">
                        <label for="example-text">AMC :</label>
                        <select name="amc_id" class="form-control" id="amc_id">
                           <option value="">Select</option>
                           <option value="Y">Yes</option>
                           <option value="N">No</option>
                        </select>
                     </div>

                  <div class="col-sm-2 col-xs-6">
                        <label for="example-text">Distributor:</label>
                        <select name="distributor_id" class="form-control select2" id="distributor_id">
                            <option value="">---Select---</option>
                            <?php
                            if($distributor):  
                                foreach ($distributor as $km => $st):
                                ?>
                                <option value="<?php echo $st->dist_distributorid; ?>"><?php echo $st->dist_distributor; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>

                     <div class="col-sm-2 col-xs-6">
                        <label for="example-text">Purchase:</label>
                        <select name="purchase_id" class="form-control" id="purchase_id">
                            <option value="">---Select---</option>
                            <?php
                            if($purchase):  
                                foreach ($purchase as $km => $st):
                                ?>
                                <option value="<?php echo $st->pudo_purdonatedid; ?>"><?php echo $st->pudo_purdonated; ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                      
                     <div id="datediv" style="display: none">
                        <div class="col-sm-2 col-xs-6">
                           <label for="">From :</label>
                           <input type="text" name="fromdate" class="form-control <?php
                              echo DATEPICKER_CLASS;?>"  value="" id="fromdate">
                        </div>
                        <div class="col-sm-2 col-xs-6">
                           <label for="">To :</label>
                           <input type="text" name="todate" class="form-control <?php
                              echo DATEPICKER_CLASS;?>" value="" id="todate">
                        </div>
                     </div>
                     <div class="col-sm-2 col-xs-6">
                        <label for="">&nbsp;</label>
                        <div>
                          <button type="search" class="btn btn-info" id="searchByDate" value="">Search
           </button>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div id="InventoryRpt">
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
            <div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
            <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
      </div>
   </div>
  <!--  <div class="clearfix"></div> -->
</div>
 <div style="margin: 10">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="" data-location="biomedical/reports/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="" data-location="biomedical/reports/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
</div>
<div class="pad-5">
   <div class="table-responsive">
      <table id="myTable" class="table table-striped">
         <thead>
            <tr>
               <th width="3%">S.N</th>
               <th width="10%">Equp.ID</th>
               <th width="10%">Description</th>
               <th width="10%">Department</th>
               <th width="5%">Room</th>
               <th width="10%">Model No</th>
               <th width="10%">Serial No</th>
               <th width="10%">Manufacture</th>
               <th width="10%">Distributor.</th>
               <th width="10%">Risk </th>
               <th width="10%">AMC</th>
               <th width="10%">Oper.</th>
               <th width="3%">Ser.St.Date.</th>
               <th width="3%">Ser.End.Warr.</th>
               <th width="5%">Manual</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>

<script type="text/javascript">
   $(document).ready(function(){
    var description_id =$('#description_id').val();
    var department_id =$('#department_id').val();
    var amc_id =$('#amc_id').val();
    var distributor_id =$('#distributor_id').val();
    var purchase_id =$('#purchase_id').val();
    var fromdate=$('#fromdate').val();
    var todate=$('#todate').val();
    var redirecturl=base_url+'biomedical/reports/get_report_list';

    var dtablelist = $('#myTable').dataTable({
        "sPaginationType": "full_numbers",

        "bSearchable": false,
        "lengthMenu": [
            [15, 30, 45, 60, 100, 200, 500, -1],
            [15, 30, 45, 60, 100, 200, 500, "All"]
        ],
        'iDisplayLength': 10,
        "sDom": 'ltipr',
        "bAutoWidth": false,

        "autoWidth": true,
        "aaSorting": [
            [0, 'desc']
        ],
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": redirecturl,
        "oLanguage": {
            "sEmptyTable": "<p class='text-danger'>No Record Found!! </p>"
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, 9]
        }],
      
    "aoColumns": [
     {
              "data": "sno"
          },
     {
              "data": "bmin_equipmentkey"
          },
      {
              "data": "eqli_description"
          },
          {
              "data": "dein_department"
          },
          {
              "data": "rode_roomname"
          },
          {
              "data": "bmin_modelno"
          },
          {
              "data": "bmin_serialno"
          },
          {
              "data": "manu_manlst"
          },
        
          {
              "data": "dist_distributor"
          },
          {
              "data": "riva_risk"
          },
          {
              "data": "bmin_amc"
          },
           {
              "data": "bmin_equip_oper"
          },
           {
              "data": "bmin_servicedatebs"
          },
           {
              "data": "bmin_endwarrantydatebs"
          },
            {
              "data": "bmin_ismaintenance"
          },
    ],
    "fnServerParams": function (aoData) {
      aoData.push({
              "name": "description_id",
              "value": description_id
          });
          aoData.push({
              "name": "department_id",
              "value": department_id
          });
          aoData.push({
              "name": "amc_id",
              "value": amc_id
          });
          aoData.push({
              "name": "distributor_id",
              "value": distributor_id
          });
          aoData.push({
              "name": "purchase_id",
              "value": purchase_id
          });
          aoData.push({
              "name": "fromdate",
              "value": fromdate
          });
          aoData.push({
              "name": "todate",
              "value": todate
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
   }).columnFilter(
   {
    sPlaceHolder: "head:after",
    aoColumns: [ 
    { type: "null" },
    { type: "text" },
    { type: "text" },
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
   
    ]
   });

$(document).off('click', '#searchByDate');
   $(document).on('click', '#searchByDate', function() {
     description_id =$('#description_id').val();
     department_id =$('#department_id').val();
     amc_id =$('#amc_id').val();
     distributor_id =$('#distributor_id').val();
     purchase_id =$('#purchase_id').val();
     fromdate=$('#fromdate').val();
     todate=$('#todate').val();  
      dtablelist.fnDraw();
      return false;
    });

   });

    
</script>
<script type="text/javascript">
   $('.engdatepicker').datepicker({
       format: 'yyyy/mm/dd',
       autoclose: true
   });
   $('.nepdatepicker').nepaliDatePicker();
</script>

