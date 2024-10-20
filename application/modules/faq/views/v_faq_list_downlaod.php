<?php
	// echo "<pre>";
 //    echo "PDF check";
	// print_r($searchResult);
	// die();
?>





<style>


    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; text-align: left;}
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>
    <!-- <?php// $this->load->view('common/v_report_header');?> -->
    <br>
    <table width="100%" style="font-size:12px;">
            <tr>
            <td style="width:45%">
            <td class="text-center"><b style="font-size:15px;"> <u><?php echo $this->lang->line('frequently_asked_questions'); ?>  </u></b> </td>
    </table>



<?php 
         $lang=$this->session->userdata('lang');

        if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $row): 
        ?>
               <?php if($lang=='en')
                { ?>
         
                

            <strong><?php echo $i; ?>. </strong>
            <strong><?php echo !empty($row->fali_title)?$row->fali_title:'';?></strong>
             <div class="padding" style="padding-left: 20px;">  
                <?php echo !empty($row->fali_description)?$row->fali_description:'';?>
            <br>
        </div>
                <?php } 


            else 
                {?>
                   
                      
              <strong>   <?php echo $i; ?>. </strong>
            <strong><?php echo !empty($row->fali_titlenp)?$row->fali_titlenp:'';?></strong>
               <div class="padding" style="padding-left: 20px;">
                <?php echo !empty($row->fali_descriptionnp)?$row->fali_descriptionnp:'';?></li>
           <br>
        </div>
         <?php } ?>




              <?php
        $i++;
        endforeach;
        endif;
        ?>



