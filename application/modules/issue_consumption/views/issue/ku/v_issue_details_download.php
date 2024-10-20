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
       <!--   <td width="233px"></td> 
        <td width='233px'></td> -->
        <!-- <td width='200px'></td>                                                                                                           -->
        <td style="text-align:center;"><font style="font-size:15px"><u><?php echo $this->lang->line('issue_detail'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
    </tr>
</table>

<!-- <table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%">S.No.</th>
            <th width="5%">Req. No.</th>
            <th width="5%">Req. Date</th>
            <th width="10%">Requested By</th>
            <th width="10%">Items Name</th>
            <th width="5%">Unit</th>
            <th width="5%">Req. Qty</th>
            <th width="10%">Material Type</th>
            <th width="10%">Category Name</th>
            <th width="5%">Order</th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->reqno)?$row->reqno:'';?></td>
            <td><?php echo !empty($row->reqdatebs)?$row->reqdatebs:'';?></td>
            <td>
                <?php echo !empty($row->requser)?$row->requser:'';?>
            </td>
            <td>
                <?php echo !empty($row->itemname)?$row->itemname:'';?>
            </td>
            <td><?php echo !empty($row->unit)?$row->unit:'';?></td>
            <td><?php echo !empty($row->qty)?$row->qty:'';?></td>
            <td><?php echo !empty($row->materialname)?$row->materialname:'';?></td>
            <td><?php echo !empty($row->category)?$row->category:'';?></td>
            <td><?php echo !empty($row->status)?$row->status:'';?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table> -->
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>     <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('issue_no'); ?></th> 
                    <th width="6%"><?php echo $this->lang->line('date'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('issued_by'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('received_by'); ?></th>
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
        foreach ($searchResult as $key => $purchase): 
            $sum_total_amt=!empty($purchase->issueamt)?$purchase->issueamt:'0';
             $sum_all +=$sum_total_amt;
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($purchase->sama_invoiceno)?$purchase->sama_invoiceno:'';?></td>
            <td><?php echo !empty($purchase->sama_billdatebs)?$purchase->sama_billdatebs:'';?></td>
            <td>
                <?php echo !empty($purchase->sama_requisitionno)?$purchase->sama_requisitionno:'';?>
            </td>
            <td>
                <?php echo !empty($purchase->itli_itemcode)?$purchase->itli_itemcode:'';?>
            </td>
            <td><?php echo !empty($purchase->itli_itemname)?$purchase->itli_itemname:'';?></td>
           
            <td><?php echo !empty($purchase->sama_depname)?$purchase->sama_depname:'';?></td>
            <td><?php echo !empty($purchase->sama_username)?$purchase->sama_username:'';?></td>
             <td>
                <?php echo !empty($purchase->sama_receivedby)?$purchase->sama_receivedby:'';?>
            </td>
            <td><?php echo !empty($purchase->sama_billtime)?$purchase->sama_billtime:'';?></td>
           
            <td><?php echo !empty($purchase->sade_qty)?$purchase->sade_qty:'';?></td>
            <td><?php echo !empty($purchase->sade_unitrate)?$purchase->sade_unitrate:'';?></td>  
            <td align="right"><?php echo !empty($purchase->issueamt)?(round($purchase->issueamt,2)):'0';?></td>
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

