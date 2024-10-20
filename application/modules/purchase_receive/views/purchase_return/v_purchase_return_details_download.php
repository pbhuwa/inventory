 <style type="text/css">
   .table-striped thead tr th {
    border: 1px solid;
   }
    .table-striped tbody tr td {
    border: 1px solid;
   }
 </style>
 <div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>
      
<div class="table-responsive">
  <table  class="table table-striped alt_table" width="100%" style="border: 1px solid;" cellspacing="0">
    <thead>
                <tr>
                    <th width="2%" style="text-align: center"><?php echo $this->lang->line('sn'); ?>
                    </th>
                      <th width="6%" style="text-align: center"><?php echo $this->lang->line('return_date_bs'); ?>
                  </th>
                   <th width="6%" style="text-align: center"><?php echo $this->lang->line('fiscal_year'); ?>
                    </th>
                     <th width="10%" style="text-align: center"><?php echo $this->lang->line('supplier'); ?> 
                    </th>
                     <th width="10%" style="text-align: center"><?php echo $this->lang->line('invoice_no'); ?> 
                    </th>
                       
                    <th width="4%" style="text-align: center"><?php echo $this->lang->line('receipt_no'); ?> 
                    </th>
                   

                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('item_name'); ?>
                    </th>

                   

                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('unit'); ?>
                    </th>
                    
                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('qty'); ?>
                    </th>
                     <th width="5%" style="text-align: center"><?php echo $this->lang->line('rate'); ?>
                    </th>
                    
                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('dis_amt'); ?>
                    </th>

                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('tax_amount'); ?>
                    </th>
                    
                    <th width="7%" style="text-align: center"><?php echo $this->lang->line('grand_total'); ?>
                    </th>
                   
                </tr>
            </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        $sum_total=0;
        $sum_disamt=0;
        $sum_vatamt=0;
        $sum_gtotal=0;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->purr_returndatebs)?$row->purr_returndatebs:'';?></td> 
            <td><?php echo !empty($row->purr_fyear)?$row->purr_fyear:'';?></td> 
             <td><?php echo !empty($row->dist_distributor)?$row->dist_distributor:'';?></td> 
             <td><?php echo !empty($row->purr_invoiceno)?$row->purr_invoiceno:'';?></td> 
              <td><?php echo !empty($row->purr_receiptno)?$row->purr_receiptno:'';?></td>
            <td><?php echo !empty($row->itli_itemname)?$row->itli_itemname:'';?></td>
             <td><?php echo !empty($row->unit_unitname)?$row->unit_unitname:'';?></td>
            <td><?php echo !empty($row->prde_returnqty)?$row->prde_returnqty:'';?></td>
            <td style="text-align: right;"><?php echo !empty($row->prde_purchaserate)?$row->prde_purchaserate:'';?></td>
           

            <td style="text-align: right;"><?php echo $disamt=  !empty($row->purr_discount)?$row->purr_discount:'0'; $sum_disamt +=$disamt; ?></td>
            <td style="text-align: right;"><?php echo $vat_amt=  !empty($row->purr_vatamount)?$row->purr_vatamount:''; $sum_vatamt +=$vat_amt;?></td>
            <td style="text-align: right;"><?php echo $grand_total=  !empty($row->purr_returnamount)?$row->purr_returnamount:''; $sum_gtotal +=$grand_total; ?></td>

        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="10">Grand Total</th>
       <!--  <th><?php echo $sum_total;  ?></th> -->
        <th><?php echo !empty($sum_disamt)?$sum_disamt:0;  ?></th>
        <th><?php echo !empty($sum_vatamt)?$sum_vatamt:0;  ?></th>
        <th><?php echo !empty($sum_gtotal)?$sum_gtotal:0;  ?></th>
      </tr>

    </tfoot>
</table>
</div>
</div>
</div>


