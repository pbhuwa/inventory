<table class="format_pdf" width="100%">
    <tr>
        <td colspan="9" style="text-align: center;">
            <h3><?php echo $this->lang->line('item_list'); ?></h3>
        </td>
    </tr>
</table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%" style="text-align: left;"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%" style="text-align: left;"><?php echo $this->lang->line('material_type'); ?></th>
            <th width="15%" style="text-align: left;"><?php echo $this->lang->line('category'); ?></th>
            <th width="10%" style="text-align: left;"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="15%" style="text-align: left;"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="15%" style="text-align: left;"><?php echo $this->lang->line('item_name_np'); ?></th>
            <th width="7%" style="text-align: left;"><?php echo $this->lang->line('purchase_rate'); ?></th>
            <th width="5%" style="text-align: left;"><?php echo $this->lang->line('unit'); ?></th>
            <th width="15%" style="text-align: left;"><?php echo $this->lang->line('item_types'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($searchResult): 
                $i=1;
                foreach ($searchResult as $key => $item):
        ?>
        <tr>
            <td><?php echo $iDisplayStart + $i; ?></td>
            <td><?php echo !empty($item->maty_material)?$item->maty_material:'';?></td>
            <td><?php echo !empty($item->eqca_category)?$item->eqca_category:'';?></td>
            <td><?php echo !empty($item->itli_itemcode)?$item->itli_itemcode:'';?></td>
            <td><?php echo !empty($item->itli_itemname)?$item->itli_itemname:'';?></td>
            <td><?php echo !empty($item->itli_itemnamenp)?$item->itli_itemnamenp:'';?></td>
            <td><?php echo !empty($item->itli_purchaserate)?$item->itli_purchaserate:'';?></td>
            <td><?php echo !empty($item->unit_unitname)?$item->unit_unitname:'';?></td>
            <td><?php echo !empty($item->eqty_equipmenttype)?$item->eqty_equipmenttype:'';?></td>
        </tr>
        <?php
                $i++;
                endforeach;
            endif;
        ?>
    </tbody>
</table>