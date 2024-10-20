<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('purchase_mrn'); ?></h3>
            <?php if($mrn_type=='all'): ?>
            <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                <?php $this->load->view('mrn_book/v_mrn_book_list');?>
            </div>
        <?php else:
        ?>
        <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                <?php $this->load->view('mrn_book/v_mrn_book_list_supplier');?>
            </div>
        <?php
        endif; ?>
        </div>
    </div>
</div>