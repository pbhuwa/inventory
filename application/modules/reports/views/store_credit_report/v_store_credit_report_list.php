<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
     <?php  $this->load->view('common/v_report_header',$this->data); ?> 
        <?php $year = $this->input->post('year');?>
      <div style="text-align: center; margin-bottom: 10px;" >
       <td style="text-align: center;">Store Credit Report For The Month <span style="text-decoration: underline;"><?php echo $month[0]->mona_namenp; ?></span> year <span style="text-decoration: underline;"><?php echo $year;?></td></span></div>
                  
                <table class="alt_table" width="100%">
                    <thead>
                <tr>
                <th width="10%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                 <th width="15%"><?php echo $this->lang->line('date').$this->lang->line('bs'); ?></th>
             
                <th width="15%"><?php echo $this->lang->line('store'); ?> <?php echo $this->lang->line('credit_no'); ?></th>
              
                <th width="20%"><?php echo $this->lang->line('description'); ?></th>
                <th width="15%"><?php echo $this->lang->line('amount'); ?></th>
                <th width="20%"><?php echo $this->lang->line('remarks'); ?></th>   
               
                </tr>
                    </thead>
                   
                     <tbody>
                
                     <?php
                             $grandtotal=0;
                        if($get_store_credit_report): 
                             

                            foreach ($get_store_credit_report as $km => $store):
                                ?>
                    <tr>
                        <td><?php echo $km+1;?></td>
                        <td><?php echo $store->rema_returndatebs; ?></td>
                        <td><?php echo $store->rema_receiveno; ?></td>
                        <td><?php echo $store->itli_itemname; ?></td>
                        <td align="right"><?php echo number_format($store->gtotal,2); ?></td>
                        <td><?php echo $store->rede_remarks; ?></td>
  
                    </tr>

                    <?php  $grandtotal +=$store->gtotal;
                endforeach;
                         else:
                            ?>
                            <tr>
                                <td colspan="6">&nbsp;</td>
                            </tr>
                            <?php
                          endif;
                     

                    ?>

                    </tbody>
                     <tfoot>
            <tr>
               <td align="right" class="td_cell" colspan="4">
               <?php echo $this->lang->line('total_amount'); ?> :</td>
               <td align="right"><?php echo number_format($grandtotal,2); ?></td>
               <td></td>
            </tr>
         </tfoot>
                </table>
        </div>
    </div>
</div>