<?php

if (count($assets_data)) :
    $schoolid = $item_details[0]->recm_school;

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
    $asen_depid =  $item_details[0]->recm_departmentid;
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



    $asen_desc = $assets_data[0]->itli_itemname;



    // $asen_assetcode = $assets_data[0]->asen_assetcode;

    // if (!empty($asen_assetcode)) :

    foreach ($assets_data as $ak => $acode) :

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

                <div style="width: 85%; margin-left: 5px">

                    <p style="font-size: 12px; padding:0; margin: 0px;  font-weight: bold; "><?php echo ORGNAME; ?></p>
                    <?php if(empty($sub_depname)): ?>
                    <p style="font-size:10px;padding:  0;line-height: 1.3; margin: 0px; font-weight: bold; "><?php echo strtoupper($this->general->string_limit($schoolname,28)); ?></p>
                <?php endif; ?>

                    <?php if(!empty($sub_depname)): ?>
                    <p style="font-size:10px;line-height:1.1;padding: 0 ; margin: 0px; font-weight: bold;"><?php echo strtoupper($this->general->string_limit($sub_depname,30)); ?></p>
                     
                     <?php endif; ?>
                      <?php 
                   if(!empty($dep_parent_dep_name)) { ?>
                    <p style="font-size:10px;padding: 0 ;line-height:1.1;margin: 0px; font-weight: bold;">

                        <?php echo $this->general->string_limit($dep_parent_dep_name,30); ?>
                           
                        </p>
                      <?php } ?>
                      <?php if(empty($sub_depname)):?>
                         <p style="opacity:0;font-size:10px;padding: 0 ;line-height:5px;margin: 0px; font-weight: bold;"> &nbsp;
                        </p>
                    <?php endif; ?>

                    <p style="font-size:10px;line-height:10px;padding:0; margin: 5px 0px 0; font-weight: bold;"><?php echo $this->general->string_limit($asen_desc,27); ?></p>

                    <div style="padding-top:0px;  ">
                        <p style="font-size:11px;line-height:1;padding: 0px; margin: 0px 0 5px; font-weight: 700;"><?php echo $asscode; ?></p>
                        <?php echo "<img src='data:image/png;base64," . base64_encode($buffer) . "'>"; ?>

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

                    echo "<img src='data:image/png;base64," . base64_encode($qr) . "'>";

                    ?>

                </div>

            </div>

        </div>

<?php
    endforeach;
// endif;
endif; ?>