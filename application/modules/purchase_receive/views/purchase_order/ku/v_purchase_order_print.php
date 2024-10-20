<style>	
	@page  {
    	size: auto;   
    	margin: 8mm;  
    } 

  h5 {
/*            margin: 0 0 10px;
*/            font-size: 16px;
            font-weight: 600;
        }
        h6 {
            font-size: 12px;
/*            margin-bottom:.5rem;
*/            font-weight: 600
        }
        .ku_details h6{
        	margin-bottom: 0
        }
	.ku_table td,
        .ku_table th {
            padding: 2px !important;
            font-size: 11px;
            border:0 !important;
        }
/*        .ku_table td{
            font-size: 11px;
            line-height: 13px !important;
             padding:2px !important;
            vertical-align: middle !important;
        }*/
        .ku_table tbody td{
            font-size: 11px;
            line-height: 13px !important;
            white-space: normal !important;
            padding:2px !important;
            vertical-align:top !important;
        }
           .ku_table th {
            vertical-align: middle !important; 
            font-weight: 600;
        }
        .ku_table thead{
            border-color: black !important;
            border-bottom: 1.5px solid !important;
        }
        .ku_table tfoot {
            border-top: 1px solid #000
        }

        .ku_bottom {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-gap:1em;
            align-items: flex-start;
            align-items: center;
            justify-content: space-between;
            padding: 8rem .5rem;
        }
        .ku_table tfoot th {
            text-align: right !important;
            font-size: 11px !important;
            padding:0rem 2px !important
        }
        .ku_bottom h6 {
            padding: .5rem 2rem 0;
            border-top: 1px solid;
            text-align: center;
            font-weight: 700;
        }
         .ku_print_header {
           /* display: grid;
            grid-template-columns: 25% 50% 25%;*/
            padding-bottom:0px !important;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
        }
        .ku_print_header .title{
            text-align: center;
        }
         .ku_print_header .title h5{
            font-weight: 700;
            color: #000;
            font-size: 1.3rem;
            margin:0;
        }
        .ku_print_header .title span{
            text-transform: uppercase;
            font-weight: 700;
            color: #000;
        }
        .ku_details ,.ku_table-wrapper{
/*            padding-left:1rem;padding-right: 1rem;
*/        }
        .ku_print_header .date {
            text-align: right;
            align-self: flex-end;
        }
        .ku_details_individual{
            display: grid;
            padding: 2px 5px;
            grid-template-columns:65% 35%;
            align-items: center;
        }
        .ku_details_individual h6{
        	display:grid;
        	font-size: 13px;
            font-weight: 600;
        	margin:0;
        	grid-template-columns:18% 3% 79%
        }
        .ku_details_individual h6 .value , .remarks, .received{
            text-transform: uppercase;
        }
        .ku_table tfoot th[colspan="3"]{
            text-align: center !important;
        }
        .ku_table tfoot th h6 {
        	font-size: 11px !important;
        	font-weight: 600
        }
         .ku_double h6{
             text-align: left;
             width: 80%;
            color: #000;
             font-weight: bold;
             margin: 0 auto !important;
         }
          h6.ku_double-border{
            padding-bottom: .25rem;
             color: #000;
             font-weight: bold;
          }
         .ku_double-border {
            position: relative;
            border-bottom: 4px double #000 !important;
        }
        .logo {
        	top:-18px !important;
        }
        .table_jo_header {
        	margin-bottom: 15px !important
        }
</style>
<div class="jo_form organizationInfo">
	<div class="headerWrapper">
		<div class="ku_print_header" style="padding-bottom: 0 !important">
		<?php 
            $header['report_no'] = '';
            $header['old_report_no'] = '';
            $header['report_title'] = 'Purchase Order';
            $this->load->view('common/v_print_report_header',$header);
        ?>
    </div>
			<?php
				$supplierid = !empty($report_data['supplier'])?$report_data['supplier']:'';
				$supplier_data =  $this->general->get_tbl_data('*','dist_distributors',array('dist_distributorid'=>$supplierid),false,'DESC');
				$suppliername = !empty($supplier_data[0]->dist_distributor)?$supplier_data[0]->dist_distributor:'';
				$supplieraddress = !empty($supplier_data[0]->dist_address1)?$supplier_data[0]->dist_address1:'';
				$supplierregno = !empty($supplier_data[0]->dist_govtregno)?$supplier_data[0]->dist_govtregno:'';
				$supplierpanno = !empty($supplier_data[0]->dist_panvatno)?$supplier_data[0]->dist_panvatno:'';
				$supplierphone = !empty($supplier_data[0]->dist_phone1)?$supplier_data[0]->dist_phone1:'';
				echo $supplierphone;
			?>
			<?php 
				if($order_details){
					$delivery_date = !empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:'';
					$delivery_site = !empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:'';
				}else{
					$delivery_date = !empty($report_data['delevery_date'])?$report_data['delevery_date']:'';
					$delivery_site = !empty($report_data['delevery_site'])?$report_data['delevery_site']:'';
				} 
			?>
			<?php 
			$result=array();
			$purchase_masterid=!empty($order_details[0]->puor_purchaseordermasterid)?$order_details[0]->puor_purchaseordermasterid:'';
			if(!empty($purchase_masterid)){
				$this->db->select('rm.rema_reqfromdepid depid,d.dept_depname depname, loc.loca_name schoolname');
				$this->db->from('puor_purchaseordermaster pm');
				$this->db->join('pure_purchaserequisition pr','pr.pure_purchasereqid=pm.puor_purchasereqmasterid','LEFT');
				$this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=pr.pure_reqmasterid','LEFT');
				$this->db->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT');
				$this->db->join('loca_location loc','loc.loca_locationid=rm.rema_school','LEFT');
				$this->db->where('puor_purchaseordermasterid',$purchase_masterid);
				$result=$this->db->get()->row();
				// echo "<pre>";
				// print_r($result);
				// die();
			}
			?>
		<div class="ku_details"  >
        <div class="ku_details_individual" >
					<h6>Order No.
						<span>:</span>
					<span class="ku_value">
						<?php echo !empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:''; ?>	
					</span>
				</h6>
				<h6 style="grid-template-columns: 35% 3% 62%">Delivery Date	<span>:</span>
					<span class="ku_value">
				<?php echo !empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:''; ?> (<?php echo !empty($order_details[0]->puor_deliverydays)?$order_details[0]->puor_deliverydays:''; ?> Days)
					
					</span>
				</h6>
			</div>
        <div class="ku_details_individual" >
				<h6>Order Date	<span>:</span>
					<span class="ku_value">
						<?php echo !empty($order_details[0]->puor_orderdatebs)?$order_details[0]->puor_orderdatebs:''; ?>	
					</span>
				</h6>
				<h6 style="grid-template-columns: 32% 3% 62%">Delivery Site<span>:</span>
					<span class="ku_value">
						<?php echo !empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:''; ?>	
					</span>
				</h6>
			</div>
        <div class="ku_details_individual">
        	<h6>Supplier	<span>:</span>
					<span class="ku_value">
				<?php echo !empty($order_details[0]->dist_distributor)?$order_details[0]->dist_distributor:''; ?>	
					</span>
				</h6>
			</div>
		</div>
	</div>
	<div class="ku_table-wrapper" style="border-top: 1px solid #000;margin-top:10px;padding-top:10px" >
		<table  class="ku_table table table-borderless " width="100%" style="margin:.5rem 0">
			<thead>
				<tr>
					<th class="td_cell"> S.N. </th>
					<th class="td_cell"> Code </th>
					<th class="td_cell"> Item Name </th>
					<th class="td_cell"> Unit </th>
					<th class="td_cell"> Qty </th>
					
					<th class="td_cell"> Rate </th>
					<th class="td_cell"> Dis.(%) </th>
					<th width="5%"> VAT </th>
					<th class="td_cell" width="10%" style="text-align: right;"> Amount(NRs) </th>
					<th class="td_cell" style="text-align: center;"> Stk. Qty </th>
					<th class="td_cell" width="30%"> Remarks </th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sub_total = 0; 
					if($order_details){ //echo"<pre>"; print_r($order_details);die;
					foreach ($order_details as $key => $dprint) { ?>
				<tr>
					<td  class="td_cell">
						<?php echo $key+1; ?>
					</td>
					<td>
						<?php 
						echo  !empty($dprint->itli_itemcode)?$dprint->itli_itemcode:''; 
                        ?>
					</td>
					<td  class="td_cell">
						<?php 
						echo  !empty($dprint->itli_itemname)?$dprint->itli_itemname:''; 
                        ?>
					</td>
					<td>
						<?php 
						echo  !empty($dprint->unit_unitname)?$dprint->unit_unitname:''; 
                        ?>
					</td>
					<td  class="td_cell">
						<?php echo !empty($dprint->pude_quantity)?$dprint->pude_quantity:0; ?>
					</td>
					<td  class="td_cell" >
						<?php echo !empty($dprint->pude_rate)?number_format($dprint->pude_rate,2):0; ?>
					</td>
					<td class="td_cell">
						<?php echo !empty($dprint->pude_discount)?number_format($dprint->pude_discount,2):''; ?>
					</td>
					<td>
						<?php echo !empty($dprint->pude_vat)?number_format($dprint->pude_vat,2):0; ?>
					</td>
					
					<td  class="td_cell" style="text-align: right;" >
						<?php 
							$qty = !empty($dprint->pude_quantity)?$dprint->pude_quantity:0;
							$rate = !empty($dprint->pude_rate)?$dprint->pude_rate:0;
							$amt = $qty*$rate;
							echo !empty($amt)?number_format($amt,2):0; 
						?>
					</td>
					<td class="td_cell" style="text-align: center;"><?php echo !empty($dprint->stockqty)?number_format($dprint->stockqty,2):''; ?></td>
					<td  class="td_cell">
						<?php echo !empty($dprint->pude_remarks)?$dprint->pude_remarks:''; ?>
					</td>
				</tr>
				<?php	
					$sub_total += $amt;
				 	} 
				 ?>
				<?php } ?>
			</tbody>
		<tfoot>
			 <tr>
			 	<th style="padding:4px 2px 1px !important" colspan="8"></th>
			 	<th style="padding:4px 2px 1px !important" colspan="2"><h6 style="padding:0 !important;margin:0 !important">Total Amount:</h6></th>
			 	<th style="padding:4px 20px 2px 1px !important" style="text-align: right;"><?php echo number_format($sub_total,2); ?></th>
			 </tr>
			 <tr>
			 	<th style="padding:1px !important" colspan="8"></th>
			 	<th style="padding:1px !important" colspan="2"><h6 style="padding:0 !important;margin:0 !important">Discount:</h6></th>
			 	<th style="padding:1px 20px 1px 1px !important" style="text-align: right;"><?php $discountamt= !empty($order_details[0]->puor_discount)?$order_details[0]->puor_discount:'0.00'; echo number_format($discountamt,2); ?>	</th>
			 </tr>
			 <tr>
			 	<th style="padding:1px !important" colspan="8"></th>
			 	<th style="padding:1px !important" colspan="2"><h6 style="padding:0 !important;margin:0 !important">Sub Total:</h6></th>
			 	<th style="padding:1px 20px 1px 1px !important" style="text-align: right;"><?php $subt=$sub_total-$discountamt; echo number_format($subt,2); ?></th>
			 </tr>
			 <tr>
			 	<th style="padding:1px !important" colspan="8"></th>
			 	<th style="padding:1px !important" colspan="2"><h6 style="padding:0 !important;margin:0 !important">VAT:</h6></th>
			 	<th style="padding:1px 20px 1px 1px !important" style="text-align: right;"><?php echo !empty($order_details[0]->puor_vatamount)?$order_details[0]->puor_vatamount:'0.00'; ?></th>
			 </tr>
			 <tr>
			 	<?php
			 	$insurance=!empty($order_details[0]->puor_insurance)?$order_details[0]->puor_insurance:'0.00';
				$carriagefreight=!empty($order_details[0]->puor_carriagefreight)?$order_details[0]->puor_carriagefreight:'0.00';
				$packing=!empty($order_details[0]->puor_packing)?$order_details[0]->puor_packing:'0.00';
				$transportcourier=!empty($order_details[0]->puor_transportcourier)?$order_details[0]->puor_transportcourier:'';
				$other=!empty($order_details[0]->puor_other)?$order_details[0]->puor_other:'0.00';
				$extratotal=$insurance+$carriagefreight+$packing+$transportcourier+$other;
				?>
			 	<th style="padding:1px !important" colspan="8"></th>
			 	<th style="padding:1px !important" colspan="2"><h6 style="padding:0 !important;margin:0 !important">Extra:</h6></th>
			 	<th style="padding:1px 20px 1px 1px  !important" style="text-align: right;"><?php echo number_format($extratotal,2); ?></th>
			 </tr>
			 <tr>
			 	<th style="padding:1px !important" colspan="8"></th>
			 	<th style="padding:1px  !important" colspan="2"><h6 style="padding:0 !important;margin:0 !important">Grand Total:</h6></th>
			 	<th style="padding:1px 20px 1px 1px !important" style="text-align: right;"><?php $gtotal=$order_details[0]->puor_amount; echo  number_format($order_details[0]->puor_amount,2) ?></th>
			 </tr>
			
				<?php if($gtotal>0): ?>
					<tr>
				<th colspan="11" style="text-align: left !important;padding-top:7px !important; border-top:1px solid !important; ">
					In Words: <?php echo $this->general->number_to_word($gtotal); ?> Only
				</th>
			</tr>
			<?php endif; ?>
			<tr>
				<th colspan="11" style="text-align: left !important;padding-top:7px !important;">
				 Remarks: 
					<?php
					echo !empty($order_details[0]->puor_remarks)?$order_details[0]->puor_remarks:'';
						// $total = !empty($order_details[0]->puor_amount)?$order_details[0]->puor_amount:0; 
						// if($total){
      //                       echo $this->general->number_to_word($total);
      //                   }
                    ?> 
                </th>
			</tr>
		</tfoot>
	</table>
	<div class="ku_bottom" style="align-items: flex-start;">
        <h6>Prepared by</h6>
        <h6>Recommended by</h6>
        <h6>Budget Checked by</h6>
         <h6>Approved by</h6>
    </div>
</div>