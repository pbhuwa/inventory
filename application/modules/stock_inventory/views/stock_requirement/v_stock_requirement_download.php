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
    <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('stock_received'); ?>  </u></b> </td>
            </table>

<strong><?php echo $this->lang->line('date'); ?>: </strong><?php echo $fromdate; ?>&nbsp;&nbsp;&nbsp;
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="5%"><?php echo $this->lang->line('category'); ?></th>
                <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                <th width="10%"><?php echo $this->lang->line('opening'); ?></th>
                <th width="10%"><?php echo $this->lang->line('received'); ?></th>
                <th width="10%"><?php echo $this->lang->line('issue'); ?></th>
                <th width="10%"><?php echo $this->lang->line('balance'); ?></th>
                <th width="10%"><?php echo $this->lang->line('current_month'); ?></th>
                <th width="10%"><?php echo $this->lang->line('previous_month1'); ?></th>
                <th width="10%"><?php echo $this->lang->line('previous_month2'); ?></th>
                <th width="10%"><?php echo $this->lang->line('previous_month1_quantity'); ?></th>
                <th width="10%"><?php echo $this->lang->line('previous_month2_quantity'); ?></th>
                <th width="10%"><?php echo $this->lang->line('req_no'); ?></th>
                <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
    </thead>
    <tbody>
        <?php
            if(!empty($searchResult)):
                 foreach($searchResult as $key=>$list):
               $listar[]=$list->categoryname;
                endforeach;
                 $uniqueCat=array_unique($listar);
               
                foreach($searchResult as $key=>$list):
                    // $unique_catname=l
                    if(array_key_exists($key, $uniqueCat))
                    {
                        $catlist= $list->categoryname;
                    }
                    else
                    {
                         $catlist='';
                    }
                    
        ?>
            <tr>
                <td>
                    <?php echo "<strong>".$catlist."</strong>"; //!empty($list->categoryname)?$list->categoryname:''; ?>
                </td>
                <td>
                    <?php echo !empty($list->itemcode)?$list->itemcode:''; ?>
                </td>
                <td>
                    <?php echo !empty($list->itemname)?$list->itemname:''; ?>
                </td>
                <td>
                    <?php echo !empty($list->op_qty)?$list->op_qty:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->rec_qty)?$list->rec_qty:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->issue_qty)?$list->issue_qty:0; ?>
                </td>
                <td>
                    <?php 
                        $opening = !empty($list->op_qty)?$list->op_qty:0;
                        $received = !empty($list->rec_qty)?$list->rec_qty:0;
                        $issue = !empty($list->issue_qty)?$list->issue_qty:0;
                        $total = $opening + $received - $issue;
                        echo $total;
                    ?>
                </td>
                <td>
                    <?php echo !empty($list->cmonth1)?round($list->cmonth1,2):0; ?>
                </td>
                <td>
                    <?php echo !empty($list->cmonth2)?round($list->cmonth2,2):0; ?>
                </td>
                <td>
                    <?php echo !empty($list->cmonth3)?round($list->cmonth3,2):0; ?>
                </td>
                <td>
                    <?php echo !empty($list->cmonth2_qty)?$list->cmonth2_qty:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->cmonth3_qty)?$list->cmonth3_qty:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->req_qty)?$list->req_qty:0; ?>
                </td>
                <td>
                    <?php echo !empty($list->purchaserate)?$list->purchaserate:0; ?>
                </td>
                <td>
                    <?php
                        $qty = !empty($list->req_qty)?$list->req_qty:'';
                        $rate = !empty($list->purchaserate)?$list->purchaserate:'';
                        echo $qty*$rate; ?>
                </td>
            </tr>    
        <?php
                endforeach;
            endif;
        ?>
    </tbody>
</table>