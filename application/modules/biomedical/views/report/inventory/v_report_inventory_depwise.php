  <div class="form-group">
    <?php $pdf=!empty($print_pdf)?$print_pdf:''; ?>
    <?php if($pdf==''): ?>
    <div class="col-sm-12">
      <div class="pull-right pad-btm-5">
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
         <?php 
         if($dep_information):
          foreach ($dep_information as $kdi => $dep):
         ?>
        <?php
        $biomedical_inv_list=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_departmentid'=>$dep->dept_depid,'bmin_isunrepairable'=>'N','bmin_isdelete'=>'N'));
         if($biomedical_inv_list):
         ?>
         Department:<?php echo $dep->dept_depname; ?>
          <table id="myTable" class="table table-striped dataTable tbl_pdf">
            <thead>
              <tr>
                <th width="3%">S.N</th>
                <th width="10%">Equp.ID</th>
                <th width="15%">Description</th>
                <!-- <th width="10%">Department</th> -->
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
              <?php
                
                $i=1;
                foreach ($biomedical_inv_list as $kb => $bil):
              ?>
              <?php 

                if(DEFAULT_DATEPICKER=='NP')
                {
                  $servicedate=$bil->bmin_servicedatebs ;
                  $end_warrenty=$bil->bmin_endwarrantydatebs;
                }
                else
                {
                  $servicedate=$bil->bmin_servicedatead ;
                  $end_warrenty=$bil->bmin_endwarrantydatead;
                }

              ?>

              <tr>
                <td><?php echo $i; ?>.</td>
                <td><?php echo $bil->bmin_equipmentkey ?></td>
                <td><?php echo $bil->eqli_description ?></td>
                <!-- <td><?php echo $bil->dein_department ?></td> -->
                <td><?php echo $bil->rode_roomname; ?></td>
                <td><?php echo $bil->bmin_modelno ?></td>
                <td><?php echo $bil->bmin_serialno ?></td>
                <td><?php echo $bil->manu_manlst; ?></td>
                <td><?php echo $bil->dist_distributor; ?></td>
                <td><?php echo $bil->riva_risk ?></td>
                <td><?php echo $bil->bmin_amc ?></td>
                <td><?php echo $bil->bmin_equip_oper; ?></td>
                

                <td>
                <?php echo $servicedate; ?>
                </td>
                <td> <?php echo $end_warrenty; ?></td>
                <td>
                  <?php $bmin_isoperation= $bil->bmin_isoperation; if($bmin_isoperation==='Y') echo 'Oper.';
                  $bmin_ismaintenance=$bil->bmin_ismaintenance; if($bmin_ismaintenance==='Y') echo 'Main.';?>
                </td>
              </tr>

              <?php
                $i++;
                endforeach;
               
              ?>

            </tbody>
          </table>

        <?php  endif; endforeach; endif;  ?>
        </div>
      </div>
    </div>
  </div>

