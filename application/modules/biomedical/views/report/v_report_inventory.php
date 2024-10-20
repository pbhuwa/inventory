  <style>
  .tbl_pdf{
    border-collapse: collapse;
    
    margin-bottom: 10px; 
  }
    .tbl_pdf tr th,
    .tbl_pdf tr td{
      border: 1px solid #000;
      font-size: 13px;
    }
     h4{
        padding: 5px;
        margin:0px; 
        font-size: 16px;;
      }
      .dataTable{
        margin-top: 0px !important;
        }
      table.dataTable{
          border: 1px solid #e4e7ea;
          border-collapse: collapse;
          vertical-align: middle;
      }
      .tbl_pdf tr th,
      .tbl_pdf tr td{
        border: 1px solid #e4e7ea;
        font-size: 12px;
        text-align: center;
      }

  </style>
  <div class="form-group">
    <?php 
      $pdf=!empty($print_pdf)?$print_pdf:''; 
    ?>
    <?php if($pdf=='Yes'): ?>
    <div class="col-sm-12">
      <div class="pull-right pad-btm-5 no-pos">
        <a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
        <a href="javascript:void(0)" class="btn btn_excel"><i class="fa fa-file-excel-o"></i></a>
        <a href="javascript:void(0)" class="btn btn_pdf"><i class="fa fa-file-pdf-o"></i></a>
      </div>
       <div class="clearfix"></div>
    <?php endif; ?>
      <div class="clearfix"></div>
<input type="hidden" id="status" value="<?php echo $status; ?>">
      <div class="col-sm-12">
        <div class="white-box pad-sides-10" id="printrpt">
          <table class="invertory-report" width="100%" style="font-size:12px;">
            <tr>
              <td></td>
              <td class="web_ttl text-center" style="text-align:center;"><h2><?php echo ORGA_NAME; ?></h2></td>
              <td></td>
            </tr>
            <tr class="title_sub">
              <td></td>
              <td style="text-align:center;"><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td>
              <td style="text-align:right; font-size:10px;">Date/Time: <?php echo CURDATE_NP ?> BS,</td>
            </tr>
            <tr class="title_sub">
              <td></td>
              <td style="text-align:center;"><b style="font-size:15px;"><span id="rptType"></span></b></td>
              <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
            </tr>
            <tr class="title_sub">
              <td width="200px"></td>
              <td style="text-align:center;"><b><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></b></td>
              <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
            </tr>
         
          </table>
          <style>
            .tbl_pdf thead tr th { border-bottom:1px solid #ddd; }
          </style>
          <div class="table-responsive">
            <?php  if($distdept){
              foreach ($distdept as $key => $dep) {
              //echo "<pre>"; print_r($distdept);die;
              //echo "<pre>"; print_r($this->input->post());die;
              if($status=='decommission')
              {
                $is_rep='Y';
              }
              else
              {
                $is_rep='N';
              }
              $srch ='';
              //$srch =array('bmin_isunrepairable'=>$is_rep);
              if($type=='desc')
              { 
                $descriptionid=$this->input->post('bmin_descriptionid');
                //print_r($descriptionid);die;
                if($descriptionid)
                {
                  $srch =array('bmin_descriptionid'=>$descriptionid,'bmin_isunrepairable'=>$is_rep);
                }
                else{
                  $srch=array('eqli_equipmentlistid'=>!empty($dep->eqli_equipmentlistid)?$dep->eqli_equipmentlistid:'','bmin_isunrepairable'=>$is_rep);
                }
              }
              if($type=='dept')
              {  
                $departmentid=$this->input->post('bmin_departmentid');
                if($departmentid)
                {
                  $srch=array('dept_depid'=>$departmentid,'bmin_isunrepairable'=>$is_rep);
                }
                else{
                  $srch=array('dept_depid'=>$dep->dept_depid,'bmin_isunrepairable'=>$is_rep);
                }
              }
              if($type=='dist')
              {  
                $distributorid=$this->input->post('bmin_distributorid');
                if($distributorid)
                {
                  $srch=array('bmin_distributorid'=>$distributorid,'bmin_isunrepairable'=>$is_rep);
                }
                else
                {  
                  $srch=array('dis.dist_distributorid'=>!empty($dep->dist_distributorid)?$dep->dist_distributorid:'','bmin_isunrepairable'=>$is_rep);
                }
              }
              if($type=='amc')
              { 
                  $amc=$this->input->post('bmin_amc');
                   if($amc)
                  {
                    $srch=array('bmin_amc'=>$amc,'bmin_isunrepairable'=>$is_rep);
                  }else{
                    $srch=array('bmin_amc'=>!empty($dep->bmin_amc)?$dep->bmin_amc:'','bmin_isunrepairable'=>$is_rep);
                  }
              }
            if($type=='pur_don')
            {  
              $purch_donatedid=$this->input->post('bmin_purch_donatedid');
               if($purch_donatedid)
              {
                $srch=array('pudo_purdonatedid'=>$purch_donatedid,'bmin_isunrepairable'=>$is_rep);
              }
              else{
                $srch=array('pudo_purdonatedid'=>!empty($dep->pudo_purdonated)?$dep->pudo_purdonated:'','bmin_isunrepairable'=>$is_rep);
              }
            } 
            //print_r($this->input->post());die;
              $details=$this->bio_medical_mdl->get_biomedical_inventory($srch);
              //echo $this->db->last_query();die; ?>
             <?php
                      if($details): $i=1; ?> 
                      <h4 class="title"><?php 
                if($type=='desc')
                {
                  echo $dep->eqli_description;
                }
                if($type=='dept')
                {
                  echo $dep->dein_department;
                }
                if($type=='dist')
                {
                  echo $dep->dist_distributor;
                }
                if($type=='pur_don')
                {
                  echo $dep->pudo_purdonated;
                }
                if($type=='amc')
                { ?>
                 AMC : <?php echo $dep->bmin_amc; ?>
               <?php } ?>
              </h4>
               
             
<div class="pad-5">
       <div class="table-responsive">
           <table id="myTable" class="able table-striped serverDatatable keypresstable ">
               <thead>
                   <tr>
                      <th width="3%">S.N</th>
                      <th width="10%">Equp.ID</th>
                      <th width="15%">Description</th>
                      <th width="10%">Department</th>
                      <th width="10%">Room</th>
                      <th width="10%">Model No</th>
                      <th width="10%">Serial No</th>
                      <th width="15%">Manufacture</th>
                      <th width="15%">Distributor.</th>
                      <th width="10%">Risk </th>
                      <th width="5%">AMC</th>
                      <th width="5%">Oper.</th>
                      <th width="10%">Ser.St.Date.</th>
                      <th width="10%">Ser.End.Warr.</th>
                      <th width="15%">Maunal</th>
                   </tr>
               </thead>
               <tbody>

               </tbody>
           </table>
       </div>
   </div>

   <script type="text/javascript">
    var is_home='<?php if($is_home=='N') echo 'N'; else echo 'Y'; ?>';
    var result_type='<?php echo !empty($result_type)?$result_type:''; ?>';
    
$(document).ready(function() {
      var rpttype =$('#rpttype').val();
      var date =$('#date').val();
      var fromdate=$('#fromdate').val();
      var todate=$('#todate').val();
      var bmin_descriptionid =$('#bmin_descriptionid').val();
      var bmin_distributorid =$('#bmin_distributorid').val();
      var bmin_departmentid =$('#bmin_departmentid').val();
      var bmin_amc =$('#bmin_amc').val();
      var bmin_purch_donatedid =$('#bmin_purch_donatedid').val();
      var bmin_isoperation =$('#bmin_isoperation').val();
      var bmin_ismaintenance =$('#bmin_ismaintenance').val();
      var status=$('#status').val();
      var redirecturl=base_url+'biomedical/reports/get_report_list';
       // var redirecturl=base_url+'biomedical/reports/generate_report'+'?=1';
    // var dataurl = base_url + "tender/procurement/get_allprocurement_list/"+is_home+'/'+result_type;

    var dtablelist = $('#myTable').dataTable({
        "sPaginationType": "full_numbers",

        "bSearchable": false,
        "lengthMenu": [
            [15, 30, 45, 60, 100, 200, 500, -1],
            [15, 30, 45, 60, 100, 200, 500, "All"]
        ],
        'iDisplayLength': 20,
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
            "sEmptyTable": "<p class='text-danger'>No Record Found!! </p>"
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, 9]
        }],
        "aoColumns": [{
                "data": null
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
            // {
            //     "data": "category"
            // },
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
                "data": "end_warrenty"
            },
              {
                "data": "bmin_ismaintenance"
            }
        ],
        "fnServerParams": function(aoData) {
           aoData.push({
                "name": "rpttype",
                "value": rpttype
            });
            aoData.push({
                "name": "date",
                "value": date
            });
            aoData.push({
                "name": "fromdate",
                "value": fromdate
            });
            aoData.push({
                "name": "todate",
                "value": todate
            });
            aoData.push({
                "name": "bmin_descriptionid",
                "value": bmin_descriptionid
            });
            aoData.push({
                "name": "bmin_distributorid",
                "value": bmin_distributorid
            });
            aoData.push({
                "name": "bmin_departmentid",
                "value": bmin_departmentid
            });
            aoData.push({
                "name": "bmin_amc",
                "value": bmin_amc
            });
            aoData.push({
                "name": "bmin_purch_donatedid",
                "value": bmin_purch_donatedid
            });
             aoData.push({
                "name": "bmin_isoperation",
                "value": bmin_isoperation
            });
              aoData.push({
                "name": "bmin_ismaintenance",
                "value": bmin_ismaintenance
            });
               aoData.push({
                "name": "status",
                "value": status
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
                type: "text"
            },
            {
                type: "text"
            },
            {
                type: "null"
            },
        ]
    });
    $(document).off('click', '#searchByDate');
    $(document).on('click', '#searchByDate', function() {
      var rpttype =$('#rpttype').val();
      var date =$('#date').val();
      var fromdate=$('#fromdate').val();
      var todate=$('#todate').val();
      var bmin_descriptionid =$('#bmin_descriptionid').val();
      var bmin_distributorid =$('#bmin_distributorid').val();
      var bmin_departmentid =$('#bmin_departmentid').val();
      var bmin_amc =$('#bmin_amc').val();
      var bmin_purch_donatedid =$('#bmin_purch_donatedid').val();
      var bmin_isoperation =$('#bmin_isoperation').val();
      var bmin_ismaintenance =$('#bmin_ismaintenance').val();
      var status=$('#status').val();
        dtablelist.fnDraw();
        return false;
    });

});

   </script>
                      <?php
                      endif;
                    ?>
                  
               <?php } }  ?>
          </div>
        </div>
      </div>
    </div>
  </div>

       