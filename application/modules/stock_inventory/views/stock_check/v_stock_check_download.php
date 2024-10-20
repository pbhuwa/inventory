<style type="text/css">
    .format_pdf thead tr th{
        border: 1px solid;
    }
    .format_pdf tbody tr td{
        border: 1px solid;
    }
</style>
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>


<table width="100%" style="font-size:12px;" >
    <tr>
        <td colspan="3" style="text-align: center;">
            <span style="font-size:15px;font-weight: bold;text-decoration: underline;"> 
                <?php echo $this->lang->line('stock_check'); ?>
            </span>
        </td>
    </tr>
</table>
<table id="" class="format_pdf" width="100%" style="border: 1px solid;" cellspacing="0">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="30%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if($searchResult): 
            $i=1;
            foreach ($searchResult as $key => $stock):
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($stock->itemcode)?$stock->itemcode:'';?></td>
            <td><?php echo !empty($stock->itemname)?$stock->itemname:'';?></td>
        </tr>
        <?php
            $i++;
            endforeach;
        endif;
        ?>
    </tbody>
</table>