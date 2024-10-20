<style>  

   .table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
   .table_jo_header { width:100%; vertical-align: top; font-size:12px; }
   .table_jo_header td.text-center { text-align:center; }
   .table_jo_header td.text-right { text-align:right; }
   h4 { font-size:18px; margin:0; }
   .table_jo_header u { text-decoration:underline; padding-top:15px; }
   .jo_tbl_head td td
   {
   padding-bottom: 10px;
   }
   .jo_table{margin-top: 15px !important;}
   .jo_table { border-right:1px solid #333; margin-top:5px; }
   .jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }
   .jo_table tr th { padding:5px 3px;}
   .jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
   .preeti{
   font-family: preeti;
   }
   .borderbottom{ border-bottom: 1px dashed #333;margin: 0px;padding: 0px; }
   .tableWrapper{
   min-height:40%;
   height:40vh;
   max-height: 100vh;
   white-space: nowrap;
   display: table;
   width: 100%;

   }
   .itemInfo{
   height:100%;
   }
   .itemInfo .td_cell{
   padding:5px;margin:5px; 
   }
   .itemInfo .td_empty{
   height:100%;
   }
   .jo_table tr td{border-bottom: 1px solid #000; padding: 0px 4px;}
  
   .footerWrapper{
   page-break-inside: avoid;
   }
   .dateDashedLine{
   min-width: 100px;display: inline-block; border:1px dashed #333;
   }
   .signatureDashedLine {
   min-width: 170px;display: inline-block; border:1px dashed #333;
   }

   img.signatureImage{
   width: 70px;
   }
</style>
<div class="jo_form organizationInfo">
   
   <table class="table_jo_header purchaseInfo">
      <tr>
         <td width="25%" rowspan="5"></td>
         <td class="text-center"><h3 class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></h3></td>
         <td width="25%" rowspan="5" class="text-right"></td>
      </tr>
      <tr>
         <td class="text-center"><h4 class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></h4></td>
      </tr>
      <tr>
         <td class="text-center <?php echo FONT_CLASS; ?>"><?php echo LOCATION;?></td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td class="text-center <?php echo FONT_CLASS; ?>"><h4><u>स्थानान्तरण फारम</u></h4></td>
      </tr>
   </table>
   <table class="jo_tbl_head">
      <tr>
         <?php $transfer_no=!empty($this->input->post('transfer_no'))?$this->input->post('transfer_no'):''; ?>

         <td width="17%" class="text-right"><span class="<?php echo FONT_CLASS; ?>"> स्थानान्तरण नं</span>: 
            <?php echo  !empty($transfer_master[0]->tfma_transferinvoice)?$transfer_master[0]->tfma_transferinvoice:$transfer_no; ?>
         </td>
         <?php $fiscal_year=!empty($this->input->post('fiscal_year'))?$this->input->post('fiscal_year'):''; ?>
         
         <td width="17%" class="text-right"><span class="<?php echo FONT_CLASS; ?>"> आर्थिक वर्ष </span>: 
            <?php echo  !empty($transfer_master[0]->tfma_fiscalyear)?$transfer_master[0]->tfma_fiscalyear:$fiscal_year;?>
         </td>
         <td width="17%" class="text-right">
<?php $transfer_date=!empty($this->input->post('transfer_date'))?$this->input->post('transfer_date'):''; ?>
<span class="<?php echo FONT_CLASS; ?>"> मिति </span>: <?php echo !empty($transfer_master[0]->tfma_transferdatebs)?$transfer_master[0]->tfma_transferdatebs:$transfer_date;?></td>

         
      </tr>
   </table>
   <br>
   <table class="table_jo_header purchaseInfo">
      <tr>
         <td colspan=3></td>
         <td><span class="<?php echo FONT_CLASS; ?>"><font style="text-align: center"> श्री </font></span>  
            <span class="borderbottom"><u>
               <?php echo !empty($transfer_master[0]->tfma_transferby)?$transfer_master[0]->tfma_transferby:'___________';
             ?> </u></span>
            <span class="<?php echo FONT_CLASS; ?>">लाई </span>
         </td>
      </tr>
   </table>
   <div class="tableWrapper">
      <table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
         <thead>
            <tr>
            <th width="5%" style="text-align: center"> सि .</th>
            <th width="10%" style="text-align: center"> मलसामानको विवरण </th>
            <th width="30%" style="text-align: center"> सामानको नाम </th>
            <th width="10%" style="text-align: center"> एकाइ </th>
            <th width="10%" style="text-align: center"> स्टक मात्रा </th>
            <th width="10%" style="text-align: center"> स्थानान्तरण मात्रा </th>
            <th width="25%" style="text-align: center"> कैफियत </th>
            </tr>
         </thead>
         <tbody>
            <?php if($transfer_details)
               { 
               
              
                  foreach($transfer_details as $key => $transfer){
               
                      ?>
            <tr>
               <td class="td_cell">
                  <?php echo $key+1; ?>
               </td>
             <td class="td_cell"> <?php echo !empty($transfer->itli_itemcode)?$transfer->itli_itemcode:''; ?></td>
               <td class="td_cell"> <?php echo !empty($transfer->itli_itemname)?$transfer->itli_itemname:'';?>
               </td>
               <td class="td_cell"> <?php echo !empty($transfer->unit_unitname)?$transfer->unit_unitname:''; ?>
                 
               </td>
               <td class="td_cell">
                  <?php echo !empty($transfer->tfde_stockqty)?$transfer->tfde_stockqty:''; ?>
               </td>
               <td class="td_cell" align="right"> <?php echo !empty($transfer->tfde_reqtransferqty)?$transfer->tfde_reqtransferqty:''; ?></td>
               <td class="td_cell" align="right">  <?php echo !empty($transfer->tfde_remarks)?$transfer->tfde_remarks:''; ?></td>
               </tr>
            <?php  
               }?>
            <?php
               $row_count = count($transfer);
               
               if($row_count < 15):
               ?>
            <tr>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               
               <td class="td_empty"></td>
            </tr>
            <?php endif;?>
            <?php
               
              
                 } else{ ?>
            <?php
               $itemid = !empty($report_data['itemid'])?$report_data['itemid']:'';
               if(!empty($itemid)): // echo"<pre>";print_r($itemid);die;
               //$sumnewno=0; $newno=0;
               foreach($itemid as $key=>$products):
               ?>
            <tr>
               <td class="td_cell">
                  <?php echo $key+1; ?>
               </td>
               <td class="td_cell">
                  <?php echo !empty($report_data['rede_code'][$key])?$report_data['rede_code'][$key]:''; ?>
               </td>
               <td class="td_cell">
                 <?php 
               $itemid = !empty($report_data['itemid'][$key])?$report_data['itemid'][$key]:'';
               $itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
               echo !empty($itemname[0]->itli_itemcode)?$itemname[0]->itli_itemcode:'';
            ?>
            <?php echo !empty($report_data['rede_code'][$key])?$report_data['rede_code'][$key]:''; ?>
               </td>
               <td class="td_cell">
                  <?php 
               $itemid = !empty($report_data['itemid'][$key])?$report_data['itemid'][$key]:'';
               $itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
               echo !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';
            ?>
               </td>
               <td class="td_cell">
                  <?php echo !empty($report_data['unit'][$key])?$report_data['unit'][$key]:''; ?>
               </td>
               <td class="td_cell"><?php echo !empty($report_data['stock_qty'][$key])?$report_data['stock_qty'][$key]:''; ?></td>
               <td class="td_cell">
                 <?php echo !empty($report_data['transfer_qty'][$key])?$report_data['transfer_qty'][$key]:''; ?>
               </td>
               <td class="td_cell"> <?php echo !empty($report_data['remarks'][$key])?$report_data['remarks'][$key]:''; ?></td>
            </tr>
            <?php

               endforeach;
               ?>
            <?php
               $row_count = count($report_data['itemid']);
               
               if($row_count < 15):
               ?>
            <tr>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
               <td class="td_empty"></td>
             
            </tr>
            <?php endif;?>
            <?php

               endif;

               }
               ?>
         </tbody>  

      </table>
   </div>

   <table class="footerWrapper">
      <tr>
         <td width="60%" style="padding-top: 30px;">माग गर्नेको दस्तखत  : </td>
         <td width="40%" style="padding-top: 30px;">(क) बजारबाट खरिद गरिदिनु । </td>
      </tr>
      <tr>
         <td>नाम  : </td>
         <td>(ख) मौज्दात दिनु ।</td>
      </tr>
      <tr>
         <td>मिति  : </td>
         <td></td>
      </tr>
      <tr>
         <td>प्रायोजन  : </td>
         <td>आदेश दिनेको दस्तखत  : </td>
      </tr>
      <tr>
         <td></td>
         <td>मिति  : </td>
      </tr>
      <tr>
         <td>जिन्सी खाता चढाउनेको दस्तखत  : </td>
         <td></td>
      </tr>
      <tr>
         <td>मिति  : </td>
         <td>माल सामान बुझिलिनेको दस्तखत  : </td>
      </tr>
      <tr>
         <td></td>
         <td>मिति  : </td>
      </tr>
      <tr>
         <td>तयार पार्नेका नाम  : </td>
         <td></td>
      </tr>
      <tr>
         <td>मिति  : </td>
         <td></td>
      </tr>
      <tr>
         <td>दस्तखत  : </td>
         <td></td>
      </tr>
   </table>
</div>