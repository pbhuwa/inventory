<style>

    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<table width="100%" style="font-size:12px;" class="format_pdf_head">
    <tr>
        
        <td colspan="6" class="web_ttl text-center" style="text-align:center;">
            <!-- <h2><?php //echo ORGA_NAME; ?></h2> -->
            <!-- <h3><?php echo ORGA_NAME; ?></h3> -->
        </td>
        <td></td>
    </tr>
    <tr class="title_sub">
        
        <!-- <td style="text-align:center;"><?php //echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td> -->
        <td colspan="6" style="text-align:center;"><h3 style="margin: 0px"><?php echo ORGA_NAME ?></h3></td>
        <td style="text-align:right; font-size:10px;"><?php echo $this->lang->line('date_time'); ?>: <?php echo CURDATE_NP ?> <?php echo $this->lang->line('bs'); ?>,</td>
    </tr>
    <tr class="title_sub">
        <!-- <td></td> -->
        <td colspan="6" style="text-align:center;"><h3 style="margin: 0px">
        <?php echo ORGA_ADDRESS1 ?></h3></td><span id="rptType"></span></td>
        <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> <?php echo $this->lang->line('ad'); ?> </td>
    </tr>
    <tr class="title_sub">
        <!-- <td width="200px"></td> -->
        <td colspan="6" style="text-align:center;"><h4 style="margin: 0px;"><span id="rptTypeSelect"><?php echo  ORGA_ADDRESS2 ?></h4></span><span id="rptTypeCheck"></span></td>
        <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
    </tr>
</table>
<br>
<table width="100%">
    <tr class="title_sub">

        <td colspan="6" style="text-align:center;"><font style="font-size:15px;"><u><?php echo $this->lang->line('list_contract'); ?></u><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></font></td>
        
    </tr>
</table>
<br>

<table id="myTable" class="format_pdf" width="100%">
    <thead>
                <tr>
                  <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                  <th width="5%"><?php echo $this->lang->line('distributor'); ?></th>
                  <th width="15%"><?php echo $this->lang->line('name'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('title'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('start_date'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('passed_days'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('end_date'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('remaining_days'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('renew_type'); ?></th>
                  <th width="5%"><?php echo $this->lang->line('value'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if($contractmgmt_list):
                  $i=1;
                  foreach ($contractmgmt_list as $key => $value):
                   
                    $date1=date_create($value->coin_contractstartdatebs );
                    $date2=date_create(CURDATE_NP);
                    $diff_passed=date_diff($date1,$date2);
                   
                    
                    $date3=date_create($value->coin_contractenddatebs );
                    $diff_remaining=date_diff($date2,$date3);
                   
                ?>
                <tr>
                  <td><?php echo $i; ?>.</td>
                  <td><?php echo $value->coty_contracttype ?></td>
                  <td><?php echo $value->dist_distributor ?></td>
                  <td><?php echo $value->coin_contracttitle ?></td>
                  <!-- <td><?php echo $value->coin_contractstartdatead ?></td> -->
                  <td><?php echo $value->coin_contractstartdatebs ?></td>
                  <!-- <td><?php echo $value->coin_contractenddatead ?></td> -->
                   <td><?php echo $diff_passed->format("%a days"); ?></td> 
                 <td><?php echo $value->coin_contractenddatebs ?></td>
                   <td><?php echo $diff_remaining->format("%R%a days"); ?></td> 

                  <td><?php echo $value->rety_renewtype ?></td>
                  <td><?php echo $value->coin_contractvalue ?></td>
                  <td><?php echo $value->coin_description ?></td>
                </tr>


                <?php
                  $i++;
                  endforeach;
                  endif;
                ?>

              </tbody>
</table>

