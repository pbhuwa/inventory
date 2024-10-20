
<table class="format_pdf" width="100%">
    <tr>
        <td colspan="6" style="text-align: center;">
            <h3><?php echo $this->lang->line('list_of_items_category'); ?></h3>
        </td>
    </tr>
</table>

<table id="" class="format_pdf" width="100%">
    <thead>
         <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('equipment_type'); ?></th>
            <th width="10%"><?php echo $this->lang->line('equipment_code'); ?></th>
            <th width="20%"><?php echo $this->lang->line('category'); ?></th>
            <th width="20%"><?php echo $this->lang->line('parent_category'); ?></th>
            <th width="15%"><?php echo $this->lang->line('post_date'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($searchResult): 
                $i=1;
                foreach ($searchResult as $key => $category):
        ?>
        <tr>
            <td><?php echo $iDisplayStart + $i; ?></td>
            <td><?php echo !empty($category->eqca_category)?$category->eqca_category:'';?></td>
            <td><?php echo !empty($category->eqca_code)?$category->eqca_code:'';?></td>
            <td><?php echo !empty($category->eqty_equipmenttype)?$category->eqty_equipmenttype:'';?></td>
            <td><?php echo !empty($category->parent_cat)?$category->parent_cat:'';?></td>
            <td>
                <?php
                    if(DEFAULT_DATEPICKER=='NP') {
                        echo !empty($category->eqca_postdatebs)?$category->eqca_postdatebs:'';          
                    }else{
                        echo !empty($category->eqca_postdatead)?$category->eqca_postdatead:'';
                    };
                ?>
            </td>
        </tr>
        <?php
                $i++;
                endforeach;
            endif;
        ?>
    </tbody>
</table>