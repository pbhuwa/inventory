  <div class="form-group">
    <?php $pdf=!empty($print_pdf)?$print_pdf:''; ?>
    <?php if($pdf==''): ?>
    <div class="col-sm-12">
      <div class="pull-right pad-btm-5 no-pos">
        <a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
        <a href="javascript:void(0)" class="btn btn_excel"><i class="fa fa-file-excel-o"></i></a>
        <a href="javascript:void(0)" class="btn btn_pdf"><i class="fa fa-file-pdf-o"></i></a>
      </div>
       <div class="clearfix"></div>
    <?php endif; ?>
      <div class="clearfix"></div>

      <div class="col-sm-12">
        <div class="white-box pad-sides-10" id="printrpt">
          <table width="100%" style="font-size:12px;">
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
              <td style="text-align:center;"><b style="font-size:15px;">Description</b></td>
              <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
            </tr>
            <tr class="title_sub">
              <td width="200px"></td>
              <td style="text-align:center;"><b>Defibrillator</b></td>
              <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
            </tr>
         
          </table>
          <style>
            .tbl_pdf thead tr th { border-bottom:1px solid #ddd; }
          </style>

          <table id="myTable" class="table table-striped dataTable tbl_pdf">
            <thead>
              <tr>
                <th width="3%">S.N</th>
                <th width="5%">Equp.ID</th>
                <th width="15%">Description</th>
                <th width="10%">Dept.</th>
                <th width="10%">Model No</th>
                <th width="10%">Serial No</th>
                <th width="15%">Manufacture</th>
                <th width="10%">Risk </th>
                <th width="5%">AMC </th>
                <th width="10%">Ser.St.Date.</th>
                <th width="10%">Ser.End.Warr.</th>
                <th width="15%">Maunal</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if($biomedical_pmcompleted_report):
                $i=1;
                foreach ($biomedical_pmcompleted_report as $kb => $pmr):
               if(DEFAULT_DATEPICKER=='NP')
                {
                  $servicedate=$pmr->bmin_servicedatebs ;
                  $end_warrenty=$pmr->bmin_endwarrantydatebs;
                }
                else
                {
                  $servicedate=$pmr->bmin_servicedatead ;
                  $end_warrenty=$pmr->bmin_endwarrantydatead;
                }

              ?>
              
              <tr>
                <td><?php echo $i; ?>.</td>
                <td><?php echo $pmr->bmin_equipmentkey ?></td>
                <td><?php echo $pmr->eqli_description ?></td>
                <td><?php echo $pmr->dept_depname ?></td>
                <td><?php echo $pmr->bmin_modelno ?></td>
                <td><?php echo $pmr->bmin_serialno ?></td>
                <td><?php //echo $pmr-> ?></td>
                <td><?php echo $pmr->riva_risk ?></td>
                <td><?php echo $pmr->bmin_amc ?></td>
                <td>
                <?php echo $servicedate; ?>
                </td>
                <td> <?php echo $end_warrenty; ?></td>
                <td>
                  <?php $bmin_isoperation= $pmr->bmin_isoperation; if($bmin_isoperation==='Y') echo 'Operation,';
                  $bmin_ismaintenance=$pmr->bmin_ismaintenance; if($bmin_ismaintenance==='Y') echo 'Maintenance';?>
                </td>
              </tr>

              <?php
                $i++;
                endforeach;
                endif;
              ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
