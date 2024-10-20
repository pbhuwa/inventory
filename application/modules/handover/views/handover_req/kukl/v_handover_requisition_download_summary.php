<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

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

