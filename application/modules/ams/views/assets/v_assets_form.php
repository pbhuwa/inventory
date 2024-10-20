<style type="text/css">

    .file {

        position: relative;

        margin-top: 25px;

    }

   

    .file label {

        background: #00653c;

        padding: 15px 20px;

        color: #fff;

        font-weight: 600;

        font-size: .9em;

        transition: all .4s;

        text-transform: capitalize;

    }

    .file input {

        position: absolute;

        display: inline-block;

        left: 0;

        top: 0;

        opacity: 0.01;

        cursor: pointer;

    }

    

    .file input:hover + label,

    

    .file input:focus + label {

        background: #34495E;

        color: #fff;

    }

    

    .assets-title h4{

        border-bottom: 1px solid #e2e2e2;

        padding-bottom: 5px;

        margin-bottom: 10px;

        padding-top: 5px;

        text-transform: capitalize;

        font-weight: 500;

        font-size: 16px;

    }

    

    .submit-btn{

        margin-top: 19px;

    }

    .assets-title + .assets-title{

        margin-top: 20px;

    }

</style>

<ul class="nav nav-tabs">

    <li class="active"><a href="#asset_entryForm" data-toggle="tab" class="active">Basic Info.</a></li>

    <?php if(!empty($assets_data)): ?>

    <li ><a href="#asset_generalForm" data-toggle="tab" >General</a></li>

    <li><a href="#lease" data-toggle="tab">Lease</a></li>

    <li><a href="#insurance" data-toggle="tab">Insurance</a></li>

     <li><a href="#maintenance" data-toggle="tab">Maintenance</a></li>

     <li><a href="#disposal" data-toggle="tab">Assets Sales/Disposal</a></li>



 <?php endif; ?>

</ul>

<div class="tab-content" id="tabs">

    <div class="tab-pane active" id="asset_entryForm" >

        <?php $this->load->view('v_assets_entry_form'); ?>

    </div> 

     <?php if(!empty($assets_data)): ?>

      <div class="tab-pane" id="asset_generalForm">


          <?php 
          if(ORGANIZATION_NAME == 'KU'){
            $this->load->view('ku/v_assets_general_form');
          }else{ 
            $this->load->view('v_assets_general_form'); 
          }
          ?>

      </div>

    <div class="tab-pane" id="lease">

         <?php $this->load->view('v_assets_lease_form') ?>

    </div>

    <div class="tab-pane" id="insurance">

        <?php $this->load->view('v_assets_insurance_form') ?>

    </div>

     <div class="tab-pane" id="maintenance"><?php $this->load->view('v_assets_maintanance_form') ?></div>

     <div class="tab-pane" id="disposal"><?php $this->load->view('v_assets_disposal_form') ?></div>

     <?php endif; ?>

</div>


<script type="text/javascript">
setTimeout(function () {
     $('.select2').select2();
}, 500);
   
</script>
