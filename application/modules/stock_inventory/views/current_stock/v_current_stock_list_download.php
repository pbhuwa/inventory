<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>


<table width="100%" style="font-size:12px;">
<tr>
    <td width="25%"></td>
    <td  style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><u><span class="<?php echo FONT_CLASS; ?>" > <?php echo $this->lang->line('current_stock_list'); ?></span></u></h3></td>
                  <td width="25%"></td>
                </tr>

              </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th ><?php echo $this->lang->line('sn'); ?></th>
            <th ><?php echo $this->lang->line('item_code'); ?></th>
            <th ><?php echo $this->lang->line('item_name'); ?></th>
            <th ><?php echo $this->lang->line('unit'); ?> </th>
            <th ><?php echo $this->lang->line('category'); ?></th> 
            <th ><?php echo $this->lang->line('type'); ?> </th>
            <th ><?php echo $this->lang->line('max_limit'); ?> </th>
            <th ><?php echo $this->lang->line('reorder_level'); ?> </th> 
             <th ><?php echo $this->lang->line('at_stock'); ?> </th>
            <th ><?php echo $this->lang->line('summary'); ?></th> 
            <th ><?php echo $this->lang->line('location'); ?></th> 
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending): 
            if($pending->itli_itemcode!=''):
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $pending->itli_itemcode; ?></td>
            <td><?php echo $pending->itli_itemname; ?></td>
            <td><?php echo $pending->unit_unitname; ?></td>
            <td><?php echo $pending->eqca_category; ?></td>
            <td><?php echo $pending->maty_material; ?></td>
            <td><?php echo $pending->itli_maxlimit; ?></td>
            <td><?php echo $pending->itli_reorderlevel; ?></td>
            <td><?php echo sprintf('%g',$pending->totalstock); ?></td>
            <td><?php echo $pending->stockrmk; ?></td>
            <td><?php echo $pending->loca_name; ?></td>
        </tr>
        <?php
        $i++;
    endif;
        endforeach;
        endif;
        ?>
    </tbody>
</table>