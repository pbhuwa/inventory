<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
     <?php  $this->load->view('common/v_report_header',$this->data); ?> 
        <?php $year = $this->input->post('year');?>
      <div style="text-align: center; margin-bottom: 10px;" >
       <td style="text-align: center;">Job Operation Report For The Month <span style="text-decoration: underline;"><?php echo $month[0]->mona_namenp; ?></span> year <span style="text-decoration: underline;"><?php echo $year;?></td></span></div>
                  
                <table class="alt_table" width="100%">
                    <thead>
                <tr>
                <th width="10%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                 <th width="15%"><?php echo !empty($this->lang->line('job_head'))?$this->lang->line('job_head'):'Job Head'; ?></th>
             
                <th width="15%"><?php echo !empty($this->lang->line('expenses'))?$this->lang->line('expenses'):'Expense'; ?></th>
                <th width="20%"><?php echo $this->lang->line('remarks'); ?></th>   
               
                </tr>
                    </thead>
                   
                     <tbody>
                
                     <?php

                        if($get_job_operation): 
                              $grandtotal=0;
                           

                            foreach ($get_job_operation as $km => $store):
                                $total_amt = $store->unitrate*$store->qty;
                                ?>
                    <tr>
                        <td><?php echo $km+1;?></td>
                        <td><?php echo $store->itli_catid; ?></td>
                        <td><?php echo $total_amt; ?></td>
                        <td><?php echo $store->sade_remarks; ?></td>
  
                    </tr>

                    <?php  $grandtotal +=$total_amt;
                endforeach;
                     
                          endif;
                    ?>

                    </tbody>
                     <tfoot>
            <tr>
                <td></td>
               <td align="right" class="td_cell">
               <?php echo $this->lang->line('total_amount'); ?> :</td>
               <td align="right"><?php echo $grandtotal; ?></td>
               <td></td>
            </tr>
         </tfoot>
                </table>
        </div>
    </div>
</div>