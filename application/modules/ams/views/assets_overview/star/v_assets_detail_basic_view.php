<style type="text/css">
	.search_pm_data ul.pm_data.pm_top li{
		display: inherit;
	}
</style>

<h5 class="ov_lst_ttl"><b>Basic</b></h5>

<ul class="pm_data pm_data_body pm_top">



	<li>

		<label> Asset Location:</label>

		<span><?php echo !empty($assets_rec_data[0]->loca_name) ? $assets_rec_data[0]->loca_name : ''; ?></span>

	</li>



	<li>

		<label> System ID:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_asenid) ? $assets_rec_data[0]->asen_asenid : ''; ?></span>

	</li>



	<li>

		<label>Asset Category:</label>

		<span><?php echo !empty($assets_rec_data[0]->eqca_category) ? $assets_rec_data[0]->eqca_category : ''; ?></span>

	</li>

	<li>

		<label> Asset Code:</label>

		<span><?php echo $ass_code = !empty($assets_rec_data[0]->asen_assetcode) ? $assets_rec_data[0]->asen_assetcode : ''; ?></span>

	</li>

	<li>

		<label> Asset Manual Code:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_assestmanualcode) ? $assets_rec_data[0]->asen_assestmanualcode : ''; ?></span>

	</li>

	<li>

		<label>Parent Asset:</label>

		<span></span>

	</li>



	<li>

		<label> Asset Description:</label>

		<span>

			<?php echo $ass_desc = !empty($assets_rec_data[0]->asen_desc) ? $assets_rec_data[0]->asen_desc : ''; ?>

		</span>

	</li>



	<li>

		<label>Make:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_make) ? $assets_rec_data[0]->asen_make : ''; ?></span>

	</li>



	<li>

		<label>Model No:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_modelno) ? $assets_rec_data[0]->asen_modelno : ''; ?></span>

	</li>

	<li>

		<label>Serial No:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_serialno) ? $assets_rec_data[0]->asen_serialno : ''; ?></span>

	</li>

	<li>

		<label> Asset Status:</label>

		<span><?php echo !empty($assets_rec_data[0]->asst_statusname) ? $assets_rec_data[0]->asst_statusname : ''; ?></span>

	</li>



	<li>

		<label> Asset Condition:</label>

		<span><?php echo !empty($assets_rec_data[0]->asco_conditionname) ? $assets_rec_data[0]->asco_conditionname : ''; ?></span>

	</li>





	<li>

		<label> Accessories:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_accessories) ? $assets_rec_data[0]->asen_accessories : ''; ?></span>

	</li>

	<li>

		<label> Remarks:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_remarks) ? $assets_rec_data[0]->asen_remarks : ''; ?></span>

	</li>

	<li class="eqp_cod">

		<label>Assets Code:</label>


			<?php

			$equipid = !empty($eqli_data[0]->bmin_equipmentkey) ? $eqli_data[0]->bmin_equipmentkey : '';

			$desc = !empty($eqli_data[0]->eqli_description) ? $eqli_data[0]->eqli_description : '';

			$servicedate = !empty($eqli_data[0]->bmin_servicedatead) ? $eqli_data[0]->bmin_servicedatead : '';

			?>



				<?php

if (count($assets_rec_data)) :
    $schoolid = $assets_rec_data[0]->asen_schoolid;

    $school_result = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $schoolid), 'loca_name', 'ASC');
    $loccode = '';
    if (!empty($school_result)) {
        $loccode =!empty($school_result[0]->loca_code) ? $school_result[0]->loca_code : '';
        if($loccode=='KU'){
            $schoolname='Central Office';
        }else{
            $schoolname=!empty($school_result[0]->loca_name) ? $school_result[0]->loca_name : '';
        }
    }
 
    $dep_parent_dep_name='';
    $sub_depname='';
    $asen_depid =  $assets_rec_data[0]->asen_depid;
     $check_parentid=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$asen_depid),'dept_depname','ASC');
        if(!empty($check_parentid)){
              $dep_parentid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
              $dep_parent_dep_name=!empty($check_parentid[0]->dept_depname)?$check_parentid[0]->dept_depname:'';

              if($dep_parentid!=0){
              $sub_department=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$dep_parentid),'dept_depname','ASC');
              if(!empty($sub_department)){
               $sub_depname=!empty($sub_department[0]->dept_depname)?$sub_department[0]->dept_depname:'';
              }
              }   
            }

            // if(!empty($sub_depname)){
            //   echo $sub_depname.'('.$dep_parent_dep_name.')';
            // }else{
            //   echo $dep_parent_dep_name;
            // }
            // die();

    // $asen_depid = $assets_data[0]->asen_depid;
    // echo $asen_depid; 
    // die();
    // if (!empty($asen_depid)) {

    //     $depresult = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $asen_depid));

    //     if (!empty($depresult)) {

    //         $depname = !empty($depresult[0]->dept_depname) ? $depresult[0]->dept_depname : '';
    //     } else {
    //         $depname = '';
    //     }
    // } else {
    //     $depname = '';
    // }

    // echo $depname;

    // die();



    $asen_desc = $assets_rec_data[0]->itli_itemname;



    // $asen_assetcode = $assets_data[0]->asen_assetcode;

    // if (!empty($asen_assetcode)) :

    foreach ($assets_rec_data as $ak => $acode) :

        $asscode = $acode->asen_assetcode;



        $qr_link = ASSETS_QR_CODE_URL . '/' . 'ams/assets_overview?asscode=' . $asscode;

?>

        <div class="" style=" height:100%;">

            <div class="" style="padding:8px 0;margin:0;text-align: center;display: flex;justify-content: space-around;align-items: center;">

                <?php

                Zend_Barcode::render('code128', 'image', array('text' => $asscode, 'barHeight' => 50, 'factor' => 4, 'drawText' => false, 'font' => 4), array());

                $buffer = ob_get_contents();



                // return $buffer;

                ob_end_clean();

                ?>

                <div style="width: 82%">

                    <p style="font-size: 12px; padding:0; margin: 0px;  font-weight: 600; "><?php echo ORGNAME; ?></p>
                    

                    <?php if(!empty($sub_depname)): ?>
                    <p style="font-size:10px;line-height:1.1;padding: 0 ; margin: 0px; font-weight: 600;"><?php echo $this->general->string_limit($sub_depname,30); ?></p>
                     
                     <?php endif; ?>
                      <?php 
                   if(!empty($dep_parent_dep_name)) { ?>
                    <p style="font-size:10px;padding: 0 ;line-height:1.1;margin: 0px; font-weight: 600;">

                        <?php echo $this->general->string_limit($dep_parent_dep_name,30); ?>
                           
                        </p>
                      <?php } ?>
                      <?php if(empty($sub_depname)):?>
                         <p style="opacity:0;font-size:10px;padding: 0 ;line-height:5px;margin: 0px; font-weight: 600;"> &nbsp;
                        </p>
                    <?php endif; ?>

                    <p style="font-size:10px;line-height:10px;padding:0; margin: 5px 0px 0; font-weight: 500;"><?php echo $this->general->string_limit($asen_desc,27); ?></p>

                    <div style="padding-top:0px;  ">
                        <p style="font-size:11px;line-height:1;padding: 0px; margin: 0px 0 5px; font-weight: 700;"><?php echo $asscode; ?></p>
                        <?php echo "<img src='data:image/png;base64,"  . base64_encode($buffer) . "' style='width:100%'>"; ?>

                    </div>

                </div>

                <div>

                    <?php

                    // echo $qr_link;

                    // die();

                    ob_start();

                    header("Content-Type: image/png");

                    $params['data'] = $qr_link;
                    // $params['data']='Department:Test,SADJK SDH';

                    // echo "<pre>";
                    // print_r($params);
                    // die();


                    $this->ciqrcode->generate($params);

                    $qr = ob_get_contents();

                    ob_end_clean();

                    echo "<img src='data:image/png;base64," . base64_encode($qr) . "' style='width:100%'>";

                    ?>

                </div>

            </div>

        </div>

<?php
    endforeach;
// endif;
endif; ?>


				<!-- <button class="btn btn-xs btn_print" id="barcodePrint"><i class="fa fa-print"></i></button> -->



	</li>



</ul>



<h5 class="ov_lst_ttl"><b>General</b></h5>

<ul class="pm_data pm_data_body">

	<li>

		<label> Asset Department:</label>

		<span><?php
            $parentdep=!empty($assets_rec_data[0]->depparent)?$assets_rec_data[0]->depparent:'';
                 if(!empty($parentdep)){
                     $depname = $assets_rec_data[0]->depparent.'/'.$assets_rec_data[0]->dept_depname;    
                    }else{
                        $depname = $assets_rec_data[0]->dept_depname;   
                    }
                    echo $depname;
        ?></span>

	</li>

	<li>

		<label> Asset Room:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_room) ? $assets_rec_data[0]->asen_room : ''; ?></span>

	</li>

	<li>

		<label>Asset Manufacture:</label>

		<span><?php echo !empty($assets_rec_data[0]->manu_manlst) ? $assets_rec_data[0]->manu_manlst : ''; ?></span>

	</li>

	<li>

		<label> Date of Manufacture:</label>

		<span><?php

				if (DEFAULT_DATEPICKER == 'NP') {

					echo !empty($assets_rec_data[0]->asen_manufacture_datebs) ? $assets_rec_data[0]->asen_manufacture_datebs : '';
				} else {

					echo !empty($assets_rec_data[0]->asen_manufacture_datead) ? $assets_rec_data[0]->asen_manufacture_datead : '';
				}

				?></span>

	</li>

	<li>

		<label>Supplier:</label>

		<span><?php echo !empty($assets_rec_data[0]->dist_distributor) ? $assets_rec_data[0]->dist_distributor : ''; ?></span>

	</li>

    <li>
       <label>Purchase Date:</label>
       <span><?php echo !empty($assets_rec_data[0]->asen_purchasedatebs) ? $assets_rec_data[0]->asen_purchasedatebs : ''; ?></span>
    </li>
    <li>
       <label>Purchase Rate</label>
       <span><?php echo !empty($assets_rec_data[0]->asen_purchaserate) ? $assets_rec_data[0]->asen_purchaserate : ''; ?></span>
    </li>
    <li>
       <label>Received By</label>
       <span><?php echo $assets_rec_data[0]->stin_fname.' '.$assets_rec_data[0]->stin_mname.' '.$assets_rec_data[0]->stin_lname ?></span>
    </li>

</ul>