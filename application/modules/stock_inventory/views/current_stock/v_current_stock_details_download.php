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
                  <td  style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><u><span class="<?php echo FONT_CLASS; ?>" > <?php echo $this->lang->line('location_wise_item_stock'); ?></span></u></h3></td>
                  <td width="25%"></td>
                </tr>
               <!--  <tr class="title_sub">
                  <td width="25%"></td>
                  <td style="text-align:center;"><b></b></td>
                  <td width="25%" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
                </tr> -->

              </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?></th> 
                    <th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('type'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('at_stock'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('unit_price'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('total_amount'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('date'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('location'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('transaction_type'); ?> </th> 
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
            <td><?php echo $pending->trde_issueqty; ?></td>
            <td><?php echo $pending->trde_unitprice; ?></td> 
            <td><?php echo $pending->trde_issueqty*$pending->trde_unitprice; ?></td>
            <td><?php echo $pending->trde_transactiondatebs; ?></td>
             <td><?php echo $pending->loca_name; ?></td>
            <td><?php echo $pending->trde_transactiontype; ?></td>
        </tr>
        <?php
        $i++;
    endif;
        endforeach;
        endif;
        ?>
    </tbody>
</table>