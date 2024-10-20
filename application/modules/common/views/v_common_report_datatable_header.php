<style type="text/css">
    .sub-header td {
        padding: 2px 5px;
        vertical-align: top;
        display: inline-flex;
        align-items: baseline;
        font-size: 12px
    }

    .sub-header td strong {
        padding-right: 3px
    }

    .sub-header-div {
        margin: 0px 0 10px !important;
        padding: 8px 5px;
        background: #eaeaea;
        border-top: 1px solid;
    }
</style>
<?php
// $searchdtype = $this->input->get('searchDateType');
// if ($searchdtype == 'date_range') {
$frmDate = $this->input->get('frmDate');
$toDate = $this->input->get('toDate');
if (!empty($frmDate) && !empty($toDate)) {
    $range = $frmDate . '-' . $toDate;
} else {
    $range = 'All';
}

?>

<table width="100%" style="margin: -15px 0 10px 0;">
    <tr>
        <td width="33%"></td>
        <td align="center" width="34%"><strong>Date Range</strong> : <?php echo $range; ?></td>
        <td width="33%"></td>
    </tr>

</table>
<div class="sub-header-div">

    <table style="width: 100%" class="organizationInfo sub-header">
        <tbody>
            <tr>
                <?php
                $locationid = $this->input->get('locationid');
                if (!empty($locationid)) :
                    $loca_result = $this->general->get_tbl_data('loca_name', 'loca_location', array('loca_locationid' => $locationid));
                    if (!empty($loca_result)) {
                        $locname = !empty($loca_result[0]->loca_name) ? $loca_result[0]->loca_name : '';
                    }
                ?>

                <?php else : $locname = 'All';
                endif; ?>
                <td width="33%"><strong>Branch</strong> : <?php echo $locname; ?> </td>

                <td align="center" width="34%" style="display:inline-block;margin: auto;"><strong><?php echo !empty($report_type) ? $report_type : ''; ?></strong></td>

                <td width="33%"><strong>School</strong> :
                    <?php
                    $schoolid = $this->input->get('schoolid');
                    if (!empty($schoolid)) :
                        $school_result = $this->general->get_tbl_data('loca_name', 'loca_location', array('loca_locationid' => $schoolid));
                        if (!empty($school_result)) {
                            $school_name = !empty($school_result[0]->loca_name) ? $school_result[0]->loca_name : '';
                        }
                    ?>
                    <?php else : $school_name = 'All';
                    endif; ?>
                    <?php echo $school_name; ?>
                </td>
            </tr>
            <tr>
                <td width="33%">
                    <!-- <strong>Requested By</strong> :
                    <?php

                    //$rema_reqby = $this->input->get('rema_reqby');
                    //echo !empty($rema_reqby) ? ucfirst($rema_reqby) : "All";
                    ?> -->
                </td>
                <td align="center" width="34%"> </td>
                <td width="33%"><strong>Department</strong> :
                    <?php
                    $depid = $this->input->get('departmentid');
                    $subdepid = $this->input->get('subdepid');
                    if (!empty($depid)) {
                        $department = $depid;
                        if ($subdepid) {
                            $department = $subdepid;
                        }
                        $check_parentid = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $department), 'dept_depname', 'ASC');
                        $dep_parent_dep_name = '';
                        $sub_depname = '';
                        if (!empty($check_parentid)) {
                            $dep_parentid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
                            $dep_parent_dep_name = !empty($check_parentid[0]->dept_depname) ? $check_parentid[0]->dept_depname : '';
                            if ($dep_parentid != 0) {
                                $sub_department = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $dep_parentid), 'dept_depname', 'ASC');
                                if (!empty($sub_department)) {
                                    $sub_depname = !empty($sub_department[0]->dept_depname) ? $sub_department[0]->dept_depname : '';
                                }
                            }
                        }

                        if (!empty($sub_depname)) {
                            echo $sub_depname . '(' . $dep_parent_dep_name . ')';
                        } else {
                            echo $dep_parent_dep_name;
                        }
                    } else {
                        echo "All";
                    }

                    ?>
                </td>
            </tr>
            <tr>
                <td width="33%"><strong>Material</strong> :
                    <?php
                    $mattypeid = $this->input->get('mattype');
                    if (!empty($mattypeid)) {
                        $mat_result = $this->general->get_tbl_data('maty_material', 'maty_materialtype', array('maty_materialtypeid' => $mattypeid));
                        if (!empty($mat_result)) {
                            echo !empty($mat_result[0]->maty_material) ? $mat_result[0]->maty_material : '';
                        }
                    } else {
                        echo "All";
                    }
                    ?>

                </td>
                <td width="34%"></td>
                <td width="33%">

                </td>
            </tr>
        </tbody>
    </table>
</div>