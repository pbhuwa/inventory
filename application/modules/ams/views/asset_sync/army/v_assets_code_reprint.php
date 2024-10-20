<?php

if (count($assets_data)) :
    

    $asen_desc = $assets_data[0]->itli_itemname;



    // $asen_assetcode = $assets_data[0]->asen_assetcode;

    // if (!empty($asen_assetcode)) :

    foreach ($assets_data as $ak => $acode) :

        $asscode = $acode->asen_assetcode;
        $schoolname = $acode->schoolname;
        $dep_name=$acode->dept_depname;



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
                    <p style="font-size:10px;padding:  0;line-height: 1.3; margin: 0px; font-weight: bold; "><?php echo ORGNAMETITLE; ?></p>
                   
                    <p style="font-size:10px;padding:  0;line-height: 1.3; margin: 0px; font-weight: 600; "><?php echo $this->general->string_limit($schoolname,28); ?></p>
              
                    <?php if(!empty($dep_name)): ?>
                    <p style="font-size:10px;line-height:1.1;padding: 0 ; margin: 0px; font-weight: 600;"><?php echo $this->general->string_limit($dep_name,30); ?></p>
                     
                     <?php endif; ?>
             
                    <p style="font-size:10px;line-height:10px;padding:0; margin: 5px 0px 0; font-weight: 500;"><?php echo $this->general->string_limit($asen_desc,27); ?></p>

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