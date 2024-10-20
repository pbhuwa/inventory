<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
    .format_pdf tr.table_bold td{font-size: 12px; font-weight: bold;}
</style>


<table width="100%" style="font-size:12px;" class="format_pdf_head">
                <tr>
                  <td width="25%"></td>
                  <td  style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><B><span class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAMETITLE; ?></span></B></h3></td>
                  <td width="25%"></td>
                </tr>
                <tr>
                  <td width="25%"></td>
                  <td  style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><B><span class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAME; ?></span></B></h3></td>
                  <td width="25%"></td>
                </tr>

                <tr class="title_sub">
                  <td width="25%"></td>
                  <td style="text-align: center;"><h4 style="color:black" class="<?php echo FONT_CLASS; ?>" ><?php echo ORGNAMEDESC; ?></h4></td> 
                  <td width="25%" style="text-align:right; font-size:10px;">
                    <?php echo $this->lang->line('date_time'); ?>: <?php echo CURDATE_NP ?> BS,</td>
                </tr> 

                <tr class="title_sub">
                  <td width="25%"></td>
                 <td style="text-align: center;"><b><font color="black"><span class="<?php echo FONT_CLASS; ?>" ><?php echo LOCATION; ?></span></font></b></td>
                  <td width="25%" style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
                </tr>

              </table>
<br><br>
              <table width="100%" style="font-size:12px;">
    <tr>
    <td style="width:45%">
    <td class="text-center">
      <b style="font-size:15px;"> 
        <u>Deprication Report <?php //echo $fiscal_year; ?></u>
      </b> 
    </td>
      </table>


<?php if(!empty($distinct_cat)):

          $total=0;
          $totaldeptilldateval=0;
          $accmulatdepprevyrs=0;
          $accmulateval=0;
          $opbalance=0;

      $all_cat_tamt=0;
      $all_totaldeptilldateval=0;
      $all_accmulatdepprevyrs=0;
      $all_accmulateval=0;
      $all_opbalance=0;


      foreach ($distinct_cat as $kcat => $cat):
      $deprication_report = $this->deprecation_report_mdl->get_deprecation_report($cat->asset_type);
      // echo $this->db->last_query();
      // die();
      if(!empty($deprication_report)): ?>
      <br>
      <strong><?php echo $cat->eqca_category; ?></strong>


<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('ass_code'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('assets'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('pur_date'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('s_date'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('e_date'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('pur_cost'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('ope_balance'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('deprate'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('f_year'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('accm_val'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('accmulatdepprevyrs'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('totaldeptilldateval'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('netvalue'); ?></th>

            
        </tr>
    </thead>
    <tbody>
        <?php 
          $i=1;
          // $total=0;
          // $totaldeptilldateval=0;
          // $accmulatdepprevyrs=0;
          // $accmulateval=0;
          // $opbalance=0;

          foreach ($deprication_report as $key => $result): 
        
          $total=$total+$result->dete_netvalue;
          $totaldeptilldateval=$totaldeptilldateval+$result->dete_totaldeptilldateval;
          $accmulatdepprevyrs=$accmulatdepprevyrs+$result->dete_accmulatdepprevyrs;
          $accmulateval=$accmulateval+$result->dete_accmulateval;
          $opbalance=$opbalance+$result->dete_opbalance;

        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $result->asen_assetcode; ?></td>
            <td><?php echo $result->itli_itemname; ?></td>
      			<td><?php echo $result->dete_purchasedatebs; ?></td>
      			<td><?php echo $result->dete_startdatebs; ?></td>
      			<td><?php echo $result->dete_orginalcost; ?></td>
      			<td><?php echo $result->dete_opbalance; ?></td>
      			<td><?php echo $result->dete_deprate; ?></td>
            <td><?php echo $result->dete_fiscalyrs; ?></td>
            <td><?php echo $result->dete_accmulateval; ?></td>
            <td><?php echo $result->dete_accmulatdepprevyrs; ?></td>
            <td><?php echo $result->dete_totaldeptilldateval; ?></td>
            <td><?php echo $result->dete_netvalue; ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        ?>
    </tbody>
    <tr class="table_bold">
      <th>Total</th>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td ><?php echo $opbalance; ?></td>
      <td></td>
      <td></td>
      <td><?php echo $accmulateval; ?></td>
      <td><?php echo $accmulatdepprevyrs; ?></td>
      <td><?php echo $totaldeptilldateval; ?></td>
      <td><?php echo $total; ?></td>
    </tr>
</table>

<?php endif; 
$all_cat_tamt +=$total;
$all_totaldeptilldateval +=$totaldeptilldateval;
$all_accmulatdepprevyrs +=$accmulatdepprevyrs;
$all_accmulateval += $accmulateval;
$all_opbalance += $opbalance;


endforeach; ?>

<br>
<table id="" class="format_pdf" width="100%">
      <tr>
        <th width="5%">Grand Total</th>
        <td width="8%"></td>
        <td width="8%"></td>
        <td width="8%"></td>
        <td width="8%"></td>
        <td width="8%"><?php echo number_format($all_opbalance,2);?></td>
        <td width="8%"></td>
        <td width="8%"></td>
        <td width="8%"><?php echo number_format($all_accmulateval,2);?></td>
        <td width="8%"><?php echo number_format($all_accmulatdepprevyrs,2);?></td>
        <td width="8%"><?php echo number_format($all_totaldeptilldateval,2);?></td>
        <td width="8%"><?php echo number_format($all_cat_tamt,2);?></td>      
      </tr>
</table>
<?php endif;?>