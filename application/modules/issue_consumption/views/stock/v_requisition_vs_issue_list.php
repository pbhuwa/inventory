<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
     <?php  $this->load->view('common/v_report_header',$this->data); ?> 
                

               
                <table class="alt_table" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2" width="5%">S.n</th>
                            <th colspan="4" width="10%">Requisition</th>
                            <th colspan="5" width="85%">Issue</th>
                        </tr>
                        <tr>
                <th width="20%"><?php echo $this->lang->line('req_no'); ?></th>
                <th width="20%"><?php echo $this->lang->line('req_date_ad'); ?></th>
                <th width="20%"><?php echo $this->lang->line('req_date_bs'); ?></th>
                <th width="20%">Req. By</th>
                <th colspan="20%"></th>
                
                </tr>
               
        </thead>
                   

                    <tbody>
                        <?php 
                         if(!empty($get_req_data)): 
                           $i=1;
                            foreach ($get_req_data as $km => $gie):
                                 $issue_result= $gie->issue_status;
                                  $issue_data = explode(',',$issue_result); 
                            // echo "<pre>";
                            // print_r($issue_data);
                             $cnt_issdata=sizeof($issue_data);
                             $rwspn=0;
                             if($cnt_issdata>0)
                             {
                                $rwspn=$cnt_issdata;
                             }

                          ?>
                        <tr rowspan="<?php echo $rwspn; ?>">
                        <td><?php echo $i;?></td>
                         <td><a href="javascript:void(0)" data-id='<?php echo $gie->rema_reqmasterid;?>' data-displaydiv="orderDetails" data-viewurl='<?php echo base_url('issue_consumption/stock_requisition/stock_requisition_views_details');?>' title="View" class="view btn-xxs"><?php echo $gie->rema_reqno; ?></a></td>
                        <td><?php echo $gie->rema_reqdatead; ?></td>
                        <td><?php echo $gie->rema_reqdatebs; ?></td>
                        <td><?php echo $gie->rema_reqby; ?></td>
                        <td>
                        <?php 
                        if(!empty($issue_result)){
                            ?>
                            <table>
                            <thead>
                                <tr>
                            <th width="20 %">S.n</th>
                            <th width="20%">Invoice No</th>
                            <th width="20%">Date</th>
                            <th width="20%">Receiver </th>
                            <th width="20%">Action</th>
                            </tr>
                            </thead>
                            
                             
                            <?php
                           

                            if(!empty($issue_data)){
                               
                                // $j=0;
                               for ($z=0; $z <$cnt_issdata ; $z++) { 
                                  $iss_lst=explode('-',$issue_data[$z]);
                               
                        ?>
                        <tr>
                        <td><?php echo $z+1; ?></td>
                        <td><?php echo $iss_lst[1]; ?></td>
                        <td><?php echo $iss_lst[2]; ?></td>
                        <td><?php echo $iss_lst[3];?></td>
                        <!-- <td>Action</td>  -->
                          <td><a href="javascript:void(0)" data-id='<?php echo $iss_lst[0];?>' data-displaydiv="orderDetails" data-viewurl='<?php echo base_url('issue_consumption/new_issue/issue_details_views');?>' title="View" class="view btn-primary btn-xxs"><i class="fa fa-eye" aria-hidden="true" ></i></a></td>
                        </tr>
                      
                        <?php
                         // $j++;
                        }
                        }
                        ?>
                          </table>
                          <?php
                       }
                       else
                       {
                        ?>
                        

                        <?php
                       }
                        ?>
                  
                         </td>
                     </tr>
                        <?php
                        $i++;
                    endforeach;
                endif;

                        ?>
                    </tbody>
                 
                </table>
        </div>
    </div>
</div>