<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h3 class="mb-0">
        
         <center><?php echo $this->lang->line('general_question'); ?></center>
         <a href="javascript:void(0)" class="btn btn_pdf2 btn_gen_report" data-exporturl="faq/faq/faq_list_pdf" data-exporttype="pdf"><i class="fa fa-file-pdf-o"></i></a>
        
      </h3>
    </div>
  </div>



  <div class="card">
    <div class="card-header" id="headingTwo">


         <?php 
         $lang=$this->session->userdata('lang');
         $i=1;
         if($faq_data){
            // echo "<pre>"; print_r($faq_data); die;
        foreach ($faq_data as $key => $faq) {
            //echo $faq['fa;li_title']; die;
            if($lang=='en'):
          ?>
      <h5 class="mb-0">
        <button class="btn btn-link collapsed <?php echo $faq['fali_faqlistid']; ?>" data-toggle="collapse" data-target="#<?php echo $faq['fali_faqlistid']; ?>" aria-expanded="false" aria-controls="collapseTwo"><strong><?php echo $i; ?>. 
         <?php echo $faq['fali_title'];?></strong>
        </button>
      </h5>
    
    <div id="<?php echo $faq['fali_faqlistid']; ?>" class="collapse<?php if($key+1 == '1') echo" in"; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        <?php echo $faq['fali_description'];?>
      </div>
    </div>

    <?php else :?>
  
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed <?php echo $faq['fali_faqlistid']; ?>" data-toggle="collapse" data-target="#collapseThree_<?php echo $faq['fali_faqlistid']; ?>" aria-expanded="false" aria-controls="collapseThree"><strong> <?php echo $i; ?> . 
         <?php echo $faq['fali_titlenp'];?></strong>
        </button>
      </h5>
    </div>
    <div id="collapseThree_<?php echo $faq['fali_faqlistid']; ?>" class="collapse <?php if($key+1 == '1') echo" in"; ?>" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
       <?php echo $faq['fali_descriptionnp'];?>
      </div>
    </div>
    <br>

     <?php 
 endif;
 $i++;} } ?>
  </div>
</div>
</div>
