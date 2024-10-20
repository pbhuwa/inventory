<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('issue_return_analysis'); ?> </h3>
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='detail') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        <?php $this->load->view('issue_return_analysis/v_issue_return_analysis_list');?>
                </div>
            </div>
        </div>
    </div>
</div>
