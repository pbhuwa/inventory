    <div class="col-sm-12">
            <div  id="FormDiv_item" class="formdiv frm_bdy">

 <?php

if (defined('ITEM_FORM')):
	if (ITEM_FORM == 'DEFAULT') {
		$this->load->view('item/v_item_form');
	} else {
		$this->load->view('item/' . REPORT_SUFFIX . '/v_item_form');
	} else :
	$this->load->view('item/' . REPORT_SUFFIX . '/v_item_form');
endif;
?>

            </div>
    </div>
    
<?php if($operation=='add'): ?>
<script type="text/javascript">
	$('.select2').select2();
</script>
<?php endif ?>
