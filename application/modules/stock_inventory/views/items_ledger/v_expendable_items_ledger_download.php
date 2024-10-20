<?php $this->load->view('common/v_report_header_datatable');?>

<table id="" class="format_pdf" width="100%">
    <thead>
         <tr>
            <th><?php echo $this->lang->line('sn'); ?></th>
            <th><?php echo $this->lang->line('date_ad'); ?></th>
            <th><?php echo $this->lang->line('date_bs'); ?></th>
            <th><?php echo $this->lang->line('description'); ?></th>
            <th><?php echo $this->lang->line('ref_no'); ?></th>

            <th><?php echo $this->lang->line('department_supplier'); ?></th>

            <th><?php echo $this->lang->line('rec_pur_qty'); ?></th>
            <th><?php echo $this->lang->line('rec_rate'); ?></th>
            <th><?php echo $this->lang->line('rec_amt'); ?></th>
            <th><?php echo $this->lang->line('issue_qty'); ?></th>
            <th><?php echo $this->lang->line('issue_rate'); ?></th>
            <th><?php echo $this->lang->line('issue_amt'); ?></th>
            <th><?php echo $this->lang->line('bal_qty'); ?></th>
            <th><?php echo $this->lang->line('rate'); ?></th>
            <th><?php echo $this->lang->line('bal_amt'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        $blcamt=0;$blcqty=0;     
        foreach ($searchResult as $key => $row): 

            $rec_purqty = $row->rec_purqty;
            $issueQty = $row->issueQty;

            $blcqty +=($rec_purqty-$issueQty);

            $rec_amt = round($row->rec_amt,2);
            $issuAmt = round($row->issuAmt,2);

            $blcamt +=($rec_amt-$issuAmt);
        ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo !empty($row->datesad)?$row->datesad:'';?></td>
            <td><?php echo !empty($row->dates)?$row->dates:'';?></td>
            <td>
                <?php echo !empty($row->description)?$row->description:'';?>
            </td>
            <td>
                <?php echo !empty($row->refno)?$row->refno:'';?>
            </td>
            <td><?php echo !empty($row->Depname)?$row->Depname:'';?></td>
           
            <td><?php echo !empty($row->rec_purqty)?$row->rec_purqty:0;?></td>
            <td><?php echo !empty($row->rec_rate)?round($row->rec_rate,2):0;?></td>
             <td>
                <?php echo !empty($row->rec_amt)?round($row->rec_amt,2):0;?>
            </td>
            <td><?php echo !empty($row->issueQty)?$row->issueQty:0;?></td>
           
            <td><?php echo !empty($row->rec_rate)?round($row->rec_rate,2):0;?></td>
            <td><?php echo !empty($row->issuAmt)?round($row->issuAmt,2):0;?></td>  
            <td><?php echo $blcqty;?></td>
            <td><?php echo !empty($row->rec_rate)?round($row->rec_rate,2):0;?></td>
            <td><?php echo $blcamt;?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>