<div class="row wb_form">

    <div class="col-sm-5">

        <div class="white-box">

            <h3 class="box-title"><?php echo $this->lang->line('items_category'); ?></h3>

            <div id="FormDiv_equipments" class="formdiv frm_bdy">

            <?php 

            if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='army'){

                $this->load->view('equipment_category/'.REPORT_SUFFIX.'/v_equipment_categoryform') ;

            }else{

            $this->load->view('equipment_category/v_equipment_categoryform') ;    

            }

            ?>

            </div>

        </div>

    </div>



    <div class="col-sm-7">

     <div class="white-box">

        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

   <div id="TableDiv">

 <?php  

      if(ORGANIZATION_NAME=='KU'){

        $this->load->view('equipment_category/'.REPORT_SUFFIX.'/v_equipment_category_list') ;

        }else{

        $this->load->view('equipment_category/v_equipment_category_list') ;    

        }

             ?>

 </div>



          

        </div>

    </div>

</div>

</div>

</div>

