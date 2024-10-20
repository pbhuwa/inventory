<div class="row wb_form">

    <div class="col-sm-6">

        <div class="white-box">

            <h3 class="box-title">Add Flowmeter Type Information</h3>

            <div id="FormDiv_flowmeters" class="formdiv frm_bdy">

            <?php $this->load->view('flowmeters/v_flowmeter_listform') ;?>

            </div>

        </div>

    </div>



    <div class="col-sm-6">

     <div class="white-box">

        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

   <div id="TableDiv">

 <?php  $this->load->view('flowmeters/v_flowmeter_lists') ?>

 </div>



          

        </div>

    </div>

</div>

</div>

</div>

