<div class="mtop_15">
    <h3 class="box-title"><?php echo $this->lang->line('convert_items_list'); ?></h3>
    <div class="table-responsive">
        <table id="myTable1" class="table table-striped serverDatatable dataTable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width=5%><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('factor'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!empty($child_convert_items)):
                        foreach($child_convert_items as $key=>$items):
                ?>
                    <tr>
                        <td><?php echo $key+1;?></td>
                        <td><?php echo !empty($items->itli_itemcode)?$items->itli_itemcode:''; ?></td>
                        <td><?php echo !empty($items->itli_itemname)?$items->itli_itemname:''; ?></td>
                        <td><?php echo !empty($items->conv_childqty)?$items->conv_childqty:''; ?></td>
                        <td><?php echo !empty($items->conv_childrate)?$items->conv_childrate:''; ?></td>
                        <td><?php echo !empty($items->amount)?$items->amount:''; ?></td>
                        <td><?php echo !empty($items->conv_factor)?$items->conv_factor:''; ?></td>
                    </tr>
                <?php
                        endforeach;
                    endif;
                ?>
            </tbody>
        </table>
    </div>
</div>