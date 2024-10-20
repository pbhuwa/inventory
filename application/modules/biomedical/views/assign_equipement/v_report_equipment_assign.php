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
              <td></td>
            </tr>
            <tr class="title_sub">
              <td></td>
              <td style="text-align:center;"><b style="font-size:15px">Assign Report</b></td>
              <td style="text-align:right; font-size:10px;">Date/Time: <?php echo CURDATE_NP ?> BS,</td>
            </tr>
            <tr class="title_sub">
              <td></td>
              <td style="text-align:center;"><b id="rptType"></b></td>
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
            <table id="myTable" class="table table-bordered dataTable tbl_pdf">
              <thead>
                <tr>
                  <th width="3%">S.n.</th>
                  <th width="8%">Equp.ID</th>
                  <th width="10%">Description</th>
                  <th width="8%">Model No</th>
                  <th width="7%">Serial No</th>
                  <th width="10%">Distributor</th>
                  <th width="3%">AMC</th>
                  <th width="5%">Pur/Don</th>
                  <th width="8%">Assign Date</th>
                  <th width="12%">Assign To</th>
                  <th width="10%">Assign By</th>
                  <th width="10%">Department</th>
                  <th width="10%">Room</th>
                  <th width="8%">Entry Date</th>

                </tr>
              </thead>
              <tbody>
                <?php
                  if($biomedical_inv_list):
                  $i=1;
                  foreach ($biomedical_inv_list as $kb => $bil):
                ?>
                <?php 

                  if(DEFAULT_DATEPICKER=='NP')
                  {
                    $assigndate=$bil->eqas_assigndatebs ;  
                    $postdate=$bil->eqas_postdatebs ;     
                  }
                  else
                  {
                    $assigndate=$bil->eqas_assigndatead ; 
                    $postdate=$bil->eqas_postdatead ;        
                  }

                ?>

                <tr>
                  <td><?php echo $i; ?>.</td>
                  <td><?php echo $bil->bmin_equipmentkey ?></td>
                  <td><?php echo $bil->eqli_description ?></td>
                  <td><?php echo $bil->bmin_modelno ?></td>
                  <td><?php echo $bil->bmin_serialno ?></td>
                  <td><?php echo $bil->dist_distributor ?></td>
                  <td><?php echo $bil->bmin_amc ?></td>
                  <td><?php echo $bil->pudo_purdonated ?></td>
                  <td><?php echo $assigndate; ?></td>
                  <td><?php echo $bil->stin_fname.' '.$bil->stin_lname; ?></td>
                  <td><?php echo $bil->usma_username; ?></td>
                  <td><?php echo $bil->dein_department ?></td>
                  <td><?php echo $bil->rode_roomname; ?></td>
                  <td><?php echo $postdate; ?></td>
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
  </div>
