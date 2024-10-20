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
    <td class="text-center"><b style="font-size:15px;"> <u> LIST OF AMC DETAILS </u></b> </td>
            </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
          <th width="10%">S.N.</th>
          <th width="10%">Assets Code</th>
          <th width="10%">Description</th>
          <th width="15%">Department</th>

          <th width="15%">Brand</th>
          <th width="15%">Condition</th> 
          <th width="15%">Manufacture</th>
          <th width="15%">Distributor</th>
          <th width="5%"> Amc Date(A.D)</th>
          <th width="5%"> Amc Date(B.S)</th>
          <th width="10%">Complete By</th>
          <th width="15%">AMC Status</th>
        
          
                     
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        // print_r($searchResult);
        // die();

        $i=1;
        foreach ($searchResult as $key => $result): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
        		<td><?php echo !empty($result->bmin_equipmentkey)?$result->bmin_equipmentkey:''; ?></td>
        		<td><?php echo !empty($result->eqli_description)?$result->eqli_description:''; ?></td>
        		<td><?php echo !empty($result->dein_department)?$result->dein_department:''; ?></td>
            <td><?php echo !empty($result->rode_roomname)?$result->rode_roomname:'' ;?></td>
            <td><?php echo !empty($result->riva_risk)?$result->riva_risk:'' ;?></td>
            <td><?php echo !empty($result->manu_manlst)?$result->manu_manlst:''; ?></td>
            <td><?php echo !empty($result->dist_distributor)?$result->dist_distributor:'' ; ?></td>
        		<td><?php echo !empty($result->amta_postdatead)?$result->amta_postdatead:''; ?></td>
        		<td><?php echo !empty($result->amta_postdatebs)?$result->amta_postdatebs:''; ?></td>
            <td><?php echo !empty($this->session->userdata('user_name'))?$this->session->userdata('user_name'):''; ?></td>
            <td><?php 
            if($result->amta_isamccompleted=='1')
              {
                echo 'Completed';
              }
            elseif($result->amta_isamccompleted=='0')
            {
              echo 'Not Completed'; 
            }?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>