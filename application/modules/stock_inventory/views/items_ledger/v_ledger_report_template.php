<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
        
        <?php $this->load->view('common/v_report_header');?>

        <?php if(!$issuefrequent){ ?>
            <table class="jo_tbl_head">
                <tr>
                    <td>
                        <span style="margin-right: 30px">
                            <strong><?php echo $this->lang->line('item_name'); ?> : </strong>    <?php echo !empty($item_report[0]->itli_itemname)?$item_report[0]->itli_itemname:'';?>
                        </span>
                        
                        <?php 
                            if(!empty($store)):
                                echo !empty($item_report[0]->storename)?"<strong>".$this->lang->line('store').": </strong>".$item_report[0]->storename:'';
                            endif;
                        ?>
                    </td>
                </tr>
            </table>

            <table class="alt_table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Ref.No.</th>
                        <th>Department/Supplier</th>
                        <th>Rec/Pur. Qty</th>
                        <th>Rec/Pur.Rate</th>
                        <th>Qty Issue</th>
                        <th>Iss. Rate</th>
                        <th>Iss. Amt</th>
                        <th>Bal. Qty</th>
                        <th>Bal. Rate</th>
                        <th>Bal. Aamt</th>

                    </tr>
                </thead>
            
                
       
    </div>
