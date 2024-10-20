<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>


<!-- <?php $this->load->view('common/v_report_header_datatable');?> -->

<table class="table_jo_header purchaseInfo" style="width: 100%; text-align: center;" >
    <tr style="text-align: center !important;">
       
        <td class="text-center" >
            <h4 style="text-align: center;">
                <u>
                    <?php echo $this->lang->line('issue_return_analysis'); ?>
                </u>
            </h4>
        </td>
    </tr>
</table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="12%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="12%"><?php echo $this->lang->line('sub_category'); ?> </th>
            <th width="10%"><?php echo $this->lang->line('category'); ?> </th>
            <th width="10%"><?php echo $this->lang->line('department_name'); ?> </th>
            <th width="7%"><?php echo $this->lang->line('return_date'); ?> </th>
            <th width="5%"><?php echo $this->lang->line('invoice_no'); ?> </th>
            <th width="5%"><?php echo $this->lang->line('qty'); ?> </th>
            <th width="5%"><?php echo $this->lang->line('rate'); ?> </th>
            <th width="8%"><?php echo $this->lang->line('amount'); ?> </th>
            <th width="5%"><?php echo $this->lang->line('issue_no'); ?> </th>
            <th width="5%"><?php echo $this->lang->line('batch_no'); ?> </th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $pending->itli_itemcode; ?></td>
            <td><?php echo $pending->itli_itemname; ?></td>
            <td><?php echo $pending->eqca_category; ?></td>
            <td><?php echo $pending->maty_material; ?></td>
            <td><?php echo $pending->dept_depname; ?></td>
            <!-- <td><?php //echo $pending->dept_depname; ?></td> -->
            <td><?php echo $pending->rema_returndatebs; ?></td>
             <td><?php echo $pending->invoiceno_1; ?></td>
             <td><?php echo $pending->rede_qty; ?></td>
            <td><?php echo $pending->rede_unitprice; ?></td>
            <td><?php echo $pending->amount; ?></td>
            <td><?php echo $pending->rede_controlno; ?></td>
            <td><?php echo $pending->rede_invoiceno; ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>