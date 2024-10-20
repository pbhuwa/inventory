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
    <td width="210px"></td>
    <td width="210px"></td>
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('purchase_order_aging'); ?>  </u></b> </td>
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
        <tr> <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="15%">0-15 <?php echo $this->lang->line('days'); ?></th>
                    <th width="15%">16-30 <?php echo $this->lang->line('days'); ?></th>
                    <th width="15%">30-45 <?php echo $this->lang->line('days'); ?></th>
                    <th width="15%">45 <?php echo $this->lang->line('days'); ?> <?php echo $this->lang->line('above'); ?> </th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $purchase): 
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($purchase->dist_distributor)?$purchase->dist_distributor:'';?></td>
            <?php
                $currentdatebs=CURDATE_NP;
                $currentdatead=CURDATE_EN;
                $deliverydatebs=$purchase->puor_deliverydatebs;
                if($purchase->puor_deliverydatead)
                {
                    $deliverydatead=$purchase->puor_deliverydatead;
                }
                else
                {
                    $deliverydatead=$this->general->NepToEngDateConv($deliverydatebs);
                }
                $days=$this->purchase_order_aging_mdl->date_different($currentdatead,$deliverydatead);
                
                $zero_to_fifteen='';
                $fifteen_to_thirty='';
                $thirty_to_fortyfive='';
                $fortyfive_to_more='';
                switch ($days) {
                    case ($days>0 && $days<=15):
                       $zero_to_fifteen=$this->purchase_order_aging_mdl->get_orderno($purchase->puor_supplierid);
                        break;
                    case ($days>15 && $days<=30):
                       $fifteen_to_thirty=$this->purchase_order_aging_mdl->get_orderno($purchase->puor_supplierid);
                        break;
                    case ($days>30 && $days<=45):
                        $thirty_to_fortyfive=$this->purchase_order_aging_mdl->get_orderno($purchase->puor_supplierid);
                        break;
                    default:
                    $fortyfive_to_more=$this->purchase_order_aging_mdl->get_orderno($purchase->puor_supplierid);
                }
             ?>
             <td><?php echo !empty($zero_to_fifteen)?$zero_to_fifteen:''; ?></td>
             <td><?php echo !empty($fifteen_to_thirty)?$fifteen_to_thirty:''; ?></td>
             <td><?php echo !empty($thirty_to_fortyfive)?$thirty_to_fortyfive:'' ?></td>
             <td><?php echo !empty($thirty_to_fortyfive)?$thirty_to_fortyfive:'' ?></td>
             <td><?php echo !empty($fortyfive_to_more)?$fortyfive_to_more:''; ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>

