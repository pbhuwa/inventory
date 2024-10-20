<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('department_issue'); ?></h3>
            <div id="dtl_supplier" class="tab-pane fade in active">
                <div  id="FormDiv_departmentissue" class="formdiv frm_bdy">
                        <?php $this->load->view('department_issue/v_department_issue_list');?>
                </div>
            </div>
        </div>
    </div>
</div>
