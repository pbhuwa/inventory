<style type="text/css">

    @page  { 

            size: auto;  

            margin: 25mm 25mm 25mm 25mm;  

    } 

    body { 

        margin: 0in;  

    } 



    @media print {

        #print {

             display:none; 

        }



        body * {

            visibility: hidden;

            max-height: 1in;

            max-width: 2in;

        }



        .printBox * {

            visibility: visible;

            max-height: 1in;

            max-width: 2in;

            overflow: hidden;

        }

    }

</style>



<div class="white-box pull-left pad-5">

    <?php 

    // echo"<pre>";

    // print_r($equipmentkeylist);

    // die();



        foreach($equipmentkeylist as $ke=>$equipment):



            $asen_assetcode=$equipmentkeylist[$ke];



            // die('here');

            $orga = explode(" ", ORGA_NAME);

            $acronym = "";



            foreach ($orga as $org) {

                $acronym .= $org[0];

            }



            $asscode = $asen_assetcode;



            // $eqID = explode('-', $asscode);

            // if( $eqID)

            // {

            // $eq_code = !$eqID[0];

            // $eq_number = $eqID[1];

            //    $new_equip_id = $acronym.'-'.$eq_code.'-'.$eq_number;



            // }



         



            // $new_equip_id = $new_equip_id;

            $qr_link= QRCODE_URL.'/assets/reports/overview_report';

            $new_equip_id = $asscode;

            $qr_link = $qr_link.'/'.$asscode;

            $assets_data=$this->general->get_tbl_data('*','asen_assetentry',array('asen_assetcode'=>$asen_assetcode));

            

            $asen_desc = !empty($assets_data[0]->asen_desc)?$assets_data[0]->asen_desc:'';

    ?>

	<div class="printBox" style="padding:5px !important; margin-top:1px; text-align: center; max-width: 2in;max-height:1in">



        <?php         

            Zend_Barcode::render('code128', 'image', array('text'=>$asen_assetcode,'barHeight'=>42,'factor'=>4, 'drawText' => false, 'font'=>4), array());

            $buffer = ob_get_contents();

           

            // return $buffer;

            ob_end_clean();

        ?>

        <div style="max-width: 1.3in; width: 70%; float:left; padding-top:5px; float: left;  ">

        <p style="font-size: 14px; padding: 0px; margin: 0px;  font-weight: 600;"><?php echo ORGANIZATION_NAME;?></p>

        <p style="font-size: 10px; padding: 0px; margin: 0px;  font-weight: 600;"></p>

        <p style="font-size:9px;padding: 0px; margin: 0px; font-weight: 600;"><?php echo $asen_desc; ?></p> 

        

            

            <p style="font-size:9px;padding: 0px; margin: 0px; font-weight: 600; sont-style: itallic;">Code: <?php echo $new_equip_id; ?></p>

            

          

        </div>



        <div style="max-width: 0.7in; width:30%; float:right;">

            <?php

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

    <?php endforeach;?>

    <button class="btn btn-xs btn_print" id="barcodePrint"><i class="fa fa-print"></i></button>

    

</div>

<div class="clearfix"></div>





<script>

	$(document).off('click','#barcodePrint');

	$(document).on('click','#barcodePrint',function(){

		// alert('test');

		$('.printBox').printThis();

	});

</script>