    <div class="form-group">
            <div class="col-md-3 col-sm-4">
                <?php $itemcode=!empty($order_item_details[0]->rema_reqno)?$order_item_details[0]->rema_reqno:''; ?>
                <label for="example-text"><?php echo $this->lang->line('order_no'); ?> :<span class="required">*</span>:</label>
                <input type="text" class="form-control required_field" id="order_Number" name="order_number"  value="<?php echo !empty($orderno[0])?$orderno[0]:'';?>" placeholder="Enter Order Number">
            </div>
            <div class="col-md-3 col-sm-4">
              <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?>: </label> 
               <?php $fiscalyear=!empty($order_item_details[0]->puor_fiscalyear)?$order_item_details[0]->puor_fiscalyear:''; ?>  
              <input type="text" name="fiscal_year" class="form-control"  placeholder="Service Start Date" value="<?php echo $fiscalyear; ?>">
              <span class="errmsg"></span>
            </div>
            <div class="col-md-3 col-sm-4">
                <?php $depid=!empty($order_item_details[0]->puor_supplierid)?$order_item_details[0]->puor_supplierid:''; ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?> :<span class="required">*</span>:</label>
                <select name="rema_reqfromdepid" class="form-control required_field select2" >
                    <option value="">---select---</option>
                    <?php
                        if($depatrment):
                            foreach ($depatrment as $km => $dep):
                    ?>
                     <option value="<?php echo $dep->dept_depid; ?>"  <?php if($depid==$dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-4">
               
                <?php $orderdate=!empty($order_item_details[0]->puor_datead)?$order_item_details[0]->puor_datead:''; ?>
                <label for="example-text"><?php echo $this->lang->line('order_date'); ?> : </label>
                <input type="text" name="order_date" class="form-control"  placeholder="Service Start Date" value="<?php echo $orderdate; ?>">
              <span class="errmsg"></span>
            </div> 
            <div class="col-md-3 col-sm-4">
                <?php $manualnodb=!empty($order_item_details[0]->rema_manualno)?$order_item_details[0]->rema_manualno:''; ?>
                <label for="example-text"><?php echo $this->lang->line('manual_no'); ?> :</label>
                <input type="text" class="form-control float" name="rema_manualno"  value="<?php echo $manualnodb; ?>" placeholder="Enter Manual Number">
            </div>
            <div class="col-md-3 col-sm-4">
              <label for="example-text"><?php echo $this->lang->line('supplier_bill_date'); ?>: </label>
              <input type="text" name="suplier_bill_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="" id="ServiceBill">
              <span class="errmsg"></span>
            </div>
            <div class="col-md-3 col-sm-4">
              <label for="example-text"><?php echo $this->lang->line('received_date'); ?>: </label>
              <input type="text" name="received_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="" id="ServiceReceived">
              <span class="errmsg"></span>
            </div>
            <div class="col-md-3 col-sm-4">
                <?php $receivenodb=!empty($order_item_details[0]->receiveno)?$order_item_details[0]->receiveno:''; ?>
                <label for="example-text"><?php echo $this->lang->line('receive_no'); ?> :</label>
                <input type="text" class="form-control" name="receiveno" value="<?php echo $receivenodb; ?>" placeholder="Enter Posted BY ">
            </div>
            <div class="col-md-3 col-sm-4">
                <?php $suplier_bill_nodb=!empty($order_item_details[0]->suplier_bill_no)?$order_item_details[0]->suplier_bill_no:''; ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_no'); ?> :</label>
                <input type="text" class="form-control" name="suplier_bill_no" value="<?php echo $suplier_bill_nodb; ?>" placeholder="Enter Posted BY ">
            </div>
        </div>