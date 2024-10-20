<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

<br>
<table width="100%">
    <tr class="title_sub">

        <td colspan="6" style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('access_log'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        <td width="200px"></td>
        
    </tr>
</table>
<br>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('login_date_bs'); ?></th>
            <th width="10%"><?php echo $this->lang->line('login_date_ad'); ?></th>
            <th width="10%"><?php echo $this->lang->line('login_time'); ?></th>
            <th width="15%"><?php echo $this->lang->line('username'); ?></th>
            <th width="10%"><?php echo $this->lang->line('login_ip'); ?></th>
            <th width="13%"><?php echo $this->lang->line('login_isvalidlogin'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->loac_logindatebs)?$row->loac_logindatebs:'';?></td>          
            <td>
               <?php echo !empty($row->loac_logindatead)?$row->loac_logindatead:'';?>
            </td>
            <td>
                <?php echo !empty($row->loac_logintime)?$row->loac_logintime:'';?>
            </td>
            <td><?php echo !empty($row->loac_loginusername)?$row->loac_loginusername:'';?></td>
            <td><?php echo !empty($row->loac_loginip)?$row->loac_loginip:'';?></td>
            <td><?php echo !empty($row->loac_isvalidlogin)?$row->loac_isvalidlogin:'';?></td> 
            
         
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

