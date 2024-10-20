<div class="row wb_form">

    <div class="col-sm-5">

        <div class="white-box">

            <h3 class="box-title"><?php echo $this->lang->line('add_budget_information'); ?></h3>

            <div id="FormDiv_budgets" class="formdiv frm_bdy">

            <?php $this->load->view('budgets/v_budgets_form') ;?>

            </div>

        </div>

    </div>



    <div class="col-sm-7">

     <div class="white-box">

        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

   <div id="TableDiv">

 <?php  $this->load->view('budgets/v_budgets_list') ?>

 </div>



          

        </div>

    </div>

</div>

</div>

</div>

