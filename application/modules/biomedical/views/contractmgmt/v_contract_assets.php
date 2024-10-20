 <div class="form-group">
            <div class="table-responsive col-sm-12">
                
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                            <th width="10%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('assets_code'); ?></th>
                            <th width="30%"><?php echo $this->lang->line('description'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="purchaseDataBody">
                        <?php $j=1;
                        if(!empty($contract_data)){ 
                           
                            foreach ($contract_data as $key => $contract) {
                              ?>
                               <?php
                   $contrt=explode(',', $contract->coin_equipid);
                   
                   $this->load->Model('ams/assets_mdl');
                    foreach($contrt as $cr){
                    $cntr=$this->assets_mdl->get_assets("asen_asenid IN ($cr)");
                    
                      if($cntr){ 
                         // echo "<pre>";
                         //    print_r($cntr); die;
                      foreach ($cntr as $key => $cor) { ?>
                        <tr class="orderrow" id="orderrow_<?php echo $j;?>" data-id='<?php echo $j;?>'>
                                   
                            <td>
                                <input type="text" class="form-control sno" id="s_no_<?php echo $j;?>" value="<?php echo $j;?>" readonly/>
                        
                                 <input type="hidden" class="receiveddetailid" name="coin_equipid[]" id="equipid_<?php echo $j;?>" value="<?php echo $cor->asen_asenid ?>" />
                            </td>
                            <td>
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control equipkey enterinput " id="equipkey_<?php echo $j;?>"  data-id='<?php echo $j;?>' data-targetbtn='view' placeholder="Asset Code"  value="<?php echo $cor->asen_assetcode; ?>" >
                                  
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Assets List' data-viewurl='<?php echo base_url('ams/assets/list_of_item'); ?>' data-id='<?php echo $j;?>' id="view_<?php echo $j; ?>"><strong>...</strong></a>
                                </div>
                            </td>
                             <td>  
                                <input type="text" class="form-control description" id="description_<?php echo $j;?>" data-id='<?php echo $j;?>' placeholder="Asset Description" value='<?php echo $cor->itli_itemname;?>' readonly>
                              
                            </td>
                           
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td>
                        </tr>
                         <?php } } } ?>
                        <?php
                        $j++; 
                    } }
                    else{ ?>
                        <tr class="orderrow" id="orderrow_1" data-id='1'>
                            <td>
                                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                                 <input type="hidden" class="receiveddetailid" name="coin_equipid[]" id="equipid_1" value=""/>
                            </td>
                            <td>
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control equipkey enterinput " id="equipkey_1"  data-id='1' data-targetbtn='view' placeholder="Asset Code">
                                  
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Assets List' data-viewurl='<?php echo base_url('ams/assets/list_of_item'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                                </div>
                            </td>
                             <td>  
                                <input type="text" class="form-control description" id="description_1" data-id='1' placeholder="Asset Description" readonly>
                              
                            </td>
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tr>
                        <td colspan="15">
                            <a href="javascript:void(0)" class="btn btn-primary btnAdd1 pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                        </td>
                    </tr>
                </table>
                             
            </div>
        </div>