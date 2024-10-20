<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

              <table width="100%" style="font-size:12px;text-align: center;">
    <tr>
    
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('purchase_requisition_book'); ?>  </u></b> </td>
            </table>

<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
           <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
        <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
        <th width="10%"><?php echo $this->lang->line('req_date'); ?>(<?php echo $this->lang->line('ad'); ?>)</th>
        <th width="10%"><?php echo $this->lang->line('req_date'); ?>(<?php echo $this->lang->line('bs'); ?>)</th>
        <th width="10%"><?php echo $this->lang->line('requisition_time'); ?> </th>
        <th width="10%"><?php echo $this->lang->line('fiscal_year'); ?></th>
         <th width="10%"><?php echo $this->lang->line('requested_to'); ?></th>
         <th width="10%"><?php echo $this->lang->line('requisted_by'); ?></th>
        <th width="8%"><?php echo $this->lang->line('user'); ?></th>
        <th width="8%"><?php echo $this->lang->line('approved_user'); ?></th>
        <th width="8%"><?php echo $this->lang->line('approved_date'); ?></th>
        <th width="8%"><?php echo $this->lang->line('material_type'); ?></th>
    
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->pure_reqno)?$row->pure_reqno:'';?></td>
            <td><?php echo !empty($row->pure_reqdatead)?$row->pure_reqdatead:'';?></td>
            <td><?php echo !empty($row->pure_reqdatebs)?$row->pure_reqdatebs:'';?></td>
            <td>
                <?php echo !empty($row->pure_posttime)?$row->pure_posttime:'';?>
            </td>
            <td><?php echo !empty($row->pure_fyear)?$row->pure_fyear:'';?></td>
            <td>
                <?php echo !empty($row->pure_requestto)?$row->pure_requestto:'';?>
            </td>
            <td>
                <?php echo !empty($row->pure_appliedby)?$row->pure_appliedby:'';?>
            </td>  
            <td><?php echo !empty($row->user)?$row->user:'';?></td>
            <td><?php echo !empty($row->usma_username)?$row->usma_username:'';?></td>

            <td>
                <?php
            if(DEFAULT_DATEPICKER=='NP')
                {
             echo !empty($row->pure_approveddatebs)?$row->pure_approveddatebs:'';
            }
            else
            {
               echo !empty($row->pure_approveddatead)?$row->pure_approveddatead:''; 
            }
             ?>   
             </td>
          <!-- <td><?php echo !empty($row->pure_reqtime)?$row->pure_reqtime:'' ;?></td>  -->
          <td><?php echo !empty($row->maty_material)?$row->maty_material:'';?></td> 
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

