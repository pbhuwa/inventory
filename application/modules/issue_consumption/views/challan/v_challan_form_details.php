<form method="post" id="FormMenu" action="<?php echo base_url('issue_consumption/challan/save_challan'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('issue_consumption/challan/form_challan'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($challan_data[0]->chma_challanmasterid)?$challan_data[0]->chma_challanmasterid:'';  ?>">
    <div class="form-group">
            <div class="col-md-2 col-sm-2">
                <?php $fiscalyear=!empty($order_list[0]->puor_fyear)?$order_list[0]->puor_fyear:''; ?>
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
                <select name="fiscalyear" class="form-control select2" id="fiscalyear" >
                    <option value="">---select---</option>
                        <?php
                            if($fiscal):
                                foreach ($fiscal as $km => $fy):
                        ?>
                    <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_name == $fiscalyear) echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                        <?php
                                endforeach;
                            endif;
                        ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $orderno=!empty($order_list[0]->orderno)?$order_list[0]->orderno:''; ?>
                <label for="example-text"><?php echo $this->lang->line('order_no'); ?><span class="required">*</span>:</label>
                <div class="dis_tab">
                    <input type="text" class="form-control required_field enterinput"  name="orderno"  value="<?php echo !empty($orderno)?$orderno:'';?>" placeholder="Enter Order Number" id="orderno" data-targetbtn='btnSearchOrderno'>
                   
                    <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchOrderno" ><i class="fa fa-search"></i></a>
                    &nbsp;
              
                    <a href="javascript:void(0)" data-id="0" data-displaydiv="Issue" data-viewurl="<?php echo base_url('issue_consumption/challan/load_order_list'); ?>" class="view table-cell width_30 btn btn-success" data-heading="Load Order list" id="orderload"><i class="fa fa-upload"></i></a>
                </div>
       
            </div>
        </div>
    <div class="form-group">
        <div class="col-md-2">
            <label for="example-text"><?php echo $this->lang->line('challan_receive_no'); ?><span class="required">*</span>:</label>
            <?php
                if(!empty($challan_data)){
                    $chma_receiveno = !empty($challan_data[0]->chma_challanrecno)?$challan_data[0]->chma_challanrecno:'';
                }else{
                    $chma_receiveno = $receiveno[0]->id+1;
                }
            ?>
            <input type="text" class="form-control required_field" name="chma_receiveno" id="txtchallanCode" placeholder="Enter Challan Receive No " value="<?php echo $chma_receiveno; ?>" readonly>
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?>: <span class="required">*</span>:</label>
            <?php
                $chma_supplierid = !empty($order_list[0]->puor_supplierid)?$order_list[0]->puor_supplierid:'';
            ?>
            <select name="chma_supplierid" class="form-control required_field select2" id="suppliername" readonly>
                <option value="">---select---</option>
                <?php
                if($supplier):
                foreach ($supplier as $km => $mat):
                ?>
                <option value="<?php echo $mat->dist_distributorid; ?>" <?php echo ($chma_supplierid == $mat->dist_distributorid)?"selected":""; ?> ><?php echo $mat->dist_distributor; ?></option>
                <?php
                endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="example-text"><?php echo $this->lang->line('challan_receive_date'); ?><span class="required">*</span>:</label>
            <?php
                if(DEFAULT_DATEPICKER == 'NP'){
                    $chma_receivedate = CURDATE_NP;
                }else{
                    $chma_receivedate = CURDATE_EN;
                }
            ?>
            <input type="text" name="chma_receivedatebs" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>"  placeholder="" value="<?php echo $chma_receivedate; ?>" id="receivw_date" placeholder="Enter Challan Receive Date">
        </div>

        <div class="col-md-2">
            <label for="example-text"><?php echo $this->lang->line('sup_challan_no'); ?> <span class="required">*</span>:</label>
           
            <input type="text" class="form-control required_field" name="chma_suchallanno" id="txtchallanCode" placeholder="Sup Challan No" value="">
        </div>
        <div class="col-md-2">
            <label for="example-text"><?php echo $this->lang->line('supplier_challan_date'); ?> :</label>
            <?php
                if(DEFAULT_DATEPICKER == 'NP'){
                    $chma_challandate = CURDATE_NP;
                }else{
                    $chma_challandate = CURDATE_EN;
                }
            ?>
            <input type="text" name="suchalandatebs" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="" value="<?php echo $chma_challandate; ?>" id="challan_date">
        </div>
    </div>

    <div class="form-group">
        <div class="pad-5" id="displayDetailList">
            <div class="table-responsive">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                            <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                            <th width="10%"> <?php echo $this->lang->line('item_code'); ?></th>
                            <th width="30%"><?php echo $this->lang->line('item_name'); ?> </th>
                            <th width="10%"> <?php echo $this->lang->line('unit'); ?>  </th>
                            <th width="8%"><?php echo $this->lang->line('odr_qty'); ?></th> 
                            <th width="7%"><?php echo $this->lang->line('qty'); ?>  </th>
                            <th width="20%"> <?php echo $this->lang->line('remarks'); ?> </th>
                            <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="purchaseBody">
                        <?php 
                            if(!empty($order_list)){
                                foreach($order_list as $key => $ord_det):
                                    if($ord_det->pude_remqty):
                        ?>
                            <tr class="directrow" id="directrow_1" data-id='1'>
                                <td>
                                    <input type="text" class="form-control sno noBorderInput" id="sno_<?php echo $key+1; ?>" value="<?php echo $key+1; ?>" readonly/>
                                </td>
                                <td>
                                    <?php echo $ord_det->itemcode; ?>
                                    <input type="hidden" class="itemsid" name="trde_itemsid[]" value="<?php echo $ord_det->itli_itemlistid; ?>" id="itemsid_<?php echo $key+1; ?>" />
                                    <input type="hidden" class="pudeid" name="pudeid[]" value="<?php echo $ord_det->pude_puordeid; ?>" id="pudeid_<?php echo $key+1; ?>" />
                                    <input type="hidden" class="form-control itemcode enterinput " id="itemcode_<?php echo $key+1; ?>" name="trde_mtmid[]"  data-id='<?php echo $key+1; ?>' data-targetbtn='view' value="<?php echo !empty($ord_det->itemcode)?$ord_det->itemcode:'';?>" >
                                </td>
                                <td>
                                    <?php 
                                        if(ITEM_DISPLAY_TYPE=='NP'){
                                            echo !empty($ord_det->itemnamenp)?$ord_det->itemnamenp:$ord_det->itemname;
                                        }else{ 
                                            echo !empty($ord_det->itemname)?$ord_det->itemname:'';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $ord_det->unit_unitname; ?>
                                    <input type="hidden" class="form-control unit" name="trde_unitpercase[]" value="<?php echo $ord_det->unit_unitname; ?>" data-id="<?php echo $key+1; ?>" id="unit_<?php echo $key+1; ?>" readonly />
                                </td>
                                <td>
                                    <?php echo $ord_det->pude_remqty; ?>
                                   <input type="hidden" class="order_qty" name="order_qty[]" value="<?php echo $ord_det->pude_remqty; ?>" id="order_qty_<?php echo $key+1; ?>" >
                                </td>
                               <td>
                                    <input type="text" class="form-control number calamt recqty arrow_keypress" data-fieldid="recqty" name="trde_issueqty[]" value="0"  data-id='<?php echo $key+1; ?>' id="recqty_<?php echo $key+1; ?>">
                                </td>
                            
                               
                                <td>
                                    <input type="text" class="form-control description arrow_keypress" name="remarks[]" data-fieldid="description" value="<?php echo $ord_det->pude_remarks; ?>" id="description_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                                    endif;
                                endforeach;
                        ?>

                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            <?php
                $save_var=$this->lang->line('save');
                $update_var=$this->lang->line('update'); ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($menu_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($menu_data)?$update_var:$save_var; ?></button>
            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($menu_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($menu_data)?$this->lang->line('update_and_print'):$this->lang->line('save_and_print'); ?>
            </button>
        </div>
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>