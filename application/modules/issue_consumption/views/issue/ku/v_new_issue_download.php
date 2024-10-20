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

        <td style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('issue_summary'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
    </tr>
</table>

<table id="" class="format_pdf" width="100%">
    <?php $apptype = $this->input->get('apptype'); ?>
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="5%"><?php echo $this->lang->line('issue_no'); ?></th>
            <th width="10%"><?php echo $this->lang->line('issue_date'); ?></th>
            <th width="10%"><?php echo $this->lang->line('department'); ?></th>
            <th width="5%"><?php echo $this->lang->line('total_amount'); ?></th>
            <th width="10%"><?php echo $this->lang->line('issued_by'); ?></th>
            <th width="10%"><?php echo $this->lang->line('received_by'); ?></th>
            <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
             <th width="10%"><?php echo $this->lang->line('issue_time'); ?></th>
            <?php if($apptype == 'cancel' || $apptype =='issue' || empty($apptype) ){ ?>
              <th width="5%"><?php echo $this->lang->line('bill_no'); ?></th> 
              <?php } 
              else {?>
              <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th> 
              <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php $apptype = $this->input->get('apptype');
        if($apptype == 'cancel' || $apptype =='issue' || empty($apptype) ){
            if($searchResult): 
        $i=1;
            foreach($searchResult as $row):
            
                $appclass='';
                $approved=$row->sama_st;
                if($approved=='C')
                {
                    $appclass='cancel';
                } ?>
        <tr>
            <td><?php echo $i; ?></td>
             <td><?php echo !empty($row->sama_invoiceno)?$row->sama_invoiceno:'';?></td>
              <td><?php echo !empty($row->sama_billdatebs)?$row->sama_billdatebs:'';?></td>
            <td><?php echo !empty($row->sama_depname)?$row->sama_depname:'';?></td>          
           
            <td>
                <?php echo !empty($row->totalamt)?$row->totalamt:'';?>
            </td>
            <td><?php echo !empty($row->sama_username)?$row->sama_username:'';?></td>
            <td><?php echo !empty($row->sama_receivedby)?$row->sama_receivedby:'';?></td>
            <td><?php echo !empty($row->sama_requisitionno)?$row->sama_requisitionno:'';?></td>
            <td><?php echo !empty($row->sama_billtime)?$row->sama_billtime:'';?></td>
            <td><?php echo !empty($row->sama_billno)?$row->sama_billno:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
    }
    else if($apptype == 'issuereturn' || $apptype == 'returncancel'){ 
         if($searchResult): 
        $i=1;
            foreach($searchResult as $row):
                // $appclass='';
                // $approved=$row->rema_st;
                // if($approved=='C')
                // {
                //     $appclass='returncancel';
                // }else{
                //     $appclass='issuereturn';
                // }?>

                <tr>
            <td><?php echo $i; ?></td>
             <td><?php echo !empty($row->rema_receiveno)?$row->rema_receiveno:'';?></td>
              <td><?php echo !empty($row->rema_returndatebs)?$row->rema_returndatebs:'';?></td>
            <td><?php echo !empty($row->dept_depname)?$row->dept_depname:'';?></td>          
           
            <td>
                <?php echo !empty($row->rema_amount)?$row->rema_amount:'';?>
            </td>
        <td><?php echo !empty($row->rema_username)?$row->rema_username:'';?></td>
            <td><?php echo !empty($row->rema_returnby)?$row->rema_returnby:'';?></td>
            <td><?php echo !empty($row->rema_invoiceno)?$row->rema_invoiceno:'';?></td>
            <td><?php echo !empty($row->rema_returntime)?$row->rema_returntime:'';?></td>
            <td><?php echo !empty($row->rema_fyear)?$row->rema_fyear:'';?></td>
            <?php
        $i++;
        endforeach;
        endif;
    } ?>
            </tbody>
</table>

