<div class="row wb_form">

    <div class="col-sm-6">

        <div class="white-box">

            <h3 class="box-title"><?php echo $this->lang->line('add_soil_information'); ?></h3>

            <div id="FormDiv_soils" class="formdiv frm_bdy">

            <?php $this->load->view('soils/v_soil_listform') ;?>

            </div>

        </div>

    </div>



    <div class="col-sm-6">

     <div class="white-box">

        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

   <div id="TableDiv">

 <?php  $this->load->view('soils/v_soil_lists') ?>

 </div>



          

        </div>

    </div>

</div>

</div>

</div>

