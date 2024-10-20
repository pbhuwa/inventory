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
  <table  class="table table-striped alt_table" width="100%" style="border:1px solid;" cellspacing="0">
    <thead>
                <tr>
                    <th width="2%" style="text-align: center"><?php echo $this->lang->line('sn'); ?>
                    </th>
                      <th width="6%" style="text-align: center"><?php echo $this->lang->line('received_number'); ?>
                       <th width="6%" style="text-align: center"><?php echo $this->lang->line('return_date_bs'); ?>
                    <th width="4%" style="text-align: center"><?php echo $this->lang->line('invoice_no'); ?> 
                    </th>
                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('supplier'); ?> 
                    </th>

                

                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('fiscal_year'); ?>
                    </th>

               
                    
                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('dis_amt'); ?>
                    </th>

                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('tax_amount'); ?>
                    </th>
                     <th width="5%" style="text-align: center"><?php echo $this->lang->line('total'); ?>
                    </th>
                    
                   <!--  <th width="7%" style="text-align: center"><?php echo $this->lang->line('grand_total'); ?>
                    </th> -->
                   
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
            <td><?php echo !empty($row->purr_receiptno)?$row->purr_receiptno:'';?></td> 
            <td><?php echo !empty($row->purr_returndatebs)?$row->purr_returndatebs:'';?></td> 
             <td><?php echo !empty($row->purr_invoiceno)?$row->purr_invoiceno:'';?></td> 
             <td><?php echo !empty($row->dist_distributor)?$row->dist_distributor:'';?></td> 
              <td><?php echo !empty($row->purr_fyear)?$row->purr_fyear:'';?></td>
            
           <!--  <td style="text-align: right;"><?php echo !empty($row->recd_unitprice)?$row->recd_unitprice:'';?></td> -->
            <td style="text-align: right;"><?php echo  !empty($row->purr_discount)?$row->purr_discount:''; ?></td>
            <td style="text-align: right;"><?php echo  !empty($row->purr_vatamount)?$row->purr_vatamount:'';?></td>
             <td style="text-align: right;"><?php echo  $total= !empty($row->purr_returnamount)?$row->purr_returnamount:'0'; $sum_total +=$total; ?></td>

           
           <!--  <td style="text-align: right;"><?php echo $grand_total=  !empty($row->recd_amount)?$row->recd_amount:''; $sum_gtotal +=$grand_total; ?></td>
 -->
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
   <!-- <tfoot>
      <tr>
        <th colspan="10">Grand Total</th>
        <th><?php echo $sum_total;  ?></th>
        <th><?php echo $sum_disamt;  ?></th>
        <th><?php echo $sum_vatamt;  ?></th>
        <th><?php echo $sum_gtotal;  ?></th>
      </tr>

    </tfoot> -->
</table>
</div>
</div>
</div>


