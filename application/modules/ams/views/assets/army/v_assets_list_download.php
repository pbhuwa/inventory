
<?php  $this->load->view('common/v_report_header');?> 

<table id="" class="format_pdf" width="100%">

    <thead>

        <tr>

            <th width="3%">S.n</th>

            <th width="5%"><?php echo $this->lang->line('assets_code'); ?></th>

            <th width="10%"><?php echo $this->lang->line('assets_type'); ?></th>

            <th width="7%"><?php echo $this->lang->line('item_name'); ?></th>

            <th width="15%"><?php echo $this->lang->line('description'); ?></th>

            <th width="8%"><?php echo $this->lang->line('serial_no'); ?></th>

            <th width="5%"><?php echo $this->lang->line('condition'); ?></th>

             <th width="8%"><?php echo $this->lang->line('purchase_date'); ?></th>

            <th width="5%">Rate</th>

            <th width="5%">Department</th>

             <th width="5%">Supplier</th>

            <th width="8%">Received By</th>

            

        </tr>

    </thead>

    <tbody>

        <?php if($searchResult): 

        $i=1;

        foreach ($searchResult as $key => $result): 

        ?>

      <tr>

      <td><?php echo $key+1;?></td>

      <td><?php echo $result->asen_assetcode; ?></td>

			<td><?php echo $result->eqca_category; ?></td>

			<td><?php echo $result->itli_itemname; ?></td>

			<td><?php echo $result->asen_desc; ?></td>

			<td><?php echo $result->asen_serialno; ?></td>

      <td><?php echo $result->asco_conditionname; ?></td>

      <td><?php echo $result->asen_purchasedatebs; ?></td>

      <td><?php echo $result->asen_purchaserate; ?></td>
      
   
      
       
      <?php 
           
           $parentdep=!empty($result->depparent)?$result->depparent:'';
           if(!empty($parentdep)){
             $depname = $result->depparent.'/'.$result->dept_depname;  
            }else{
              $depname = $result->dept_depname; 
            }
      ?>
      <td> <?php echo $depname; ?></td>  


      <td><?php echo $result->dist_distributor; ?></td>
      <?php
                $fname=!empty($result->stin_fname)?$result->stin_fname:'';
                $mname=!empty($result->stin_mname)?$result->stin_mname:'';
                $lname=!empty($result->stin_lname)?$result->stin_lname:'';
                $receiver_name=$fname.' '.$mname.' '.$lname;
                if(ORGANIZATION_NAME=='KU'){
                  if(empty($result->asen_staffid)){
                    $str = strtoupper($result->asen_desc);
                    if(strpos($str, "RECEVIED BY") || strpos($str, "RECEVIED BY"))
                    {
                    $replace_rec_var = substr($str,strpos($str, "RECEVIED BY"), -1);
                    $replace_rec=str_replace('RECEVIED BY', '', $replace_rec_var);
                    $receiver_name=$replace_rec;
                    }

                  }
                }
                ?>

        

           <td><?php echo $receiver_name; ?></td>



        </tr>

        <?php

        $i++;

        endforeach;

        endif;

        ?>

    </tbody>

</table>