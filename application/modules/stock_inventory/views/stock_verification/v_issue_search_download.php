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
    <td width="210px"></td>
    <td width="210px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u>Stock Verification Issue  </u></b> </td>
            </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
                    <th width="5%">S.No</th>
                    <th>Item Code</th>
                    <th>Item Names</th>
                    <th>Unit Name</th>
                    <th>Quantity</th>  
                    <th>Rate</th>  

                    <th>Amount</th>        
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $result): 
          
          if(ITEM_DISPLAY_TYPE=='NP'){
                  $rec_itemname = !empty($result->itli_itemnamenp)?$result->itli_itemnamenp:$result->itli_itemname;
                }else{ 
                    $rec_itemname = !empty($result->itli_itemname)?$result->itli_itemname:'';
                }


        ?>
        <tr>
            <td><?php echo $key+1;?></td>
			<td><?php echo $result->itli_itemcode; ?></td>
			<td><?php echo $rec_itemname; ?></td>
			<td><?php echo $result->unit_unitname; ?></td>
			<td><?php echo $result->qty; ?></td>
      <td align="right"><?php echo number_format($result->rate,2); ?></td>

			<td align="right"><?php echo number_format(($result->qty*$result->rate),2); ?></td>
               

        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>