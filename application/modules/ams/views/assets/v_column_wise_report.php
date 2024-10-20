<?php $this->load->view('assets/v_assets_common');?>
<form method="post" id="reportGeneration" action="" class="form-material form-horizontal form" >
      <div class="clearfix"></div>
      <div class="white-box">
         <h3 class="box-title"><?php echo $this->lang->line('assets_summary_report'); ?></h3>
        
           
              <?php $this->load->view('assets/v_column_wise_detail_report'); ?>
      </div>
                
    
      <div class="clearfix"></div>
         </div>
      </div>
  