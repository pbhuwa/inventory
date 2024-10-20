<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<?php echo $this->load->view('common/v_pdf_excel_header'); ?>


<table width="100%" style="font-size:12px;">
<tr>
    <td width="25%"></td>
    <td  style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><u><span class="<?php echo FONT_CLASS; ?>" > <?php echo $this->lang->line('location_wise_item_stock'); ?></span></u></h3></td>
                  <td width="25%"></td>
                </tr>

              </table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th ><?php echo $this->lang->line('sn'); ?></th>
            <th ><?php echo $this->lang->line('item_code'); ?></th>
            <th ><?php echo $this->lang->line('item_name'); ?></th>
            <!-- <th width="10%"><?php echo $this->lang->line('total'); ?></th> -->
                    <?php if($location)
            // echo "<pre>";
            // print_r($location);
            // die();
             {
                $dtable_column = '';
                $dtable_column .='[{ "data": "sno"},{ "data": "itemcode" },{ "data": "itemname" }, { "data": "totalallloc" },';
                foreach ($location as $key => $loca) { 
                $dtable_column .='{ "data": "location'.$loca->locid.'" },';
                 ?>
            <th width="10%">
                <?php echo $loca->loca_name; ?>
            </th>
            <?php } }
          
            $dtable_column = rtrim($dtable_column,',');  $dtable_column .="]";
            ?>  
        </tr>
    </thead>
   
    <tbody>
        <?php if($searchResult): 
        $i=1;
        $totalallloc=0;	
        foreach($searchResult as $key=>$loc_count){
        	
        }

        foreach ($searchResult as $key => $pending): 
            if($pending->lost_itemcode!=''):

            	foreach ($this->data['location'] as $key => $locat) {
				$rwloc=('location'.$locat->locid);
				$totalloc = $pending->{$locationid};
				$totalallloc += $totalloc;
			}; 
        ?>
      
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $pending->lost_itemcode; ?></td>
            <td><?php echo $pending->lost_itemname; ?></td>
            <!-- <td><?php echo $totalallloc; ?></td> -->
            <?php
            	foreach($this->data['location'] as $key => $locat){
            ?>
				<td>
					<?php 
						$locationid = "location".$locat->locid;
						echo $pending->$locationid;
					?>
				</td>
            <?php
            	}
            ?>
            
        </tr>
        <?php
        $i++;
    endif;
        endforeach;
        endif;
        ?>
    </tbody>
</table>
