 <style type="text/css">
     
     .table-striped thead tr th {
        border: 1px solid;
     }
    .table-striped tbody tr th {
        border: 1px solid;
     }
 </style>
 <div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
     
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>
      

<div class="table-responsive">
  <table  class="table table-striped alt_table" width="100%" style="border:1px solid;" cellspacing="0">
    <thead>
                <tr>
                    <th width="2%" style="text-align: center"><?php echo $this->lang->line('sn'); ?>
                    </th>
                      <th width="6%" style="text-align: center"><?php echo $this->lang->line('received_date'); ?>
                       <th width="6%" style="text-align: center"><?php echo $this->lang->line('bill_date'); ?>
                    <th width="4%" style="text-align: center"><?php echo $this->lang->line('order_no'); ?> 
                    </th>
                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('supplier'); ?> 
                    </th>

                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('item_name'); ?>
                    </th>

                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('fiscal_year'); ?>
                    </th>

                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('unit'); ?>
                    </th>
                    
                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('qty'); ?>
                    </th>
                     <th width="5%" style="text-align: center"><?php echo $this->lang->line('rate'); ?>
                    </th>
                     <th width="5%" style="text-align: center"><?php echo $this->lang->line('total'); ?>
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
        $sum_gtotal=0;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->recm_receiveddatebs)?$row->recm_receiveddatebs:'';?></td> 
            <td><?php echo !empty($row->recm_supbilldatebs)?$row->recm_supbilldatebs:'';?></td> 
             <td><?php echo !empty($row->recm_purchaseorderno)?$row->recm_purchaseorderno:'';?></td> 
             <td><?php echo !empty($row->dist_distributor)?$row->dist_distributor:'';?></td> 
              <td><?php echo !empty($row->recm_fyear)?$row->recm_fyear:'';?></td>
            <td><?php echo !empty($row->itli_itemname)?$row->itli_itemname:'';?></td>
             <td><?php echo !empty($row->unit_unitname)?$row->unit_unitname:'';?></td>
            <td><?php echo !empty($row->recd_purchasedqty)?$row->recd_purchasedqty:'';?></td>
            <td style="text-align: right;"><?php echo !empty($row->recd_unitprice)?$row->recd_unitprice:'';?></td>
             <td style="text-align: right;"><?php echo  $total= !empty($row->total)?$row->total:'0'; $sum_total +=$total; ?></td>

            <td style="text-align: right;"><?php echo $disamt=  !empty($row->recd_discountamt)?$row->recd_discountamt:''; $sum_disamt +=$disamt; ?></td>
            <td style="text-align: right;"><?php echo $vat_amt=  !empty($row->recd_vatamt)?$row->recd_vatamt:''; $sum_vatamt +=$vat_amt;?></td>
            <td style="text-align: right;"><?php echo $grand_total=  !empty($row->recd_amount)?$row->recd_amount:''; $sum_gtotal +=$grand_total; ?></td>

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
        <th><?php echo $sum_total;  ?></th>
        <th><?php echo $sum_disamt;  ?></th>
        <th><?php echo $sum_vatamt;  ?></th>
        <th><?php echo $sum_gtotal;  ?></th>
      </tr>

    </tfoot>
</table>
</div>
</div>
</div>


