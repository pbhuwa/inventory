<div class="row">
        <div class="col-sm-6">
            <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('stock_adjustment_details'); ?></h3>
            <div  id="FormDiv_item" class="formdiv frm_bdy">
                <?php $this->load->view('stock_adjustment/stock_adjustment_detail_form');?>
            </div>
        </div>
    </div>

   <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('stock_adjustment_details_list'); ?></h3>
            <div id="TableDiv">
                <?php $this->load->view('stock_adjustment/stock_adjustment_detail_list');?>
            </div>
        </div>
    </div>
</div>