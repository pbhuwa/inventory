<div class="row row_5">
    <div class="col-sm-12">
        <h3 class="stock_sec_ttl">Assets </h3>
        <div class="row row_5">
            <ul class="head_sum stock_head">
                <li class="width-25">
                    <div class="head-info">
                        <div class="hi_left">
                            <img src="<?php echo base_url() ?>assets/template/images/dist.png" alt="">
                        </div>
                        <div class="hi_right">
                            <h4>Total</h4>
                            <p>
                                <a href="javascript:void(0)" class="btnviewd"  data-viewurl='#' data-resultval="all" data-orgid='2'><span>Total</span>
                                <?php echo !empty($assets_dashboard_count[0]->total)?$assets_dashboard_count[0]->total:0;?></a> 
                                <a href="javascript:void(0)" class="btnviewd" data-viewurl='#' data-resultval="cur" data-orgid='2' ><span>Today</span><?php echo !empty($assets_dashboard_count[0]->today)?$assets_dashboard_count[0]->today:0;?></a>
                            </p>
                        </div>
                    </div>
                </li>

                <li class="width-25">
                    <div class="head-info">
                        <div class="hi_left">
                            <img src="<?php echo base_url() ?>assets/template/images/dist.png" alt="">
                        </div>
                        <div class="hi_right">
                            <h4>By Status</h4>
                            <p>
                                <a href="javascript:void(0)" class="btnviewd"  data-viewurl='#' data-resultval="all" data-orgid='2'><span>Operation</span>
                                <?php echo !empty($assets_dashboard_count[0]->in_use)?$assets_dashboard_count[0]->in_use:0;?></a> 
                                <a href="javascript:void(0)" class="btnviewd" data-viewurl='#' data-resultval="cur" data-orgid='2' ><span>Non Operation</span><?php echo !empty($assets_dashboard_count[0]->in_store)?$assets_dashboard_count[0]->in_store:0;?></a>
                               
                            </p>
                        </div>
                    </div>
                </li>

                <li class="width-25">
                    <div class="head-info">
           
                        <div class="hi_left">
                            <img src="<?php echo base_url() ?>assets/template/images/dist.png" alt="">
                        </div>
                        <div class="hi_right">
                            <h4>By Condition</h4>
                            <p>
                                <a href="javascript:void(0)" class="btnviewd"  data-viewurl='#' data-resultval="all" data-orgid='2'><span>New</span>
                                <?php echo !empty($assets_dashboard_count[0]->new)?$assets_dashboard_count[0]->new:0;?></a> 
                                <a href="javascript:void(0)" class="btnviewd" data-viewurl='#' data-resultval="cur" data-orgid='2' ><span>Good</span><?php echo !empty($assets_dashboard_count[0]->good)?$assets_dashboard_count[0]->good:0;?></a>
                                <a href="javascript:void(0)" class="btnviewd" data-viewurl='#' data-resultval="cur" data-orgid='2' ><span>Fair</span><?php echo !empty($assets_dashboard_count[0]->fair)?$assets_dashboard_count[0]->fair:0;?></a>
                                <a href="javascript:void(0)" class="btnviewd" data-viewurl='#' data-resultval="cur" data-orgid='2' ><span>Poor</span><?php echo !empty($assets_dashboard_count[0]->poor)?$assets_dashboard_count[0]->poor:0;?></a>
                            </p>
                        </div>
                    </div>
                </li>

                <li class="width-25">
                    <div class="head-info">
           
                        <div class="hi_left">
                            <img src="<?php echo base_url() ?>assets/template/images/dist.png" alt="">
                        </div>
                        <div class="hi_right">
                            <h4>By Depreciation Type</h4>
                            <p>
                                <a href="javascript:void(0)" class="btnviewd"  data-viewurl='#' data-resultval="all" data-orgid='2'><span>Straight Line</span>
                                <?php echo !empty($assets_dashboard_count[0]->sl)?$assets_dashboard_count[0]->sl:0;?></a> 
                                <a href="javascript:void(0)" class="btnviewd" data-viewurl='#' data-resultval="cur" data-orgid='2' ><span>Double Declining B.</span><?php echo !empty($assets_dashboard_count[0]->ddb)?$assets_dashboard_count[0]->ddb:0;?></a>
                                <a href="javascript:void(0)" class="btnviewd" data-viewurl='#' data-resultval="cur" data-orgid='2' ><span>Unit of Production</span><?php echo !empty($assets_dashboard_count[0]->uop)?$assets_dashboard_count[0]->uop:0;?></a>
                                <a href="javascript:void(0)" class="btnviewd" data-viewurl='#' data-resultval="cur" data-orgid='2' ><span>Sum of Year Digits</span><?php echo !empty($assets_dashboard_count[0]->soyd)?$assets_dashboard_count[0]->soyd:0;?></a>
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- 

  <h3 class="home_sub_ttl">Assets</h3> 
  <div class="row row_5">
                        <ul class="head_sum">
                            <li class="width-25">
                                <div class="head-info">
                                    <a href="<?php echo base_url('biomedical/bio_medical_inventory'); ?>" class="a_link"><i class="fa fa-plus"></i></a>
                                    <div class="hi_left">
                                        <img src="<?php echo base_url() ?>assets/template/images/equipment.png" alt="">
                                    </div>
                                    <div class="hi_right">
                                        <h4>Assets Inven. </h4>
                                        <p>
                                            <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/get_all_biomedical_inv') ?>' data-resultval="all" data-orgid='2' ><span>Total</span><?php echo $inventory_total_asset[0]->total_inventory; ?>
                                            </a> 
                                            <a href="javascript:void(0)" data-resultval="bmin_equipid" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/get_all_biomedical_inv') ?>' data-orgid='2' ><span>Today</span><?php echo $inventory_today_asset[0]->todays_inventory; ?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="width-25">
                                <div class="head-info">
                                    <a href="<?php echo base_url('biomedical/distributors'); ?>" class="a_link"><i class="fa fa-plus"></i></a>
                                    <div class="hi_left">
                                        <img src="<?php echo base_url() ?>assets/template/images/dist.png" alt="">
                                    </div>
                                    <div class="hi_right">
                                        <h4>Distributor</h4>
                                        <p><a href="javascript:void(0)" class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/distributors/get_all_distributers') ?>' data-resultval="all" data-orgid='2'><span>Total</span>
                                            <?php echo $distributors_total_asset[0]->total_distributers

                                            ?></a> <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/distributors/get_all_distributers') ?>' data-resultval="cur" data-orgid='2' ><span>Today</span><?php echo $distributors_today_asset[0]->todays_distributers ?></a></p>
                                    </div>
                                </div>
                            </li>
                            <li class="width-25">
                                <div class="head-info">
                                    <a href="<?php echo base_url('biomedical/manufacturers'); ?>" class="a_link"><i class="fa fa-plus"></i></a>
                                    <div class="hi_left">
                                        <img src="<?php echo base_url() ?>assets/template/images/manu.png" alt="">
                                    </div>
                                    <div class="hi_right">
                                        <h4>Manufacturer</h4>
                                        <p><a href="javascript:void(0)"  class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/manufacturers/get_all_manufacturers') ?>' data-resultval="all" data-orgid='2' ><span>Total</span><?php  echo $manufactures_total_asset[0]->total_manufactures ?></a> <a href="javascript:void(0)" class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/manufacturers/get_all_manufacturers') ?>' data-resultval="cur" data-orgid='2' ><span>Today</span><?php echo $manufactures_today_asset[0]->todays_manufactures ?></a></p>
                                    </div>
                                </div>
                            </li>
                            <li class="width-25">
                                <div class="head-info">
                                    <a href="javascript:void(0)" class="a_link"><i class="fa fa-plus"></i></a>
                                    <div class="hi_left">
                                        <img src="<?php echo base_url() ?>assets/template/images/repair.png" alt="">
                                    </div>
                                    <div class="hi_right">
                                        <h4>Under Repair</h4>


                                        <p><a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/repair_request_info/get_repair_request') ?>' data-resultval="all" data-orgid='2' ><span>Total</span><?php echo $under_repair_total_asset[0]->total_repairreq ?></a> <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/repair_request_info/get_repair_request') ?>' data-resultval="cur" data-orgid='2'  ><span><?php echo $under_repair_total_asset[0]->total_repairreq ?></span>1</a></p>
                                    </div>
                                </div>
                            </li>
                            
                            <li class="width-25">
                                <div class="head-info">
                                    <a href="<?php echo base_url('biomedical/service_techs'); ?>" class="a_link"><i class="fa fa-plus"></i></a>
                                    <div class="hi_left">
                                        <img src="<?php echo base_url() ?>assets/template/images/service.png" alt="">
                                    </div>
                                    <div class="hi_right">
                                        <h4>Service Tech</h4>
                                        <p><a href="javascript:void(0)"  class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/service_techs/get_all_service_tec') ?>' data-resultval="all" data-orgid='2' ><span>Total</span><?php echo $servicetech_total_asset[0]->total_servicetech ?></a> <a href="javascript:void(0)" class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/service_techs/get_all_service_tec') ?>' data-resultval="cur" data-orgid='2' ><span>Today</span><?php echo $servicetech_today_asset[0]->todays_servicetech ?></a> </p>
                                    </div>
                                </div>
                            </li>
                            <div class="clearfix"></div>
                        </ul>
                    </div> -->