<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('direct_purchase'); ?></h3>
            <div  id="FormDiv_DirectReceive" class="formdiv frm_bdy">
                <?php $this->load->view('purchase/v_purchase_form');?>
            </div>
        </div>
    </div>
    <!-- <div class="col-sm-12">
        <div class="white-box">
                <?php //$this->load->view('purchase/v_purchase_lists');?>
        </div>
    </div> -->
</div>