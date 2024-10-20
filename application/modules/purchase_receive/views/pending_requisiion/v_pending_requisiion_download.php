<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<table width="100%" style="font-size:12px;" class="format_pdf_head">
    <tr>
        <td></td>
        <td class="web_ttl text-center" style="text-align:center;">
            <h2><?php echo ORGA_NAME; ?></h2>
        </td>
        <td></td>
    </tr>
    <tr class="title_sub">
        <td></td>
        <td style="text-align:center;"><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td>
        <td style="text-align:right; font-size:10px;">Date/Time: <?php echo CURDATE_NP ?> BS,</td>
    </tr>
    <tr class="title_sub">
        <td></td>
        <td style="text-align:center;"><b style="font-size:15px;"><span id="rptType"></span></b></td>
        <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
    </tr>
    <tr class="title_sub">
        <td width="200px"></td>
        <td style="text-align:center;"><b><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></b></td>
        <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
    </tr>
</table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
           <!--  <th width="5%">S.No.</th>
            <th width="15%">Requisition No</th>
            <th width="15%">Requisition Date</th>
            <th width="15%">Items Code</th>
            <th width="10%">Items Name</th>
            <th width="10%">Requisition time</th>
            <th width="10%">F Year</th>
            <th width="10%">Approved User</th>
            <th width="10%">Approved Date</th>
            <th width="10%">Request By</th> -->
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->requ_requno)?$row->requ_requno:'';?></td>
            <td><?php echo !empty($row->requ_requdatebs)?$row->requ_requdatebs:'';?></td>
            <td><?php echo !empty($row->requ_appliedby)?$row->requ_appliedby:'';?></td>
            <td><?php echo !empty($row->requ_reqtime)?$row->requ_reqtime:'';?></td>
            <td><?php echo !empty($row->requ_requfyear)?$row->requ_requfyear:'';?></td>
            <td><?php echo !empty($row->requ_approvaluser)?$row->requ_approvaluser:'';?></td>
            <td><?php echo !empty($row->requ_approvaldatebs)?$row->requ_approvaldatebs:'';?></td>
            <td><?php echo !empty($row->requ_requser)?$row->requ_requser:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

