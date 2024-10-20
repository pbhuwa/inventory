<?php
   $storekeeper_signature_view_group = array('SI','SK','PR','AC','SA', 'DM');

   $branch_manager_signature_view_group = array('BM','SI','SK','PR','AC','SA','DM');
?>
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
   .jo_footer { border:1px solid #333; vertical-align: top; }
   .jo_footer td { padding:8px 8px;	}
   .preeti{
   font-family: preeti;
   }
   .borderbottom{ border-bottom: 1px dashed #333;margin: 0px;padding: 0px; }
   .tableWrapper{
   min-height:60%;
   height:60vh;
   max-height: 100vh;
   white-space: nowrap;
   display: table;
   width: 100%;
   /*overflow-y: auto;*/
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
   /*.itemInfo tr:last-child td{border:0px !important;}
   .itemInfo {border-bottom: 0px;}*/
   .footerWrapper{
   page-break-inside: avoid;
   }
   .dateDashedLine{
   min-width: 100px;display: inline-block; border:1px dashed #333;
   }
   .signatureDashedLine {
   min-width: 170px;display: inline-block; border:1px dashed #333;
   }
   .jo_footer img{
   margin-top: -15px;
   margin-left: 10px;
   }
   img.signatureImage{
   width: 70px;
   }
</style>
<div class="jo_form organizationInfo">
   <div class="headerWrapper">
      <?php 
         //$header['report_no'] = 'म.ले.प.फा.नं ५१';
         $header['report_title'] = 'माग फारम';
         $this->load->view('common/v_print_report_header',$header);
         ?>
      <table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">
         <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%"></td>
            <!-- <td width="33.333333%" style="text-align: right;">
               <span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">निकासी  नं </span>
               <span class="borderbottom" style="min-width:80px;display: inline-block;margin: 0px;padding: 0px; "></span>
               </td> -->
         </tr>
         <tr>
            <td width="80%">
               <span style="font-size: 12px; margin-bottom: 5px;" class="<?php echo FONT_CLASS; ?>"> श्री </span> <span class="borderbottom"><?php
                  if($stock_requisition){
                  	echo !empty($stock_requisition[0]->rema_reqby)?$stock_requisition[0]->rema_reqby:''; 
                  }else{
                   	echo !empty($report_data['rema_reqby'])?$report_data['rema_reqby']:'';
                  } ?> </span>
               <!-- <span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">लाई </span> -->
            </td>
            
            <td width="10%" style="text-align: center;padding-right: 70px;" class="text-center">
               <span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">माग नं </span> 
               	<?php
                  if($stock_requisition){ ?>
               		<span class="borderbottom"> 
               			<?php 
                  echo !empty($stock_requisition[0]->rema_reqno)?$stock_requisition[0]->rema_reqno:''; ?> 
               	<?php }else{ ?>
               	<span class="borderbottom">
               	 	<?php echo !empty($report_data['rema_reqno'])?$report_data['rema_reqno']:'';
                  } ?></span>
               </td>
            <!-- rema_reqdatebs -->
            <!-- 	<td width="33.333333%" style="text-align: right;">
               <span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> मिति </span>: 
               <span class="borderbottom">
               	<?php echo !empty($stock_requisition[0]->rema_reqdatebs)?$stock_requisition[0]->rema_reqdatebs: CURDATE_NP;?>
               </span>
               </td> -->
         </tr>
      </table>
   </div>
   <div class="tableWrapper">
      <table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
         <thead>
            <tr>
               <th width="5%" class="td_cell" rowspan="2"> सि.न.</th>
               <!-- <th width="7%" class="td_cell" rowspan="2">जिन्सी खातापन न. </th> -->
               <th width="25%" style="padding-left: 50px;" class="td_cell" rowspan="2"> सामानको विवरण </th>
               <th width="7%"  style="padding-left: 60px;" class="td_cell" colspan="2"> परिमाण </th>
               <th width="7%"  style="padding-left: 15px;" class="td_cell" rowspan="2"> इकाई </th>
               <th width="10%" style="padding-left: 30px;" class="td_cell"> दर</th>
               <th width="10%" style="padding-left: 10px;" class="td_cell"> जम्मा रकम </th>
               <th width="15%" style="padding-left: 30px;" class="td_cell" rowspan="2"> कैफियत </th>
            </tr>
            <tr>
               <th width="10%" style="padding-left: 30px;" class="td_cell">माग</th>
               <th width="10%" style="padding-left: 20px;" class="td_cell">निकासा</th>
               <th width="10%" style="padding-left: 30px;" class="td_cell"> रू</th>
               <th width="10%" style="padding-left: 30px;" class="td_cell">रू </th>
            </tr>
         </thead>
         <tbody>
            <?php if($stock_requisition)
               { 
               	$grandtotal=0;
                //echo"<pre>";  print_r($stock_requisition);die;
               	foreach($stock_requisition as $key => $stock){
               		$cur_qty=!empty($stock->rede_qty)?$stock->rede_qty:'';
               	    $rate = !empty($stock->rede_unitprice)?$stock->rede_unitprice:'';	 
               		$totamt=!empty($stock->rede_totalamt)?$stock->rede_totalamt:'';
               
               
               		 ?>
            <tr>
               <td class="td_cell">
                  <?php echo $key+1; ?>
               </td>
              <!--  <td class="td_cell">
                  <?php //echo !empty($stock->itli_itemcode)?$stock->itli_itemcode:'';
                     ?>
               </td> -->
               <td class="td_cell">
                  <?php 
                     if(ITEM_DISPLAY_TYPE=='NP'){
                     
                     	echo !empty($stock->itli_itemnamenp)?$stock->itli_itemnamenp:$stock->itli_itemname;
                     }else
                     {
                     	
                     	echo !empty($stock->itli_itemname)?$stock->itli_itemname:'';
                     }
                     ?>
               </td>
               <td class="td_cell" align="right">   <?php echo $cur_qty; ?>
               </td>
               <td class="td_cell" align="right">
                 
               </td>
               <td class="td_cell">
                  <?php echo !empty($stock->unit_unitname)?$stock->unit_unitname:''; ?>
               </td>
               <td class="td_cell" align="right"><?php echo $rate ?></td>
               <td class="td_cell" align="right"><?php echo $totamt ?></td>
               <td class="td_cell">
                  <?php echo !empty($stock->rede_remarks)?$stock->rede_remarks:''; ?>
               </td>
            </tr>
            <?php  $grandtotal+=$totamt; 
               }?>
            <?php
               $row_count = count($stock);
               
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
               <td class="td_empty"></td>
               <!-- <td class="td_empty"></td> -->
            </tr>
            <?php endif;?>
            <?php
               
              
                 } else{ ?>
            <?php
               $itemid = !empty($report_data['rede_itemsid'])?$report_data['rede_itemsid']:'';
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
                     $itemid = !empty($report_data['rede_itemsid'][$key])?$report_data['rede_itemsid'][$key]:'';
                     $itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
                     if(ITEM_DISPLAY_TYPE=='NP'){
                     	echo !empty($itemname[0]->itli_itemnamenp)?$itemname[0]->itli_itemnamenp:$itemname[0]->itli_itemname;
                     }else
                      {
                     	echo !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';
                     }
                     
                     
                     ?>
               </td>
               <td class="td_cell">
                  <?php echo !empty($report_data['rede_qty'][$key])?$report_data['rede_qty'][$key]:''; ?>
               </td>
               <td class="td_cell">
                  <?php 
                     $unitid = !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:'';
                     $unitname =  $this->general->get_tbl_data('*','unit_unit',array('unit_unitid'=>$unitid),false,'DESC');
                     echo !empty($unitname[0]->unit_unitname)?$unitname[0]->unit_unitname:'';
                     ?>
                  <!-- <?php //echo !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:''; ?> -->
               </td>
               <td class="td_cell"></td>
               <td class="td_cell">
                  <?php echo !empty($report_data['rede_remarks'][$key])?$report_data['rede_remarks'][$key]:''; ?>
               </td>
            </tr>
            <?php

               endforeach;
               ?>
            <?php
               $row_count = count($report_data['rede_itemsid']);
               
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
               <td class="td_empty"></td>
               <td class="td_empty"></td>
            </tr>
            <?php endif;?>
            <?php

               endif;

               }
               ?>
         </tbody>
         <tfoot>
            <tr>
               <td class="td_cell" colspan="5">अक्षरूपी : <?php echo $this->general->number_to_word( $grandtotal);?> </td>
               <td>अनुमानित लागत :</td>
               <td align="right"><?php echo $grandtotal; ?></td>
               <td></td>
            </tr>
         </tfoot>
      </table>
   </div>
   <div class="footerWrapper">
      <table class="jo_footer" style="padding-top: 10px;padding-bottom: 10px;border: 0px solid #000;border-top: 0px;page-break-inside: avoid;">
         <tr>
            <td width="60%" style="padding-top: 30px;"> बजेटमा रकम ब्यवस्था छ / छैन   </td>
            <td width="60%" style="padding-top: 30px;"> मौज्दात छ / छैन   </td>
         </tr>
         <tr>
            <td style="padding-top: 25px;"><span class="signatureDashedLine"></span></br>
               लेखा अधिकृत 
            </td>
            <td style="padding-top: 10px;white-space: nowrap;">
               <?php
                  $storekeeper_signature = '';

                  $storekeeper_id = !empty($stock_requisition_details[0]->rema_approvedid)?$stock_requisition_details[0]->rema_approvedid:'';

                  if(in_array($this->usergroup, $storekeeper_signature_view_group)):
                     if(!empty($storekeeper_id)):
                        $get_storekeeper_signature = $this->general->get_signature($storekeeper_id);

                        $storekeeper_signature = $get_storekeeper_signature->usma_signaturepath;
                     endif;
                  endif;
               ?>
               <?php
                  if(!empty($storekeeper_signature)):
               ?>
               <span class="signatureDashedLine">
                  <img src="<?php echo base_url(SIGNATURE_UPLOAD_PATH).'/'.$storekeeper_signature; ?>" alt="" class="signatureImage" />
               </span>
               <?php
                  else:
               ?>
               <span class="signatureDashedLine"></span>
               <?php
                  endif;
               ?>
               </br>
               स्टोर किपर
            </td>
            <td style="padding-top: 10px;">
               <?php
                  $demander_id = $stock_requisition_details[0]->rema_postby;

                  if(!empty($demander_id)):
                     $get_demander_signature = $this->general->get_signature($demander_id);

                     $demander_signature = $get_demander_signature->usma_signaturepath;
                  else:
                     $demander_signature = '';
                  endif;

                  if(!empty($demander_signature)):
               ?>
               <span class="signatureDashedLine">
                   <img src="<?php echo base_url(SIGNATURE_UPLOAD_PATH).'/'.$demander_signature; ?>" alt="" class="signatureImage"> 
               </span> माग गर्नेको सही र मिति
               <?php
                  else:
               ?>
                  <span class="signatureDashedLine"></span> माग गर्नेको सही र मिति
               <?php
                  endif;
               ?>
               <!-- <span class="signatureDashedLine"></span> -->
            </td>
         </tr>
         <tr>
            <td style="padding-top: 25px;"><span class="signatureDashedLine"></span></br>बजारबाट  खरीद  गर्न स्वीकृत 
            </td>
            <td></td>
            <?php
               $branch_manager_signature = '';

               $branch_manager_id = !empty($stock_requisition_details[0]->rema_verifiedby)?$stock_requisition_details[0]->rema_verifiedby:'';
               
               if(in_array($this->usergroup, $branch_manager_signature_view_group)):
                  if(!empty($branch_manager_id)):
                     $get_branch_manager_signature = $this->general->get_signature($branch_manager_id);

                     $branch_manager_signature = $get_branch_manager_signature->usma_signaturepath;
                  endif;
               endif;
            ?>
            <td style="padding-top: 20px;padding-bottom: 20px;">
               <?php
                  if(!empty($branch_manager_signature)):
               ?>
               <span class="signatureDashedLine"><img src="<?php echo base_url(SIGNATURE_UPLOAD_PATH).'/'.$branch_manager_signature; ?>" alt="" class="signatureImage"></span> शाखा प्रमुखको सिफारिश 
               <?php
                  else:
               ?>
               <span class="signatureDashedLine"></span> शाखा प्रमुखको सिफारिश 
               <?php
                  endif;
               ?>
            </td>
         </tr>
         <tr>
            <td style="padding-top: 20px;padding-bottom: 20px;"><span class="signatureDashedLine"></span></br>आदेश  दिने अधिकारी
            </td>
            <td style="padding-top: 10px;padding-bottom: 20px;">
            </td>
         </tr>
      </table>
   </div>
</div>