<style>
    .purs_table tbody tr td {

        border: none;

        vertical-align: center;
    }
</style>

<?php

$stock_view_group = array('SA');

?>

<?php

// $this->location_ismain;
$id = !empty($req_data[0]->rema_reqmasterid) ? $req_data[0]->rema_reqmasterid : '';

// $this->usergroup = $this->session->userdata(USER_GROUPCODE);
// $this->locationid = $this->session->userdata(LOCATION_ID);
// $this->username = $this->session->userdata(USER_NAME);
$initial_reqno = !empty($requisition_no) ? $requisition_no : '';
$rema_reqno = !empty($req_data[0]->rema_reqno) ? $req_data[0]->rema_reqno : $initial_reqno;

if ($this->usergroup == 'DM') :

    $readonly = 'readonly';

else :

    $readonly = '';

endif;

?>

<form method="post" id="FormStockRequisition" action="<?php echo base_url('issue_consumption/stock_requisition/save_requisition'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('issue_consumption/stock_requisition/index/reload'); ?>">

    <input type="hidden" name="id" value="<?php echo !empty($req_data[0]->rema_reqmasterid) ? $req_data[0]->rema_reqmasterid : '';  ?>">

    <input type="hidden" name="save_type" value="<?php echo !empty($save_type) ? $save_type : '';  ?>">

    <div class="form-group">

        <div class="col-md-3">

            <label for="example-text">Choose Material Type : </label><br>

            <?php

            $rema_mattype = !empty($req_data[0]->rema_mattypeid) ? $req_data[0]->rema_mattypeid : 1;

            ?>

            <select name="rema_mattypeid" id="mattypeid" class="form-control chooseMatType required_field">

                <?php

                if (!empty($material_type)) :

                    foreach ($material_type as $mat) :

                ?>

                        <option value="<?php echo $mat->maty_materialtypeid; ?>" <?php if ($rema_mattype == $mat->maty_materialtypeid) echo "selected=selected"; ?>> <?php echo $mat->maty_material; ?></option>

                <?php

                    endforeach;

                endif;

                ?>

            </select>

        </div>

        <div class="col-md-3">

            <?php

            $rema_reqno = !empty($req_data[0]->rema_reqno) ? $req_data[0]->rema_reqno : '';

            if ($save_type == 'resubmit') {

                $show_req_no = $requisition_no;
            } else {

                $show_req_no = !empty($rema_reqno) ? $rema_reqno : $requisition_no;
            }

            ?>

            <label for="example-text"><?php echo $this->lang->line('req_no'); ?> <span class="required">*</span>:</label>

            <input type="text" class="form-control required_field" name="rema_reqno" id="rema_reqno" value="<?php echo $show_req_no; ?>" readonly />

        </div>

        <?php

        $display = 'style="display:block"';

        if (defined('SHOW_REQUISTION_TYPE')) :

            if (SHOW_REQUISTION_TYPE == 'Y') :

                $display = 'style="display:block"';

            else :

                $display = 'style="display:none"';

            endif;

        endif;

        ?>

        <div class="col-md-3" <?php echo $display; ?>>

            <label for="example-text"><?php echo $this->lang->line('choose'); ?> : </label><br>

            <?php

            $rema_isdep = !empty($req_data[0]->rema_isdep) ? $req_data[0]->rema_isdep : '';

            if ($rema_isdep) {

                $issue_checked = "checked ='checked'";

                if ($rema_isdep == 'Y') {

                    $issue_checked = "checked ='checked'";

                    $transfer_checked = "";
                } else {

                    $issue_checked = "";

                    $transfer_checked = "checked ='checked'";
                }
            } else {

                $issue_checked = "checked ='checked'";

                $transfer_checked = '';
            }

            ?>

            <input type="radio" class="mbtm_13 chooseReqType" name="rema_isdep" data-reqtype="issue" value="Y" <?php echo $issue_checked; ?> id="chooseReqtypeIss"><?php echo $this->lang->line('issue'); ?>

        </div>

        <div class="col-md-3">

            <?php $rema_manualno = !empty($req_data[0]->rema_manualno) ? $req_data[0]->rema_manualno : 0; ?>

            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?> :</label>

            <input type="text" class="form-control" name="rema_manualno" value="<?php echo $rema_manualno; ?>" placeholder="Enter Manual Number">

        </div>

        <div class="col-md-3">

            <?php

            if (DEFAULT_DATEPICKER == 'NP') {

                $req_date = !empty($req_data[0]->rema_reqdatebs) ? $req_data[0]->rema_reqdatebs : DISPLAY_DATE;
            } else {

                $req_date = !empty($req_data[0]->rema_reqdatead) ? $req_data[0]->rema_reqdatead : DISPLAY_DATE;
            }

            ?>

            <label for="example-text"><?php echo $this->lang->line('date'); ?>: </label>

            <input type="text" name="rema_reqdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Requisition Date" value="<?php echo $req_date; ?>" id="requisitionDate">

            <span class="errmsg"></span>

        </div>

        <div class="col-md-3">

            <?php

            $parentdepid = !empty($parent_depid) ? $parent_depid : '';

            if (!empty($parentdepid)) {

                $depid = $parentdepid;
            } else {

                $depid = !empty($req_data[0]->rema_reqfromdepid) ? $req_data[0]->rema_reqfromdepid : '';
            }

            // echo $parentdepid;

            // $this->general->get_tbl_data('*','dept_department',array('dept_parentdepid'=>$depid),'dept_depname','ASC');

            ?>

            <label for="example-text">Department <span class="required">*</span>:</label>

            <div class="dis_tab">

                <select name="rema_reqfromdepid" id="rema_reqfromdepid" class="form-control required_field select2 ">

                    <option value="">--select--</option>

                    <?php if (!empty($department)) :

                        foreach ($department as $kd => $dep) :

                    ?>

                            <option value="<?php echo $dep->dept_depid ?>" <?php if ($depid == $dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname ?></option>

                    <?php endforeach;
                    endif; ?>

                </select>

            </div>

        </div>

        <?php

        $subdepid = !empty($req_data[0]->rema_reqfromdepid) ? $req_data[0]->rema_reqfromdepid : '';

        if (!empty($sub_department)) :

            $displayblock = 'display:block';

        else :

            $displayblock = 'display:none';

        endif;

        ?>

        <div class="col-md-3" id="subdepdiv" style="<?php echo $displayblock; ?>">

            <label for="example-text">Sub Department <span class="required">*</span>:</label>

            <select name="rema_subdepid" id="rema_subdepid" class="form-control">

                <?php if (!empty($sub_department)) : ?>

                    <option value="">--select--</option>

                    <?php foreach ($sub_department as $ksd => $sdep) :

                    ?>

                        <option value="<?php echo $sdep->dept_depid; ?>" <?php if ($sdep->dept_depid == $subdepid) echo "selected=selected"; ?>><?php echo $sdep->dept_depname; ?></option>

                <?php endforeach;
                endif; ?>

            </select>

        </div>

        <div class="col-md-3">

            <?php $remareqby = !empty($req_data[0]->rema_reqby) ? $req_data[0]->rema_reqby : $this->username; ?>

            <label for="example-text"><?php echo $this->lang->line('requested_by'); ?><span class="required">*</span> :</label>

            <input type="text" id="id" autocomplete="off" name="rema_reqby" value="<?php echo $remareqby; ?>" class="form-control" placeholder="Requested By" />

            <!-- <input type="text" id="id" autocomplete="off" name="rema_reqby" value="<?php echo $remareqby; ?>" class="form-control searchText" placeholder="Requested By" data-srchurl="<?php echo base_url(); ?>issue_consumption/stock_requisition/list_of_reqby">

                <div class="DisplayBlock" id="DisplayBlock_id"></div> -->

        </div>

        <div class="col-md-3">

            <label for="example-text">Store :</label>

            <?php $storeid = !empty($req_data[0]->rema_reqtodepid) ? $req_data[0]->rema_reqtodepid : ''; ?>

            <select name="rema_reqtodepid" id="rema_reqtodepid" class="form-control">

                <?php

                if (!empty($store_type)) :

                    foreach ($store_type as $km => $store) :

                ?>

                        <option value="<?php echo $store->eqty_equipmenttypeid; ?>" <?php if ($storeid == $store->eqty_equipmenttypeid) echo "selected=selected"; ?>><?php echo $store->eqty_equipmenttype; ?></option>

                <?php

                    endforeach;

                endif;

                ?>

            </select>

        </div>

    </div>

    <div class="clearfix"></div>

    <div class="form-group">

        <div class="table-responsive col-sm-12">

            <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">

                <thead>

                    <tr>

                        <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>

                        <th scope="col" width="10%"> <?php echo $this->lang->line('code'); ?> </th>

                        <th scope="col" width="15%"> <?php echo $this->lang->line('particular'); ?> </th>

                        <th scope="col" width="5%"> <?php echo $this->lang->line('unit'); ?> </th>

                        <th scope="col" width="5%"> <?php echo $this->lang->line('stock_qty'); ?> </th>

                        <th scope="col" width="5%"> <?php echo $this->lang->line('req_qty'); ?> </th>

                        <th scope="col" width="5%"> <?php echo $this->lang->line('rate'); ?> </th>

                        <th scope="col" width="5%"> <?php echo $this->lang->line('amount'); ?> </th>

                        <th scope="col" width="10%"><?php echo $this->lang->line('remarks'); ?> </th>

                        <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>

                    </tr>

                </thead>

                <tbody id="orderBody">

                    <?php

                    $j = 1;

                    if (!empty($req_data)) :

                        foreach ($req_data as $req_key => $req_value) :

                    ?>

                            <tr class="orderrow" id="orderrow_<?php echo !empty($req_value->rede_reqdetailid) ? $req_value->rede_reqdetailid : ''; ?>" data-id='<?php echo $j; ?>'>

                                <td data-label="S.No.">

                                    <input type="text" class="form-control sno" id="s_no_<?php echo $j; ?>" value="<?php echo $j; ?>" readonly />

                                    <input type="hidden" name="rede_reqdetailid[]" class="reqdetailid" id="reqdetailid_<?php echo $j; ?>" value="<?php echo !empty($req_value->rede_reqdetailid) ? $req_value->rede_reqdetailid : ''; ?>" />

                                </td>

                                <td data-label="Code">

                                    <div class="dis_tab">

                                        <input type="text" class="form-control itemcode enterinput" id="itemcode_<?php echo $j; ?>" name="rede_code[]" data-id='<?php echo $j; ?>' data-targetbtn='view' value="<?php echo !empty($req_value->itli_itemcode) ? $req_value->itli_itemcode : ''; ?>" readonly />

                                        <input type="hidden" class="itemid" name="rede_itemsid[]" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_itemsid) ? $req_value->rede_itemsid : ''; ?>" id='itemid_<?php echo $j; ?>'>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='<?php echo $j; ?>' id='view_<?php echo $j; ?>'><strong>...</strong></a>&nbsp;

                                    </div>

                                </td>

                                <td data-label="Particular">

                                    <?php

                                    if (ITEM_DISPLAY_TYPE == 'NP') {

                                        $req_itemname = !empty($req_value->itli_itemnamenp) ? $req_value->itli_itemnamenp : $req_value->itli_itemname;
                                    } else {

                                        $req_itemname = !empty($req_value->itli_itemname) ? $req_value->itli_itemname : '';
                                    } ?>

                                    <input type="text" class="form-control itemname" id="itemname_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_itemname) ? htmlspecialchars($req_itemname,ENT_QUOTES) : ''; ?>" readonly>

                                    <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_<?php echo $req_key + 1; ?>">

                                </td>

                                <td data-label="Unit">

                                    <input type="text" class="form-control float rede_unit calculateamt" id="rede_unit_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->unit_unitname) ? $req_value->unit_unitname : ''; ?>">

                                    <input type="hidden" class="unitid" name="rede_unit[]" id="unitid_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_unit) ? $req_value->rede_unit : ''; ?>" />

                                </td>

                                <td data-label="Stock Quantity">

                                    <input type="text" name="rede_qtyinstock[]" class="form-control float rede_qtyinstock calculateamt" id="rede_qtyinstock_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_qtyinstock) ? $req_value->rede_qtyinstock : ''; ?>" readonly>

                                </td>

                                <td data-label="Req. Quantity">

                                    <input type="text" class="form-control float rede_qty calamt rede_qty arrow_keypress" name="rede_qty[]" data-fieldid="rede_qty" id="rede_qty_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_qty) ? $req_value->rede_qty : ''; ?>" />

                                </td>

                                <td>

                                    <input type="text" class="form-control float rede_unitprice calamt arrow_keypress" name="rede_unitprice[]" data-fieldid="rede_unitprice" id="rede_unitprice_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_unitprice) ? $req_value->rede_unitprice : ''; ?>" readonly="true">

                                </td>

                                <td>

                                    <?php $subtotal = ($req_value->rede_qty) * ($req_value->itli_purchaserate); ?>

                                    <input type="text" name="rede_totalamt[]" class="form-control eachtotalamt" value="0.00" id="rede_totalamt_<?php echo $req_key + 1; ?>" readonly="true">

                                </td>

                                <td data-label="Remarks">

                                    <input type="text" class="form-control  rede_remarks jump_to_add" id="rede_remarks_<?php echo $j; ?>" name="rede_remarks[]" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_remarks) ? $req_value->rede_remarks : ''; ?>" />

                                </td>

                                <td data-label="Action">

                                    <div class="actionDiv acDiv2" id="acDiv2_<?php echo $j; ?>"></div>

                                    <?php

                                    if (count($req_data) > 1) :

                                    ?>

                                        <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="<?php echo $j; ?>" id="addRequistion_<?php echo $j; ?>"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>

                                    <?php

                                    endif;

                                    ?>

                                </td>

                            </tr>

                        <?php

                            $j++;

                        endforeach;

                    else :

                        ?>

                        <tr class="orderrow" id="orderrow_1" data-id='1'>

                            <td data-label="S.No.">

                                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly />

                            </td>

                            <td data-label="Code">

                                <div class="dis_tab">

                                    <input type="text" class="form-control itemcode enterinput" id="itemcode_1" name="rede_code[]" data-id='1' data-targetbtn='view' value="">

                                    <input type="hidden" class="itemid" name="rede_itemsid[]" data-id='1' value="" id="itemid_1">

                                    <input type="hidden" name="rede_qtyinstock[]" data-id='1' class="qtyinstock" id="qtyinstock_1" value="" />

                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='1' id="view_1"><strong>...</strong></a>&nbsp;
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item Entry' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>'>+</a>
                                </div>

                            </td>

                            <td data-label="Particular">

                                <input type="text" class="form-control itemname" id="itemname_1" name="" data-id='1' readonly>

                                <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_1">

                            </td>

                            <td data-label="Unit">

                                <input type="text" value="" class="form-control float rede_unit calculateamt" id="rede_unit_1" data-id='1' readonly="true">

                                <input type="hidden" class="unitid" name="rede_unit[]" id="unitid_1" data-id='1' />

                            </td>

                            <td data-label="Stock Quantity">

                                <input type="text" class="form-control float rede_qtyinstock calculateamt" name="rede_qtyinstock[]" id="rede_qtyinstock_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_qtyinstock) ? $req_value->rede_qtyinstock : ''; ?>" readonly="true">

                            </td>

                            <td data-label="Req. Quantity">

                                <input type="text" class="form-control float calamt rede_qty  arrow_keypress required_field" name="rede_qty[]" data-fieldid="rede_qty" id="rede_qty_1" data-id='1'>

                            </td>

                            <td>

                                <input type="text" class="form-control rede_unitprice float calamt arrow_keypress" name="rede_unitprice[]" data-fieldid="rede_unitprice" id="rede_unitprice_1" value="0" data-id='1' placeholder="Rate" <?php echo $readonly; ?> />

                                <!--  <input type="hidden" class="form-control unitamtid float" name="rede_unitprice[]" id="unitamtid_1" value="0"  data-id='1' placeholder="Rate"> -->

                            </td>

                            <td>

                                <input type="text" name="rede_totalamt[]" class="form-control eachtotalamt" value="0" id="rede_totalamt_1" readonly="true">

                            </td>

                            <td data-label="Remarks">

                                <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_1" name="rede_remarks[]" data-id='1'>

                            </td>

                            <td data-label="Action">

                                <div class="actionDiv acDiv2" id="acDiv2_1"></div>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

                <tbody>

                    <tr class="resp_table_breaker">

                        <td colspan="9">

                        </td>

                        <td>

                            <?php

                            if ($save_type != 'resubmit') :

                            ?>

                                <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1" id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>

                            <?php

                            endif;

                            ?>

                            <div class="clearfix"></div>

                        </td>

                    </tr>

                </tbody>

            </table>

            <div class="roi_footer">

                <div class="row">

                    <div class="col-sm-4">

                        <?php $rema_workplace = !empty($req_data[0]->rema_workplace) ? $req_data[0]->rema_workplace : ''; ?>

                        <div>

                            <label for=""><?php echo $this->lang->line('work_place'); ?> : </label>

                            <input type="text" name="rema_workplace" class="form-control" rows="4" value="<?php echo $rema_workplace; ?>">

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-4">

                        <?php $rema_workdesc = !empty($req_data[0]->rema_workdesc) ? $req_data[0]->rema_workdesc : ''; ?>

                        <div>

                            <label for=""><?php echo $this->lang->line('work_description'); ?> : </label>

                            <textarea name="rema_workdesc" class="form-control" rows="4" placeholder=""><?php echo $rema_workdesc; ?></textarea>

                        </div>

                    </div>

                    <div class="col-sm-4">

                        <?php $rema_remarks = !empty($req_data[0]->rema_remarks) ? $req_data[0]->rema_remarks : ''; ?>

                        <div>

                            <label for=""><?php echo $this->lang->line('full_remarks'); ?> : </label>

                            <textarea name="rema_remarks" class="form-control" rows="4" placeholder=""><?php echo $rema_remarks; ?></textarea>

                        </div>

                    </div>

                </div>

                <!--   <div class="col-sm-6 pull-right">

                            <fieldset class="pull-right mtop_10 pad-top-14">

                                <ul> -->

                <!--   <li>

                                        <label><?php //echo $this->lang->line('sub_total'); 
                                                ?></label>

                                        <input type="text" class="form-control float" name="subtotalamt" id="subtotalamt" value=""  />

                                    </li> -->

                <!--   <li>

                                    <label><?php //echo $this->lang->line('clearance_amt'); 
                                            ?></label>

                                    <input type="text" class="form-control extra" name="clearanceamt" id="clearanceamt">

                                </li> -->

                <!--      </ul>

                            </fieldset>

                        </div> -->

            </div>

            <div id="Printable" class="print_report_section printTable">

            </div>

        </div> <!-- end table responsive -->

    </div>

    <div class="form-group">

        <div class="col-md-12">

            <?php

            if ($save_type == 'resubmit') {

                $save_operation = 'save';

                $save_btn =  $this->lang->line('save');
            } else {

                $save_operation = !empty($req_data) ? 'update' : 'save';

                $save_btn =  !empty($req_data) ? 'Update' : $this->lang->line('save');
            }

            ?>

            <button type="submit" class="btn btn-info  save" data-operation='<?php echo $save_operation  ?>' id="btnSubmit"><?php echo $save_btn ?></button>

            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($req_data) ? 'update' : 'save ' ?>' id="btnPrintSubmit" data-print="print"><?php echo !empty($req_data) ? 'Update & Print' : $this->lang->line('save_and_print') ?></button>

        </div>

        <div class="col-sm-12">

            <div class="alert-success success"></div>

            <div class="alert-danger error"></div>

        </div>

    </div>

</form>

<script type="text/javascript">
    $(document).off('click', '.btnAdd');

    $(document).on('click', '.btnAdd', function() {

        var id = $(this).data('id');

        var itemid = $('#itemid_' + id).val();

        var qty = $('#qtyinstock_' + id).val();

        var rate = $('#rede_qty_' + id).val();

        var rates = $('#rede_unitprice_' + id).val();

        var trplusOne = $('.orderrow').length + 1;

        var trpluOne = $('.orderrow').length;

        var itemid = $('#itemid_' + id).val();

        var code = $('#itemname_' + trplusOne).val();

        // alert(itemid);

        var newitemid = $('#itemid_' + trpluOne).val();

        var reqqty = $('#rede_qty_' + trpluOne).val();

        if (newitemid == '')

        {

            $('#itemcode_' + trpluOne).focus();

            return false;

        }

        if (reqqty == 0 || reqqty == '' || reqqty == null)

        {

            $('#rede_qty_' + trpluOne).focus();

            return false;

        }

        <?php

        if (in_array($this->usergroup, $stock_view_group)) :

        ?>

            if (rates == '' || rates == null)

            {

                $('#rede_unitprice_' + id).focus();

                return false;

            }

        <?php

        endif;

        ?>

        var storeid = $("#rema_reqtodepid option:selected").val();

        var matType = $("#mattypeid").val();

        // alert(matType);

        // return;

        // alert(storeid);

        setTimeout(function() {

            $('.btnitem').attr('data-storeid', storeid);

            $('.btnitem').data('storeid', storeid);

            // $('.btnitem').data('type',matType);

            $('.btnitem').attr('data-type', matType);

        }, 500);

        if (trplusOne == 2)

        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');

        }

        var template = '';

        template = '<tr class="orderrow" id="orderrow_' + trplusOne + '" data-id="' + trplusOne + '"><td data-label="S.No."><input type="text" class="form-control sno" id="s_no_' + trplusOne + '" value="' + trplusOne + '" readonly/></td><td data-label="Code"> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_' + trplusOne + '" name="rede_code[]" data-id="' + trplusOne + '" data-targetbtn="view" readonly /> <input type="hidden" class="itemid" name="rede_itemsid[]" data-id="' + trplusOne + '" id="itemid_' + trplusOne + '" > <input type="hidden" data-id="' + trplusOne + '" class="qtyinstock" id="qtyinstock_' + trplusOne + '" /> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="List of Item" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition '); ?>" data-id="' + trplusOne + '" id="view_' + trplusOne + '" ><strong>...</strong></a>&nbsp<a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item Entry" data-viewurl="<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>"data-id="' + trplusOne + '" id="view_' + trplusOne + '">+</a> </div></td><td data-label="Particular"><input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_' + trplusOne + '" > <input type="text" class="form-control itemname" id="itemname_' + trplusOne + '" name="" data-id="' + trplusOne + '" readonly></td><td data-label="Unit"><input type="text" class="form-control float rede_unit calculateamt" name="" id="rede_unit_' + trplusOne + '" data-id="' + trplusOne + '" > <input type="hidden" class="unitid" name="rede_unit[]" id="unitid_' + trplusOne + '" data-id="' + trplusOne + '"/></td> <td data-label="Req. Quantity "><input type="text" class="form-control float rede_qtyinstock calculateamt" name="rede_qtyinstock[]" id="rede_qtyinstock_' + trplusOne + '" data-id="' + trplusOne + '" readonly /> </td><td data-label="Req. Quantity"><input type="text" class="form-control float rede_qty calamt arrow_keypress required_field" data-fieldid="rede_qty" name="rede_qty[]" id="rede_qty_' + trplusOne + '" data-id=' + trplusOne + ' value="0" ></td><td> <input type="text" class="form-control float rede_unitprice calamt arrow_keypress" name="rede_unitprice[]" data-fieldid="rede_unitprice"  id="rede_unitprice_' + trplusOne + '" value="" data-id="' + trplusOne + '" placeholder=""></td> </td> <td><input type="text" name="rede_totalamt[]" class="form-control eachtotalamt" value="0" readonly="true" id="rede_totalamt_' + trplusOne + '"> </td><td data-label="Remarks"> <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_' + trplusOne + '" name="rede_remarks[]"  data-id="' + trplusOne + '"> </td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_' + trplusOne + '"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="' + trplusOne + '"  id="addRequistion_' + trplusOne + '"><span class="btnChange" id="btnChange_' + trplusOne + '"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

        // template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td data-label="S.No."><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td data-label="Code"> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="rede_code[]" data-id="'+trplusOne+'" data-targetbtn="view" readonly /> <input type="hidden" class="itemid" name="rede_itemsid[]" data-id="'+trplusOne+'" id="itemid_'+trplusOne+'" > <input type="hidden" data-id="'+trplusOne+'" class="qtyinstock" id="qtyinstock_'+trplusOne+'" /> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="List of Item" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition '); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'" ><strong>...</strong></a>&nbsp </div></td><td data-label="Particular"><input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_'+trplusOne+'" > <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="" data-id="'+trplusOne+'" readonly></td><td data-label="Unit"><input type="text" class="form-control float rede_unit calculateamt" name="" id="rede_unit_'+trplusOne+'" data-id="'+trplusOne+'" > <input type="hidden" class="unitid" name="rede_unit[]" id="unitid_'+trplusOne+'" data-id="'+trplusOne+'"/></td> <td data-label="Req. Quantity"><input type="text" class="form-control float rede_qty calamt arrow_keypress" data-fieldid="rede_qty" name="rede_qty[]" id="rede_qty_'+trplusOne+'" data-id='+trplusOne+' value="0" ></td><td data-label="Remarks"> <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_'+trplusOne+'" name="rede_remarks[]"  data-id="'+trplusOne+'"> </td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

        // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');

        // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');

        $('#itemcode_' + trplusOne).focus();

        $('#orderBody').append(template);

    });

    $(document).off('click', '.btnRemove');

    $(document).on('click', '.btnRemove', function() {

        var id = $(this).data('id');

        var whichtr = $(this).closest("tr");

        var conf = confirm('Are Your Want to Sure to remove?');

        if (conf)

        {

            var trplusOne = $('.orderrow').length + 1;

            whichtr.remove();

            //  for (var i = 0; i < trplusOne; i++) {

            //   $('#s_no_'+i).val(i);

            // }

            setTimeout(function() {

                $(".orderrow").each(function(i, k) {

                    var vali = i + 1;

                    $(this).attr("id", "orderrow_" + vali);

                    $(this).attr("data-id", vali);

                    $(this).find('.sno').attr("id", "s_no_" + vali);

                    $(this).find('.sno').attr("value", vali);

                    $(this).find('.itemcode').attr("id", "itemcode_" + vali);

                    $(this).find('.itemcode').attr("data-id", vali);

                    $(this).find('.reqdetailid').attr("id", "reqdetailid_" + vali);

                    $(this).find('.reqdetailid').attr("data-id", vali);

                    $(this).find('.qtyinstock').attr("id", "qtyinstock_" + vali);

                    $(this).find('.qtyinstock').attr("data-id", vali);

                    $(this).find('.itemid').attr("id", "itemid_" + vali);

                    $(this).find('.itemid').attr("data-id", vali);

                    $(this).find('.itemname').attr("id", "itemname_" + vali);

                    $(this).find('.itemname').attr("data-id", vali);

                    $(this).find('.view').attr("id", "view_" + vali);

                    $(this).find('.view').attr("data-id", vali);

                    $(this).find('.rede_unit').attr("id", "rede_unit_" + vali);

                    $(this).find('.rede_unit').attr("data-id", vali);

                    $(this).find('.unitid').attr("id", "unitid_" + vali);

                    $(this).find('.unitid').attr("data-id", vali);

                    $(this).find('.unitamtid').attr("id", "unitamtid_" + vali);

                    $(this).find('.unitamtid').attr("data-id", vali);

                    $(this).find('.rede_qty').attr("id", "rede_qty_" + vali);

                    $(this).find('.rede_qty').attr("data-id", vali);

                    $(this).find('.rede_remarks').attr("id", "rede_remarks_" + vali);

                    $(this).find('.rede_remarks').attr("data-id", vali);

                    $(this).find('.acDiv2').attr("id", "acDiv2_" + vali);

                    $(this).find('.eachsubtotal').attr("id", "eachsubtotal_" + vali);

                    $(this).find('.eachsubtotal').attr("data-id", vali);

                    $(this).find('.eachtotalamt').attr("id", "rede_totalamt_" + vali);

                    $(this).find('.eachtotalamt').attr("data-id", vali);

                    $(this).find('.totalamount').attr("id", "totalamount_" + vali);

                    $(this).find('.totalamount').attr("data-id", vali);

                    $(this).find('.rede_unitprice').attr("id", "rede_unitprice_" + vali);

                    $(this).find('.rede_unitprice').attr("data-id", vali);

                    // $(this).find('.acDiv2').attr("data-id",vali);

                    $(this).find('.btnAdd').attr("id", "addOrder_" + vali);

                    $(this).find('.btnAdd').attr("data-id", vali);

                    $(this).find('.btnRemove').attr("id", "addOrder_" + vali);

                    $(this).find('.btnRemove').attr("data-id", vali);

                    $(this).find('.btnChange').attr("id", "btnChange_" + vali);

                });

            }, 600);

            setTimeout(function() {

                var trlength = $('.orderrow').length;

                // alert(trlength);

                if (trlength == 1)

                {

                    $('#acDiv2_1').html('');

                }

            }, 800);

        }

    });

    $(document).off('click', '.itemDetail');

    $(document).on('click', '.itemDetail', function() {

        var rowno = $(this).data('rowno');

        var rate = $(this).data('rate');

        var itemcode = $(this).data('itemcode');

        var itemname = $(this).data('itemname_display');

        var itemid = $(this).data('itemid');

        var stockqty = $(this).data('issueqty');

        var unitname = $(this).data('unitname');

        var unitid = $(this).data('unitid');

        var unitamtid = $(this).data('unitamtid');

        var rede_unitprice = $(this).data('purrate');

        $('#itemcode_' + rowno).val(itemcode);

        // $('#itemcode_'+rowno).val(itemcode);

        $('#itemid_' + rowno).val(itemid);

        $('#itemname_' + rowno).val(itemname);

        $('#itemstock_' + rowno).val(stockqty);

        $('#rede_unit_' + rowno).val(unitname);

        $('#rede_qtyinstock_' + rowno).val(stockqty);

        $('#unitid_' + rowno).val(unitid);

        $('#unitamtid_' + rowno).val(unitamtid);

        $('#rede_unitprice_' + rowno).val(rede_unitprice);

        $('#myView').modal('hide');

        $('#rede_qty_' + rowno).focus().select();

        $('.calamt').change();

        return false;

    })
</script>

<script>
    $(document).off('click', '#checkApproval');

    $(document).on('click', '#checkApproval', function() {

        var check = $('#checkApproval').prop('checked');

        if (check == true) {

            var conf = confirm('Do you want to approve this requisition?');

            if (conf) {

                var checkStatus = $('#checkApproval:checked').length;

                // alert(checkStatus);

                if (checkStatus == '1') {

                    $('.approvalForm').show();

                }

            }

        } else {

            $('.approvalForm').hide();

        }

    });
</script>

<?php

if (empty($req_data)) :

?>

    <script type="text/javascript">
        $(document).ready(function() {

            var deptypeid = '<?php echo $rema_isdep ?>';

            if (deptypeid == 'N')

            {

                $('#chooseReqtypeTran').click();

            } else

            {

                $('#chooseReqtypeIss').click();

            }

            //         setTimeout(function(){

            // },500);  

            // $('').change();

        })
    </script>

<?php

endif;

?>

<script type="text/javascript">
    $(document).off('change', '#rema_reqtodepid');

    $(document).on('change', '#rema_reqtodepid', function()

        {

            // alert(storeid);

            var storeid = '';

            var reqType = $("input[name='rema_isdep']:checked").val();

            // alert(reqType);

            if (reqType == 'Y')

            {

                var depname = $("#rema_reqtodepid option:selected").text();

                storeid = $("#rema_reqtodepid option:selected").val();

            } else

            {

                var depname = $("#rema_reqfromdepid option:selected").text();

                storeid = $("#rema_reqfromdepid option:selected").val();

            }

            var matType = $("#mattypeid").val();

            // 

            $('.btnitem').attr('data-storeid', storeid);

            $('.btnitem').data('storeid', storeid);

            $('.btnitem').attr('data-type', matType);

            $('.btnitem').data('type', matType);

        })
</script>

<script>
    $(document).ready(function() {

        var storeid = $("#rema_reqtodepid option:selected").val();

        var matType = $("#mattypeid").val();

        // alert(storeid);

        $('.btnitem').attr('data-storeid', storeid);

        $('.btnitem').data('storeid', storeid);

        $('.btnitem').attr('data-type', matType);

        $('.btnitem').data('type', matType);

    });
</script>

<script>
    $(document).off('keyup change', '.calamt');

    $(document).on('keyup change', '.calamt', function() {

        var id = $(this).data('id');

        var qty = $('#rede_qty_' + id).val();

        if (qty == null || qty == ' ')

        {

            qty = 0;

        }

        var rate = $('#rede_unitprice_' + id).val();

        if (rate == null || rate == ' ')

        {

            rate = 0;

        }

        var rede_totalamt = 0;

        var totalamt = parseFloat(qty) * parseFloat(rate);

        var valid_totalamt = checkValidValue(totalamt);

        $('#rede_totalamt_' + id).val(valid_totalamt.toFixed(2));

        // if(rate>0)

        // {

        //     $('#free_'+id).val(0);

        // }

        //console.log(rede_qty);

        // $('#totalamt_1').val(500);

        var stotal = 0;

        var eachsubtotal = 0;

        $(".eachtotalamt").each(function() {

            stotal += parseFloat($(this).val());

        });

        eachsubtotal = parseFloat(eachsubtotal);

        // stotal=parseFloat(stotal)+parseFloat(eachcctotal);

        $('#subtotalamt').val(eachsubtotal.toFixed(2));

        $('#totalamount').val(stotal.toFixed(2));

        $('.extra').change();

    })

    $(document).off('change', '.chooseMatType');

    $(document).on('change', '.chooseMatType', function() {

        var matType = $(this).val();

        var reqType = $('input[name=rema_isdep]:checked').data('reqtype');

        var todepid = $('#rema_reqtodepid').val();

        var submitdata = {
            depid: todepid,
            type: reqType,
            mattype: matType
        };

        var submiturl = base_url + 'issue_consumption/stock_requisition/get_req_no_by_mat_type';

        ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

        function beforeSend() {

            // $('.overlay').modal('show');

            $('#rema_reqno').attr('disabled', 'disabled');

            $('#rema_reqno').val('Loading...');

        };

        function onSuccess(jsons) {

            data = jQuery.parseJSON(jsons);

            setTimeout(function() {

                $('#rema_reqno').empty().val(data.reqno);

                $('#rema_reqno').removeAttr('disabled');

            }, 1000);

        }

        $('.btnitem').attr('data-type', matType);

        $('.btnitem').data('type', matType);

        var orderrow_length = $('.orderrow').length;

        var itemid = $('#itemid_1').val();

        if (orderrow_length >= 1 && itemid) {

            var trplusOne = 1;

            var template = '<tr class="orderrow" id="orderrow_' + trplusOne + '" data-id="' + trplusOne + '"><td data-label="S.No."><input type="text" class="form-control sno" id="s_no_' + trplusOne + '" value="' + trplusOne + '" readonly/></td><td data-label="Code"> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_' + trplusOne + '" name="rede_code[]" data-id="' + trplusOne + '" data-targetbtn="view" readonly /> <input type="hidden" class="itemid" name="rede_itemsid[]" data-id="' + trplusOne + '" id="itemid_' + trplusOne + '" > <input type="hidden" data-id="' + trplusOne + '" class="qtyinstock" id="qtyinstock_' + trplusOne + '" /> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="List of Item" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition '); ?>" data-id="' + trplusOne + '" id="view_' + trplusOne + '" ><strong>...</strong></a>&nbsp </div></td><td data-label="Particular"><input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_' + trplusOne + '" > <input type="text" class="form-control itemname" id="itemname_' + trplusOne + '" name="" data-id="' + trplusOne + '" readonly></td><td data-label="Unit"><input type="text" class="form-control float rede_unit calculateamt" name="" id="rede_unit_' + trplusOne + '" data-id="' + trplusOne + '" > <input type="hidden" class="unitid" name="rede_unit[]" id="unitid_' + trplusOne + '" data-id="' + trplusOne + '"/></td> <td data-label="Req. Quantity "><input type="text" class="form-control float rede_qtyinstock calculateamt" name="rede_qtyinstock[]" id="rede_qtyinstock_' + trplusOne + '" data-id="' + trplusOne + '" readonly /> </td><td data-label="Req. Quantity"><input type="text" class="form-control float rede_qty calamt arrow_keypress required_field" data-fieldid="rede_qty" name="rede_qty[]" id="rede_qty_' + trplusOne + '" data-id=' + trplusOne + ' value="0" ></td><td> <input type="text" class="form-control float rede_unitprice calamt arrow_keypress" name="rede_unitprice[]" data-fieldid="rede_unitprice"  id="rede_unitprice_' + trplusOne + '" value="" data-id="' + trplusOne + '" placeholder=""readonly="true"></td> </td> <td><input type="text" name="rede_totalamt[]" class="form-control eachtotalamt" value="0" readonly="true" id="rede_totalamt_' + trplusOne + '"> </td><td data-label="Remarks"> <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_' + trplusOne + '" name="rede_remarks[]"  data-id="' + trplusOne + '"> </td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_' + trplusOne + '"></div></td></tr>';

            // if (conf != true) {

            //     return false;

            // } else {

                $('tr.orderrow').remove();

                $('#orderBody').append(template);

            // }

        }

    });
</script>

<?php

if (!empty($load_select2)) :

    if ($load_select2 == 'Y') :

?>

        <script type="text/javascript">
            $('.select2').select2();
        </script>

<?php

    endif;

endif;

?>

<script type="text/javascript">
    $('.nepdatepicker').nepaliDatePicker({

        npdMonth: true,

        npdYear: true,

        //npdYearCount: 10 // Options | Number of years to show

    });
</script>

<script type="text/javascript">
    $(document).off('change', '#locationid');
    $(document).on('change', '#locationid', function(e) {

        var schoolid = $(this).val();

        var submitdata = {
            schoolid: schoolid
        };

        var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';

        // aletr(schoolid);

        $('#rema_reqfromdepid').html('');

        ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

        function beforeSend() {

        };

        function onSuccess(jsons) {

            data = jQuery.parseJSON(jsons);

            if (data.status == 'success') {

                $('#subdepdiv').hide();

                $('#rema_reqfromdepid').html(data.dept_list);

            } else {

                $('#rema_reqfromdepid').html();

                $("#rema_reqfromdepid").select2("val", "");

                $("#rema_subdepid").select2("val", "");

            }

        }

    });

    $(document).off('change', '#rema_reqfromdepid');
    $(document).on('change', '#rema_reqfromdepid', function(e) {

        var schoolid = $(this).val();
        var submitdata = {
            schoolid: schoolid
        };

        var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';
        // aletr(schoolid);
        $("#rema_subdepid").select2("val", "");
        $('#rema_subdepid').html('');
        ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

        function beforeSend() {

        };

        function onSuccess(jsons) {

            data = jQuery.parseJSON(jsons);

            if (data.status == 'success') {

                $('#subdepdiv').show();
                $('#rema_subdepid').html(data.dept_list);

            } else {

                $('#subdepdiv').hide();
                $('#rema_subdepid').html();

            }
        }

    });
</script>