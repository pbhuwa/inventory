<div id="print_preview" class="tab-pane fade">
			<div id="printrpt" class="pad-5">
				<div class="pull-right pad-btm-5">
					<a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
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