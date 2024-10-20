<div class="row wb_form">

    <div class="col-sm-6">

        <div class="white-box">

            <h3 class="box-title">Add Joint Information</h3>

            <div id="FormDiv_joints" class="formdiv frm_bdy">

            <?php $this->load->view('joints/v_joint_listform') ;?>

            </div>

        </div>

    </div>



    <div class="col-sm-6">

     <div class="white-box">

        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

   <div id="TableDiv">

 <?php  $this->load->view('joints/v_joint_lists') ?>

 </div>



          

        </div>

    </div>

</div>

</div>

</div>

