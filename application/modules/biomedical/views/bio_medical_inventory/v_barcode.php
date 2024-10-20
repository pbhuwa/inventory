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