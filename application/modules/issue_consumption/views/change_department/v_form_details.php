
    <input type="hidden" name="id" value="<?php echo!empty($department[0]->sama_salemasterid)?$department[0]->sama_salemasterid:'';  ?>">
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text">Invoice  No : <span class="required">*</span>:</label>
            <input type="text" class="form-control invoice_no" name="invoice_no" id="invoice_no" value="<?php echo!empty($department[0]->sama_invoiceno)?$department[0]->sama_invoiceno:'';  ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Fiscal year : <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="fiscal_year" value="<?php echo!empty($department[0]->sama_fyear)?$department[0]->sama_fyear:'';  ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">New Invoice No: <span class="required">*</span>:</label>
            <input type="text" class="form-control" value="<?php echo!empty($department[0]->sama_invoiceno)?$department[0]->sama_invoiceno:'';  ?>" name="chma_new_invoiceno" id="txtchallanCode" placeholder="New Invoice No">
        </div>
        <div class="col-md-3">
            <label for="example-text">Date :<span class="required">*</span>:</label>
            <input type="text" name="chma_receivedatebs" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="" value="<?php echo DISPLAY_DATE; ?>" id="receivw_date" placeholder="Enter Challan Receive Date">
        </div>
    </div>
    <div class="clear-fix"></div>
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text">Req No: <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="req_no" id="txtchallanCode"  value="<?php echo!empty($department[0]->sama_requisitionno)?$department[0]->sama_requisitionno:'';  ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Manual No : <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="sama_manualbillno" value="<?php echo!empty($department[0]->sama_manualbillno)?$department[0]->sama_manualbillno:'';  ?>" id="txtchallanCode" placeholder=" Enter Manual No">
        </div>
        <div class="col-md-3">
          <?php  $deptype =!empty($department[0]->sama_storeid)?$department[0]->sama_storeid:'';?>
            <label for="example-text">Select Actual Department: <span class="required">*</span>:</label>
            <select name="dept_depid" class="form-control select2" id="deptsubcategory">
                <option value="">---select---</option>
                <?php
                if($departmentdata): 
                foreach ($departmentdata as $km => $mat):
                ?>
                <option value="<?php echo $mat->dept_depid; ?>" <?php if($deptype==$mat->dept_depid) echo 'selected=selected'; else { 
                            if(empty($deptype)) echo "selected=selected"; } ?>><?php echo $mat->dept_depname; ?>
                </option>
                <?php
                endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="example-text">Received By : <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="receivedby" id="txtchallanCode" value="<?php echo!empty($department[0]->sama_soldby)?$department[0]->sama_soldby:'';  ?>">
        </div>
        <div class="col-md-6">
            <label for="exampleFormControlTextarea1">Remarks</label>
            <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" name="remarks" rows="3"><?php echo !empty($department[0]->sama_remarks)?$department[0]->sama_remarks:'';  ?> </textarea>
        </div>
    </div>