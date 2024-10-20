<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
        <div class="form-group row resp_xs">
            <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
                <table class="table table-striped dt_alt dataTable" id="reqTable" tabindex="1" >
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('item_code'); ?></th>
                            <th><?php echo $this->lang->line('item_name'); ?></th>
                            <th><?php echo $this->lang->line('unit'); ?></th>
                            <th><?php echo $this->lang->line('purchase_rate'); ?></th>
                            <th><?php echo $this->lang->line('qty'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($stock_received)):
                                foreach($stock_received as $stock):
                        ?>
                        <tr>
                            <td><?php echo !empty($stock->itemcode)?$stock->itemcode:'';?></td>
                            <td><?php echo !empty($stock->itemname)?$stock->itemname:'';?></td>
                            <td><?php echo !empty($stock->unitname)?$stock->unitname:'';?></td>
                            <td><?php echo !empty($stock->unitprice)?$stock->unitprice:'';?></td>
                            <td><?php echo !empty($stock->requiredqty)?$stock->requiredqty:'';?></td>
                        </tr>
                        <?php
                                endforeach;
                            endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>