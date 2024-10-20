<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }

</style>

<?php echo $this->load->view('common/v_pdf_excel_header'); ?>

<br>
<table width="100%">
    <tr class="title_sub">

       <td colspan="11" style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('handover'); ?> List</u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>


   </tr>
</table>
<br>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
          <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
          <th width="5%"><?php echo $this->lang->line('handover_issue_no'); ?></th>
          <th width="5%">Hand. Req.NO</th>
          <th width="8%" ><?php echo $this->lang->line('handover_issue_date').'('.$this->lang->line('ad').')'; ?></th>
          <th width="8%" ><?php echo $this->lang->line('handover_issue_date').'('.$this->lang->line('bs').')'; ?></th>
          <th width="6%">Is Received?</th>
          <th width="7%">Handover To</th>
          <th width="7%"><?php echo $this->lang->line('received_by'); ?></th>
          <th width="7%">Handover Time</th>
          <th width="6%"><?php echo $this->lang->line('fiscal_year'); ?> </th>

      </tr>
  </tr>
</thead>

<tbody>
    <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 


            ?>

            <tr>
                <td  style="border: 1px solid; padding: 7px 0 ; text-align: center "><?php echo $i; ?></td>
                <td style=" border:1px solid; padding: 7px 0; text-align: center"><?php echo !empty($row->haov_handoverno)?$row->haov_handoverno:'';?></td>
                <td style="border: 1px solid; padding: 7px 0; text-align: center"><?php echo !empty($row->haov_handoverreqno)?$row->haov_handoverreqno:'';?></td>
                <td style="border: 1px solid; padding: 7px 0; text-align: center"><?php echo !empty($row->haov_handoverdatead)?$row->haov_handoverdatead:'';?></td>
                <td style="border: 1px solid; padding: 7px 0; text-align: center"><?php echo !empty($row->haov_handoverdatebs)?$row->haov_handoverdatebs:'';?></td> 
                 <td style="border: 1px solid; padding: 7px 0; text-align: center"><?php  if($row->haov_isreceived =='Y'){ echo "Y"; }else{ echo "N"; }?></td>         
                <td style="border: 1px solid; padding: 7px 0; text-align: center"><?php echo !empty($row->tolocation)?$row->tolocation:'';?></td> 
                 <td style="border: 1px solid; padding: 7px 0; text-align: center"><?php echo !empty($row->haov_receivedby)?$row->haov_receivedby:'';?></td> 
                <td style="border: 1px solid; padding: 7px 0; text-align: center"><?php echo !empty($row->haov_handovertime)?$row->haov_handovertime:'';?></td>
                <!-- <td><?php echo !empty($row->rede_remarks)?$row->rede_remarks:'';?></td> -->
                <td style="border: 1px solid; padding: 7px 0; text-align: center"><?php echo !empty($row->haov_fyear)?$row->haov_fyear:'';?></td>

            </tr>
            <?php
            $i++;
        endforeach;
    endif;
    ?>
</tbody>
</table>

