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
    <td width="200px">
      <td width="200px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('purchase_requisition_detail'); ?>  </u></b> </td>
            </table>


<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
            <th width="10%"><?php echo $this->lang->line('requisition_date'); ?></th>
            <th width="5%"><?php echo $this->lang->line('time'); ?></th>
            <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th>
            <th width="10%"><?php echo $this->lang->line('approved_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('approved_date'); ?></th>
           <!--  <th width="10%">Issue Time</th> -->
            <th width="10%"><?php echo $this->lang->line('issue_time'); ?></th>
            <th width="10%"><?php echo $this->lang->line('requisted_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
           
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
            <td><?php echo !empty($row->itli_itemname)?$row->itli_itemname:'';?></td>
            <td>
                <?php echo !empty($row->purd_qty)?$row->purd_qty:'';?>
            </td>
            <td>
                <?php echo !empty($row->purd_unit)?$row->purd_unit:'';?>
            </td>
            <td><?php echo !empty($row->pure_reqdatebs)?$row->pure_reqdatebs:'';?></td>
            <td><?php echo !empty($row->pure_posttime)?$row->pure_posttime:'';?></td>
            <td><?php echo !empty($row->pure_fyear)?$row->pure_fyear:'';?></td>
            <td><?php echo !empty($row->pure_requestto)?$row->pure_requestto:'';?></td>
            <td><?php echo !empty($row->pure_approveddatebs)?$row->pure_approveddatebs:'';?></td>
            <td><?php echo !empty($row->pure_reqtime)?$row->pure_reqtime:'';?></td>
            <td><?php echo !empty($row->pure_appliedby)?$row->pure_appliedby:'';?></td> 
            <td><?php echo !empty($row->purd_remarks)?$row->purd_remarks:'';?></td>
           
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

