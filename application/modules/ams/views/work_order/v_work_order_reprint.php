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



<!--     <div class="header">
        <div> -->
         <?php 
         //$header['report_no'] = 'म.ले.प.फा.नं ५१';

     
         $header['report_title'] = 'Work Order';
   

      $this->load->view('common/v_print_report_header',$header);
      ?>
      <div class="work_order_header">
        <div>
            <div style="margin-top:2rem">
                <!-- <p class="mb-1">सि.न. </p> -->
                <p>Project Name :<span><?php echo !empty($work_order_master[0]->projectname)?$work_order_master[0]->projectname:''; ?></span></p>
                <p>Chowk and differnet places :<span><?php echo !empty($work_order_master[0]->locationname)?$work_order_master[0]->locationname:''; ?></span></p>
                <p>To  Contractor :<span><?php echo !empty($work_order_master[0]->contractor_name)?$work_order_master[0]->contractor_name:''; ?></span></p>
            </div>
        </div>
        <div class="title">
            <!-- <h5 class="mb-1">काठमाण्डौ विश्वविद्यालय</h5>
            <span style="font-size: 1.4rem;">नखप्ने सामान माग फाराम</span> -->
        </div>
        <div class="date" style="align-self: flex-start;">

            <div class="other_details text-left pl-5 ml-5">
                <p>Work Order on:- <span><?php echo !empty($work_order_master[0]->woma_workorderno)?$work_order_master[0]->woma_workorderno:''; ?></span></p>
                <p>Work to be completed on:- <span></span></p>
            </div>
        </div>

    </div>
    <div style="border: 1px solid #000; padding:5px;margin-bottom: 20px;">
    <p style="margin:0">Your E-GP Bidding Bidding document of notice no <u><?php echo !empty($work_order_master[0]->woma_noticeno)?$work_order_master[0]->woma_noticeno:''; ?></u> has been approved on _________________.
        This work order is given to you execute the above job as per drawing, design & specification under the site in charge's instruction & supervision within the specified date.
    </p>
    </div>
    <table class="table work_order_table table-bordered " width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="5%" style="vertical-align: top;border-bottom-width: 2px !important;">S.N.</th>
                <th width="50%">Description</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Amount</th>
                <th>Remarks</th>
            </tr>
            
            <tr class="extra">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
       
        </thead>
        <tbody>
            <?php if(!empty($work_order_detail)): 
                foreach ($work_order_detail as $kwd => $wod):
                ?>
            <tr>
                <td align="center" style="vertical-align: bottom;"><?php echo $kwd+1; ?></td>
                <td><?php echo !empty($wod->wode_description)?$wod->wode_description:''; ?></td>
                <td><?php echo !empty($wod->wode_qty)?$wod->wode_qty:''; ?></td>
                <td><?php echo !empty($wod->wode_unit)?$wod->wode_unit:''; ?></td>
                <td><?php echo !empty($wod->wode_rate)?$wod->wode_rate:''; ?></td>
                <td><?php echo !empty($wod->wode_totalamt)?$wod->wode_totalamt:''; ?></td>
                <td><?php echo !empty($wod->wode_remarks)?$wod->wode_remarks:''; ?></td>
            </tr>
             <?php
                endforeach;
              endif; ?>
            
        </tbody>
    </table>
    <div class="work_order_bottom mt-5 pt-5">

        <div>
            <h6>Prepared by</h6>
        </div>
        <div>
            <h6>Checked by</h6>
        </div>
        <div>
            <h6>Approved by</h6>
        </div>
    </div>
    <!-- <div class="note">
        <p>कृपया एउटै प्रकृति भएको सामान हरुको लागि एउटै मात्र माग फाराम प्रयोग गर्नुहोला ।</p>
    </div> -->
