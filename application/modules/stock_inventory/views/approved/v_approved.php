<div class="row wb_form">

    <div class="col-sm-6">

        <div class="white-box">

            <h3 class="box-title"><?php echo $this->lang->line('add_approved_information'); ?></h3>

            <div id="FormDiv_approved" class="formdiv frm_bdy">

            <?php $this->load->view('approved/v_approved_form') ;?>

            </div>

        </div>

    </div>



    <div class="col-sm-6">

     <div class="white-box">

        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

   <div id="TableDiv">

 <?php  $this->load->view('approved/v_approved_list') ?>

 </div>



          

        </div>

    </div>

</div>

</div>

</div>

