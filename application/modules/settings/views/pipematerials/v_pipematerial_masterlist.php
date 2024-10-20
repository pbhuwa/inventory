<div class="row wb_form">

    <div class="col-sm-6">

        <div class="white-box">

            <h3 class="box-title">Add Pipe Material Information</h3>

            <div id="FormDiv_pipematerials" class="formdiv frm_bdy">

            <?php $this->load->view('pipematerials/v_pipematerial_listform') ;?>

            </div>

        </div>

    </div>



    <div class="col-sm-6">

     <div class="white-box">

        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

   <div id="TableDiv">

 <?php  $this->load->view('pipematerials/v_pipematerial_lists') ?>

 </div>



          

        </div>

    </div>

</div>

</div>

</div>

