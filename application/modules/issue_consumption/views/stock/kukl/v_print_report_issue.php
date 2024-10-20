<?php

   // for remarks

$rema_workplace = !empty($stock_requisition[0]->rema_workplace)?$stock_requisition[0]->rema_workplace:'';

$rema_workdesc = !empty($stock_requisition[0]->rema_workdesc)?$stock_requisition[0]->rema_workdesc:'';

$rema_recommendstatus = !empty($stock_requisition[0]->rema_recommendstatus)?$stock_requisition[0]->rema_recommendstatus:'';

$rema_remarks = !empty($stock_requisition[0]->rema_remarks)?$stock_requisition[0]->rema_remarks:'';



$reqno = !empty($stock_requisition[0]->rema_reqno)?$stock_requisition[0]->rema_reqno:'';



$fyear = !empty($stock_requisition[0]->rema_fyear)?$stock_requisition[0]->rema_fyear:'';



$centralrequest = !empty($stock_requisition[0]->rema_centralrequest)?$stock_requisition[0]->rema_centralrequest:'';

$proceedissue = !empty($stock_requisition[0]->rema_proceedissue)?$stock_requisition[0]->rema_proceedissue:'';

$proceedpurchase = !empty($stock_requisition[0]->rema_proceedpurchase)?$stock_requisition[0]->rema_proceedpurchase:'';



   // department supervisor

$department_supervisor_data = $this->general->get_user_list_for_report($reqno, $fyear, '4', 'rema_approved');

$department_supervisor_fullname = !empty($department_supervisor_data[0]->usma_fullname)?$department_supervisor_data[0]->usma_fullname:'';

$department_supervisor_empid = !empty($department_supervisor_data[0]->usma_employeeid)?$department_supervisor_data[0]->usma_employeeid:'';

if(DEFAULT_DATEPICKER == 'NP'){

   $department_supervisor_date = !empty($department_supervisor_data[0]->aclo_actiondatebs)?$department_supervisor_data[0]->aclo_actiondatebs:'';

}else{

   $department_supervisor_date = !empty($department_supervisor_data[0]->aclo_actiondatead)?$department_supervisor_data[0]->aclo_actiondatead:'';

}





   // storekeeper

// $storekeeper_data = $this->general->get_user_list_for_report($reqno, $fyear, '1', 'rema_approved');

$storekeeper_data = $this->general->get_user_list_for_report($reqno, $fyear, 'N', 'pure_isapproved');

$storekeeper_fullname = !empty($storekeeper_data[0]->usma_fullname)?$storekeeper_data[0]->usma_fullname:'';

$storekeeper_empid = !empty($storekeeper_data[0]->usma_employeeid)?$storekeeper_data[0]->usma_employeeid:'';



if(DEFAULT_DATEPICKER == 'NP'){

   $storekeeper_date = !empty($storekeeper_data[0]->aclo_actiondatebs)?$storekeeper_data[0]->aclo_actiondatebs:'';

}else{

   $storekeeper_date = !empty($storekeeper_data[0]->aclo_actiondatead)?$storekeeper_data[0]->aclo_actiondatead:'';

}



   // procurement

$procurement_data = $this->general->get_user_list_for_report($reqno, $fyear, 'V', 'pure_isapproved');

$procurement_fullname = !empty($procurement_data[0]->usma_fullname)?$procurement_data[0]->usma_fullname:'';

$procurement_empid = !empty($procurement_data[0]->usma_employeeid)?$procurement_data[0]->usma_employeeid:'';



if(DEFAULT_DATEPICKER == 'NP'){

   $procurement_date = !empty($procurement_data[0]->aclo_actiondatebs)?$procurement_data[0]->aclo_actiondatebs:'';

}else{

   $procurement_date = !empty($procurement_data[0]->aclo_actiondatead)?$procurement_data[0]->aclo_actiondatead:'';

}



   // accountant

// $accountant_data = $this->general->get_user_list_for_report($reqno, $fyear, '1', 'pure_accountverify');

$accountant_data = $this->general->get_user_list_for_report($reqno, $fyear, 'M', 'pure_isapproved');

$accountant_fullname = !empty($accountant_data[0]->usma_fullname)?$accountant_data[0]->usma_fullname:'';

$accountant_empid = !empty($accountant_data[0]->usma_employeeid)?$accountant_data[0]->usma_employeeid:'';



if(DEFAULT_DATEPICKER == 'NP'){

   $accountant_date = !empty($accountant_data[0]->aclo_actiondatebs)?$accountant_data[0]->aclo_actiondatebs:'';

}else{

   $accountant_date = !empty($accountant_data[0]->aclo_actiondatead)?$accountant_data[0]->aclo_actiondatead:'';

}



   // branch manager

$branch_manager_data = $this->general->get_user_list_for_report($reqno, $fyear, 'P', 'pure_isapproved');

$branch_manager_fullname = !empty($branch_manager_data[0]->usma_fullname)?$branch_manager_data[0]->usma_fullname:'';

$branch_manager_empid = !empty($branch_manager_data[0]->usma_employeeid)?$branch_manager_data[0]->usma_employeeid:'';



if(DEFAULT_DATEPICKER == 'NP'){

   $branch_manager_date = !empty($branch_manager_data[0]->aclo_actiondatebs)?$branch_manager_data[0]->aclo_actiondatebs:'';

}else{

   $branch_manager_date = !empty($branch_manager_data[0]->aclo_actiondatead)?$branch_manager_data[0]->aclo_actiondatead:'';

}



    // department supervisor

$it_officer_data = $this->general->get_user_list_for_report($reqno, $fyear, '2', 'rema_itstatus');

$it_officer_fullname = !empty($it_officer_data[0]->usma_fullname)?$it_officer_data[0]->usma_fullname:'';

$it_officer_empid = !empty($it_officer_data[0]->usma_employeeid)?$it_officer_data[0]->usma_employeeid:'';



if(DEFAULT_DATEPICKER == 'NP'){

   $it_officer_date = !empty($it_officer_data[0]->aclo_actiondatebs)?$it_officer_data[0]->aclo_actiondatebs:'';

}else{

   $it_officer_date = !empty($it_officer_data[0]->aclo_actiondatead)?$it_officer_data[0]->aclo_actiondatead:'';

}



?>

<style>  

   .table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:14px; border-collapse:collapse; }

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

   .jo_footer td { padding:8px 8px; }

   .preeti{

      font-family: preeti;

   }

   .footerwrapper .spanborder {

      border: none !important;

      border-bottom: 1px dashed #000 !important;

   }

   .borderbottom{ border-bottom: 1px dashed #333;margin: 0px;padding: 0px; }

   .tableWrapper{

      min-height:45%;

      height:45vh;

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

   .signatureDateLine {

      min-width: 170px;display:inline-block;border-bottom:1px solid #333 !important;

   }

   .signatureDateLine + span {

      padding-top:15px

   }

   .jo_footer img{

      margin-top: -15px;

      margin-left: 10px;

   }

   img.signatureImage{

      width: 70px;

   }

</style>

<?php

   if(empty($centralrequest) && empty($proceedpurchase) && empty($proceedissue)):

      $is_demand_processed_status = 'N';

   else:

      $is_demand_processed_status = 'Y';

   endif;

?>

<div class="jo_form organizationInfo">

   <div class="headerWrapper">

      <?php 

         //$header['report_no'] = 'म.ले.प.फा.नं ५१';



      if($is_demand_processed_status == 'Y'):

         $header['report_title'] = 'माग फारम';

      else:

         $header['report_title'] = 'युनिभर्सल फारम';

      endif;



      $this->load->view('common/v_print_report_header',$header);

      ?>

      <table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">

         <tr>

            <td width="33.333333%"></td>

            <td width="33.333333%"></td>

            

         </tr>

         <tr>

            <td width="80%">

               <span style="font-size: 12px; margin-bottom: 5px;" class="<?php echo FONT_CLASS; ?>"> श्रीमान् </span> <span class="borderbottom"><?php

               if($stock_requisition){

                 $designationid= !empty($stock_requisition[0]->rema_reqto)?$stock_requisition[0]->rema_reqto:''; 
                 if(!empty($designationid)){
               		 $rslt= $this->stock_requisition_mdl->get_user_by_group_code(array('usma_userid'=>$designationid));
		                // echo "<pre>";
		                // print_r($rslt);
		                // die();
		                if(!empty($rslt)){
		                	echo $rslt[0]->usma_fullname;
		                }  	
                 }
               

             	}
                 ?>
                </span>



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

                     <th width="10%" style="padding-left: 30px;" class="td_cell" rowspan="2"> कैफियत </th>

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

                  // to merge all it comments

                     $it_comment_list = array();

                     foreach($stock_requisition as $key => $stock){

                        if(!empty($stock->rede_itcomment)):

                           $it_comment_list[] = !empty($stock->rede_itcomment)?$stock->rede_itcomment:'';

                        endif;



                        $all_it_comment = '';

                        if(!empty($it_comment_list)):

                           foreach($it_comment_list as $ikey=>$icom):

                            $all_it_comment .= $icom.',';

                         endforeach;

                      endif;

                   }



                   $account_comment = '';

                   if(!empty($account_action_log)):

                     foreach($account_action_log as $log):

                        $account_comment .= $log->usma_fullname.'-'.$log->aclo_comment.',';

                     endforeach;

                  endif;



                  $it_comment = rtrim($all_it_comment,',');



                  // $all_remarks = !empty($it_comment)?$it_comment.', '.$account_comment:$account_comment;

                  $all_remarks = !empty($it_comment)?$it_comment:'';



                  // details view start

                  $count_items = count($stock_requisition);

                  $grandtotal=0;



                  foreach($stock_requisition as $key => $stock){

                     $cur_qty=!empty($stock->rede_qty)?$stock->rede_qty:0;

                     $rate = !empty($stock->itli_purchaserate)?$stock->itli_purchaserate:0; 

                     // $rate = !empty($stock->rede_unitprice)?$stock->rede_unitprice:0;    

                     // $totamt=!empty($stock->rede_totalamt)?$stock->rede_totalamt:0; 

                     $totamt = $cur_qty * $rate;

                     $fullremarks=  !empty($stock_requisition[0]->rema_remarks)?$stock_requisition[0]->rema_remarks:'';

                     ?>

                     <tr>

                        <td class="td_cell">

                           <?php echo $key+1; ?>

                        </td>

                        

                        <td class="td_cell">

                           <?php 

                           // if(ITEM_DISPLAY_TYPE=='NP'){

                              

                           //    echo !empty($stock->itli_itemnamenp)?$stock->itli_itemnamenp:$stock->itli_itemname;

                           // }else

                           // {

                              

                           //    echo !empty($stock->itli_itemname)?$stock->itli_itemname:'';

                           // }



                           if(ITEM_DISPLAY_TYPE=='NP'){



                           $item_name= !empty($stock->itli_itemnamenp)?$stock->itli_itemnamenp:$stock->itli_itemname;

                        }

                        else{

                          $item_name= !empty($stock->itli_itemname)?$stock->itli_itemname:'';

                        }  



                        if($item_name=='Unknown Item'){

                           echo $stock->rede_remarks;

                        } else{

                           echo $item_name;

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



                     <?php

                        if($is_demand_processed_status == 'N'):

                     ?>

                     <td class="td_cell" align="right"></td>

                     <td class="td_cell" align="right"></td>

                     <?php

                        else:

                     ?>

                     <td class="td_cell" align="right"><?php echo $rate ?></td>

                     <td class="td_cell" align="right"><?php echo $totamt ?></td>

                     <?php

                        endif;

                     ?>

                     

                     <?php if($key == 0): ?>

                        <td style="height: 100%; clear: both;overflow: hidden;" class="td_cell" rowspan="<?php echo $count_items+20; ?>">

                           <div style="writing-mode: vertical-rl;width: 100%;height: 100%; font-size:10px;">

                              <?php 

                           // echo !empty($stock->rede_remarks)?$stock->rede_remarks:'';

                            if(!empty($fullremarks)):

                               echo "Full Remarks:"; 

                              echo !empty($fullremarks)?$fullremarks:'';

                              endif;



                              ?>

                              <br/>

                              <?php 

                              if(!empty($it_comment)):

                                 echo !empty($it_officer_fullname)?$it_officer_fullname.' (IT)-':'';

                              endif;

                              ?>  

                              <?php 

                              echo !empty($all_remarks)?$all_remarks:''; 

                              ?> 

                              <br/>

                           </div>

                        </td>

                     <?php endif; ?> 

                  </tr>

                  <?php  $grandtotal+=$totamt; 

               }?>

               <?php

               $row_count = count(array($stock));

               

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

                     <!-- <td class="td_empty"></td> -->

                  </tr>

               <?php endif;

            } 

            else

            { 



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

                        }

                        else{

                           echo !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';

                        }   

                        ?>

                     </td>

                     <td class="td_cell">

                        <?php 

                        echo !empty($report_data['rede_qty'][$key])?$report_data['rede_qty'][$key]:''; 

                        ?>

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

                        <?php 

                        echo !empty($report_data['rede_remarks'][$key])?$report_data['rede_remarks'][$key]:''; 

                        ?>

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

                  <?php 

               endif;

               ?>

               <?php

            endif;

         }

         ?>

      </tbody>

      <tfoot>

         <tr>

            <?php

               $grandtotal = 0; // no estimate total until procurement

            ?>

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

         <td width="60%" style="padding-top: 30px;"> 

            बजेटमा रकम ब्यवस्था

            <?php

               echo ($check_budget_availability[0]->pure_isapproved == 'B')?'छैन':'छ';

            ?>

         </td>

         <td width="40%" style="padding-top: 30px;"> 

            मौज्दात छ 

         </td>

      </tr>

      <tr>

         <td style="padding-top: 25px;">

            <?php

            if(!empty($accountant_fullname)):

               ?>

            <span class="signatureDateLine">

               <?php 

               echo $accountant_fullname; 

               echo ($accountant_empid)?'('.$accountant_empid.')':'';

               ?>

            </span> 

             <span class="signatureDashedLine spanborder" >

               <?php 

                  echo $accountant_date; 

               ?>

            </span> 

            <?php

            else:

               ?>

               <span class="signatureDashedLine"></span>

               <?php

            endif;

            ?>

            <br/>लेखा अधिकृत 

         </td>

         <td style="padding-top: 10px">

            <?php

            if(!empty($storekeeper_fullname)):

               ?>

               <span class="signatureDateLine"  >

                  <?php 

                  echo $storekeeper_fullname; 

                  echo ($storekeeper_empid)?'('.$storekeeper_empid.')':'';

                  ?>

               </span>

                <span class="signatureDashedLine spanborder" >

                     <?php 

                        echo $storekeeper_date; 

                     ?>

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

      <td style="padding-top: 10px">

         <?php

         $demander_id = $stock_requisition[0]->rema_postby;

         $demander_date = $stock_requisition[0]->rema_reqdatebs;



         if(!empty($demander_id)):

            $get_demander_signature = $this->general->get_signature($demander_id);



            $demander_fullname = $get_demander_signature->usma_fullname;

            $demander_empid = $get_demander_signature->usma_employeeid;

         else:

            $demander_fullname = '';

            $demander_empid = '';

         endif;



         if(!empty($demander_fullname)):

            ?>

            <span class=" signatureDateLine" >

              <?php 

              echo $demander_fullname; 

              echo ($demander_empid)?'('.$demander_empid.')':'';

              ?>

           </span>

           <span class="signatureDashedLine  spanborder ">

              <?php 

              echo $demander_date; 

              ?>

           </span> 



           माग गर्नेको सही र मिति

           <?php

        else:

         ?>

         <span class="signatureDashedLine"></span> माग गर्नेको सही र मिति

         <?php

      endif;

      ?>

   </td>

</tr>

<tr>

   <td style="padding-top: 25px;">

      <?php

         if($procurement_fullname):

      ?>

      <span class="signatureDateLine">

         <?php 

            echo $procurement_fullname; 

            echo ($procurement_empid)?'('.$procurement_empid.')':'';

         ?>

      </span>

      <span class="signatureDashedLine spanborder" >

         <?php 

            echo $procurement_date; 

         ?>

      </span> 

      <?php

         else:

      ?>

      <span class="signatureDashedLine"></span>

      <?php

         endif;

      ?>

  </br>

     बजारबाट  खरीद  गर्न स्वीकृत 

  </td>

  <td></td>

  

  <td style="padding-top: 20px;padding-bottom: 20px;">

   <?php

   if(!empty($department_supervisor_fullname)):

      ?>

      <span class="signatureDateLine">

         

         <?php 

         echo $department_supervisor_fullname; 

         echo ($department_supervisor_empid)?'('.$department_supervisor_empid.')':'';

         ?>

      </span> 

      <span class="signatureDashedLine spanborder" >

         <?php 

            echo $department_supervisor_date; 

         ?>

      </span> 

      शाखा प्रमुखको सिफारिश 

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

   <td style="padding-top: 20px;padding-bottom: 20px;">

      <?php

         if(empty($account_action_log)):

            if(!empty($branch_manager_fullname )):

      ?>

         <span class="signatureDateLine">

            <?php 

               echo $branch_manager_fullname; 

               echo ($branch_manager_empid)?'('.$branch_manager_empid.')':'';

            ?>

         </span>

         <span class="signatureDashedLine spanborder" >

            <?php 

               echo $branch_manager_date; 

            ?>

         </span> 

      <?php

            else:

      ?>

       <span class="signatureDashedLine"></span>

      <?php

            endif; 

         endif; 

      ?>



   </br>आदेश  दिने अधिकारी

   </td>

   <td style="padding-top: 10px;padding-bottom: 20px;">

   </td>

</tr>

</table>

</div>

</div>



<?php

   if(!empty($account_action_log)):

?>

<div class="print_break_page" id="break_page" style='page-break-before:always; display: none;'>

  

   <table>

      <thead>

         <tr>

            <th>S.No.</th>

            <th>Username</th>

            <th>Comment</th>

            <th>Date</th>

         </tr>

      </thead>

      <tbody>

          <?php

            foreach($account_action_log as $akey=>$log):

         ?>

         <tr>

            <td><?php echo $akey+1;?></td>

            <td><?php echo $log->usma_fullname; ?></td>

            <td><?php echo $log->aclo_comment; ?></td>

            <td><?php echo $log->aclo_actiondatebs; ?></td>

         </tr>

         <?php

            endforeach;

         ?>

      </tbody>

   </table>

   

</div>

<?php

   endif;

?>

