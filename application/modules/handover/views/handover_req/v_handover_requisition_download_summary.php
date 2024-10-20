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
        <!-- <td></td> -->
        <td colspan="11" class="web_ttl text-center" style="text-align:center;">
            <!-- <h2><?php //echo ORGA_NAME; ?></h2>  -->
            <h3><?php echo ORGNAMETITLE; ?></h3>
        </td>
        <td></td>
    </tr>
    <tr class="title_sub">
        <!-- <td></td> -->
        
        <td colspan="11" style="text-align:center;"><h3 style="margin-bottom: 0px; margin: 0px"><?php echo ORGNAME ?></h3></td>
        <td style="text-align:right; font-size:10px;"><?php echo $this->lang->line('date_time'); ?>: <?php echo CURDATE_NP ?> <?php echo $this->lang->line('bs'); ?>,</td>
    </tr>
    <tr class="title_sub">
        <!-- <td></td> -->
        <td colspan="11" style="text-align:center;"><h3 style="margin-bottom: 0px; margin: 0px"> <?php echo ORGNAMEDESC ?></h3></td>
        <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> <?php echo $this->lang->line('ad'); ?> </td>
    </tr>
    <tr class="title_sub">
        <!-- <td width="200px"></td> -->
        <td colspan="11" style="text-align:center;"><h4 style="font-size:10px; margin: 0px;"><?php echo LOCATION ?></h4><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></td>
        <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
    </tr>
</table>
<br>
<table width="100%">
    <tr class="title_sub">
        <!-- <td colspan="2" width="200px"></td>
        <td width='200px'></td>
 -->
        <td colspan="11" style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('handover_requisition_summary'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
        
    </tr>
</table>
<br>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('date_bs'); ?></th>
            <th width="5%"><?php echo $this->lang->line('date_ad'); ?></th>
            <th width="6%"><?php echo $this->lang->line('handover_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('from_branch'); ?></th>
            <th width="10%"><?php echo $this->lang->line('to_branch'); ?></th>
              <th width="10%"><?php echo $this->lang->line('from_department'); ?></th>
            <th width="10%"><?php echo $this->lang->line('username'); ?></th>
           <!--  <th width="5%"><?php echo $this->lang->line('is_issue'); ?></th>  -->
            <th width="10%"><?php echo $this->lang->line('req_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('approved_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('remarks'); ?></th> 
            <th width="5%"><?php echo $this->lang->line('manual_no'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
   
        ?>
          

        <tr>
            <td><?php echo $i; ?></td>
             <td><?php echo !empty($row->harm_reqdatebs)?$row->harm_reqdatebs:'';?></td>
              <td><?php echo !empty($row->harm_reqdatead)?$row->harm_reqdatead:'';?></td>
            <td><?php echo !empty($row->harm_handoverreqno)?$row->harm_handoverreqno:'';?></td> 
            <td><?php echo !empty($row->fromloc)?$row->fromloc:'';?></td>
            <td><?php echo !empty($row->toloc)?$row->toloc:'';?></td>          
            <td><?php echo !empty($row->dept_depname)?$row->dept_depname:'';?></td>          
            <td><?php echo !empty($row->harm_username)?$row->harm_username:'';?></td>
            <!-- <td><?php echo !empty($row->harm_ishandover)?$row->harm_ishandover:'';?></td> -->
            <td><?php echo !empty($row->harm_requestedby)?$row->harm_requestedby:'';?></td> 
            <td><?php echo !empty($row->harm_approvedby)?$row->harm_approvedby:'';?></td>
            <td><?php echo !empty($row->harm_remarks)?$row->harm_remarks:'';?></td>
            <td><?php echo !empty($row->harm_manualno)?$row->harm_manualno:'';?></td>
           
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

