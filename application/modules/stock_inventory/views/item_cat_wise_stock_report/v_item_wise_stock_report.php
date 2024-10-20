<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('category_wise_stock_report'); ?> </h3>
            <div  id="FormDiv_StockCheck" class="formdiv frm_bdy">
                <?php $this->load->view('item_cat_wise_stock_report/v_item_wise_stock_report_list');?>
            </div>
        </div>
    </div>
</div>