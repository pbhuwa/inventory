<style type="text/css">
  #chartdiv {
    width: 100%;
    height: 500px;
  }
</style>
<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->

<!-- <script src="<?php echo base_url().PLUGIN_DIR ?>highcharts/highcharts.js"></script> -->


<style>
  .bio_dash .head_sum li { 
    width: 25%;
    text-align: center;
  }

</style>
<?php    if(!empty($dashboardaccess_array)): ?>
  <div class="home_filter_box">

    </div><?php //echo print_r($this->data['received']);die; ?>
    <!-- dashboard start -->
    <?php 
    // echo "<pre>";
    // print_r($dashboardaccess_array);
    // die();

    ?>

    <!-- Humanresource Dasboad-->
    <?php if(ORGANIZATION_NAME=='KUKL'): ?>
     <?php if(in_array(12,$dashboardaccess_array)): ?>
      <div class="row row_5">
        <div class="col-sm-12">
          <h3 class="stock_sec_ttl">User Registeration</h3>
          <div class="row row_5">
            <ul class="head_sum stock_head">
              <?php if(in_array(12,$dashboardaccess_array)): ?>
               <li class=" width-25">
                <div class="head-info">
                 <div class="hi_left">
                  <img src="<?php echo base_url() ?>assets/template/images/purchases.png" alt="">
                </div>
                <div class="hi_right">
                  <h4>Users Reg. Requests </h4>
                  <p>
                    <a href="<?php echo base_url('/settings/user_register') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='3'><span><?php echo $this->lang->line('total');?></span>
                      <?php echo $total_reguser[0]->total_reguserdetail;?></a>

                       <!-- <a href="javascript:void(0)" class="btnredirect"  data-viewurl="<?php echo base_url('/settings/user_register') ?>"  data-orgid='3'><span><?php echo $this->lang->line('today');?></span>
                        <?php echo $total_today[0]->total_regusertoday;?></a> -->

                        <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('/settings/user_register') ?>" data-dashboard_data="approved">
                          <span><?php echo $this->lang->line('approved');?></span>
                          <?php echo $approve_requser[0]->total_reguserapproved; ?></a>

                          <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('/settings/user_register') ?>" data-dashboard_data="pending">
                            <span><?php echo $this->lang->line('pending');?></span>
                            <?php echo $pending_requser[0]->total_reguserpending; ?></a>

                            <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('/settings/user_register') ?>" data-dashboard_data="cancel">
                              <span><?php echo $this->lang->line('cancel');?></span>
                              <?php echo $cancel_requser[0]->total_regusercancel; ?></a>

                            </p>
                          </div>
                        </div>
                      </li>
                    <?php endif; ?>

                  </ul>
                </div>
              </div>

            </div>
          <?php endif; endif; ?>
          <!-- Humanresource Dasboad-->

          <?php if(in_array(1,$dashboardaccess_array) || in_array(2,$dashboardaccess_array) || in_array(3,$dashboardaccess_array) || in_array(4,$dashboardaccess_array)): ?>
          <div class="row row_5">

            <div class="col-sm-12">
              <h3 class="stock_sec_ttl"><?php echo $this->lang->line('purchase');?> | <?php echo $this->lang->line('receive');?></h3>
              <div class="row row_5">
                <ul class="head_sum stock_head">
                  <?php if(in_array(1,$dashboardaccess_array)): ?>
                   <li class=" width-25">
                    <div class="head-info">
                     <div class="hi_left">
                      <a href="<?php echo base_url('purchase_receive/purchase_requisition') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'> <img src="<?php echo base_url() ?>assets/template/images/purchases.png" alt=""></a>

                      <!--  <img src="<?php //echo base_url() ?>assets/template/images/purchases.png" alt=""> -->
                    </div>

                    <!--  purchase_requisition/pur_req_book -->


                    <div class="hi_right">
                      <h4><?php echo $this->lang->line('purchase');?> <?php echo $this->lang->line('requisition');?> </h4>
                      <p>
                 <!--  <a href="<?php //echo base_url('purchase_receive/purchase_requisition_details') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'><span><?php //echo $this->lang->line('total');?></span>
                  <?php //echo $purchaserequisitiondetail[0]->total_purchaserequisitiondetail;?></a>  -->

                  <a href="<?php echo base_url('purchase_receive/purchase_requisition/pur_req_book') ?>" class="btnviewd" data-viewurl='<?php echo base_url('purchase_receive/purchase_requisition/pur_req_book') ?>' data-resultval="cur" data-orgid='2' ><span><?php echo $this->lang->line('total');?></span><?php echo $purchaserequisitiondetail[0]->total_purchaserequisitiondetail; ?></a> 



                  <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/purchase_requisition/pur_req_book') ?>" data-dashboard_data="approved">
                    <span><?php echo $this->lang->line('approved');?></span>
                    <?php echo $purchaserequisitionapproved[0]->total_purchaserequisitionapproved; ?></a>



                    <!--  <a href="<?php //echo base_url('purchase_receive/pending_requisition') ?>" class="btnviewd" data-viewurl='' data-resultval="cur" data-orgid='2' ><span><?php //echo $this->lang->line('pending');?></span><?php //echo $purchaserequisitionpending[0]->total_purchaserequisitionpending; ?></a> -->

                    <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/purchase_requisition/pur_req_book') ?>" data-dashboard_data="pending">
                      <span><?php echo $this->lang->line('pending');?></span>
                      <?php echo $purchaserequisitionpending[0]->total_purchaserequisitionpending; ?></a>
                    </p>
                  </div>
                </div>
              </li>
            <?php endif; ?>
            <?php if(in_array(2,$dashboardaccess_array)): ?>
             <li class="width-25">
              <div class="head-info">
               <!--  <a href="<?php echo base_url('biomedical/bio_medical_inventory'); ?>" class="a_link"><i class="fa fa-plus"></i></a> -->
               <div class="hi_left">
                <a href="<?php echo base_url('purchase_receive/quotation') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'> <img src="<?php echo base_url() ?>assets/template/images/quotation.png" alt=""></a>

                <!--  <img src="<?php //echo base_url() ?>assets/template/images/quotation.png" alt=""> -->
              </div>

              <div class="hi_right">
                <h4><?php echo $this->lang->line('quotation');?></h4>
                <p>
                  <a href="<?php echo base_url('purchase/quotation_book') ?>" class="btnviewd quotationviewd" data-viewurl='<?php echo base_url('purchase_receive/quotation_analysis') ?>' data-resultval="all" data-orgid='2' ><span><?php echo $this->lang->line('total');?></span><?php echo $purchase_quotation[0]->total_purchase_quotation; ?>
                </a> 

                <!--    <a href="javascript:void(0)" data-resultval="bmin_equipid" class="btnviewd x" data-viewurl='<?php //echo base_url('biomedical/bio_medical_inventory/get_all_biomedical_inv') ?>' data-orgid='2' ><span><?php //echo $this->lang->line('pending');?></span><?php// echo $pending_quotation[0]->total_pending_quotation; ?></a> -->

                <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/quotation_details') ?>" data-dashboard_data="pending">
                  <span><?php echo $this->lang->line('pending');?></span>
                  <?php echo $pending_quotation[0]->total_pending_quotation; ?></a>

                  <!--      <a href="javascript:void(0)" data-resultval="bmin_equipid" class="btnviewd quotationviewd" data-viewurl='<?php //echo base_url('biomedical/bio_medical_inventory/get_all_biomedical_inv') ?>' data-orgid='2' ><span><?php// echo $this->lang->line('verified');?></span><?php //echo $verified_quotation[0]->total_verified_quotation; ?></a> -->

                  <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/quotation_details') ?>" data-dashboard_data="finalapproved">
                    <span><?php echo $this->lang->line('verified');?></span><?php echo $verified_quotation[0]->total_verified_quotation; ?></a>
<!-- 
                                <a href="<?php //echo base_url('purchase_receive/quotation_analysis') ?>" data-resultval="bmin_equipid" class="btnviewd quotationviewd" data-viewurl='<?php //echo base_url('biomedical/purchase_receive/quotation_analysis') ?>' data-orgid='2' ><span><?php //echo $this->lang->line('approved');?></span><?php //echo $approved_quotation[0]->total_approved_quotation; ?>
                              </a> -->

                              <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/quotation_details') ?>" data-dashboard_data="approved">
                                <span><?php echo $this->lang->line('approved');?></span>
                                <?php echo $approved_quotation[0]->total_approved_quotation; ?>
                              </a>

                              <!--   <a href="javascript:void(0)" data-resultval="bmin_equipid" class="btnviewd quotationviewd" data-viewurl='<?php //echo base_url('biomedical/bio_medical_inventory/get_all_biomedical_inv') ?>' data-orgid='2' ><span><?php //echo $this->lang->line('cancel');?></span><?php 
                                $cancel= (($purchase_quotation[0]->total_purchase_quotation) - ($approved_quotation[0]->total_approved_quotation) - ($pending_quotation[0]->total_pending_quotation)- ($verified_quotation[0]->total_verified_quotation)); echo $cancel;?>
                              </a> -->

                               <!--   <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/quotation_details') ?>" data-dashboard_data="rejected">
                                    <span><?php echo $this->lang->line('rejected');?></span>
                                    <?php 
                                $cancel= (($purchase_quotation[0]->total_purchase_quotation) - ($approved_quotation[0]->total_approved_quotation) - ($pending_quotation[0]->total_pending_quotation)- ($verified_quotation[0]->total_verified_quotation)); echo $cancel;?>
                              </a> -->
                            </p>
                          </div>
                        </div>
                      </li>
                    <?php endif; ?>
                    <?php if(in_array(3,$dashboardaccess_array)): ?>
                     <li class="width-25">
                      <div class="head-info">
                        <div class="hi_left">
                         <a href="<?php echo base_url('purchase_receive/purchase_order') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'>  <img src="<?php echo base_url() ?>assets/template/images/phone.png" alt=""></a>
                         <!--   <img src="<?php //echo base_url() ?>assets/template/images/phone.png" alt=""> -->
                       </div>
                       <div class="hi_right">
                        <h4><?php echo $this->lang->line('order_heading');?> </h4>
                        <p>
                          <a href="<?php echo base_url('purchase_receive/purchase_order_details') ?>" class="btnviewd"  data-viewurl='<?php echo base_url('purchase_receive/purchase_order/purchase_order_book') ?>' data-resultval="all" data-orgid='2'><span><?php echo $this->lang->line('total');?></span>
                            <?php echo $purchaseorderdetail[0]->total_purchaseorderdetail;?></a> 

                            <!--  <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php //echo base_url('biomedical/distributors/get_all_distributers') ?>' data-resultval="cur" data-orgid='2' ><span><?php //echo $this->lang->line('pending');?></span><?php //echo $purchaseorderpending[0]->total_purchaseorderpending;?></a> -->

                            <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/purchase_order/purchase_order_book') ?>" data-dashboard_data="pending">
                              <span><?php echo $this->lang->line('pending');?></span>
                              <?php echo $purchaseorderpending[0]->total_purchaseorderpending;?></a>


                              <!--  <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php //echo base_url('biomedical/distributors/get_all_distributers') ?>' data-resultval="cur" data-orgid='2' ><span><?php //echo $this->lang->line('partially_received_header');?></span><?php echo $purchaseorderpratially[0]->total_purchaseorderpratially;?></a> -->
                              <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/purchase_order/purchase_order_book') ?>" data-dashboard_data="partialcomplete">
                                <span><?php echo $this->lang->line('partially_received_header');?></span>
                                <?php echo $purchaseorderpratially[0]->total_purchaseorderpratially;?></a>

                                <!-- <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php //echo base_url('biomedical/distributors/get_all_distributers') ?>' data-resultval="cur" data-orgid='2' ><span><?php //echo $this->lang->line('completetly_received_header');?></span>
                                    <?php 
                                    $Complete_received= (($purchaseorderdetail[0]->total_purchaseorderdetail) - ($purchaseorderpending[0]->total_purchaseorderpending) - ($purchaseorderpratially[0]->total_purchaseorderpratially)); echo $Complete_received;?></a> -->

                                    <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('purchase_receive/purchase_order/purchase_order_book') ?>" data-dashboard_data="complete">
                                      <span><?php echo $this->lang->line('completetly_received_header');?></span>
                                      <?php 
                                      $Complete_received= (($purchaseorderdetail[0]->total_purchaseorderdetail) - ($purchaseorderpending[0]->total_purchaseorderpending) - ($purchaseorderpratially[0]->total_purchaseorderpratially)); echo $Complete_received;?></a>
                                    </p>
                                  </div>
                                </div>
                              </li>
                            <?php endif; ?>
                            <?php if(in_array(4,$dashboardaccess_array)): ?>
                             <li class="width-25">
                              <div class="head-info">
                                <div class="hi_left">
                                 <a href="<?php echo base_url('purchase_receive/direct_purchase') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'>   <img src="<?php echo base_url() ?>assets/template/images/cart.png" alt=""></a>
                                 <!--  <img src="<?php //echo base_url() ?>assets/template/images/cart.png" alt=""> -->
                               </div>
                               <div class="hi_right">
                                <h4><?php echo $this->lang->line('direct_purchase');?> </h4>
                                <p>

                                  <a href="<?php echo base_url('purchase_receive/direct_purchase/direct_purchase_summary') ?>" class="btnviewd"  data-viewurl='<?php echo base_url('purchase_receive/direct_purchase/direct_purchase_summary') ?>' data-resultval="all" data-orgid='2'><span><?php echo $this->lang->line('total');?></span>
                                    <?php echo $direct_purchase[0]->total_direct_purchase;?></a>

                                    <a href="javascript:void(0)" class="btnredirect" data-viewurl='<?php echo base_url('purchase_receive/direct_purchase/direct_purchase_summary') ?>' data-dashboard_data="received"><span><?php echo $this->lang->line('received');?></span><?php echo $direct_purchase_receive[0]->total_direct_purchase_receive;?></a>
                                    <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/distributors/get_all_distributers') ?>' data-resultval="cur" data-orgid='2' ><span><?php echo $this->lang->line('cancel');?></span><?php echo $direct_purchase_cancel[0]->total_direct_purchase_cancel;?></a>

                                  </p>
                                </div>
                              </div>
                            </li>
                          <?php endif; ?>

                        </ul>
                      </div>
                    </div>

                  </div>
                <?php endif; ?>
                <?php if(in_array(5,$dashboardaccess_array) || in_array(6,$dashboardaccess_array) || in_array(7,$dashboardaccess_array) || in_array(8,$dashboardaccess_array)|| in_array(14,$dashboardaccess_array)|| in_array(15,$dashboardaccess_array)): ?>

                <div class="row row_5">
                  <div class="col-sm-12">
                    <h3 class="stock_sec_ttl"><?php echo $this->lang->line('stock_requisition');?> | <?php echo $this->lang->line('issue');?> <?php  if(ORGANIZATION_NAME!='KUKL'): ?>| <?php echo $this->lang->line('receive') ;?> <?php endif; ?></h3>
                    <div class="row row_5">
                      <ul class="head_sum stock_head">
                        <?php if(in_array(5,$dashboardaccess_array)): ?>
                          <li>
                            <div class="head-info">
                              <div class="hi_left">
                                <a href="<?php echo base_url('issue_consumption/stock_requisition') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'><img src="<?php echo base_url() ?>assets/template/images/customer.png" alt="" /></a>
                              </div>
                              <div class="hi_right">
                                <h4><?php echo $this->lang->line('stock_requisition');?> </h4>
                                <p>


                                  <a href="<?php echo base_url('issue_consumption/stock_requisition/requisition_list') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'><span><?php echo $this->lang->line('total');?></span>
                                    <?php echo $stock_requisition_total[0]->total_requisition;?></a> 

                                    <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('/issue_consumption/stock_requisition/requisition_list') ?>" data-dashboard_data="approved">
                                      <span><?php echo $this->lang->line('approved');?></span>
                                      <?php echo $stock_requistion_approved[0]->total_requisition_approve;?>
                                    </a>

                                    <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('/issue_consumption/stock_requisition/requisition_list') ?>" data-dashboard_data="pending">
                                      <span><?php echo $this->lang->line('pending');?></span>
                                      <?php echo $stock_requistion_pending[0]->total_requisition_pending;?>
                                    </a>

                    <!--             <a href="<?php echo base_url('issue_consumption/stock_requisition/requisition_list') ?>" class="btnviewd" data-viewurl='<?php echo base_url('purchase_receive/purchase_requisition/pur_req_book') ?>' data-resultval="cur" data-orgid='2' ><span><?php echo $this->lang->line('approved');?></span><?php echo $stock_requistion_approved[0]->total_requisition_approve; ?></a>
                      <a href="<?php echo base_url('issue_consumption/stock_requisition/requisition_list') ?>" class="btnviewd" data-viewurl='' data-resultval="cur" data-orgid='2' ><span><?php echo $this->lang->line('pending');?></span><?php echo $stock_requistion_pending[0]->total_requisition_pending; ?></a> -->

                    </p>
                  </div>
                </div>
              </li>
            <?php endif; ?>

            <?php if(in_array(15,$dashboardaccess_array)): ?>
             <li class="available-stock">
              <div class="head-info">
                <div class="hi_left">
                  <img src="<?php echo base_url() ?>assets/template/images/stock.png" alt="">
                </div>
                <div class="hi_right">
                  <h4><?php echo $this->lang->line('department_stock');?></h4>
                  <p>
                    <a href="javascript:void(0)" class="btnredirect available-btn" data-viewurl='<?php echo base_url('issue_consumption/test/stock_list?apptype=available') ?>' data-resultval="all" data-apptype="available" data-orgid='2' ><span><?php echo $this->lang->line('available');?></span><?php echo !empty($department_stock_count[0]->avl_cnt)?$department_stock_count[0]->avl_cnt:0; ?>
                  </a> 
                  <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('issue_consumption/test/stock_list?apptype=limited') ?>" data-dashboard_data="limited">
                    <span><?php echo $this->lang->line('limited');?></span>
                    <?php echo !empty($department_stock_count[0]->limit_cnt)?$department_stock_count[0]->limit_cnt:0; ?>
                  </a>


                  <a href="javascript:void(0)" data-resultval="bmin_equipid" class="btnredirect outofstock-btn" data-apptype="zero" data-viewurl='<?php echo base_url('issue_consumption/test/stock_list?apptype=zero') ?>' data-dashboard_data="zero" data-orgid='2' ><span><?php echo $this->lang->line('out_of_stock');?></span>
                    <?php echo !empty($department_stock_count[0]->out_cnt)?$department_stock_count[0]->out_cnt:0; ?>
                  </a>
                </p>
              </div>
            </div>
          </li>
        <?php endif; ?>
        <?php if(in_array(6,$dashboardaccess_array)): ?>

          <li>
            <div class="head-info">
              <div class="hi_left">
               <a href="<?php echo base_url('issue_consumption/new_issue') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'>    <img src="<?php echo base_url() ?>assets/template/images/issue.png" alt=""></a>

             </div>
             <div class="hi_right">
              <h4><?php echo $this->lang->line('issue');?> </h4>
              <p>
                <a href="javascript:void(0)" class="btnredirect"  data-viewurl='<?php echo base_url('/issue_consumption/new_issue/issuebook') ?>' data-dashboard_data="issue"><span><?php echo $this->lang->line('issue');?></span>
                  <?php echo !empty($issue_count[0]->iss_count)?$issue_count[0]->iss_count:0; ?></a> 
                  <a href="javascript:void(0)" class="btnredirect" data-viewurl='<?php echo base_url('/issue_consumption/new_issue/issuebook') ?>'data-dashboard_data="issuereturn" ><span><?php echo $this->lang->line('return');?></span>  <?php echo !empty($issue_return_count[0]->ir_count)?$issue_return_count[0]->ir_count:0; ?></a>

                </p>
              </div>
            </div>
          </li>
        <?php endif; ?>
        <?php if(in_array(14,$dashboardaccess_array)): ?>

          <li>
            <div class="head-info">
              <div class="hi_left">
               <a href="<?php //echo base_url('issue_consumption/new_issue') ?>" class="btnviewd"  data-viewurl='' data-resultval="all" data-orgid='2'>    <img src="<?php echo base_url() ?>assets/template/images/issue.png" alt=""></a>

             </div>
             <div class="hi_right">
              <h4><?php echo $this->lang->line('receive');?>   </h4>
              <p>
                <a href="javascript:void(0)" class="btnredirect"  data-viewurl='<?php echo base_url('/issue_consumption/new_issue/issuebook') ?>' data-dashboard_data="issue"><span><?php echo $this->lang->line('receive');?></span>
                  <?php echo !empty($issue_count[0]->iss_count)?$issue_count[0]->iss_count:0; ?></a> 
                  <a href="javascript:void(0)" class="btnredirect" data-viewurl='<?php echo base_url('/issue_consumption/new_issue/issuebook') ?>'data-dashboard_data="issuereturn" ><span><?php echo $this->lang->line('return');?></span>  <?php echo !empty($issue_return_count[0]->ir_count)?$issue_return_count[0]->ir_count:0; ?>
                </a>
                <a href="javascript:void(0)" class="btnredirect" data-viewurl='<?php echo base_url('issue_consumption/new_issue/issuebook') ?>' data-resultval="cur" data-orgid='2' ><span><?php echo $this->lang->line('cancel');?></span><?php echo $issue_cancel_count[0]->cancel_count;?></a>

              </p>
            </div>
          </div>
        </li>
      <?php endif; ?>

    </ul>
  </div>
</div>
<div class="col-sm-12">
  <?php if(in_array(7,$dashboardaccess_array)): ?>
   <h3 class="stock_sec_ttl"><?php echo $this->lang->line('stock');?></h3>
   <div class="row row_5">
     <ul class="head_sum stock_head">

      <li class="available-stock">
        <div class="head-info">
          <div class="hi_left">
            <img src="<?php echo base_url() ?>assets/template/images/stock.png" alt="">
          </div>
          <div class="hi_right">
            <h4><?php echo $this->lang->line('stock');?></h4>
            <p>
              <a href="javascript:void(0)" class="btnredirect available-btn" data-viewurl='<?php echo base_url('stock_inventory/current_stock?apptype=available') ?>' data-resultval="all" data-apptype="available" data-orgid='2' ><span><?php echo $this->lang->line('available');?></span><?php echo !empty($stock_count[0]->StockCnt)?$stock_count[0]->StockCnt:0; ?>
            </a> 



            <a href="javascript:void(0)" class="btnredirect" data-viewurl="<?php echo base_url('stock_inventory/current_stock?apptype=limited') ?>" data-dashboard_data="limited">
              <span><?php echo $this->lang->line('limited');?></span>
              <?php echo !empty($stock_count[0]->LimitCnt)?$stock_count[0]->LimitCnt:0; ?>
            </a>


            <a href="javascript:void(0)" data-resultval="bmin_equipid" class="btnredirect outofstock-btn" data-apptype="zero" data-viewurl='<?php echo base_url('stock_inventory/current_stock?apptype=zero') ?>' data-dashboard_data="zero" data-orgid='2' ><span><?php echo $this->lang->line('out_of_stock');?></span>
              <?php echo !empty($stock_count[0]->ZeroCnt)?$stock_count[0]->ZeroCnt:0; ?>
            </a>
          </p>
        </div>
      </div>
    </li>
  <?php endif; ?>
  <?php if(in_array(8,$dashboardaccess_array)): ?>
    <li class="expenses">
      <div class="head-info">
        <div class="hi_left">
         <img src="<?php echo base_url() ?>assets/template/images/money-expenses.png" alt="">
       </div>
       <div class="hi_right">
        <h4><?php echo $this->lang->line('expenses');?></h4>
        <p>
          <a href="#" class="btnviewd">
            <span><?php echo $this->lang->line('amount');?></span>
            <span class="amount"><?php echo !empty($expenses_sum[0]->total_expenses)?$expenses_sum[0]->total_expenses:'0'; ?></span>
          </a>
        </p>

      </div>
    </div>
  </li>

</ul>
</div>
<?php endif; ?>
</div>
<div class="clearfix"></div>
</div>


<div class="clearfix"></div>
</div>
<?php endif; ?>

<!-- dashboard end -->
<?php if(in_array(9,$dashboardaccess_array)): ?>
  <div class="white-box chart-box">
    <div class="row">
      <div class="pad-5">
        <div class="col-md-12 col-sm-12">
          <h3 class="box-title"><?php echo $this->lang->line('requisition'); ?>/<?php echo $this->lang->line('issue'); ?></h3>
          <!-- <div id="chartContainer" style="height: 300px; width: 100%;"></div> -->
          <div class="white-box">
            <ul class="nav nav-tabs pre_main">
             <li class="active"><a data-toggle="tab" href="#weekly">Weekly Req/Issue</a></li>
             <li><a data-toggle="tab" href="#thisyear">This Year</a></li>
             <li><a data-toggle="tab" href="#year_wise">Year Wise</a></li>
           </ul>
           <div class="tab-content pad-5 mtop_5">
             <div id="weekly" class="tab-pane fade in active">
              <h3 class="pre_main_title">This Week Requisition/Issue Chart
              </h3>
              <div id="weekpm">
               <?php $this->load->view('stock_chart/weekly_req_issue_chart'); ?>
             </div>
           </div>
           <div id="thisyear" class="tab-pane fade">
            <h3 class="pre_main_title">This Year Requisition/Issue Chart</h3>
            <div id="yearpm">
             <?php $this->load->view('stock_chart/year_req_issue_chart'); ?>
           </div>
         </div>
         <div id="year_wise" class="tab-pane fade">
          <h3 class="pre_main_title">Yearwise Requisition/Issue Chart</h3>
          <div id="yearwisepm">
           <?php $this->load->view('stock_chart/year_wise_req_issue_chart'); ?>
         </div>
       </div>
     </div>
   </div>

 </div>
</div>
</div>
</div>

<div class="white-box">
  <div class="row">
    <div class="pad-5">
      <div class="col-lg-6 col-xs-12">
        <h3 class="box-title">Requisition Chart</h3>
        <div id="piechart-req" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
      </div>

      <div class="col-lg-6 col-xs-12">
        <h3 class="box-title">Issue Chart</h3>
        <div id="piechart-iss" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
</div>


<?php
if(!empty($req_chart)):
  $rdata='';
  $rdata="[";        
  foreach ($req_chart as $krc => $reqdata) {
    $rdata.='{name: "'.$reqdata->category.'",
    y: '.$reqdata->req_per.',
  } ,';
}
$rdata.="]";
endif;
?>
<?php
if(!empty($issue_chart)):
  $idata='';
  $idata="[";        
  foreach ($issue_chart as $krc => $issdata) {
    $idata.='{name: "'.$issdata->category.'",
    y: '.$issdata->iss_per.',
  } ,';
}
$idata.="]";
endif;
?>
<script type="text/javascript">
 var rdata=<?php echo $rdata; ?>;
     // alert(rdata);
     var idata=<?php echo $idata; ?>
   </script>


   <script type="text/javascript">
    Highcharts.chart('piechart-req', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: 'Most Requisited Category'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      credits: {
        enabled: false
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          size:'100%',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
            style: {
              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            }
          }
        }
      },
      series: [{
        name: 'Brands',
        colorByPoint: true,
        data: rdata
      }]
    });
  </script>
  <script type="text/javascript">
    Highcharts.chart('piechart-iss', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: 'Most Issued Category'
      },
      credits: {
        enabled: false
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          size:'100%',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
            style: {
              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            }
          }
        }
      },
      series: [{
        name: 'Brands',
        colorByPoint: true,
        data: idata
      }]
    });
  </script>

<?php endif; ?>
<?php endif; ?>