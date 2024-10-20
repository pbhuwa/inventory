<div class="searchWrapper">
    <form id="issue_report_searchForm">
        <div class="form-group">
            <div class="row">
                <?php echo $this->general->location_option(2, 'locationid'); ?>

                <div class="col-md-2">

                    <label for="example-text">Choose Material Type : </label><br>
                    <select name="sama_mattypeid" id="mattypeid" class="form-control chooseMatType required_field">
                    <option value="">--All--</option>
                        <?php
                        if (!empty($material_type)) :
                            foreach ($material_type as $mat) :
                        ?>
                                <option value="<?php echo $mat->maty_materialtypeid; ?>">  <?php echo $mat->maty_material; ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>


                </div>
                 <div class="col-md-2">
                    <label for="example-text">Category : </label><br>
                    <select name="categoryid" id="categoryid" class="form-control select2 required_field">

                        <option value="">--All--</option>
                        <?php
                        if (!empty($category)) :
                            foreach ($category as $cat) :
                        ?>

                                <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>" > <?php echo $cat->eqca_category; ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>                    
                </div>

                 <div class="col-md-2">
                    <label for="example-text">Department:</label>

                       

                            <select name="departmentid" id="departmentid" class="form-control select2 ">

                                <option value="">--All--</option>

                                <?php if (!empty($department)) :

                                    foreach ($department as $kd => $dep) :

                                ?>

                                        <option value="<?php echo $dep->dept_depid ?>"><?php echo $dep->dept_depname ?></option>



                                <?php endforeach;
                                endif; ?>

                            </select>

                     </div>

                <div class="col-md-2">
                    <label><?php echo $this->lang->line('date_search'); ?> :</label>
                    <select name="searchDateType" id="searchDateType" class="form-control">
                        <option value="date_range">By Date Range</option>
                        <option value="date_all">All</option>
                    </select>
                </div>

                <div class="dateRangeWrapper">
                    <div class="col-md-1">
                        <label><?php echo $this->lang->line('from_date'); ?> :</label>
                        <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
                    </div>

                    <div class="col-md-1">
                        <label><?php echo $this->lang->line('to_date'); ?>:</label>
                        <input type="text" id="toDate" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
                    </div>
                </div>
                <?php if(ORGANIZATION_NAME=='KU'): ?>
                <div class="col-md-2">

                    <label>School<span class="required">*</span>:</label>

                    <?php
                    $select_option = '<option value="">All</option>';
                    if ($this->location_ismain == 'Y' && in_array($this->usergroup, $this->show_location_group)) {
                        $loca_cond = array(
                            'loca_isactive' => 'Y',
                        );
                    } else {
                        $loca_cond = array(
                            'loca_isactive' => 'Y',
                            'loca_locationid' => $this->locationid
                        );
                        $select_option = '';
                    }

                    $locationlist = $this->general->get_tbl_data('*', 'loca_location', $loca_cond);

                    $school = $this->locationid;

                    ?>

                    <select class="form-control required_field" name="school" id="schoolid">

                        <?php
                        echo $select_option;
                        if (!empty($locationlist)) :

                            foreach ($locationlist as $kl => $loc) {

                        ?>

                                <option value="<?php echo $loc->loca_locationid; ?>" <?php if ($school == $loc->loca_locationid) echo "selected=selected"; ?>><?php echo $loc->loca_name; ?></option>

                            <?php

                            }

                            ?>

                        <?php

                        endif;

                        ?>

                    </select>

                </div>

                <div class="col-md-2">

                    <?php

                    $parentdepid = !empty($parent_depid) ? $parent_depid : '';

                    if (!empty($parentdepid)) {

                        $depid = $parentdepid;
                    } else {

                        $depid = !empty($req_data[0]->departmentid) ? $req_data[0]->departmentid : '';
                    }

                    // echo $parentdepid;



                    // $this->general->get_tbl_data('*','dept_department',array('dept_parentdepid'=>$depid),'dept_depname','ASC');

                    ?>

                    <label for="example-text">Department <span class="required">*</span>:</label>

                    <div class="dis_tab">

                        <select name="departmentid" id="departmentid" class="form-control required_field ">

                            <option value="">--All--</option>

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

                $subdepid = !empty($req_data[0]->departmentid) ? $req_data[0]->departmentid : '';

                if (!empty($sub_department)) :

                    $displayblock = 'display:block';

                else :

                    $displayblock = 'display:none';

                endif;

                ?>

                <div class="col-md-2" id="subdepdiv" style="<?php echo $displayblock; ?>">

                    <label for="example-text">Sub Department:</label>

                    <select name="subdepid" id="subdepid" class="form-control">

                        <?php if (!empty($sub_department)) : ?>

                            <option value="">--All--</option>

                            <?php foreach ($sub_department as $ksd => $sdep) :

                            ?>

                                <option value="<?php echo $sdep->dept_depid; ?>" <?php if ($sdep->dept_depid == $subdepid) echo "selected=selected"; ?>><?php echo $sdep->dept_depname; ?></option>

                        <?php endforeach;
                        endif; ?>

                    </select>

                </div>
            <?php endif; ?>
                <div class="col-md-2">
                    <label>Received By</label>
                    <select class="form-control select2" name="sama_receivedby">
                        <option value="">---All---</option>
                        <?php
                        // $staff_info = $this->general->get_tbl_data('*', 'stin_staffinfo');
                        // if (!empty($staff_info)) :
                        // foreach ($staff_info as $ks => $sta) {
                        ?>
                        <!-- <option value="<?php //echo $sta->stin_staffinfoid . ',' . $sta->stin_fname . ' ' . $sta->stin_mname . ' ' . $sta->stin_lname 
                                            ?>"><?php //echo $sta->stin_fname . ' ' . $sta->stin_mname . ' ' . $sta->stin_lname 
                                                ?></option> -->
                        <?php
                        // }
                        // endif;
                        ?>
                        <?php
                        if (!empty($requested_by)) :
                            foreach ($requested_by as $ks => $sta) :
                        ?>
                                <option value="<?= $sta->sama_receivedby ?>"><?= $sta->sama_receivedby ?></option>
                        <?php endforeach;
                        endif; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Report Type</label>
                    <select name="rpt_type" class="form-control">
                        <option value="summary">Summary</option>
                        <option value="detail">Detail</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Report Wise</label>
                    <select name="rpt_wise" class="form-control" id="rpt_wise">
                        <option value="default">Default</option>
                        <option value="category_wise">Category wise</option>
                        <option value="item_wise">Item wise</option>
                        <option value="department">Department</option>
                        <option value="received_by">Received By</option>
                        <option value="demand_date">Demand Date</option>
                        <option value="issue_date">Issue Date</option>

                        <option value="material_type">Material Type</option>
                    </select>
                </div>
                <div class="col-md-3" id="itemdiv" style="display: none;">
                    <label>Item</label>
                    <div class="dis_tab">   
                    <input type="text" class="form-control" name="itemname" id="itemname" value="">
                    <input type="hidden" name="itemid" id="itemid" value="">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item_life_cycle/list_of_item'); ?>"><strong>...</strong></a>
                     <a href="javascript:void(0)" class="table-cell width_30" style="font-size: 16px;font-weight: bold;color: #ea2d2d;" title="Clear" id="clear"> X </a>
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Print Orientation</label>
                    <select name="page_orientation" class="form-control">
                        <option value="P">Portrait </option>
                        <option value="L">Landscape</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="reports/issue_report/get_search_issue_report"><?php echo $this->lang->line('search'); ?></button>
                </div>
            </div>
        </div>
    </form>

</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>
<script type="text/javascript">
    $(document).off('change', '#searchDateType');
    $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });
</script>

<script type="text/javascript">
    $(document).off('change','#rpt_wise');
    $(document).on('change','#rpt_wise',function(e){
        var rpt_wise=$(this).val();
        // alert(rpt_wise);
        // return false;
        if(rpt_wise=='item_wise'){
            $('#itemdiv').show();
        }else{
            $('#itemdiv').hide();
        }
    });

$(document).off('click','.itemDetail');
$(document).on('click','.itemDetail',function(e){
    var itemid=$(this).data('itli_itemlistid');
    var itemname=$(this).data('itli_itemname');
    var itemcode=$(this).data('itli_itemcode');
    if(itemid){
      var item_marge=itemcode+'|'+itemname;
      $('#itemid').val(itemid);
      $('#itemname').val(item_marge);
      $('#myView').modal('hide');
    }
});

$(document).off('click','#clear');
$(document).on('click','#clear',function(e){
     $('#itemid').val('');
    $('#itemname').val('');
});
</script>
