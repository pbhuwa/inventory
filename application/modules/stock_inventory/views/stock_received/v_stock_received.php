<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('stock_received'); ?></h3>
            <div  id="FormDiv_StockCheck" class="formdiv frm_bdy">
                <?php $this->load->view('stock_received/v_stock_received_list');?>
            </div>
        </div>
    </div>
</div>