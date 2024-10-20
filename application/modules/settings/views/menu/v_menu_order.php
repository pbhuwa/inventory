<link href="<?php echo base_url().TEMPLATE_CSS ?>elements.css" rel="stylesheet">
    <div class="row">
        <div class="col-sm-10">
            <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('module_order_management'); ?></h3>
                <div id="FormDiv" class="formdiv frm_bdy">
                 <div class="notification"></div>
                    <div class="well">
                    <?=$menus?>                       
                    </div> <!-- .well -->
                </div>
            </div>
        </div>

        <div class="col-sm-2">
         
        </div>
    </div>

 <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>jquery-ui.min.js"></script>
  <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>jquery.mjs.nestedSortable.js"></script>

   
<script type="text/javascript">
    $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 5,

            isTree: true,
            expandOnHover: 700,
            startCollapsed: true,
            update: function() {
                /*var arraied = $(this).nestedSortable('toArray', {startDepthCount: 0});
                alert(arraied);*/
                var order = $(this).nestedSortable("serialize");
                //var order = $(this).nestedSortable('toArray', {startDepthCount: 0});
                $.post(base_url + "/settings/menu/ajax_order", order, function(theResponse){
                    $(".notification").html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">X</button>Menu order updated successfully.</div>');
                });
            }
        });
</script>

