<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
	 <?php  $this->load->view('common/v_report_header',$this->data); ?> 
	<?php if(!empty($item_name)): 
			
		foreach ($item_name as $key => $item): ?>
		<br>
		<table class="jo_tbl_head">
				<tr>
					<td>
					<strong><?php echo $item->tena_name; ?></strong>
					</td>
				</tr>
		</table>

		<?php $test_map_details=$this->test_mdl->get_all_item_details(array('tema_testnameid'=>$item->tema_testnameid,'tt.tema_postdatebs >='=>$frmDate, 'tt.tema_postdatebs <='=>$toDate),false,false,false,'ASC'); 
		 // echo $this->db->last_query();
			if(!empty($test_map_details)):		
		?>
		<table class="alt_table">
				<thead>
				<tr>
                    <th> <?php echo $this->lang->line('sn'); ?>. </th>
                    <th>Department</th>
                    
                    <th> <?php echo $this->lang->line('particular'); ?> </th>
                    <th>Amount</th>
                    <th>Unit</th>
                    <th>Min Test Count </th>
                    <th> Max Test Count </th>
                   
                </tr>
				</thead>
				<tbody>
					<?php 
					$i=1;
					foreach ($test_map_details as $keys => $mapitem):
					?>
					<tr>
						<td><?php echo $i;?></td>
						 <td > 
                           <?php echo !empty($mapitem->tema_apidepname)?$mapitem->tema_apidepname:''; ?>
                        </td>

						
						  <td >  
                               <?php
                               if(ITEM_DISPLAY_TYPE=='NP'){
                                $item_name = !empty($mapitem->itli_itemnamenp)?$mapitem->itli_itemnamenp:$mapitem->itli_itemname;
                            }else{ 
                                $item_name = !empty($mapitem->itli_itemname)?$mapitem->itli_itemname:'';
                            }?>
                           <?php echo !empty( $item_name)? $item_name:''; ?>
                        </td>
                         
						 <td > 
                           <?php echo !empty($mapitem->tema_perml)?$mapitem->tema_perml:''; ?>
                        </td>
                        <td > 
                           <?php echo !empty($mapitem->unit_unitname)?$mapitem->unit_unitname:''; ?>
                        </td>
                        <td > 
                           <?php echo !empty($mapitem->tema_mintestcount)?$mapitem->tema_mintestcount:''; ?>
                        </td>
                        <td > 
                           <?php echo !empty($mapitem->tema_maxtestcount)?$mapitem->tema_maxtestcount:''; ?>
                        </td>
						
						
					</tr>
					<?php
					$i++;
					
				
					endforeach;
					
					 ?>
				
				</tbody>
		</table>
	<?php endif; endforeach; ?>
	
	<?php
	endif; ?>