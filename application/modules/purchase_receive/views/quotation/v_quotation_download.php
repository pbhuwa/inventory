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
    <td width="215px">
      <td width="215px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('quotation_summary'); ?>  </u></b> </td>
            </table>


<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('quotation_no'); ?></th>
                        <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('quotation_date'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('supplier_date'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('supplier_no'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('valid_till'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('grand_total'); ?></th>
                    
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        
        $i=1;
        foreach ($searchResult as $key => $pending): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
			<td><?php echo $pending->quma_quotationnumber; ?></td>
			<td><?php echo $pending->supp_suppliername; ?></td>
			<td>
         <?php if(DEFAULT_DATEPICKER=='NP')
           {
            echo $pending->quma_quotationdatebs;
          }else{
            $pending->quma_quotationdatead;
           } 
           ?>
           </td>
			<td><?php if(DEFAULT_DATEPICKER=='NP')
           {
            echo $pending->quma_supplierquotationdatebs;
          }else{
            $pending->quma_supplierquotationdatead;
           } 
           ?>
      </td>
			<td><?php echo $pending->quma_supplierquotationnumber; ?></td>
       <td>
         <?php if(DEFAULT_DATEPICKER=='NP')
           {
            echo $pending->quma_expdatebs;
          }else{
            $pending->quma_expdatead;
           } ?>
       </td>
         <td align="right"><?php echo number_format($pending->quma_totalamount,2); ?></td>
         </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>