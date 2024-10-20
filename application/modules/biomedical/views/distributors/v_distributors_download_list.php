<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
    .body {
        border-top: 5px solid red !important;
    }
    .format_pdf tbody tr td {
    text-align: center !important;
    }
</style>
<body class="body">
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>
<table width="100%">
    <tr class="title_sub">
        <td colspan="6" style="text-align:center;"><font style="font-size:15px;"><u>Suppliers List</u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
    </tr>
</table>
<br>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="8%"><?php echo $this->lang->line('distributor_code'); ?></th>
            <th width="32%"><?php echo $this->lang->line('distributor_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('phone_no'); ?></th>
            <th width="15%"><?php echo $this->lang->line('dist_address'); ?></th>
            <th width="15%"><?php echo $this->lang->line('government_reg_no'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->dist_distributorcode; ?></td>
            <td><?php echo $row->dist_distributor; ?></td>
            <td><?php echo $row->dist_phone1; ?></td>
            <td><?php echo $row->dist_address1; ?></td>
            <td><?php echo $row->dist_govtregno; ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>
</body>

 <!-- echo $row->dist_distributor;
 echo $row->dist_distributorcode;
 echo $row->dist_govtregno;
 echo $row->dist_govtregdatebs;
 echo $row->dist_phone1;
 echo $row->dist_phone2;
 echo $row->dist_distributor;
 echo $row->coun_countryname;
 echo $row->dist_city;
 echo $row->dist_address1;
 echo $row->dist_address2;
 echo $row->dist_fax;
 echo $row->dist_salesrep;
 echo $row->dist_homephone;
 echo $row->dist_email;
 echo $row->dist_mobilephone;
 echo $row->dist_repemail;
 echo $row->dist_servicetech1;
 echo $row->dist_servicetech2;
 echo $row->dist_servicetech3; -->