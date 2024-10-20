<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
     <?php  $this->load->view('common/v_report_header',$this->data); ?> 
                

               
                <table class="alt_table" width="100%">
                    <thead>
                <tr>
                <th width="3%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                <th width="6%"><?php echo $this->lang->line('issue_no'); ?></th> 
                 <th width="6%"><?php echo $this->lang->line('date').'('.$this->lang->line('bs').')'; ?></th>
                <th width="6%"><?php echo $this->lang->line('date').'('.$this->lang->line('ad').')'; ?></th>
                <th width="7%"><?php echo $this->lang->line('issue_time'); ?></th>
                <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                 <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                <th width="6%"><?php echo $this->lang->line('received_qty'); ?></th>
                <th width="7%"><?php echo $this->lang->line('expenses_qty'); ?></th>
                <th width="7%"><?php echo $this->lang->line('remaining_qty'); ?></th>
               
               
                </tr>
                    </thead>
                   

                     <tbody>
                    <?php
                    
                

                    if($get_category_wise):
                        foreach($get_category_wise as $key=>$gei): 
                            $item_cat=$this->test_mdl->get_issue_expenses_analysis(array('eq.itli_catid'=>$gei->itli_catid));

                        if($item_cat):
                    ?>
                      <tr>
                        <td colspan="11"><strong><?php echo $gei->eqca_category;  ?></strong></td>
                   
                    </tr>
                     <?php
                        if($item_cat): 
                           

                            foreach ($item_cat as $km => $gie):
                                ?>
                    <tr>
                        <td><?php echo $km+1;?></td>
                        <td><?php echo $gie->sama_invoiceno; ?></td>
                        <td><?php echo $gie->sama_billdatebs; ?></td>
                        <td><?php echo $gie->sama_billdatead; ?></td>
                        <td><?php echo $gie->sama_billtime; ?></td>
                        <td><?php echo $gie->itli_itemcode; ?></td>  
                        <td><?php echo $gie->itli_itemname; ?></td>
                        <td><?php echo $gie->unit_unitname; ?></td>
                          <td><?php echo $gie->sama_depname; ?></td>
                        <td align="right"><?php echo $gie->sade_qty; ?></td>
                        <td align="right"><?php echo !empty($gie->expqty)?$gie->expqty:'0.00'; ?></td>
                        <td align="right"><?php echo number_format((float)$gie->sade_qty-$gie->expqty, 2, '.', ''); ?></td>
                        
                      
                       
                        
                    </tr>
                    <?php endforeach;
                          endif;
                    ?>
                    <?php        
                    endif; 
                    endforeach; 
                    endif; 
                    ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>