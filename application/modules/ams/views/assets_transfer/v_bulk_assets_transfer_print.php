 <style>

  @page  {
        size: auto;   
        margin: 8mm;  
    } 
  h5 {
            margin: 0 0 10px;
            font-size: 16px;
            font-weight: 600;
        }
        h6 {
            font-size: 14px;
            font-weight: 600
        }
    .ku_details h6 {
        margin-bottom: 0rem
    }
    .ku_table td,
        .ku_table th {
            padding: .5rem .5rem  .25rem !important;
            font-size: 15px;
            border:0 !important;
        }
        .ku_table tbody td{
            font-size: 14px;
            white-space: pre-line !important;
            padding:0px !important;
            vertical-align:top !important;
        }
           .ku_table th {
            vertical-align: middle !important; 
            font-weight: 600;
        }
        .ku_table thead{
            border-color: black !important;
            border-bottom: 1.5px solid !important;
        }
        .ku_table tbody tr:not(:last-child){
            border-bottom: 1px solid !important;
        }
        .ku_table tfoot {
            border-top: 1.5px solid #000
        }
        .ku_bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5rem 1rem 0;
        }
        .ku_table tfoot th {
            text-align: right !important;
            padding:0.5rem .25rem !important
        }
        .ku_bottom h6 {
            padding: .5rem 2rem 0;
            border-top: 1px solid;
            text-align: center;
            font-weight: 700;
        }
         .ku_print_header {
           /* display: grid;
            grid-template-columns: 25% 50% 25%;*/
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #000;
        }
        .ku_print_header .title{
            text-align: center;
        }
         .ku_print_header .title h5{
            font-weight: 600;
            color: #000;
            font-size: 1.275rem;
            margin:0;
        }
        .ku_print_header .title span{
            text-transform: uppercase;
            font-weight: 600;
            color: #000;
        }
        .ku_details ,.ku_table-wrapper{
            padding-left:1rem;padding-right: 1rem;
        }
        .ku_print_header .date {
            text-align: right;
            align-self: flex-end;
        }

        .ku_table tfoot th[colspan="4"]{
            text-align: center !important;
        }
         .ku_double h6{
             text-align: left;
             width: 70%;
            color: #000;
             font-weight: bold;
             margin: 0 auto;
         }
          h6.ku_double-border{
            padding-bottom: .35rem;
             color: #000;
             font-weight: bold;
          }
         .ku_double-border {
            position: relative;
            border-bottom: 4px double #000 !important;
        }

        .ku_details_individual{
            display: grid;
/*            padding: 2px 5px;
*/            grid-template-columns:1fr 1fr 1fr;
            align-items: center;
        }
        .ku_details_individual.full {
            grid-template-columns: 1fr;
        }

        .ku_details_individual h6{
            display:grid;
            font-size: 13px;
            font-weight: 600;
            margin:0;
            grid-template-columns:37% 3% 60%
        }
        .ku.details.individual.full h6 {
            grid-template-columns: 18% 3% 79%;
        }
        .ku_details_individual h6 .value , .remarks, .received{
            text-transform: uppercase;
        }

    </style>

<div class="jo_form organizationInfo">
    <div class="headerWrapper"  >
        <div class="ku_print_header">
             <?php 

    $this->load->view('common/v_print_report_header',$header);

?>

<div style="margin-top: -30px;">

              <div class="text-right">Transfer Date : <?php echo !empty($transfer_details[0]->astm_transferdatebs)?$transfer_details[0]->astm_transferdatebs:''; ?></div> 
        </div>
    </div>
<div class="ku_details"  >
        <div class="ku_details_individual" >
                <h6 style="grid-template-columns: 30% 3% 67%">Fiscal Year 
                        <span>:</span>
                    <span class="ku_value">
                       <?php echo !empty($transfer_details[0]->astm_fiscalyrs)?$transfer_details[0]->astm_fiscalyrs:''; ?>  
                    </span>
                </h6>
                <h6 >Transfer Code<span>:</span>
                    <span class="ku_value">
                <?php echo !empty($transfer_details[0]->astm_transferno)?$transfer_details[0]->astm_transferno:''; ?>
                    
                    </span>
                </h6>
                <h6 >Manual Code<span>:</span>
                    <span class="ku_value">
                <?php echo !empty($transfer_details[0]->astm_manualno)?$transfer_details[0]->astm_manualno:''; ?>
                    
                    </span>
                </h6>
            </div>
      
        <div class="ku_details_individual.full" >
                <h6>Transfer From <span>:</span>
                    <span class="ku_value">
                        <?php

              $school_id=!empty($transfer_details[0]->astm_fromschoolid)?$transfer_details[0]->astm_fromschoolid:'';

               $school_result=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$school_id),'loca_name','ASC'); 

               if(!empty($school_result)){

                echo !empty($school_result[0]->loca_name)?$school_result[0]->loca_name:'';
                echo"-";

               }

              ?>
 <?php 

            $reqdepartment=!empty($transfer_details[0]->astm_from)?$transfer_details[0]->astm_from:'';

            $check_parentid=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$reqdepartment),'dept_depname','ASC');

            $dep_parent_dep_name='';

            $sub_depname='';
            if(!empty($check_parentid)){
              $dep_parentid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
              $dep_parent_dep_name=!empty($check_parentid[0]->dept_depname)?$check_parentid[0]->dept_depname:'';
              if($dep_parentid!=0){
              $sub_department=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$dep_parentid),'dept_depname','ASC');
              if(!empty($sub_department)){

               $sub_depname=!empty($sub_department[0]->dept_depname)?$sub_department[0]->dept_depname:'';
              }
            }   
        }

            if(!empty($sub_depname)){
              echo $sub_depname.'('.$dep_parent_dep_name.')';
            }else{
              echo $dep_parent_dep_name;

            }

        ?>
          
                    </span>
                </h6>
        </div>
        <div class="ku_details_individual.full">
                <h6 >Transfer To <span>:</span>
                    <span class="ku_value">
            <?php
            $school_id=!empty($transfer_details[0]->astm_toschoolid)?$transfer_details[0]->astm_toschoolid:'';
            $school_result=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$school_id),'loca_name','ASC'); 
            if(!empty($school_result)){
            echo !empty($school_result[0]->loca_name)?$school_result[0]->loca_name:'';
            echo "-";
               }
        ?>
 <?php 
            $reqdepartment=!empty($transfer_details[0]->astm_to)?$transfer_details[0]->astm_to:'';
            $check_parentid=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$reqdepartment),'dept_depname','ASC');
            $dep_parent_dep_name='';
            $sub_depname='';
            if(!empty($check_parentid)){
              $dep_parentid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
              $dep_parent_dep_name=!empty($check_parentid[0]->dept_depname)?$check_parentid[0]->dept_depname:'';

              if($dep_parentid!=0){
              $sub_department=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$dep_parentid),'dept_depname','ASC');
              if(!empty($sub_department)){
               $sub_depname=!empty($sub_department[0]->dept_depname)?$sub_department[0]->dept_depname:'';
                }
              }   
            }

             if(!empty($sub_depname)){
              echo $sub_depname.'('.$dep_parent_dep_name.')';

            }else{

              echo $dep_parent_dep_name;

            }

        ?>
          
                    </span>
                </h6>
            </div>
            <div class="ku_details_individual.full" >
                <h6>Received By<span>:</span>
                    <span class="ku_value">
                        <?php 
                         echo !empty($transfer_details[0]->astm_receivedby)?$transfer_details[0]->astm_receivedby:''; 
                        ?>
                    </span>
                </h6>
            </div>

    </div>

    <div class="ku_table-wrapper">
    <table class="ku_table table table-borderless " width="100%" style="margin:1.5rem 0">

        <thead>

            <tr>

                <th rowspan="2" width="5%">S.N.</th>

                <th>Asset Code</th>
                <th>Item Name</th>
                <th width="35%">Description</th>
                <th style="text-align: right;">Pur. Rate</th>
                <th style="text-align: center;">Remarks</th>

            </tr>

        </thead>

        <tbody>

            <?php 
            $sum_orgamt=0;
            if(!empty($transfer_details)): 

                foreach ($transfer_details as $kwd => $tdata):

                ?>

            <tr>

                <td align="center" style="vertical-align: bottom;"><?php echo $kwd+1; ?></td>

                <td><?php echo !empty($tdata->asen_assetcode)?$tdata->asen_assetcode:''; ?></td>
                <td><?php echo !empty($tdata->itli_itemname)?$tdata->itli_itemname:''; ?></td>
                <td><?php echo !empty($tdata->asen_desc)?$tdata->asen_desc:''; ?></td>

                <td style="text-align: right;"><?php echo $orgamt= !empty($tdata->astd_originalamt)?$tdata->astd_originalamt:''; $sum_orgamt +=$orgamt; ?></td>

               <td><?php echo !empty($tdata->astd_remark)?$tdata->astd_remark:''; ?></td>

            </tr>

             <?php

                endforeach;

              endif; ?>

        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align: center;">G.total</th>
                <th style="text-align: right;"><?php echo $sum_orgamt; ?></th>
                <th></th>
            </tr>
        </tfoot>

    </table>
    </div>
    <div class="ku_bottom">
        <h6>Prepared by</h6>

        <h6>Checked by</h6>
        <h6>Approved by</h6>
    </div>
</div>
</div>
