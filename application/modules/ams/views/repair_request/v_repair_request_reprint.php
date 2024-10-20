 <style>

        .work_order_table.table td,

        .work_order_table.table th {

            font-size: 15px;

            padding: 3px !important;

            white-space: normal !important;

            text-align: center;

        }


        .work_order_table.table th {

            text-align: center !important;

            font-weight: bold;

            vertical-align: middle;

            color: #000;

        }

        .work_order_table.table td.td_empty {

            padding: 7px !important

        }

        .work_order_table.table-bordered td,

        .work_order_table.table-bordered th {

            border-color: black !important;

            border-bottom-width: 1px !important;

        }


        .work_order_bottom {

            display: grid;

            grid-template-columns: repeat(3, 33.33%);

            grid-column-gap: 2em;


            align-items: center;

             padding: 25px 0rem ; 

            color: #000;

        }



        .work_order_bottom h6 , .bottom_order h6{

            padding: .5rem 0;

            font-size: 16px;

            

        }



        .work_order_table.table tfoot th {

            text-align: right !important;

            padding: .25rem !important

        }



        .work_order_header {

            display: flex;

            justify-content: space-between;


            align-items: baseline;

        }



        .work_order_header p {

            margin: 0;

            font-size: 16px;

            line-height: 1.2;

            font-weight: bold

        }

        p {
            font-size: 15px
        }

        .work_order_header p span {

            font-weight: lighter;

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
        .double_top {
            font-weight:bold;border-top:1px solid;border-bottom: 4px double;width: fit-content;font-size:17px;
            padding:3px 5px 0;
        }

       .work_order_table.table-bordered .extra th {

        padding: 5px!important;

        border-bottom-width: 2px !important;
    }
        .date p {
            margin-bottom:0px
        }

        

    </style>


    <?php 
    $header['report_title'] = ' मर्मत, सम्भार तथा संरक्षण आवेदन फाराम';
    $header['report_no'] = ' म.ले.प.फारम नं: ४१४';
    $this->load->view('common/v_print_report_header',$header);
    ?>

      <div class="work_order_header">
        <span style="display: block;">आर्थिक वर्ष: <u><?php echo !empty($repair_master[0]->rerm_fiscalyrs)?$repair_master[0]->rerm_fiscalyrs:''; ?></u> साल <u><?php echo $month_name; ?> </u> महिना
            </span>

    </div>

        <div class="date" style="align-self: flex-start;justify-content: flex-end;display: flex;padding-right:30px">

            <div class="other_details text-left ">
                <p>मर्मत आवेदन फारम नं :<span><?php echo !empty($repair_master[0]->rerm_requestno)?$repair_master[0]->rerm_requestno:''; ?></span> <br>

                मिति:- <span><?php echo !empty($repair_master[0]->rerm_requestdatebs)?$repair_master[0]->rerm_requestdatebs:''; ?></span>
                </p>

            </div>

        </div>
    <div  style="margin-bottom: 0">

        <p style="margin:0 0 4px">मर्मत आवेदककर्ताले भर्ने</p>

    </div>


    <table class="table work_order_table table-bordered " width="100%">

        <thead>
            <tr>
                <th>क्र.सं.</th>
                <th>सामानको विवरण</th>
                <th>समान पहिचान नं</th>
                <th>अनुमानत मर्मत लागत</th>
                <th>मर्मत गर्नुपर्ने कारण</th>
                <th>मर्मत आवेदककर्ताको नाम र सही</th>
                <th>कैफियत</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(count($repair_detail)): 
                foreach ($repair_detail as $key => $detail):
            ?>
            <tr>
                <td><?=$key+1?></td>
                <td><?=$detail->rerd_assetsdesc?></td>
                <td><?=$detail->rerd_assetcode?></td>
                <td><?=$detail->rerd_estimateamt?></td>
                <td><?=$detail->rerd_problem?></td>
                <td><?php echo !empty($repair_master[0]->rerm_requestby)?$repair_master[0]->rerm_requestby:""; ?></td>
                <td><?=$detail->rerd_remark?></td>
            </tr>
            <?php endforeach;?>

        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" align="left">कुल जम्मा रकम :</th>
                <th></th>
                <th><?php echo !empty($repair_master[0]->rerm_estmatecost)?$repair_master[0]->rerm_estmatecost:""; ?></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    <?php endif;?>

    </table>

    <div class="" style="border-top:2px dotted black;margin-top:30px">

        <p style="font-weight: bold;font-size: 16px ;margin:2px 0 4px">स्टोरकिपर/फाँटवालाले भर्ने</p>

        </div>


    <table class="table work_order_table table-bordered " width="100%">

        <thead>

            <tr>
                <th >जिन्सी संकेत नं</th>
                <th >वारेन्टी अविध भए / नभएको</th>
                <th >अगाडी मर्मत गरिएको पटक</th>
                <th >यस अघि मर्मत गरिएको मिति</th>
                <th >अगाडी मर्मत गरिएको रकम</th>
            </tr>


        </thead>

        <tbody>

            <tr>
                <td class="td_empty"></td>
                <td class="td_empty"></td>
                <td class="td_empty"></td>
                <td class="td_empty"></td>
                <td class="td_empty"></td>

            </tr>
            <tr>
                <td class="td_empty"></td>
                <td class="td_empty"></td>
                <td class="td_empty"></td>
                <td class="td_empty"></td>
                <td class="td_empty"></td>

            </tr>


            

        </tbody>

    </table>

   <div style="margin-top:30px">
    <p> श्री ...............................<br>
        मर्मत आदेश दिइएको / निकायको नाम :<br>
        <span style="width:20%;display:inline-block">ठेगाना :         </span><span style="width:20%;display:inline-block">फोन नं:           </span><br>
        <span style="width:20%;display:inline-block">संस्ठा दर्ता नं : </span><span style="width:20%;display:inline-block">प्यान नं :</span><br>
        माथि उल्लेखित सामानको मर्मत गरी मिति ......... भित्र .................... कर्यालय ......... स्थानमा बिल /इन्भाइससहित बुझाउनुहोला ।
    </p>
   </div>
   <div class="work_order_bottom">
       <div>
           <h6>सिफारिस गर्ने शाखा प्रमुखको सही :</h6>
           <p>नाम :</p>
           <p>दर्ता :</p>
           <p>मिति :</p>
       </div>
       <div>
           <h6>सिफारिस गर्ने शाखा प्रमुखको सही :</h6>
           <p>नाम :</p>
           <p>दर्ता :</p>
           <p>मिति:</p>
       </div>
       <div>
           <h6>सिफारिस गर्ने शाखा प्रमुखको सही :</h6>
           <p>नाम :</p>
           <p>दर्ता :</p>
           <p>मिति :</p>
       </div>
   </div>

  <!--  <h3 class="double_top" style="margin-bottom: 20px">उध्येश्य</h3>

    <p>
        स} ~को समयमै मम#त, स°ार गरी Jभावकारी Jयोगमा \ाउने, उ
मम#त, संभार तथा संरvण खच#लाइ# तुलना·क ब ̧ेषणका आधारमा नयXण गन
    </p>
<h3 class="double_top" style="margin: 30px 0 5px">फाराम भनM तरकाः</h3>

    <ul style="list-style-type: devanagari;">
        <li>ु नै एक &ज(ी सामानको मम#त तथा स°ार खच# बापत राDखने अभलेख खाता हो । यसले कु नै एक सामानमा aस सामानको आयु भरी कत मम#त e` भuे रेकड# राªदछ ।</li>
         <li>ु नै एक &ज(ी सामानको मम#त तथा स°ार खच# बापत राDखने अभलेख खाता हो । यसले कु नै एक सामानमा aस सामानको आयु भरी कत मम#त e` भuे रेकड# राªदछ ।</li>
          <li>ु नै एक &ज(ी सामानको मम#त तथा स°ार खच# बापत राDखने अभलेख खाता हो । यसले कु नै एक सामानमा aस सामानको आयु भरी कत मम#त e` भuे रेकड# राªदछ ।</li>
           <li>ु नै एक &ज(ी सामानको मम#त तथा स°ार खच# बापत राDखने अभलेख खाता हो । यसले कु नै एक सामानमा aस सामानको आयु भरी कत मम#त e` भuे रेकड# राªदछ ।</li>
        
    </ul> -->




<div class="work_order_header" style="page-break-before: always;">
        <div style="width: 25%">
        </div>

        <div style="margin-top:10px;text-align: center;width: 50%">
            
            <p>संघ/प्रदेश/स्थानीय तह <br>

............... मन्त्रालय / विभाग / कार्यालय<br>
कार्यालय कोड नं.:<br>
मर्मत, संभार तथा सम्रक्षण आवेदन फाराम
<span style="display: block">आर्थिक वर्ष: २०.......साल ............महिना
        </div>


        <div style="text-align: right;width: 25%">
            <span>म.ले.प.फारम नं: ४१४ </span>
        </div>

    </div>
        <div class="date" style="display: flex;justify-content: space-between;margin:30px 0 20px">
        <div>
            <p style="visibility: hidden;"></p>
            <p>जिन्सी सामानको नाम</p>
            <p>स्पेसिफिकेशन</p>
            <p>सामानको पहिचान नं </p>
            <p>मोडल नं</p>
        </div>
        <div>
            <p>पाना नं</p>
            <p style="visibility: hidden"></p>
            <p>जिन्सी संके त नं:</p>
            <p>जिन्सी खाता पाना.नं.</p>
            <p>समानको परल मूल्य</p>
        </div>
    </div>




    <table class="table work_order_table table-bordered " width="100%">

        <thead>

            <tr>

                <th rowspan="2">मिति:</th>

                <th rowspan="2">मर्मत आवेदन फारम नं</th>

                <th rowspan="2">आवेदन कर्ताको नाम</th>

                <th colspan="2">मर्मत गर्दा फेरिएको नँया सामान</th>

                <th colspan="2">मर्मत गर्दाको अन्य खर्च</th>

                <th rowspan="2">जम्मा लागत</th>

                <th rowspan="2">मर्मत संभार गर्ने व्यक्ति वा फर्मको विवरण</th>

                <th rowspan="2">मर्मत संभारको निरिक्षण / प्माणित गर्नेको नाम र सही</th>

                <th rowspan="2">कैफियत</th>


            </tr>
            <tr>
                <th>बिवरण </th>
                <th>मूल्य</th>
                <th>बिवरण </th>
                <th>मूल्य</th>
            </tr>


        </thead>

        <tbody>

            <tr>
                <td>१ </td>
                <td>२</td>
                <td>३ </td>
                <td>४</td>
                <td>५ </td>
                <td>६ </td>
                <td>७</td>
                <td>८=५+७</td>
                <td>९</td>
                <td>१०</td>
                <td>११</td>
            </tr>
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
                <td class="td_empty"></td>
                <td class="td_empty"></td>
            </tr>
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
                <td class="td_empty"></td>
                <td class="td_empty"></td>
            </tr>
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
                <td class="td_empty"></td>
                <td class="td_empty"></td>
            </tr>
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
                <td class="td_empty"></td>
                <td class="td_empty"></td>
            </tr>

            

        </tbody>


    </table>

   <div class="bottom_order" style="margin: 30px 0;display: flex;justify-content: space-between;">
       <div>
           <h6>भण्डार शाखा प्रमुखको सहीः </h6>
           <p>नामः</p>
           <p>दर्जा:</p>
           <p>मिति:</p>
       </div>
       <div style="padding-right: 40px">
           <h6>कार्यालय प्रमुखको सहीः</h6>
           <p>नामः</p>
           <p>दर्जा:</p>
           <p>मिति:</p>
       </div>

   </div>

<!--    <h3 class="double_top" style="margin-bottom: 5px">उ^े _</h3>

    <p>
        पुँजीगत /साव#जनक स}~को गुणKरयु Jभावकारी मम#त संभार तथा संरvण काय# वw$त गरी स}~को संचालन तथा संरvण गनM गराउन
    </p>

    <h3 class="double_top" style="margin: 30px 0 ">फाराम भनM तरकाः</h3>

    <ul style="list-style-type: devanagari;">
        <li>ु नै एक &ज(ी सामानको मम#त तथा स°ार खच# बापत राDखने अभलेख खाता हो । यसले कु नै एक सामानमा aस सामानको आयु भरी कत मम#त e` भuे रेकड# राªदछ ।</li>
         <li>ु नै एक &ज(ी सामानको मम#त तथा स°ार खच# बापत राDखने अभलेख खाता हो । यसले कु नै एक सामानमा aस सामानको आयु भरी कत मम#त e` भuे रेकड# राªदछ ।</li>
          <li>ु नै एक &ज(ी सामानको मम#त तथा स°ार खच# बापत राDखने अभलेख खाता हो । यसले कु नै एक सामानमा aस सामानको आयु भरी कत मम#त e` भuे रेकड# राªदछ ।</li>
           <li>ु नै एक &ज(ी सामानको मम#त तथा स°ार खच# बापत राDखने अभलेख खाता हो । यसले कु नै एक सामानमा aस सामानको आयु भरी कत मम#त e` भuे रेकड# राªदछ ।</li>
        
    </ul> -->

    <!-- <div class="note">

        <p>कृपया एउटै प्रकृति भएको सामान हरुको लागि एउटै मात्र माग फाराम प्रयोग गर्नुहोला ।</p>

    </div> -->

