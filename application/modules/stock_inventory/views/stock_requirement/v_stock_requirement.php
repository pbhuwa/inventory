<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><th width="10%"><?php echo $this->lang->line('stock_requirement'); ?></h3>
            <div id="FormDiv_StockRequirement" class="formdiv frm_bdy">
                <?php
                	$data = $stock_requirement_list;
                	$this->load->view('stock_requirement/v_stock_requirement_list',$data);
                ?>
            </div>
        </div>
    </div>
</div>