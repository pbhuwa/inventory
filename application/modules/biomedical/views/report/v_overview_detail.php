<style>

	.ov_report_dtl .ov_lst_ttl { font-size:12px; margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px solid #efefef; }

	.ov_report_dtl .pm_data_tbl { width:100%; margin-bottom:10px; }

	.ov_report_dtl .pm_data_tbl td, .ov_report_dtl .pm_data_tbl td b { font-size:12px; }

	.ov_report_dtl .count { background-color:#e3e3e3; font-size:12px; padding:2px 5px; }

	

	table.ov_report_tbl { border-left:1px solid #e3e3e3; border-top:1px solid #e3e3e3; border-collapse:collapse; margin-bottom:10px; }

	table.ov_report_tbl thead th { text-align:left; background-color:#e3e3e3; padding:2px; font-size:12px; }

	table.ov_report_tbl tbody td { font-size:12px; border-right:1px solid #e3e3e3; border-bottom:1px solid #e3e3e3; line-height:13px; padding:2px; }

	.search_pm_data ul.pm_data li label{

		width: 150px;

	}

	.search_pm_data ul.pm_data li{

		font-size: 13px;

    	line-height: 17px;

    	display:table;

    	width:100%;

	}

	.search_pm_data ul.pm_data li label, .search_pm_data ul.pm_data li span{ display:table-cell; vertical-align: top; padding:4px 0; }

	.search_pm_data ul.pm_data { padding:5px 7px; }

	#barcodePrint{

		position: absolute;top: 0;right: 5px;    background-color: #03a9f3; border: 1px solid #03a9f3; color:#fff;

	}



	.ov_report_tabs #tab_selector { margin-bottom:5px; }



	.ov_report_tabs #tab_selector {

	    border: none;

	    background-color: #00663f;

	    background: -webkit-linear-gradient(#00b588, #017558);

	    background: -o-linear-gradient(#00b588, #017558);

	    background: -moz-linear-gradient(#00b588, #017558);

	    background: linear-gradient(#00b588, #017558);

	    color: #fff;

	}

	.ov_report_tabs #tab_selector option {

	    color: #444;

	}



	@media only screen and (max-width:991px) { 

	.ov_report_tabs ul.nav-tabs li a { font-size:12px; padding:10px; }

	 }

	 @media only screen and (max-width:767px) {

	 	.ov_report_tabs ul.nav-tabs li a { font-size: 12px; padding: 10px 29px; }

	 }

	 @media only screen and (max-width:667px) {

	 	.ov_report_tabs ul.nav-tabs li { width:33.33333333%; }

	 	.ov_report_tabs ul.nav-tabs li a { padding:10px; text-align:center; }

	 	.search_pm_data ul.pm_data li.eqp_cod label, .search_pm_data ul.pm_data li.eqp_cod span { display:block; }

	 }

	 @media only screen and (max-width:414px) {

	 	.ov_report_tabs ul.nav-tabs li { width:50%; }

	 	.search_pm_data ul.pm_data { column-count: 1; }

	 }

</style>

<div class="ov_report_tabs pad-5 tabbable">



	<ul class="nav nav-tabs form-tabs hidden-xs">

		<li class="tab-selector active"><a data-toggle="tab" href="#dtl_rpt">Details</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#rep_cmt">Repair Comments</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#rep_req">Repair Request</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#pm_data">PM Data</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#pm_comp">PM Complete</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#assign">Assign</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#handover">Handover</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#unrepairable">Amc</a></li>



		<li class="tab-selector"><a data-toggle="tab" href="#maintainance">Maintainance Log</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#print_preview">Print Preview</a></li>

	</ul>

	

	<select class="mb10 form-control select2 visible-xs" id="tab_selector">

        <option value="0">Details</option>

        <option value="1">Repair Comments</option>

        <option value="2">Repair Request</option>

        <option value="3">PM Data</option>

        <option value="4">PM Complete</option>

        <option value="5">Assign</option>

        <option value="6">Handover</option>

        <option value="7">Unrepairable Equipment</option>

        <option value="8">Print Preview</option>

    </select>



	<div class="tab-content white-box pad-5">

		<div id="dtl_rpt" class="tab-pane fade in active">

			<h5 class="ov_lst_ttl"><b>Details</b></h5>

			<input type="hidden" name="pmta_equipid" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>">

			<ul class="pm_data pm_data_body">

				<li>

					<label> Equipment ID</label>

					<span>

			        	<?php echo !empty($eqli_data[0]->bmin_equipmentkey)?$eqli_data[0]->bmin_equipmentkey:'';?>

			        </span>

				</li>

				<li>

					<label> Equipment Type</label>

					<span>

			        	<?php echo !empty($eqli_data[0]->eqty_equipmenttype)?$eqli_data[0]->eqty_equipmenttype:'';?>

		        	</span>

				</li>

			    <li>

			        <input type="hidden" name="pmta_equipid" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>">

			        <label> Description</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->eqli_description)?$eqli_data[0]->eqli_description:'';?>

			        </span>

			    </li>

			    <li>

					<label> Model No.</label>

					<span>

			        <?php echo !empty($eqli_data[0]->bmin_modelno)?$eqli_data[0]->bmin_modelno:'';?>

			        </span>

				</li>

			    <li>

			        <label>Serial Number</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->bmin_serialno)?$eqli_data[0]->bmin_serialno:'';?>

			        </span>

			    </li>

			    <li>

			        <label>Department</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->dein_department)?$eqli_data[0]->dein_department:'';?>	

			        </span>

			    </li>

			    <li>

			        <label>Room</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->rode_roomname)?$eqli_data[0]->rode_roomname:'';?>

			        </span>

			    </li>

			    <li>

			        <label>Risk Value</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->riva_risk)?$eqli_data[0]->riva_risk:'';?>

			        </span>

			    </li>

			    <li>

			        <label>Equipment Operational</label>

			        <span>

			        <?php 

			        	$equip_oper =  !empty($eqli_data[0]->bmin_equip_oper)?$eqli_data[0]->bmin_equip_oper:'';

			        	if($equip_oper == 'Yes'){

			        		$label = 'label-success';

			        	}else{

			        		$label = 'label-danger';

			        	}

			        ?>

			        <div class="label <?php echo $label;?>">

			        	<?php echo $equip_oper; ?>

			        </div>

			    	</span>

			    </li>

			    <li>

			        <label>Manufacturer</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->manu_manlst)?'<i class="fa fa-building" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'. $eqli_data[0]->manu_manlst.'<br/>':'';?>

			        <?php 

			        	$ad1 = !empty($eqli_data[0]->manu_address1)?$eqli_data[0]->manu_address1:'';

			        	$ad2 = !empty($eqli_data[0]->manu_address2)?$eqli_data[0]->manu_address2:'';

			        	if($ad1 && $ad2){

			        		echo '<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'.$ad1.', '.$ad2;

			        	}else if($ad1){

			        		echo '<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'.$ad1;

			        	}else if($ad2){

			        		echo '<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'.$ad2;

			        	}

			        ?>

			        <?php echo !empty($eqli_data[0]->manu_phone1)?'<i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'. $eqli_data[0]->manu_phone1.'<br/>':'';?>

			        <?php echo !empty($eqli_data[0]->manu_email)?'<i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'. $eqli_data[0]->manu_email.'<br/>':'';?>

			        <?php echo !empty($eqli_data[0]->manu_website)?'<i class="fa fa-globe" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'. $eqli_data[0]->manu_website.'<br/>':'';?>

			    	</span>

			    </li>

			    <li>

			        <label> Distributor</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->dist_distributor)?$eqli_data[0]->dist_distributor:'';?>

			        </span>

			    </li>

			    <li>

			        <label> AMC</label>

			        <span>

			        <?php 

			        	$amc = !empty($eqli_data[0]->bmin_amc)?$eqli_data[0]->bmin_amc:'';

			        	echo ($amc == 'N')?"No":"Yes";

			        ?>

			        </span>

			    </li>

			   

			    <li>

			        <label>Service Start Date</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->bmin_servicedatead)?$eqli_data[0]->bmin_servicedatead:'';?>

			        </span>

			    </li>

			   <li>

			        <label> Postdatead</label>

			        <?php echo !empty($eqli_data[0]->bmin_postdatead)?$eqli_data[0]->bmin_postdatead:'';?>

			    </li>

			    <li>

			        <label>End Warranty Date</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->bmin_endwarrantydatead)?$eqli_data[0]->bmin_endwarrantydatead:'';

			        ?>

			        </span>

			    </li>

			    <li>

			        <label>Purchase/ Donate</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->pudo_purdonated)?$eqli_data[0]->pudo_purdonated:'';?>

			        </span>

			    </li>

			    <li>

			        <label> AMC Contractor</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->amc_contractor)?$eqli_data[0]->amc_contractor:'';?>

			        </span>

			    </li>

			    <li>

			        <label> Manual</label>

			        <span>

			        <?php 

			        	$bmin_isoperation = !empty($eqli_data[0]->bmin_isoperation)?$eqli_data[0]->bmin_isoperation:'';

			        	$bmin_ismaintenance = !empty($eqli_data[0]->bmin_ismaintenance)?$eqli_data[0]->bmin_ismaintenance:'';

			        	echo ($bmin_isoperation == 'Y')?'Operation   ':'';

			        	echo ($bmin_ismaintenance == 'Y')?'Maintainance':'';

			        ?>

			        </span>

			    </li>

			    <li>

			        <label> Cost</label>

			        <span>

			        	<?php 

			        	$currencytype =  !empty($eqli_data[0]->cuty_currencytypename)?$eqli_data[0]->cuty_currencytypename:'';

			        	echo !empty($eqli_data[0]->bmin_cost)?$eqli_data[0]->bmin_cost.' '.$currencytype:'';

			        ?>

			    </span>

			    </li>

			    <li>

			        <label> Bill No.</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->bmin_billno)?$eqli_data[0]->bmin_billno:'';?>

			        </span>

			    </li>

			    <li>

			        <label> Known Person Name</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->bmin_known_person)?$eqli_data[0]->bmin_known_person:'';?>

			        </span>

			    </li>

			    <li>

			        <label> Accessories</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->bmin_accessories)?$eqli_data[0]->bmin_accessories:'';?>

			        </span>

			    </li>

			    <li>

			        <label> Comments</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->bmin_comments)?$eqli_data[0]->bmin_comments:'';?>

			        </span>

			    </li>





			    <li class="eqp_cod">

			    	<label>Equipment Code</label>

			    	<span>

			    		<?php

			    			$equipid = !empty($eqli_data[0]->bmin_equipmentkey)?$eqli_data[0]->bmin_equipmentkey:'';

			    			$desc = !empty($eqli_data[0]->eqli_description)?$eqli_data[0]->eqli_description:'';

			    			$servicedate = !empty($eqli_data[0]->bmin_servicedatead)?$eqli_data[0]->bmin_servicedatead:'';

			    		?>

			    					

			    		<div class="white-box pull-right pad-5">

							<div class="printBox" style="padding:4px !important; text-align: center; max-width: 2in;max-height:1in">

							<?php         

					            Zend_Barcode::render('code128', 'image', array('text'=>$equipid,'barHeight'=>42,'factor'=>4, 'drawText' => false, 'font'=>4), array());

					            $buffer = ob_get_contents();

					           

					            // return $buffer;

					            ob_end_clean();

					        ?>



					        <p style="font-size: 10px; padding: 0px; margin: 0px; display: block; font-weight: 600; "><?php echo ORGA_NAME;?></p>

							<p style="font-size:9px;padding: 0px; margin: 0px; font-weight: 600;"><?php echo $desc; ?></p>

					        <div style="max-width: 1.3in; width: 70%; float:left; padding-top:5px;  ">

					            

					            <p style="font-size:9px;padding: 0px; margin: 0px; font-weight: 600;"><?php echo $new_equip_id; ?></p>

					            

					            <?php echo "<img src='data:image/png;base64," . base64_encode( $buffer )."'>"; ?>

					        </div>



					        <div style="max-width: 0.7in; width:30%; float:right;">

					            <?php

					            // echo $qr_link;

					            // die();

					                ob_start();

					                header("Content-Type: image/png");

					                $params['data'] = $qr_link;

					                $this->ciqrcode->generate($params);

					                $qr = ob_get_contents();

					                ob_end_clean();

					                echo "<img src='data:image/png;base64," . base64_encode( $qr )."'>";

					            ?>

					        </div>

					        <div class="clearfix"></div>

						</div>

						    <!-- <button class="btn btn-xs btn_print" id="barcodePrint"><i class="fa fa-print"></i></button> -->

						    

						</div>

			    	</span>

			    </li>

			</ul>

		</div>

		

<div class="modal fade" id="equipHandover" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content xyz-modal-123">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel">Handover Equipment</h4>

            </div>

            

            <div class="modal-body pad-5 scroll vh80 displyblock">



            </div>

        </div>

    </div>

</div>

		<div id="rep_cmt" class="tab-pane fade">

			<h5 class="ov_lst_ttl"><b>Repair Comments (<?php if(!empty($cmnt_data) && is_array($cmnt_data)) echo sizeof($cmnt_data);?>)</b></h5>

			<a href="javascript:void(0)" class="btn btn-primary repairComments" data-equipid="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>" data-pmtaid="<?php echo !empty($eqli_data[0]->pmta_pmtableid)?$eqli_data[0]->pmta_pmtableid:'';?>">

				+

			</a>



			<?php

				$this->load->view('bio_medical_inventory/v_comment_modal');

			?>







			<div class="table-responsive">

				<table class="table table-striped dataTable" width="100%">

					<thead>

						<tr>

							<th width="5%">S.N.</th>

							<th width="25%">Comment</th>

							<th width="10%">Reported By</th>

							<th width="15%">Reported Status</th>

							<th width="10%">Approved By</th>

							<th width="10%">Reported Mac/IP</th>

							<th width="12%">Reported Date(AD)</th>

							<th width="12%">Reported Date(BS)</th>

							<th width="10%">Time</th>

						</tr>

					</thead>

					<tbody>



						<?php

						if(!empty($cmnt_data)){

						foreach($cmnt_data as $key=>$valu){?>

						<tr>

							<td><?php echo $key+1; ?></td>

							<td><?php echo $valu->eqco_comment; ?></td>

							<td><?php echo $valu->postby; ?></td>

							<td><?php if($valu->eqco_comment_status == 1){echo "Approved";}else{ echo "Pending" ;} ?></td>

							<td><?php echo $valu->approvedby;?></td>

							<td><?php echo $valu->eqco_postmac.' ('.$valu->eqco_postip.')'; ?></td>

							<td><?php echo $valu->eqco_postdatead; ?></td>

							<td><?php echo $valu->eqco_postdatebs; ?></td>

							<td><?php echo $valu->eqco_posttime; ?></td>

						</tr>

						<?php } } ?>



					</tbody>

				</table>

			</div>

		</div>

		<div id="rep_req" class="tab-pane fade">

			<h5 class="ov_lst_ttl"><b>Repair Request (<?php  if(!empty($equipment_detail) && is_array($equipment_detail)) echo sizeof($equipment_detail); ?>)</b></h5>

			<?php

				$this->load->view('pm_data/v_pmcompletedmodal');

			?>

			<div class="table-responsive">

				<table id="repairTableInfo" class="table table-striped dataTable">

	                  <thead>

	                      <tr>

	                          <th width="2%">S.n</th>

	                          <th width="6%">Date(AD)</th>

	                          <th width="6%">Date(BS)</th>

	                          <th width="6%">Time</th>

	                          <th width="6%">Equipment ID</th>

	                          <th width="6%">Department</th>

	                          <th width="6%">Room</th>

	                          <th width="8%">Problem Type</th>

	                          <th width="20%">Problem</th>

	                          <th width="30%">Action Taken</th>

	                          <th width="5%">Action</th>

	                      </tr>

	                  </thead>

	                  <tbody>

	                    <?php

	                    if($equipment_detail):

	                      $i=1;

	                      foreach ($equipment_detail as $eqk => $eqdt):

	                        $prblmtype=$eqdt->rere_problemtype;

	                        if($prblmtype=='Ex')

	                        {

	                          $problemtype='External';

	                        }

	                        else

	                        {

	                          $problemtype='Internal';

	                        }

	                      ?>

	                      <tr>

	                        <td><?php echo $i; ?></td>

	                        <td><?php echo $eqdt->rere_postdatead; ?></td>

	                        <td><?php echo $eqdt->rere_postdatebs ?></td>

	                        <td><?php echo $eqdt->rere_posttime; ?></td>

	                        <td><?php echo $eqdt->bmin_equipmentkey; ?></td>

	                        <td><?php echo $eqdt->dein_department; ?></td>

	                        <td><?php echo $eqdt->rode_roomname; ?></td>

	                        <td><?php echo $problemtype; ?></td>

	                        <td><?php echo $eqdt->rere_problem; ?></td>

	                        <td><?php echo $eqdt->rere_action; ?></td>

	                        <td><a href="javascript:void(0)">View</a></td>                        

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

		<div id="pm_data" class="tab-pane fade">

			<?php 

			 $curdate = CURDATE_EN;



			if(!empty($pmdata)){ ?>

			<h5 class="ov_lst_ttl"><b>PM Data</b></h5>

			<div class="table-responsive">

			<table class="table table-border table-striped table-site-detail dataTable">

	        <thead>

	          	<tr>

	                <th>PM Date(AD) </th>

	                <th>PM Date(BS) </th>

	                <th>Remarks </th>

	                <th>Status </th>

	                <th>Is Comp. ?</th>

	                <th>Action</th>

	            </tr>

	        </thead>

	        <tbody>

	            <?php

	                $j=1;

	                foreach($pmdata as $data){ 

	                    $newDate = !empty($data->pmta_pmdatead)?$data->pmta_pmdatead:'';

	                    if($newDate < $curdate){

	                        $style = "color:#d00";

	                        $status = "Completed";

	                        $display = "display:none;";

	                    }else{

	                        $style = "color:#0f0";

	                        $status = "Available";

	                        $display = "display:inline-block;";

	                    }

	                $pmtableid = !empty($data->pmta_pmtableid)?$data->pmta_pmtableid:'';

	                //$pmtableid = !empty($data->pmta_ispmcompleted)?$data->pmta_ispmcompleted:'';

	            ?>

	            <tr id="listid_<?php echo $pmtableid; ?>">

	                <td>

	                    <?php echo !empty($data->pmta_pmdatead)?$data->pmta_pmdatead:'';?>

	                </td>

	                <td>

	                    <?php echo !empty($data->pmta_pmdatebs)?$data->pmta_pmdatebs:'';?>

	                </td>

	                <td>

	                    <?php echo !empty($data->pmta_remarks)?$data->pmta_remarks:'';?>

	                </td>

	                <td style="<?php echo $style; ?>"><?php echo $status; ?></td>

	                <td>

	                    <?php 

	                    $ispmcomplete=!empty($data->pmta_ispmcompleted)?$data->pmta_ispmcompleted:'0';

	                    $completedatead=!empty($data->pmta_completedatead)?$data->pmta_completedatead:'';

	                    $completedatebs=!empty($data->pmta_completedatebs)?$data->pmta_completedatebs:'';

	                    if(DEFAULT_DATEPICKER=='NP')

	                    {

	                        $compdate=$completedatebs;

	                    }

	                    else

	                    {

	                        $compdate=$completedatead;

	                    }

	                    

	                    if($ispmcomplete=='1'):

	                    echo '<label class="label label-success">Yes</label>';

	                    echo '<br>'.$compdate;

	                    else:

	                    echo '<label class="label label-danger">No</label>';

	                    endif;



	                    ?>

	                </td>



	                

	                <td><a href="javascript:void(0)" class="text-danger btnDelete" data-id="<?php echo $pmtableid; ?>" data-deleteurl="<?php echo base_url('biomedical/pm_data/deletepm_data');?>"><i class="fa fa-minus-square-o "></i></a>&nbsp;&nbsp;&nbsp;

	                    <a href="javascript:void(0)" class="btnEditPM" style="<?php echo $display;?>"  data-editid="<?php echo $pmtableid; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;

	                    <a href="javascript:void(0)" class="isCompletePm" style="<?php echo $display;?>"  data-equipid="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>" data-pmtaid="<?php echo $pmtableid; ?>"><?php if($data->pmta_ispmcompleted == 0){ echo "Is Completed";}?></a>

	                </td>

	            </tr>

	            <?php

                $j++;

                    }

                }

                    ?>

                </tbody>

            </table>

            </div>

<!-- 

				<table class="table table-striped ov_report_tbl" width="100%">

					<thead>

						<tr>

							<th width="10%">PM Date(AD)</th>

							<th width="10%">PM Date(BS)</th>

							<th width="15%">PM Remarks</th>

							<th width="15%">PM Status</th>

							<th width="10%">Post Date(AD)</th>

							<th width="10%">Post Date(BS)</th>

							<th width="10%">Post Time</th>

						</tr>

					</thead>

					<?php 

						foreach($pmta as $pm):

						$curdate = CURDATE_EN;

						$newDate = !empty($pm->pmta_pmdatead)?$pm->pmta_pmdatead:'';

	                ?>

	                <?php if($newDate > $curdate):

	                	$style = "color:#0f0";

	                    $status = "Available";

	                ?>

					<tr>

					<td><?php echo $pm->pmta_pmdatead;?></td>

					<td><?php echo $pm->pmta_pmdatebs;?></td>

					<td><?php echo $pm->pmta_remarks;?></td>	

					<td style="<?php echo $style; ?>">

							<?php echo $status; ?>

					</td>	

					<td><?php echo $pm->pmta_postdatead;?></td>		

					<td><?php echo $pm->pmta_postdatead;?></td>		

					<td><?php echo $pm->pmta_posttime;?></td>		

						

					</tr>

					<?php endif;?>

					<?php endforeach;?>

				</table> -->



			<?php //}  ?>

		</div>

		<div id="pm_comp" class="tab-pane fade">

			<?php if(!empty($pmcpmpleted)){ ?>

				<h5 class="ov_lst_ttl"><b>PM Complete</b></h5>



				<table class="pm_data_tbl pm_data" width="100%">

					<tr>			

						<td width="50%">

							<b>Description </b>: <?php echo $pmcpmpleted[0]->pmco_description;?>

						</td>

						<td width="50%">

							<b>PM Completed Date (AD) </b>: <?php echo $pmcpmpleted[0]->pmco_postdatead;?>

						</td>

					</tr>

					<tr>

						<td>

							<b>PM Completed Date (BS) </b>: <?php echo $pmcpmpleted[0]->pmco_postdatebs;?>

						</td>

						<td></td>

					</tr>

				</table>	

			<?php } ?>

		</div>

		<div id="assign" class="tab-pane fade">

			<div class="table-responsive">

			<table class="table table-striped dataTable" width="100%">

				<thead>

            <tr>

                <th width="10%">Ass.Date (AD)</th>

                <th width="10%">Ass.Date (BS)</th>

                <th width="10%">Ent.Date(AD)</th>

                <th width="10%">Ent.Date(BS)</th>

                <th width="10%">Time</th>

                <th width="20%">Assign To</th>

                <th width="20%">Assign By</th>

                <th width="20%">Action</th>

            </tr>

        </thead>

        <tbody>

            <?php 

            if($equip_assign):

                foreach ($equip_assign as $eak => $assign):

                ?>

                <tr>

                    <td><?php echo $assign->eqas_assigndatead; ?></td>

                    <td><?php echo $assign->eqas_assigndatebs; ?></td>

                    <td><?php echo $assign->eqas_postdatead; ?></td>

                    <td><?php echo $assign->eqas_postdatebs; ?></td>

                    <td><?php echo $assign->eqas_posttime; ?></td>

                    <td><?php echo $assign->stin_fname.' '.$assign->stin_lname; ?></td>

                    <td><?php echo $assign->usma_username; ?></td>

                    <td>



                        <?php if($assign->eqas_ishandover=='N'): ?>

                        <a href="javascript:void(0)" class="btn btn-sm btn-success btnHandover" data-eqas_equipmentassignid="<?php echo $assign->eqas_equipmentassignid; ?>" data-equipid="<?php echo $assign->eqas_equipid; ?>" data-equipdepid="<?php echo $assign->eqas_equipdepid; ?>" data-equiproomid="<?php echo $assign->eqas_equiproomid; ?>" data-staffcode="<?php echo $assign->stin_code; ?>" data-staffname="<?php echo $assign->stin_fname.' '.$assign->stin_lname; ?>">Handover</a>

                    <?php endif; ?>

                    </td>



                </tr>

                <?php

                endforeach;

            endif;

            ?>

        </tbody>

			</table>

			</div>

		</div>

		<div id="handover" class="tab-pane fade">

			<div class="table-responsive">

			<table class="table table-striped dataTable" width="100%">

				 <thead>

				 	<tr>

	                <th width="10%">Date (AD)</th>

	                <th width="10%">Date (BS)</th>

	                <th width="10%">Time</th>

	                <th width="15%">Handover From</th>

	                <th width="15%">Handover To</th>

	                <th width="15%">Entry Date(AD)</th>

	                <th width="15%">Entry Date(BS)</th>

	                <th width="15%">Handover By</th>

            	</tr>

		        </thead>

		        <tbody>

		            <?php 

		            if($equip_handover):

		                foreach ($equip_handover as $kh => $handover):

		                ?>

		            <tr>

		                <td><?php echo $handover->eqas_handoverdatead; ?></td>

		                <td><?php echo $handover->eqas_handoverdatebs; ?></td>

		                <td><?php echo $handover->eqas_posttime; ?></td>

		                <td><?php echo $handover->stin_fname.' '.$handover->stin_lname; ?></td>

		                <td><?php echo $handover->hstin_fname.' '.$handover->hstin_lname; ?></td>

		                <td><?php echo $handover->eqas_postdatead; ?></td>

		                <td><?php echo $handover->eqas_postdatebs; ?></td>

		                <td><?php echo $handover->husma_username; ?></td>

		            </tr>

		           <?php 

		       endforeach; endif;

		             ?>

		         </tbody>

			</table>

			</div>

		</div>

		<div id="unrepairable" class="tab-pane fade">

			<?php if(!empty($amc_data)){ ?>

			<h5 class="ov_lst_ttl"><b>AMC</b></h5>

			<table class="pm_data_tbl pm_data dataTable" width="100%">

			<thead>

				<tr>

					<th width="10%">AMC Date(AD)</th>

					<th width="10%">AMC Date(BS)</th>

					<th width="25%">Remarks</th>

					<th width="10%">Time</th>

				</tr>

			</thead>

				<?php foreach($amc_data as $key => $am) { ?>

				<tr>

					<td><?php echo $am->amta_amcdatead;?></td>

					<td><?php echo $am->amta_amcdatebs;?></td>

					<td><?php echo $am->amta_remarks;?></td>

					<td><?php echo $am->amta_posttime;?></td>

				</tr>

				<?php } ?>

			</table>

			<?php } ?>

		</div>

		<div id="print_preview" class="tab-pane fade">

			<div id="printrpt" class="pad-5">

				<div class="pull-right pad-btm-5">

					<a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>

					<!-- <a href="javascript:void(0)" class="btn btn_excel"><i class="fa fa-file-excel-o"></i></a> -->

					<a href="javascript:void(0)" class="btn btn_pdf" data-id="<?php echo $eqli_data[0]->bmin_equipid ?>"><i class="fa fa-file-pdf-o"></i></a>

				</div>

				<div class="clearfix"></div>

				<div class="white-box pad-5 ov_report_dtl">

					<table width="100%" style="font-size:12px;">

						<tr>

							<td></td>

							<td class="web_ttl text-center" style="text-align:center;"><h2><?php echo ORGA_NAME; ?></h2></td>

							<td></td>

						</tr>

						<tr class="title_sub">

							<td></td>

							<td style="text-align:center;"><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td>



							<td style="text-align:right; font-size:10px;"><b>Date/Time:</b> <?php echo CURDATE_NP ?> BS,</td>

						</tr>

						<tr class="title_sub">

							<td></td>

							<td style="text-align:center;"><b style="font-size:15px;"></b></td>

							<td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>

						</tr>

						<tr class="title_sub">

							<td width="200px"></td>

							<td style="text-align:center;"><b></b></td>

							<td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>

						</tr>

					</table>



					<h5 class="ov_lst_ttl"><b>Details Report</b></h5>

					

					<input type="hidden" name="pmta_equipid" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>">

					<ul class="pm_data pm_data_body">

						<li>

					<label> Equipment ID</label>

					<span>

			        	<?php echo !empty($eqli_data[0]->bmin_equipmentkey)?$eqli_data[0]->bmin_equipmentkey:'';?>

			        </span>

				</li>

				<li>

					<label> Equipment Type</label>

					<span>

			        	<?php echo !empty($eqli_data[0]->eqty_equipmenttype)?$eqli_data[0]->eqty_equipmenttype:'';?>

		        	</span>

				</li>

			    <li>

			        <input type="hidden" name="pmta_equipid" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>">

			        <label> Description</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->eqli_description)?$eqli_data[0]->eqli_description:'';?>

			        </span>

			    </li>

			    <li>

					<label> Model No.</label>

					<span>

			        <?php echo !empty($eqli_data[0]->bmin_modelno)?$eqli_data[0]->bmin_modelno:'';?>

			        </span>

				</li>

			    <li>

			        <label>Serial Number</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->bmin_serialno)?$eqli_data[0]->bmin_serialno:'';?>

			        </span>

			    </li>

			    <li>

			        <label>Department</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->dein_department)?$eqli_data[0]->dein_department:'';?>	

			        </span>

			    </li>

			    <li>

			        <label>Room</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->rode_roomname)?$eqli_data[0]->rode_roomname:'';?>

			        </span>

			    </li>

			    <li>

			        <label>Risk Value</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->riva_risk)?$eqli_data[0]->riva_risk:'';?>

			        </span>

			    </li>

			    <li>

			        <label>Equipment Operational</label>

			        <span>

			        <?php 

			        	$equip_oper =  !empty($eqli_data[0]->bmin_equip_oper)?$eqli_data[0]->bmin_equip_oper:'';

			        	if($equip_oper == 'Yes'){

			        		$label = 'label-success';

			        	}else{

			        		$label = 'label-danger';

			        	}

			        ?>

			        <div class="label <?php echo $label;?>">

			        	<?php echo $equip_oper; ?>

			        </div>

			    	</span>

			    </li>

			    <li>

			        <label>Manufacturer</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->manu_manlst)?'<i class="fa fa-building" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'. $eqli_data[0]->manu_manlst.'<br/>':'';?>

			        <?php 

			        	$ad1 = !empty($eqli_data[0]->manu_address1)?$eqli_data[0]->manu_address1:'';

			        	$ad2 = !empty($eqli_data[0]->manu_address2)?$eqli_data[0]->manu_address2:'';

			        	if($ad1 && $ad2){

			        		echo '<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'.$ad1.', '.$ad2;

			        	}else if($ad1){

			        		echo '<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'.$ad1;

			        	}else if($ad2){

			        		echo '<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'.$ad2;

			        	}

			        ?>

			        <?php echo !empty($eqli_data[0]->manu_phone1)?'<i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'. $eqli_data[0]->manu_phone1.'<br/>':'';?>

			        <?php echo !empty($eqli_data[0]->manu_email)?'<i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'. $eqli_data[0]->manu_email.'<br/>':'';?>

			        <?php echo !empty($eqli_data[0]->manu_website)?'<i class="fa fa-globe" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;'. $eqli_data[0]->manu_website.'<br/>':'';?>

			    	</span>

			    </li>

			    <li>

			        <label> Distributor</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->dist_distributor)?$eqli_data[0]->dist_distributor:'';?>

			        </span>

			    </li>

			    <li>

			        <label> AMC</label>

			        <span>

			        <?php 

			        	$amc = !empty($eqli_data[0]->bmin_amc)?$eqli_data[0]->bmin_amc:'';

			        	echo ($amc == 'N')?"No":"Yes";

			        ?>

			        </span>

			    </li>

			   

			    <li>

			        <label>Service Start Date</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->bmin_servicedatead)?$eqli_data[0]->bmin_servicedatead:'';?>

			        </span>

			    </li>

			    <li>

			        <label>End Warranty Date</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->bmin_endwarrantydatead)?$eqli_data[0]->bmin_endwarrantydatead:'';

			        ?>

			        </span>

			    </li>

			    <li>

			        <label>Purchase/ Donate</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->pudo_purdonated)?$eqli_data[0]->pudo_purdonated:'';?>

			        </span>

			    </li>

			    <li>

			        <label> AMC Contractor</label>

			        <span>

			        <?php echo !empty($eqli_data[0]->amc_contractor)?$eqli_data[0]->amc_contractor:'';?>

			        </span>

			    </li>

			    <li>

			        <label> Manual</label>

			        <span>

			        <?php 

			        	$bmin_isoperation = !empty($eqli_data[0]->bmin_isoperation)?$eqli_data[0]->bmin_isoperation:'';

			        	$bmin_ismaintenance = !empty($eqli_data[0]->bmin_ismaintenance)?$eqli_data[0]->bmin_ismaintenance:'';

			        	echo ($bmin_isoperation == 'Y')?'Operation   ':'';

			        	echo ($bmin_ismaintenance == 'Y')?'Maintainance':'';

			        ?>

			        </span>

			    </li>

			    <li>

			        <label> Cost</label>

			        <span>

			        	<?php 

			        	$currencytype =  !empty($eqli_data[0]->cuty_currencytypename)?$eqli_data[0]->cuty_currencytypename:'';

			        	echo !empty($eqli_data[0]->bmin_cost)?$eqli_data[0]->bmin_cost.' '.$currencytype:'';

			        ?>

			    </span>

			    </li>

			    <li>

			        <label> Bill No.</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->bmin_billno)?$eqli_data[0]->bmin_billno:'';?>

			        </span>

			    </li>

			    <li>

			        <label> Known Person Name</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->bmin_known_person)?$eqli_data[0]->bmin_known_person:'';?>

			        </span>

			    </li>

			    <li>

			        <label> Accessories</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->bmin_accessories)?$eqli_data[0]->bmin_accessories:'';?>

			        </span>

			    </li>

			    <li>

			        <label> Comments</label>

			        <span>

			        	<?php echo !empty($eqli_data[0]->bmin_comments)?$eqli_data[0]->bmin_comments:'';?>

			        </span>

			    </li>

				</ul>

						

					<hr>

					<h5 class="ov_lst_ttl"><b>Equipment Comments <?php  if(!empty($cmnt_data)) echo  '('.count($cmnt_data).')';?> </b></h5>		



					<table class="ov_report_tbl" width="100%">

						<thead>

							<tr>

								<th width="25%">Repair Request Comment</th>

								<th width="32%">Reported Status</th>

								<th width="10%">Reported  Date(AD)</th>

								<th width="10%">Reported  Date(BS)</th>

								<th width="10%">Time</th>

							</tr>

						</thead>

						<tbody>



							<?php

							if(!empty($cmnt_data)){

							foreach($cmnt_data as $valu){?>

							<tr>

								<td><?php echo $valu->eqco_comment;?></td>

								<td><?php if($valu->eqco_comment_status == 1){echo "Approved";}else{ echo "Pending" ;} ?></td>

								<td><?php echo $valu->eqco_postdatead ?></td>

								<td><?php echo $valu->eqco_postdatebs ?></td>

								<td><?php echo $valu->eqco_posttime ?></td>

							</tr>

							<?php } } ?>



						</tbody>

					</table>

					

					<hr>



					<h5 class="ov_lst_ttl"><b>Repair Request <?php  if(!empty($rere_data)) echo '('. count($rere_data).')';?></b></h5>



					<table class="ov_report_tbl" width="100%">

						<thead>

							<tr>

								<th width="12%">PM Notes</th>

								<th width="20%">Reported By</th>

								<th width="20%">Department</th>

								<th width="20%">Problem</th>

								<th width="10%">Date (AD)</th>

								<th width="10%">Date (BS)</th>

								<th width="10%">Time</th>

							</tr>

						</thead>

						<tbody>

							<?php

							if(!empty($rere_data)){

							foreach($rere_data as $val){?>

							<tr>

								<td><?php echo $val->rere_notes;?></td>

								<td><?php echo $val->rere_reported_by;?></td>

								<td><?php echo $val->dept_depname;?></td>

								<td><?php echo $val->rere_problem;?></td>

								<td><?php echo $val->rere_postdatead;?></td>

								<td><?php echo $val->rere_postdatebs;?></td>

								<td><?php echo $val->rere_posttime;?></td>

							</tr>

							<?php } } ?>

						</tbody>

					</table>

					

					<hr>		



					<?php if(!empty($pmdata)){  //echo"<pre>"; print_r($pmdata);die; //pmta?>

					<h5 class="ov_lst_ttl"><b>PM Data</b></h5>

						<table class="pm_data_tbl pm_data" width="100%">

							<thead>

								<tr>

									<th width="12%">PM Remarks</th>

									<th width="20%">PM Status</th>

									<th width="20%">PM Date (AD)</th>

									<th width="20%">PM Date (BS)</th>

									<th width="20%">Is Comp. ?</th>

								</tr>

							</thead>

							<?php  

								foreach($pmdata as $pm):

								$curdate = CURDATE_EN;

								$newDate = !empty($pm->pmta_pmdatead)?$pm->pmta_pmdatead:'';

			                

			                 $newDate = !empty($data->pmta_pmdatead)?$data->pmta_pmdatead:'';

		                    if($newDate < $curdate){

		                        $style = "color:#d00";

		                        $status = "Completed";

		                        $display = "display:none;";

		                    }else{

		                        $style = "color:#0f0";

		                        $status = "Available";

		                        $display = "display:inline-block;";

		                    } ?>

			                 <?php //if($newDate > $curdate):

			                // 	$style = "color:#0f0";

			                //     $status = "Available";

			                ?>

							<tr>			

								<td>

			 						<?php echo $pm->pmta_remarks;?>

								</td>

								<td style="<?php echo $style; ?>">

									<?php echo $status; ?>

								</td>

								<td>

			 						<?php echo $pm->pmta_postdatead;?>

								</td>

								<td>

			 						<?php echo $pm->pmta_postdatead;?>

								</td>

								 <td>

	                    		<?php 

				                    $ispmcomplete=!empty($data->pmta_ispmcompleted)?$data->pmta_ispmcompleted:'0';

				                    $completedatead=!empty($data->pmta_completedatead)?$data->pmta_completedatead:'';

				                    $completedatebs=!empty($data->pmta_completedatebs)?$data->pmta_completedatebs:'';

				                    if(DEFAULT_DATEPICKER=='NP')

				                    {

				                        $compdate=$completedatebs;

				                    }

				                    else

				                    {

				                        $compdate=$completedatead;

				                    }

				                    

				                    if($ispmcomplete=='1'):

				                    echo '<label class="label label-success">Yes</label>';

				                    echo '<br>'.$compdate;

				                    else:

				                    echo '<label class="label label-danger">No</label>';

				                    endif;



				                    ?>

				                </td>

							</tr>

							<?php //endif;?>

							<?php endforeach;?>

						</table>



					<hr>



					<?php }  ?>





					<?php if(!empty($pmcpmpleted)){ ?>

						<h5 class="ov_lst_ttl"><b>PM Complete</b></h5>



						<table class="pm_data_tbl pm_data" width="100%">

							<tr>			

								<td width="50%">

									<b>Description </b>: <?php echo $pmcpmpleted[0]->pmco_description;?>

								</td>

								<td width="50%">

									<b>PM Completed Date (AD) </b>: <?php echo $pmcpmpleted[0]->pmco_postdatead;?>

								</td>

							</tr>

							<tr>

								<td>

									<b>PM Completed Date (BS) </b>: <?php echo $pmcpmpleted[0]->pmco_postdatebs;?>

								</td>

								<td></td>

							</tr>

						</table>



						<hr>	

					<?php } ?>

						

					<?php if(!empty($decom)){ ?>

						<h5 class="ov_lst_ttl"><b>Unrepairable Equipment</b></h5>

						

						<table class="pm_data_tbl pm_data" width="100%">

							<tr>	

								<td width="50%">

									<b>Resoan Disommission </b>: <?php echo $decom[0]->ureq_resoan_disommission;?>

								</td>

								<td>

									<b>End Date (AD) </b>: <?php echo $decom[0]->ureq_postdatead;?>

								</td>

							</tr>

							<tr>	

								<td>

									<b>End Date (BS) </b>: <?php echo $decom[0]->ureq_postdatebs;?>

								</td>

								<td></td>

							</tr>

						</table>

					<?php } ?>

				<!-- this is for assign  -->

				<?php  if($equip_assign): ?>

				<h5 class="ov_lst_ttl"><b> Assign </b></h5>

				<table class="table table-striped dataTable" width="100%">

					<thead>

		            <tr>

		                <th width="10%">Ass.Date (AD)</th>

		                <th width="10%">Ass.Date (BS)</th>

		                <th width="10%">Ent.Date(AD)</th>

		                <th width="10%">Ent.Date(BS)</th>

		                <th width="10%">Time</th>

		                <th width="20%">Assign To</th>

		                <th width="20%">Assign By</th>

		            </tr>

		        </thead>

		        <tbody>

		            <?php 

		            if($equip_assign):

		                foreach ($equip_assign as $eak => $assign):

		                ?>

		                <tr>

		                    <td><?php echo $assign->eqas_assigndatead; ?></td>

		                    <td><?php echo $assign->eqas_assigndatebs; ?></td>

		                    <td><?php echo $assign->eqas_postdatead; ?></td>

		                    <td><?php echo $assign->eqas_postdatebs; ?></td>

		                    <td><?php echo $assign->eqas_posttime; ?></td>

		                    <td><?php echo $assign->stin_fname.' '.$assign->stin_lname; ?></td>

		                    <td><?php echo $assign->usma_username; ?></td>

		                </tr>

		                <?php

		                endforeach;

		            endif;

		            ?>

		        </tbody>

					</table>

				<?php endif; ?>

				<!-- this is for assign  -->

				<?php  if($equip_handover): ?>

				<h5 class="ov_lst_ttl"><b> Handover </b></h5>	

				<table class="table table-striped dataTable" width="100%">

				 <thead>

				 	<tr>

	                <th width="10%">Date (AD)</th>

	                <th width="10%">Date (BS)</th>

	                <th width="10%">Time</th>

	                <th width="15%">Handover From</th>

	                <th width="15%">Handover To</th>

	                <th width="15%">Entry Date(AD)</th>

	                <th width="15%">Entry Date(BS)</th>

	                <th width="15%">Handover By</th>

            	</tr>

		        </thead>

		        <tbody>

		            <?php 

		                foreach ($equip_handover as $kh => $handover):

		                ?>

		            <tr>

		                <td><?php echo $handover->eqas_handoverdatead; ?></td>

		                <td><?php echo $handover->eqas_handoverdatebs; ?></td>

		                <td><?php echo $handover->eqas_posttime; ?></td>

		                <td><?php echo $handover->stin_fname.' '.$handover->stin_lname; ?></td>

		                <td><?php echo $handover->hstin_fname.' '.$handover->hstin_lname; ?></td>

		                <td><?php echo $handover->eqas_postdatead; ?></td>

		                <td><?php echo $handover->eqas_postdatebs; ?></td>

		                <td><?php echo $handover->husma_username; ?></td>

		                

		            </tr>

		           <?php 

		        endforeach; 

		             ?>

		         </tbody>

			    </table>

			    <?php endif; ?>

			    <?php if(!empty($amc_data)){ ?>

					<h5 class="ov_lst_ttl"><b>AMC</b></h5>

					<table class="pm_data_tbl pm_data dataTable" width="100%">

					<thead>

						<tr>

							<th width="10%">AMC Date(AD)</th>

							<th width="10%">AMC Date(BS)</th>

							<th width="25%">Remarks</th>

							<th width="10%">Time</th>

						</tr>

					</thead>

						<?php foreach($amc_data as $key => $am) { ?>

						<tr>

							<td><?php echo $am->amta_amcdatead;?></td>

							<td><?php echo $am->amta_amcdatebs;?></td>

							<td><?php echo $am->amta_remarks;?></td>

							<td><?php echo $am->amta_posttime;?></td>

						</tr>

						<?php } ?>

					</table>

					<?php } ?>

				</div>

				

			</div>

		</div>

		<div id="maintainance" class="tab-pane fade">

			<h5 class="ov_lst_ttl"><b>Maintanance Log (<?php if(!empty($maintenance_data) && is_array($maintenance_data)) echo sizeof($maintenance_data);?>)</b></h5>

			<a href="javascript:void(0)" class="btn btn-primary maintainanceModel" data-equipid="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>" data-pmtaid="<?php echo !empty($eqli_data[0]->pmta_pmtableid)?$eqli_data[0]->pmta_pmtableid:'';?>">

				+

			</a>



			<?php

				//$this->load->view('bio_medical_inventory/v_maintenamcelog_modal');

			?>

			<div class="table-responsive">

				<table class="table table-striped dataTable" width="100%">

					<thead>

						<tr>

							<th width="5%">S.N.</th>

							<th width="25%">Equipment</th>

							<th width="25%">Equipment Code</th>

							<th width="25%">Department</th>

							<th width="25%">Maintained By</th>

											

					 	    <th width="25%">Comment</th>

							

							<th width="25%">Comment Date AD</th>

							<th width="25%">Comment Date BS</th>

							<th width="25%">Time</th>

                             <th width="25%">Remark</th>	

						



							

							

						</tr>

					</thead>

					<tbody>



						<?php

						if(!empty($maintenance_data)){

						foreach($maintenance_data as $key=>$valu){?>

						<tr>

							<td><?php echo $key+1; ?></td>

							<td><?php echo $valu->eqli_description; ?></td>

							<td><?php echo $valu->bmin_equipmentkey; ?></td>

							<td><?php echo $valu->dept_depname; ?></td>

							

						   <td><?php echo $this->session->userdata('user_name'); ?></td>



							<td><?php echo $valu->malo_comment; ?></td>

							<td><?php echo $valu->malo_postdatead; ?></td>

							<td><?php echo $valu->malo_postdatebs; ?></td>

							<td><?php echo $valu->malo_time; ?></td>

							<td><?php echo $valu->malo_remark; ?></td>

							

						</tr>

						<?php } } ?>



					</tbody>

				</table>

			</div>



		</div>

	</div>

</div>







<div id="maintenanceModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-md">

        <!-- Modal content-->

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <h4 class="modal-title">Maintenance Log Form</h4>

            </div>

            <div class="modal-body">

                <form method="post" id="FormMaintenance" action="<?php echo base_url('biomedical/Bio_medical_inventory/save_maintenance'); ?>"  class="form-material form-horizontal form">

                    <div class="form-group mbtm_0">



                  <!--  <div class="col-md-4">

							<label for="example-text">Department :

							</label>

							<?php $department= !empty($eqli_data[0]->malo_depid)?$eqli_data[0]->malo_depid:''; ?>

							<select class="form-control" name="malo_depid" autofocus="true" id="malo_depid">

							<option value="">---select----</option>

							<?php

							if($dep_data): 

							foreach ($dep_data as $ket => $dep):

							?>

							<option value="<?php echo $dep->dept_depid; ?>" <?php if($department==$dep->dept_depid) // echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>

							<?php endforeach; endif; ?>

							</select>

							</div> -->



	

				<!-- <div class="col-md-4">



                	<label for="example-text">Equipment:</label>



                	<select name="malo_equipid" class="form-control" id="malo_equipid">



                  	<option value="">---select---</option>



                	</select>



              		</div> -->





              	<!-- <div class="col-md-4">



                	<label for="example-text">Equipment Code:</label>



                	<select name="malo_eqicode" class="form-control" id="malo_eqicode">



                  	<option value="">---select---</option>



                	</select>



              		</div> -->



              	<div class="col-md-4">

              			<label for="example-text">Equipment Code:</label>

              			 <?php 

                               if($equipment_data)

                               	{

                               		foreach ($equipment_data as $key => $value) {

                               			$equipment_name=$value->eqli_description;

                               			$equipment_code=$value->bmin_equipmentkey;

                               		}

                               	}

                               	?>



              			 <input  name="malo_equip_code" class="form-control"  value="<?php echo !empty($equipment_code)?$equipment_code:''; ?>" readonly='true' id="malo_equip_code">



              	</div>



              	<div class="col-md-4">

              			<label for="example-text">Equipment:</label>

              			 

                                   

              			 <input  name="malo_equip_name" class="form-control"  value="<?php echo !empty($equipment_name)?$equipment_name:''; ?>" readonly='true' id="malo_equip_name">



              	</div>



							

				





                        <div class="col-md-12">

                            <label>Problem: </label>

                            <textarea style="width: 100%;height: 50px;" name="malo_comment" class="form-control" autofocus="true"></textarea>

                            

                        </div>

                         <div class="col-md-12">

                            <label>Tentative Solution: </label>

                            <textarea style="width: 100%;height: 50px;" name="malo_remark" class="form-control" autofocus="true"></textarea>

                       </div>



                          <div class="col-md-4">







                              <label for="example-text"> Time: </label>



                              <?php $a=$this->general->get_currenttime();



                                   $time=date("h:i a",strtotime($a));?>



                              <input  name="malo_time" class="form-control time"  value="<?php echo !empty($customer_query_data[0]->malo_time)?$customer_query_data[0]->malo_time:$time; ?>" id="cuqu_time">







                              </div>

                         <div class="col-md-4">

                        <label>Maintained Date: </label>

                        <input type="text" name="malo_commentdatead" id="malo_commentdatead" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE ?>"/>

                    </div>

                      <!-- <div class="col-md-4">

                        <label>Maintained Time: </label>

                        <input type="text" name="malo_time" id="malo_time" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php $get_currenttime; ?> "/>

                    </div> -->

                    <input type="hidden" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:''; ?>" name="malo_equipid" id="eqco_eqid"/>





                        <div class="col-sm-12">

                            <button type="submit" class="btn btn-info savelist mtop_10" data-isdismiss="Y" >Save</button>

                            <div  class="alert-success success"></div>

                            <div class="alert-danger error"></div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>





<script>

	



	$(document).off('click','#barcodePrint');

	$(document).on('click','#barcodePrint',function(){

		// alert('test');

		$('.printBox').printThis();

	});

</script>



<script type="text/javascript">

	$(document).off('click','.isCompletePm');

	$(document).on('click','.isCompletePm',function(){

	    var equipid = $(this).data('equipid'); 

	    var pmtaid = $(this).data('pmtaid');

	    //alert(equipid);

	    $('#equiPid').val(equipid);

	    $('#pmtatable').val(pmtaid);

	    $.ajax({

	        type: "POST",

	        url: base_url + 'home/get_repair_data',

	        data:{equipid:equipid, pmtaid:pmtaid},

	        dataType: 'json',

	        success: function(datas) {

	          	$('#pmCompletedModal').modal('show');

	          	if(datas.status=='success') {

	             	$('.resultrRepairComment').html(datas.tempform);

	          	}

	        }

	    });

	});



	$(document).off('click','.repairComments');

	$(document).on('click','.repairComments',function(){

		$('#repairCommentModal').modal('show');

	});







</script>



<script type="text/javascript">

		$(document).off('click','.maintainanceModel');

	$(document).on('click','.maintainanceModel',function(){

		//alert('hello');

		$('#maintenanceModal').modal('show');

	});



</script>



<script type="text/javascript">

    $(document).off('click','.btnHandover');

    $(document).on('click','.btnHandover',function(){

      

      var id=$(this).data('equipid');

      var departmentid=$(this).data('equipdepid');

      var roomid=$(this).data('equiproomid');

      var assignid=$(this).data('eqas_equipmentassignid');

      var staffcode=$(this).data('staffcode');

      var staffname=$(this).data('staffname');

      var action=base_url+'biomedical/assign_equipement/get_equipment_handover_detail';

      // alert(url);



     $('#equipHandover').modal('show');



        $.ajax({

          type: "POST",

          url: action,

          data:{id:id,departmentid:departmentid,roomid:roomid,assignid:assignid,staffcode:staffcode,staffname:staffname},

          dataType: 'html',

          beforeSend: function() {

            $('.overlay').modal('show');

          },

        success: function(jsons) 

          {



         data = jQuery.parseJSON(jsons);   

        // alert(data.status);

        if(data.status=='success')

        {

        

          $('.displyblock').html(data.tempform);

        }  

       

       else{

        alert(data.message);

       }

       $('.overlay').modal('hide');

     }

       });



  });





</script>



<script type="text/javascript">

   $(document).off('click','.btnsaveHandover');

  $(document).on('click','.btnsaveHandover',function(){

    var equipid =$('#equipid').val();

    var assignid =$('#assignid').val();

    var staffcode =$('#staffcode').val();

    var staffname =$('#staffname').val();

    var assigndate=$('#assigndate').val();

    var staffid =$('#staffid').val();

    var staffdepid =$('#staffdepid').val();

    var staffroomid =$('#staffroomid').val();



   





    if(staffcode =='')

    {

      $('#staffcode').focus();

      return false;

    }

    if(staffname =='')

    {

      $('#staffname').focus();

      return false;

    }

    if(assigndate =='')

    {

      $('#assigndate').focus();

      return false;

    }



  var action=base_url+'biomedical/assign_equipement/save_equipment_handover';

   $.ajax({

          type: "POST",

          url: action,

          data:{equipid:equipid,assigndate:assigndate,staffid:staffid,staffdepid:staffdepid,staffroomid:staffroomid,assignid:assignid},

          dataType: 'html',

          beforeSend: function() {

            $('.overlay').modal('show');

          },

        success: function(jsons) 

          {

            data = jQuery.parseJSON(jsons);   

        // alert(data.status);

            $('#ResponseSuccess').html('');

            if(data.status=='success')

            {

               $('#ResponseSuccess').html(data.message);

           

                setTimeout(function(){

                   $('#equipHandover').modal('hide');

                 },800);



                 setTimeout(function(){

                  $('#searchPmdata').click();

                 },1000);

              

            } 

            else{

            alert(data.message);

           } 

              $('.overlay').modal('hide');

          }

       });

  })

</script>



<script>

    $(document).off('click','.nepdatepicker');

    $(document).on('click','.nepdatepicker',function(){

        $('.nepdatepicker').nepaliDatePicker();

    });



 //    $('#tab_selector').on('change', function (e) {

	//     $('.form-tabs li a').eq($(this).val()).tab('show');

	// });













	   $(document).on('change','#malo_depid',function() {



        var malo_depid = $(this).val(); 



        var action = base_url+'/biomedical/reports/get_department_equipment';



          $.ajax({



          type: "POST",



          url: action,



          data:{malo_depid:malo_depid},



          dataType: 'json',



        success: function(datas) 



          {



            // console.log(datas);



            var opt='';



                opt='<option value="">---select---</option>';



                $.each(datas,function(i,k)



                {



                  opt += '<option value='+k.bmin_equipid+'>'+k.eqli_description+'</option>';



                });



          $('#malo_equipid').html(opt);



          }



      });



    })









	   $(document).on('change','#malo_equipid',function() {



        var malo_equipid = $(this).val(); 



        var action = base_url+'/biomedical/reports/get_equipment_code';



          $.ajax({



          type: "POST",



          url: action,



          data:{malo_equipid:malo_equipid},



          dataType: 'json',



        success: function(datas) 



          {



            // console.log(datas);



            var opt='';



                opt='<option value="">---select---</option>';



                $.each(datas,function(i,k)



                {



                  opt += '<option value='+k.bmin_equipid+'>'+k.bmin_equipmentkey+'</option>';



                });



          $('#malo_eqicode').html(opt);



          }



      });



    })

</script>











