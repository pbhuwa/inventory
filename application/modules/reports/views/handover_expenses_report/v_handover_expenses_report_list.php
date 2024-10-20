<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
     <?php  $this->load->view('common/v_report_header',$this->data); ?> 
        <?php $year = $this->input->post('year');?>
      <div style="text-align: center; margin-bottom: 10px;" >
       <td style="text-align: center;">Handover Expenses Report For The Month <span style="text-decoration: underline;"><?php echo $month[0]->mona_namenp; ?></span> year <span style="text-decoration: underline;"><?php echo $year;?></td></span></div>
                

               
                <table class="alt_table" width="100%">
                    <thead>
                <tr>
                <th width="3%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                 <th width="6%"><?php echo $this->lang->line('date').$this->lang->line('bs'); ?></th>
             
                <th width="10%"><?php echo $this->lang->line('expenses'); ?> <?php echo $this->lang->line('handover_no'); ?></th>
                <th width="5%"><?php echo $this->lang->line('demand'); ?> <?php echo $this->lang->line('location'); ?></th>
                <th width="5%"><?php echo $this->lang->line('description'); ?></th>
                <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
             </tr>
                    </thead>
                     <tbody>
                     <?php
                    //  echo "<pre>";
                    //  print_r($get_handover_expenses_report);
                    //  die();
                        if(!empty($get_handover_expenses_report)): 
                              $grandtotal=0;
                            foreach ($get_handover_expenses_report as $km => $handover):
                                ?>
                    <tr>
                        <td><?php echo $km+1;?></td>
                        <td><?php echo $handover->haov_handoverdatebs; ?></td>
                        <td><?php echo $handover->haov_handoverno; ?></td>
                        <td><?php echo $handover->toloc; ?></td>
                        <td><?php echo $handover->itli_itemname; ?></td>
                        <td align="right"><?php echo $handover->gtotal; ?></td>
                        <td><?php echo $handover->haod_remarks; ?></td>
  
                    </tr>

                    <?php  $grandtotal +=$handover->gtotal;
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
            <tr>
                <td colspan="7">
                    In Word: <?php echo $this->general->number_to_word($grandtotal); ?>
                </td>
            </tr>
         </tfoot>
                </table>
        </div>
    </div>
</div>