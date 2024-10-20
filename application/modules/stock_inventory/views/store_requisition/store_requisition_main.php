<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('store_requisition_entry'); ?></h3>
            <div  id="FormDiv_item" class="formdiv frm_bdy">
                <?php $this->load->view('store_requisition/store_requisition_form');?>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="white-box">
            <div id="TableDiv">
                <?php $this->load->view('store_requisition/store_requisition_list');?>
            </div>
        </div>
    </div>
</div>