<style> 
    .table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
    .table_jo_header { width:100%; vertical-align: top; font-size:12px; }
    .table_jo_header td.text-center { text-align:center; }
    .table_jo_header td.text-right { text-align:right; }
    h4 { font-size:18px; margin:0; }
    .table_jo_header u { text-decoration:underline; padding-top:15px; }

    .jo_table { border-right:1px solid #333; margin-top:5px; }
    .jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

    .jo_table tr th { padding:5px 3px; background: #258967}
    .jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
    
    .jo_footer { border:1px solid #333; vertical-align: top; }
    .jo_footer td { padding:8px 8px;    }
    .alt_table { width:100%; border-collapse:collapse; border:1px solid #000;}
    .alt_table thead tr th, .alt_table tbody tr td { border:1px solid #e4e7ea; padding:5px 5px; font-size:13px; }
    .alt_table tbody tr td { padding:5px; font-size:12px; }
    .alt_table tbody tr.alter td { border:0; text-align:center; }
    .text-right{ text-align:right; }
    .alt_table thead tr th{background: #258967;color: #fff;}
    .jo_form h4{    margin-bottom: 6px;margin-top: 4px;font-size: 15px;}
    .alt_table tbody tr:nth-of-type(odd){background: #f9f9f9;} 
</style>
<div class="col-sm-12">
    <div class="white-box pad-5 mtop_10 pdf-wrapper">
        <div class="jo_form organizationInfo" id="printrpt">
        <h4 class="text-center"><?php echo $this->lang->line('monthly_department_requisition'); ?> <?php echo $this->lang->line('items'); ?></h4>
                <?php if(!empty($details_requisition_department)){
                  //echo"<pre>"; print_r($details_requisition_department);die;
                    $sumqty=0;$raetsum=0;$totalsum=0;
                foreach ($details_requisition_department as $key => $value) {  ?>
                <h5 style="background: #ebebeb;margin: 0px;padding: 5px;font-size: 13px;"><?php echo $this->lang->line('department_name'); ?> : <b><?php echo $value->dept_depname; ?></b></h5>
                <table class="alt_table" style="margin-bottom: 10px;">
                    <thead>
                        <tr>
                            <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>
                            <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                            <th width="30%"><?php echo $this->lang->line('item_name'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?> </th>
                            <th width="5%"><?php echo $this->lang->line('received_by'); ?> </th>
                            <th width="5%"><?php echo $this->lang->line('invoice_no'); ?> </th>
                            <th width="8%"><?php echo $this->lang->line('date_bs'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('date_ad'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('unit'); ?>   </th>
                            <th width="5%"><?php echo $this->lang->line('qty'); ?>   </th>
                            <th width="10%"><?php echo $this->lang->line('rate'); ?>  </th>
                            <th width="5%"><?php echo $this->lang->line('total'); ?> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $details = $this->monthlywise_item_issue_mdl->get_details_issue(array('sade_salemasterid'=>$value->salemasterid,'rd.sade_itemsid'=>$value->sade_itemsid));
                    //echo $this->db->last_query();
               // echo"<pre>"; print_r($details);
                $sum3 = 0; $sum1 = 0;  $sum2 = 0;
                if($details):
                    foreach($details as $key=>$df): 
                    ?>
                    <tr>
                        <?php 
                        $cal1 = $df->sade_curqty;
                        $cal2 = $df->sade_unitrate;
                        $cal3 = $cal1*$cal2;
                        ?>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $df->itli_itemcode; ?></td>
                        <td><?php echo $df->itli_itemname; ?></td>
                        <td><?php echo $df->sama_fyear; ?></td>
                        <td><?php echo $df->sama_receivedby ?></td>
                        <td><?php echo $df->sama_invoiceno ?></td>
                        <td><?php echo $df->sama_username ?></td>
                        <td><?php echo $df->sama_billdatebs; ?></td>
                        <td><?php echo $df->sama_billdatead; ?></td>
                        <td><?php echo $df->sade_unit; ?></td>
                        <td><?php echo $df->sade_curqty; ?></td>
                        <td><?php echo $df->sade_unitrate; ?></td>
                         <td></td>

                        <?php $sum3+= $df->sade_curqty;?>
                        <?php $sum1+= $df->sade_unitrate;?>
                        <?php $sum2+= $cal3;?>
                    </tr>
                    <?php endforeach; 
                    endif; ?>
                    <tr>
                        <td colspan="9"  style="font-size:14px;" class="text-right"><b><?php echo $this->lang->line('grand_total'); ?> :</b>   </td>
                        <td class="text-right"  style="font-size:14px;" ><b><?php  echo number_format($sum3,2);?></b></td>
                        <td class="text-right"  style="font-size:14px;" ><b><?php  echo number_format($sum1,2);?></b></td>
                        <td class="text-right"  style="font-size:14px;" ><b><?php  echo number_format($sum2,2);?></b></td>
                    </tr>
                    </tbody>
                </table>
             <?php $sumqty +=$sum3;
                    $raetsum +=$sum1;
                    $totalsum +=$sum2;
              }    ?>
              <table width="100%">
                  <tr>
                      <td width="71%" style="text-align: right; font-size: 14px;"><b><?php echo $this->lang->line('total_issue'); ?> : <?php echo number_format($sumqty,2);  ?></b></td>
                      <td colspan="4" style="text-align: right; font-size: 14px;"><b><?php echo $this->lang->line('price_sum'); ?> : <?php echo number_format($totalsum,2);  ?></b></td>
                  </tr>
              </table>
        <?php } ?>
        </div>
    </div>
</div>


