<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }

</style>
<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

<table>
    <tr class="title_sub" >
        <td style="width: 200px"></td>
        <td style="text-align:center; "><font style="font-size:15px;"><u><?php echo $this->lang->line('monthly_department_requisition'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
    </tr>
</table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th><?php echo $this->lang->line('department'); ?></th>
            <th><?php echo $this->lang->line('shrawan'); ?></th>
            <th><?php echo $this->lang->line('bhadra'); ?></th>
            <th><?php echo $this->lang->line('aaswin'); ?></th>
            <th><?php echo $this->lang->line('kartik'); ?></th>
            <th><?php echo $this->lang->line('mangsir'); ?></th>
            <th><?php echo $this->lang->line('poush'); ?></th>
            <th><?php echo $this->lang->line('magh'); ?></th>
            <th><?php echo $this->lang->line('falgun'); ?></th>
            <th><?php echo $this->lang->line('chaitra'); ?></th>
            <th><?php echo $this->lang->line('baishak'); ?></th>
            <th><?php echo $this->lang->line('jesth'); ?></th>
            <th><?php echo $this->lang->line('ashadh'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row):  ///print_r($searchResult);die;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->dept_depname)?$row->dept_depname:'';?></td>
            <td><?php echo !empty($row->mdr4)?$row->mdr4:'';?></td>
            <td><?php echo !empty($row->mdr5)?$row->mdr5:'';?></td>          
            <td><?php echo !empty($row->mdr6)?$row->mdr6:'';?></td>
            <td><?php echo !empty($row->mdr7)?$row->mdr7:'';?></td>
            <td><?php echo !empty($row->mdr8)?$row->mdr8:'';?></td>
            <td><?php echo !empty($row->mdr9)?$row->mdr9:'';?></td>
            <td><?php echo !empty($row->mdr10)?$row->mdr10:'';?></td> 
            <td><?php echo !empty($row->mdr11)?$row->mdr11:'';?></td>
            <td><?php echo !empty($row->mdr12)?$row->mdr12:'';?></td>
            <td><?php echo !empty($row->mdr1)?$row->mdr1:'';?></td>
            <td><?php echo !empty($row->mdr2)?$row->mdr2:'';?></td>
            <td><?php echo !empty($row->mdr3)?$row->mdr3:'';?></td>
           
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

