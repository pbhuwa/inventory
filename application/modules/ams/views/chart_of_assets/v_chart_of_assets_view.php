
<link href="<?php echo base_url().ASSETS_DIR ?>/common/jstree/themes/default/style.css" rel="stylesheet">
<div id="assets_chart" class="demo">
<?php 
	echo $category_type;
 ?>
</div>


  <script src="<?php echo base_url().ASSETS_DIR.'/'; ?>common/jstree/jstree.js"></script>

  <script type="text/javascript">
  	$('#assets_chart').jstree();
  </script>