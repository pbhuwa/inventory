<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo " id="printrpt">
     <?php  $this->load->view('common/v_report_header',$this->data); ?> 
      <?php $year = $this->input->post('year');?>
      <div style="text-align: center; margin-bottom: 10px;" >
       <td style="text-align: center;">Purchase Report For The Month <span style="text-decoration: underline;"><?php echo $month[0]->mona_namenp; ?></span> year <span style="text-decoration: underline;"><?php echo $year;?></td></span></div>
                

               
                <table class="alt_table" width="100%">
                    <thead>
                <tr>
                <th width="3%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                 <th width="6%"><?php echo $this->lang->line('date').$this->lang->line('bs'); ?></th>
             
                <th width="10%"><?php echo $this->lang->line('income'); ?> <?php echo $this->lang->line('issue_no'); ?></th>
                <th width="5%"><?php echo $this->lang->line('purchase'); ?> <?php echo $this->lang->line('order_no'); ?></th>
                <th width="5%"><?php echo $this->lang->line('supplier_name'); ?></th>
                <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
           
               
               
                </tr>
                    </thead>
                   

                     <tbody>
                
                     <?php

                        if($get_purchase_report): 
                              $grandtotal=0;
                           

                            foreach ($get_purchase_report as $km => $purchase):
                                ?>
                    <tr>
                        <td><?php echo $km+1;?></td>
                        <td><?php echo $purchase->recm_receiveddatebs; ?></td>
                        <td><?php echo $purchase->recno; ?></td>
                        <td><?php echo $purchase->recm_purchaseorderno; ?></td>
                        <td><?php echo $purchase->dist_distributor; ?></td>
                        <td align="right"><?php echo $purchase->amt; ?></td>
                        <td><?php echo $purchase->recm_remarks; ?></td>
  
                    </tr>

                    <?php  $grandtotal +=$purchase->amt;
                endforeach;
                     
                          endif;
                    ?>
                      
                   
                    </tbody>
                     <tfoot>
            <tr>
               <td align="right" class="td_cell" colspan="5">
               <?php echo $this->lang->line('total_amount'); ?> :</td>
               <td align="right"><?php echo $grandtotal; ?></td>
               <td></td>
            </tr>
         </tfoot>
                </table>
        </div>
    </div>
</div>