<h3 class="home_sub_ttl">EQUIPMENTS</h3>
<div class="row row_5">

    <ul class="head_sum" style="flex-wrap: wrap;">
        <li>
            <div class="head-info">
                <a href="<?php echo base_url('biomedical/bio_medical_inventory'); ?>" class="a_link"><i class="fa fa-plus"></i></a>
                <div class="hi_left">
                    <img src="<?php echo base_url() ?>assets/template/images/equipment.png" alt="">
                </div>
                <div class="hi_right">
                    <h4>Inventory </h4>
                    <p>
                        <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/get_all_biomedical_inv') ?>' data-orgid='1' data-resultval="all"><span>Total</span><?php echo $inventory_total_bio[0]->total_inventory; ?>
                        </a> 
                        <a href="javascript:void(0)" data-resultval="bmin_equipid" class="btnviewd"   data-orgid='1' data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/get_all_biomedical_inv') ?>'><span>Today</span><?php echo $inventory_today_bio[0]->todays_inventory; ?>
                        </a>
                    </p>
                </div>
            </div>
        </li>
        <li>
            <div class="head-info">
                <a href="<?php echo base_url('biomedical/distributors'); ?>" class="a_link"><i class="fa fa-plus"></i></a>
                <div class="hi_left">
                    <img src="<?php echo base_url() ?>assets/template/images/dist.png" alt="">
                </div>
                <div class="hi_right">
                    <h4>Distributor</h4>
                    <p><a href="javascript:void(0)" class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/distributors/get_all_distributers') ?>' data-resultval="all" data-orgid='1' ><span>Total</span>
                        <?php echo $distributors_total_bio[0]->total_distributers

                        ?></a> <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/distributors/get_all_distributers') ?>' data-orgid='1'  data-resultval="cur"><span>Today</span><?php echo $distributors_today_bio[0]->todays_distributers ?></a></p>
                </div>
            </div>
        </li>
        <li>
            <div class="head-info">
                <a href="<?php echo base_url('biomedical/manufacturers'); ?>" class="a_link"><i class="fa fa-plus"></i></a>
                <div class="hi_left">
                    <img src="<?php echo base_url() ?>assets/template/images/manu.png" alt="">
                </div>
                <div class="hi_right">
                    <h4>Manufacturer</h4>
                    <p><a href="javascript:void(0)"  class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/manufacturers/get_all_manufacturers') ?>' data-resultval="all" data-orgid='1' ><span>Total</span><?php  echo $manufactures_total_bio[0]->total_manufactures ?></a> <a href="javascript:void(0)" class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/manufacturers/get_all_manufacturers') ?>' data-resultval="cur" data-orgid='1' ><span>Today</span><?php echo $manufactures_today_bio[0]->todays_manufactures ?></a></p>
                </div>
            </div>
        </li>
        <li>
            <div class="head-info">
                <a href="javascript:void(0)" class="a_link"><i class="fa fa-plus"></i></a>
                <div class="hi_left">
                    <img src="<?php echo base_url() ?>assets/template/images/repair.png" alt="">
                </div>
                <div class="hi_right">
                    <h4>Under Repair</h4>
                    <p><a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/repair_request_info/get_repair_request') ?>' data-resultval="all" data-orgid='1' ><span>Total</span><?php echo $under_repair_total_bio[0]->total_repairreq ?></a> <a href="javascript:void(0)" class="btnviewd" data-viewurl='<?php echo base_url('biomedical/repair_request_info/get_repair_request') ?>' data-orgid='1' data-resultval="cur" ><span>Today</span><?php echo $under_repair_today_bio[0]->today_repairreq ?></a></p>
                </div>
            </div>
        </li>
        <li>
            <div class="head-info">
                <a href="javascript:void(0)" class="a_link"><i class="fa fa-plus"></i></a>
                <div class="hi_left">
                    <img src="<?php echo base_url() ?>assets/template/images/ppm.png" alt="">
                </div>
                <div class="hi_right">
                    <h4>PM Detail</h4>
                    <p><a href="javascript:void(0)"><span>Total</span><?php echo $pm_data_today[0]->today_pmdata ?></a></p>
                </div>
            </div>
        </li>
        <li>
            <div class="head-info">
                <a href="<?php echo base_url('biomedical/service_techs'); ?>" class="a_link"><i class="fa fa-plus"></i></a>
                <div class="hi_left">
                    <img src="<?php echo base_url() ?>assets/template/images/service.png" alt="">
                </div>
                <div class="hi_right">
                    <h4>Service Tech</h4>
                    <p><a href="javascript:void(0)"  class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/service_techs/get_all_service_tec') ?>' data-resultval="all" data-orgid='1' ><span>Total</span><?php echo $servicetech_total_bio[0]->total_servicetech ?></a> <a href="javascript:void(0)" class="btnviewd"  data-viewurl='<?php echo base_url('biomedical/service_techs/get_all_service_tec') ?>' data-resultval="cur" data-orgid='1' ><span>Today</span><?php echo $servicetech_today_bio[0]->todays_servicetech ?></a> </p>
                </div>
            </div>
        </li>
        <div class="clearfix"></div>
    </ul>
</div>