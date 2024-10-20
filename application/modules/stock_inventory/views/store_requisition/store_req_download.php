<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>

<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

              <table width="100%" style="font-size:12px;">
    <tr>
    <td style="width:45%">
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('store_requisition_list'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('req_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('req_date_bs'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('req_date_ad'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('req_time'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('req_by'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <!-- <th width="15%"><?php echo $this->lang->line('cost_center'); ?></th> -->
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->reno_reqno)?$row->reno_reqno:'';?></td>
            <td><?php echo !empty($row->reno_reqdatebs)?$row->reno_reqdatebs:'';?></td>
            <td>
                <?php echo !empty($row->reno_reqdatead)?$row->reno_reqdatead:'';?>
            </td>
            <td>
                <?php echo !empty($row->reno_reqtime)?$row->reno_reqtime:'';?>
            </td>
            <td><?php echo !empty($row->reno_appliedby)?$row->reno_appliedby:'';?></td>
            <td><?php echo !empty($row->reno_fyear)?$row->reno_fyear:'';?></td>
            <!-- <td><?php echo !empty($row->reno_costcenter)?$row->reno_costcenter:'';?></td> -->
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

