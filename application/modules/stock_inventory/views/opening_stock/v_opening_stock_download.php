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
    <td width="218px"></td>
    <td width="218px"></td>

    <td class="text-center"><b style="font-size:15px;"> <u>Closing Stock List </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="1%">S.n</th>
            <th width="8%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="12%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%">Material Type</th>
            <th width="15%">Category</th>
         <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="5%"><?php echo $this->lang->line('rate'); ?></th>

            <th width="5%"><?php echo $this->lang->line('amount'); ?></th>
            <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th>
            <th width="5%"><?php echo $this->lang->line('remarks'); ?> </th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        $sum_qty=0;
        $sum_tamount=0.00;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->itli_itemcode)?$row->itli_itemcode:'';?></td>
            <td><?php echo !empty($row->itli_itemname)?ucfirst($row->itli_itemname):'';?></td>
            <td>
                <?php echo !empty($row->maty_material)?$row->maty_material:'';?>
            </td>
            <td>
                <?php echo !empty($row->eqca_category)?$row->eqca_category:'';?>
            </td>
             <td style="text-align: right;"><?php
             $sum_qty +=$row->trde_requiredqty;
              echo !empty($row->trde_requiredqty)? sprintf('%g',$row->trde_requiredqty):'';?></td>
            <td style="text-align: right;"><?php echo !empty($row->trde_unitprice)?$row->trde_unitprice:'';?></td>
           
            <td style="text-align: right;"><?php 
            $total_amt=$row->trde_requiredqty*$row->trde_unitprice;
            echo number_format($total_amt,2); 

             $sum_tamount +=$total_amt;

            ?></td>
            
            <td><?php echo !empty($row->trma_fyear)?$row->trma_fyear:'';?></td>
            <td><?php echo !empty($row->trde_remarks)?$row->trde_remarks:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        ?>
        <tr style="background: black; color: white">
            <td colspan="5">Grand  Total</td>
            <td style="color: white;text-align: right;font-weight: bold;"><?php echo number_format($sum_qty,2); ?></td>
            <td></td>
            <td style="color: white;text-align: right;font-weight: bold;"><?php echo number_format( $sum_tamount,2); ?></td>
            <td></td>
            <td></td>
        </tr>
        <?php
        endif;
        ?>
    </tbody>
</table>

