<div class="searchWrapper">
    <form id="purchase_mrn_search_form">
        <div class="form-group">
            <div class="row">
                <?php echo $this->general->location_option(2,'locationid'); ?>
                <div class="col-md-2">
                    <label><?php echo $this->lang->line('fiscal_year'); ?></label>
                    <select name="fiscalyrs" class="form-control">
                        <?php 
                        if(!empty($fiscalyrs)):
                            foreach ($fiscalyrs as $kfy => $fyrs):
                        ?>
                        <option value="<?php echo $fyrs->fiye_name; ?>"><?php echo $fyrs->fiye_name ?></option>
                        <?php
                            endforeach;
                        endif; 
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="purchase_receive/report_format/report_generate/<?php echo $report_type; ?>"><?php echo $this->lang->line('search'); ?></button></button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $this->load->view('v_common_field'); ?>