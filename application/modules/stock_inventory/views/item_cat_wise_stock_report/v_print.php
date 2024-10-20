<!--<div class="tableWrapper">
		<table class="jo_table itemInfo" style="width: 100%;border-collapse: collapse;border: 1px solid #333;">
			<tr>
				<th rowspan="2">क्र. सं.</th>
				<th rowspan="2">खाता पाना नं.</th>
				<th rowspan="2">जिन्सी वर्गीकरण संकेत नं</th>
				<th rowspan="2">विवरण</th>
				<th rowspan="2">एकाइ</th>
				<th colspan="2">जिन्सी खाता बमोजिमको</th>
				<th colspan="2">स्पेसीफिकेसन</th>
				<th colspan="3">चालु हालतमा</th>
				<th colspan="2">चालु हालतमा</th>
				<th rowspan="2">कै</th>
			</tr>
			<tr>
				<th>परिमाण</th>
				<th>मुल्य</th>
				<th>मिलान भएको संख्या</th>
				<th>मिलान नभएको संख्या </th>
				<th>घट</th>
				<th>बढ</th>
				<th>घट / बढ मुल्य</th>
				<th>रहेको</th>
				<th>नरहेको</th>
			</tr>
			<tr>
			<td>१</td>
			<td>२</td>
			<td>३</td>
			<td>४</td>
			<td>५</td>
			<td>६</td>
			<td>७</td>
			<td>८</td>
			<td>९</td>
			<td>१०</td>
			<td>११</td>
			<td>१२</td>
			<td>१३</td>
			<td>१४</td>
			<td>१५</td>
			</tr>
		
	
	<?php  
						
	                    foreach ($searchResult as $key => $direct) { ?>
	            <tr style="border-bottom: 1px solid #212121;">
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						<?php echo $key+1; ?>
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						<?php echo !empty($direct->itli_itemcode)?$direct->itli_itemcode:''; ?>
					</td>
					<td  class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						 <?php echo !empty($direct->itli_itemname)?$direct->itli_itemname:''; ?>
					</td>
					 
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
	                    <?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>
	                </td>

	                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
	                    <?php echo $direct->qty; ?>
	                </td>

	                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
	                    <?php echo $direct->amount; ?>
	                </td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						
					</td>
					 <td class="td_cell">
	                </td>
	                 <td class="td_cell">
	                </td>
	                 <td class="td_cell">
	                </td>
					<td class="td_cell"></td>
					<td class="td_cell">
					</td>
					<td style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						
					</td>
				</tr><?php
				$sum += $direct->amount;
				 	// $vatsum += $direct->recd_vatamt;

				
				 } ?>
				 <tr>
					<td colspan="15"  style="text-align: center;text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;font-size: 12px;">
						<span class="<?php echo FONT_CLASS; ?>">कूल  जम्मा : </span>:
					
						<?php echo !empty($sum)?number_format($sum,2):''; ?>
					</td>
				
				</tr>
				
		</table>
    	</div>
    	
    <?php }else{ ?> -->