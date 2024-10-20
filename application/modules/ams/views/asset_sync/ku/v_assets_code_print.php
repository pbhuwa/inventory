<?php 

$schoolid=$this->input->post('schoolid');

 $school_result=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$schoolid),'loca_name','ASC'); 

               if(!empty($school_result)){

                $schoolname= !empty($school_result[0]->loca_code)?$school_result[0]->loca_code:'';

               }



$asen_depid= $this->input->post('asen_depid');

if(!empty($asen_depid)){

	$depresult=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$asen_depid[0]));

	if(!empty($depresult)){

		$depname=!empty($depresult[0]->dept_assetcode)?$depresult[0]->dept_assetcode:'';

	}

}

// echo $depname;

// die();



$asen_desc=$this->input->post('asen_desc');



$asen_assetcode=$this->input->post('asen_assetcode');

if(!empty($asen_assetcode)):

	foreach($asen_assetcode as $ak=>$acode):

		$asscode=$asen_assetcode[$ak];



		$qr_link=ASSETS_QR_CODE_URL.'/'.'ams/assets_overview?asscode='.$asscode;

 ?>

<div class="" style=" height:100%;">

							<div class="" style="padding:8px 0;margin:0;text-align: center;display: flex;justify-content: space-around;align-items: center;">

							<?php         

					            Zend_Barcode::render('code128', 'image', array('text'=>$asscode,'barHeight'=>50,'factor'=>4, 'drawText' => false, 'font'=>4), array());

					            $buffer = ob_get_contents();

					           

					            // return $buffer;

					            ob_end_clean();

					        ?>

					        <div style="width: 82%">

					        <p style="font-size: 12px; padding:0; margin: 0px;  font-weight: 600; "><?php echo ORGNAME;?></p>

					        <p style="font-size:10px;padding:  ; margin: 0px; font-weight: 600; "><?php echo $schoolname; ?></p>

							<p style="font-size:10px;padding: 0 ; margin: 0px; font-weight: 600;"><?php echo $depname; ?></p>

							<p style="font-size:10px;padding:0; margin: 0px; font-weight: 500;"><?php echo $asen_desc; ?></p>

					        <div style="padding-top:3px;  ">

					            

					            <p style="font-size:12px;padding: 0px; margin: 0px; font-weight: 700;"><?php echo $asscode; ?></p>

					            

					            <?php echo "<img src='data:image/png;base64," . base64_encode( $buffer )."'>"; ?>

					        </div>

					    </div>

					        <div >

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

						</div>

	</div>

<?php endforeach; endif; ?>