<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">Stock Requisition</h3>
            <div  id="FormDiv_item" class="formdiv frm_bdy">
                <?php $this->load->view('stock/v_stockrequisition_form');?>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="white-box">
            <div id="TableDiv">
                <?php $this->load->view('stock/v_stockrequisition_list');?>
            </div>
        </div>
    </div>
</div>