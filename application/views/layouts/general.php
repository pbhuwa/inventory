<?php

?>
<?php if (ORGANIZATION_NAME == 'NPHL'): ?>
<?php $this->load->view('common/header_new');?>
<?php else: ?>
<?php $this->load->view('common/header');?>	
<?php endif ?>

<div class="clearfix"></div>



<div class="clearfix"></div>



<?php echo $template['body']; ?>





<div class="clear"></div>




<?php if (ORGANIZATION_NAME == 'NPHL'): ?>

	<?php $this->load->view('common/footer_new');?>
	<?php else: ?>
	<?php $this->load->view('common/footer');?>
<?php endif ?>



