<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
     <?php  $this->load->view('common/v_report_header',$this->data); ?> 
                

               
                <table class="alt_table" width="100%">
                    <thead>
                
                <tr>
                <th width="3%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                <th width="6%"><?php echo $this->lang->line('item_name'); ?></th> 
             
                <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="7%">Department</th>
                
                <th  width="6%">TEST</th>
                <th  width="6%">Remaining Test</th>
                <th width="7%"><?php echo $this->lang->line('expenses_qty'); ?></th>
                <th width="6%">Receive KIT</th>
                <th width="6%">Exp Kit</th>
                <th width="7%">Rem KIT </th>
                </tr>
               
               
                
                    </thead>
                    <tbody>
                    <?php
                    

                    if($get_department_wise):
                    foreach($get_department_wise as $key=>$gei): 
                        $Dep_stock=$this->test_mdl->item_stock_department($itemid,$depid);
                     

                if($Dep_stock):
                    ?>
                     <!--  <tr>
                        <td colspan="11"> <strong><?php echo $gei->dept_depname;  ?></strong></td>
                   
                    </tr> -->
                     <?php
                        if($Dep_stock): 
                           

                            foreach ($Dep_stock as $km => $gie):
                                ?>
                    <tr>
                        <td><?php echo $km+1;?></td>
                        <td><?php echo $gie->itli_itemname; ?></td>
                        <td><?php echo $gie->itli_itemcode; ?></td>
                        <td><?php echo $gie->dept_depname; ?></td>
                        <td><?php echo $gie->test_qty; ?></td>
                        <td><?php echo $gie->lab_stock_qty; ?></td>  
                        <td><?php echo $gie->rec_cnt; ?></td>
                        <td><?php echo $gie->rec_qty; ?></td>
                         <td align="right"><?php echo number_format((float)$gie->rec_qty-$gie->avl_item_stock, 2, '.', ''); ?></td>
                        <td><?php echo $gie->avl_item_stock; ?></td>
                        
                         
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
