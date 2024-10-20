 <style>

       





        .work_order_table.table td,

        .work_order_table.table th {

            font-size: 15px;

            padding: 3px !important

        }



        .work_order_table.table th {

            text-align: center !important;

            font-weight: bold;

            color: #000;

        }



        .work_order_table.table-bordered td,

        .work_order_table.table-bordered th {

            border-color: black !important;

            border-bottom-width: 1px !important;

        }





        .work_order_bottom {

            display: grid;

            grid-template-columns: repeat(3, 31%);

            grid-column-gap: 2em;

            grid-row-gap: 3em;

            align-items: center;

             padding: 60px 0rem 0; 

            color: #000;

        }



        .work_order_bottom h6 {

            border-top: 2px dotted;

            text-align: center;

            padding: .5rem 0;

            font-size: 18px;

            font-weight: 700;

        }



        .work_order_bottom p span {

            border-bottom: 2px dotted;

            width: 82%;

            display: inline-block;

        }



        .work_order_table.table tfoot th {

            text-align: right !important;

            padding: .25rem !important

        }



        .work_order_header {

            display: flex;

            justify-content: space-between;

            padding-bottom: 10px;

            align-items: center;

        }



        .work_order_header p {

            margin: 0;

            font-size: 15px;

            line-height: 1.5;

            font-weight: bold

        }

        .work_order_header p span {

            font-weight: 400

        }



        .work_order_header .title {

            text-transform: uppercase;

            font-weight: 700;

            text-align: center;

        }



        .work_order_header .date {

            text-align: right;

            align-self: center;

        }



        .details_individual {

            display: grid;

            grid-template-columns: 75% 25%;

            align-items: center;

        }



        .details_individual h6 .value,

        .remarks,

        .received {

            text-transform: uppercase;

        }



        .work_order_table.table tfoot th[colspan="4"] {

            text-align: center !important;

        }

       .work_order_table.table-bordered .extra th {

    padding: 5px!important;

    border-bottom-width: 2px !important;

        

    </style>







         <?php 





     

         $header['report_title'] = 'मर्मत संभार फाराम';

   



      $this->load->view('common/v_print_report_header',$header);

      ?>

      <div class="work_order_header">

        <div>

            <div style="margin-top:2rem">

                <!-- <p class="mb-1">सि.न. </p> -->

                <p>श्री समान्य प्रशासन शखा</p>

                <p>मुख्य कार्यालय, त्रिपुरेश्वर मार्ग &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                मर्मत फाराम नं : <u><?php echo !empty($assets_repair_request_master[0]->rerm_requestno)?$assets_repair_request_master[0]->rerm_requestno:''; ?></u>&nbsp;&nbsp;&nbsp;&nbsp;

विभाग:<u><?php echo !empty($assets_repair_request_master[0]->dept_depname)?$assets_repair_request_master[0]->dept_depname:''; ?></u></p>

            </div>

        </div>

        <div class="title">

            

        </div>

        <div class="date" style="align-self: flex-start;">



            <div class="other_details text-left pl-5 ml-5">

              

                <p>मिति:- <span><?php echo !empty($assets_repair_request_master[0]->rerm_requestdatebs)?$assets_repair_request_master[0]->rerm_requestdatebs:''; ?></span></p>

            </div>

        </div>



    </div>

    <div style="border: 1px solid #000; padding:5px;margin-bottom: 20px;">

    

    </div>

    <table class="table work_order_table table-bordered " width="100%">

        <thead>

            <tr>

            <th rowspan="2" width="5%" style="vertical-align: top;border-bottom-width: 2px !important;">सि.न</th>

                <th width="55%">मर्मत संभार विवरण</th>

                <th width="15%">इष्टिमेट रकम</th>

                <th width="25%">कैफियत</th>

               

            </tr>

            

            

       

        </thead>

        <tbody>

            <?php if(!empty($assets_repair_request_detail)): 

                foreach ($assets_repair_request_detail as $kwd => $rrl):

                ?>

            <tr>

                <td align="center" style="vertical-align: bottom;"><?php echo $kwd+1; ?></td>

                <td><?php 

                $assets_code=!empty($rrl->asen_assetcode)?$rrl->asen_assetcode:'';

                $assets_desc= !empty($rrl->asen_desc)?$rrl->asen_desc:'';

                $assets_problem =!empty($rrl->rerd_problem)?$rrl->rerd_problem:'';

                echo $assets_code.'('.$assets_desc.')';

                ?>



                <p><strong><u>समस्या विवरण</strong></u>:</p>

                <?php echo $assets_problem;?>

                </td>

                <td>

                    <?php echo $rrl->rerd_estimateamt; ?>

                </td>

                <td><?php echo !empty($rrl->rerd_remark)?$rrl->rerd_remark:''; ?></td>

            </tr>

             <?php

                endforeach;

              endif; ?>

            

        </tbody>

    </table>

    <p class="mb-5"><b>बजेट रकम व्यवस्था छ / छैन</b></p>

    <div class="work_order_bottom mt-5 pt-5">



        <div>

            <h6>लेखा अधिकृत </h6>

        </div>

        <div>

            <!-- <h6>सिफारिस गर्ने</h6>

            <p>मिति: <span></span></p> -->

        </div>

        <div>

            <?php 

                echo !empty($assets_repair_request_master[0]->rerm_requestby)?$assets_repair_request_master[0]->rerm_requestby:''; 

                echo '('.$assets_repair_request_master[0]->rerm_requestdatebs.')';



            ?>

            <h6>माग गर्नेको सही र मिति</h6>

        </div>

        <div>

            <h6>समान्य प्रशासन शखा</h6>

        </div>

        <div>

            <h6>स्विकृत गर्ने </h6>

        </div>

        <div>

            <h6>प्रयोग गर्नेको सही</h6>

        </div>

</div>



    <!-- <div class="note">

        <p>कृपया एउटै प्रकृति भएको सामान हरुको लागि एउटै मात्र माग फाराम प्रयोग गर्नुहोला ।</p>

    </div> -->

