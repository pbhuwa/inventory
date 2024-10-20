<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('direct_purchase'); ?></h3>
			<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">
	            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
	                <?php $this->load->view('purchase/v_direct_purchase_form');?>
	            </div>
			</div>
        </div>
    </div>
</div>