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
    <tr class="title_sub">
        <td width="210px"></td>
        <td width='210px'></td>

        <td style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('handover_issue_detail'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
    </tr>
</table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>  
            <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="6%"><?php echo $this->lang->line('handover_issue_no'); ?></th> 
            <th width="6%"><?php echo $this->lang->line('date'); ?></th>
            <th width="5%"><?php echo $this->lang->line('handover_no'); ?></th>
            <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('department'); ?></th>
            <th width="6%"><?php echo $this->lang->line('issued_by'); ?></th>
            <th width="7%"><?php echo $this->lang->line('received_by'); ?></th>
            <th width="7%"><?php echo $this->lang->line('issue_time'); ?></th>
            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
            <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
            <th width="7%"><?php echo $this->lang->line('amount'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
            $i=1;
            $sum_all=0;
            foreach ($searchResult as $key => $handover_issue): 
                $sum_total_amt=!empty($handover_issue->haov_totalamount)?$handover_issue->haov_totalamount:'0';
                $sum_all +=$sum_total_amt;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo !empty($handover_issue->haov_hanoverno)?$handover_issue->haov_hanoverno:'';?></td>
                    <td><?php echo !empty($handover_issue->haov_handoverdatead)?$handover_issue->haov_handoverdatead:'';?></td>
                    <td>
                        <?php echo !empty($handover_issue->sama_requisitionno)?$handover_issue->sama_requisitionno:'';?>
                    </td>
                    <td>
                        <?php echo !empty($handover_issue->itli_itemcode)?$handover_issue->itli_itemcode:'';?>
                    </td>
                    <td><?php echo !empty($handover_issue->itli_itemname)?$handover_issue->itli_itemname:'';?></td>

                    <td><?php echo !empty($handover_issue->haov_depname)?$handover_issue->haov_depname:'';?></td>
                    <td><?php echo !empty($handover_issue->haov_username)?$handover_issue->haov_username:'';?></td>
                    <td>
                        <?php echo !empty($handover_issue->haov_receivedby)?$handover_issue->haov_receivedby:'';?>
                    </td>
                    <td><?php echo !empty($handover_issue->sama_billtime)?$handover_issue->sama_billtime:'';?></td>

                    <td><?php echo !empty($handover_issue->haod_qty)?$handover_issue->haod_qty:'';?></td>
                    <td><?php echo !empty($handover_issue->haod_unitprice)?$handover_issue->haod_unitprice:'';?></td>  
                    <td align="right"><?php echo !empty($handover_issue->issueamt)?(round($handover_issue->issueamt,2)):'0';?></td>
                </tr>
                <?php
                $i++;
            endforeach;
        endif;
        ?>
    </tbody>
    <tr>
        <th colspan="12"><?php echo $this->lang->line('total'); ?></th>
        <th align="right"><?php echo number_format($sum_all,2); ?></th>
    </tr>
</table>

