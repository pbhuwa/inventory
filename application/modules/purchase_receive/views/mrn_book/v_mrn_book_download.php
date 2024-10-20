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
        <td width="130px"></td>
        <td width="130px"></td>
        <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('mrn_purchase_detail'); ?>  </u></b> </td>
    </tr>
      </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th><?php echo $this->lang->line('mrn'); ?></th>
            <th ><?php echo $this->lang->line('date'); ?></th>
            <th ><?php echo $this->lang->line('order_no'); ?></th>
            <th><?php echo $this->lang->line('bill_no'); ?></th>
            <th><?php echo $this->lang->line('bill_date'); ?></th>
            <th ><?php echo $this->lang->line('supplier_name'); ?></th>
            <th ><?php echo $this->lang->line('amount'); ?> </th>
            <th ><?php echo $this->lang->line('discount'); ?> </th>
            <th ><?php echo $this->lang->line('vat'); ?> </th> 
            <th ><?php echo $this->lang->line('net_amount'); ?> </th> 
            <th ><?php echo $this->lang->line('user'); ?> </th> 
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending):   //echo"<pre>"; print_r($searchResult);die;
        ?>
        <tr>

            <td><?php echo $key+1;?></td>
			<td><?php echo $pending->recm_invoiceno; ?></td>
			<td><?php echo $pending->recm_receiveddatebs; ?></td>
			<td><?php echo $pending->recm_purchaseorderno; ?></td>
			<td><?php echo $pending->recm_supplierbillno; ?></td>
			<td><?php echo $pending->recm_supbilldatebs; ?></td>
            <td><?php echo $pending->dist_distributor; ?></td>
            <td><?php echo $pending->recm_amount; ?></td>
            <td><?php echo $pending->recm_discount; ?></td>
            <td><?php echo $pending->recm_taxamount; ?></td>
			<td><?php echo $pending->recm_clearanceamount; ?></td>
            <td><?php echo $pending->usma_username; ?></td>
			
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>