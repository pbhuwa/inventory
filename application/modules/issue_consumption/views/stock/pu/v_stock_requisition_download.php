<style>
    .format_pdf {
        border: 1px solid #000;
        border-collapse: initial;
    }

    .format_pdf thead tr th,
    .format_pdf tbody tr td {
        font-size: 13px;
        border: 1px solid #000;
        padding: 2px 4px;
    }

    .format_pdf tbody tr td {
        font-size: 12px;
        padding: 4px;
    }

    .format_sub_tbl_pdf {
        width: 80%;
        border-collapse: collapse;
        border-color: #ccc;
    }

    .format_sub_pdf,
    .format_sub_tbl_pdf thead tr th,
    .format_sub_tbl_pdf tbody tr td {
        background-color: #fff;
    }

    .format_sub_pdf {
        background-color: #f0f0f0;
        clear: both;
    }
</style>
<style>
    .table>tbody>tr>td,
    .table>tbody>tr>th {
        vertical-align: middle !important;
        white-space: normal !important;

    }

    @media print {
        @page {
            margin: 8mm;
        }
    }

    /*.table>tbody>tr:last-child td {
        font-weight:bold;
    }*/
</style>

<?php //echo $this->load->view('common/v_pdf_excel_header'); 
?>
<?php
$this->load->view('common/v_report_header');
$this->load->view('common/v_common_report_datatable_header');
?>
<br>
<!-- <table width="100%"> -->
<!-- <tr class="title_sub"> -->
<!-- <td colspan="2" width="200px"></td>
        <td width='200px'></td>
 -->
<!-- <td colspan="11" style="text-align:center;">
            <font style="font-size:15px;"><u><?php //echo $this->lang->line('stock_requisition_summary'); 
                                                ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font>
        </td>


    </tr>
</table> -->
<br>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%" style="padding: 10px 0;"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%" style="padding: 10px 0;"><?php echo $this->lang->line('req_date_ad'); ?></th>
            <th width="5%" style="padding: 10px 0;"><?php echo $this->lang->line('req_date_bs'); ?></th>
            <th width="6%" style="padding: 10px 0;"><?php echo $this->lang->line('req_no'); ?></th>
            <th width="10%" style="padding: 10px 0;"><?php echo $this->lang->line('from'); ?></th>
            <th width="10%" style="padding: 10px 0;"><?php echo $this->lang->line('store'); ?></th>
            <th width="10%" style="padding: 10px 0;"><?php echo $this->lang->line('username'); ?></th>
            <th width="5%" style="padding: 10px 0;"><?php echo $this->lang->line('is_issue'); ?></th>
            <th width="10%" style="padding: 10px 0;"><?php echo $this->lang->line('req_by'); ?></th>
            <th width="10%" style="padding: 10px 0;"><?php echo $this->lang->line('approved_by'); ?></th>
            <th width="5%" style="padding: 10px 0;"><?php echo $this->lang->line('manual_no'); ?></th>
            <th width="5%" style="padding: 10px 0;"><?php echo $this->lang->line('rem_qty'); ?></th>


        </tr>
    </thead>
    <tbody>
        <?php if ($searchResult) :
            $i = 1;

            foreach ($searchResult as $key => $row) :
                $frm_dep='';
                $schoolname = !empty($row->schoolname) ? $row->schoolname : '';
                $depparent = !empty($row->deptparent) ? $row->deptparent : '';
                if (!empty($depparent)) {
                    $frm_dep = $schoolname . '-' . $depparent . '/' . $frm_dep;
                } else {
                    $frm_dep = $schoolname . '-' . $frm_dep;
                }

                $frm_dep=rtrim($frm_dep, ',');



        ?>

                <tr>
                    <td style="padding: 7px 0; text-align: center"><?php echo $i; ?></td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->rema_reqdatebs) ? $row->rema_reqdatebs : ''; ?></td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->rema_reqdatead) ? $row->rema_reqdatead : ''; ?></td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->rema_reqno) ? $row->rema_reqno : ''; ?></td>
                    <td style="padding: 7px 0; text-align: center">
                        <?php echo !empty($frm_dep) ? $frm_dep : ''; ?>
                    </td>
                    <td style="padding: 7px 0; text-align: center;">
                        <?php echo !empty($row->depto) ? $row->depto : ''; ?>
                    </td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->rema_username) ? $row->rema_username : ''; ?></td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->rema_status) ? $row->rema_status : ''; ?></td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->rema_reqby) ? $row->rema_reqby : ''; ?></td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->rema_approvedby) ? $row->rema_approvedby : ''; ?></td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->rema_manualno) ? $row->rema_manualno : ''; ?></td>
                    <td style="padding: 7px 0; text-align: center"><?php echo !empty($row->cntitem) ? $row->cntitem : ''; ?></td>



                </tr>
        <?php
                $i++;
            endforeach;
        endif;
        ?>
    </tbody>
</table>