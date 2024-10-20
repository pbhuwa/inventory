<style type="text/css">
	.bgclass
	{
		background: #d0caca;
	}
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
	<div class="jo_form organizationInfo" id="printrpt">
		
		<?php $this->load->view('common/v_report_header');?>
		<table class="alt_table">
			<thead>
				<th width="5%">S.n</th>
				<th width="15%">Item Name</th>
				<th width="5%">Qty.</th>
				<?php echo $th_sup; ?>
			</thead>
			<tbody>
				<?php
				if(!empty($itemwise_quotation_rate)):
					$i=0;
					foreach ($itemwise_quotation_rate as $kiq => $qrate ):
						$minrate=$qrate->minrate;
					?>
					<tr>
						<td><?php echo $kiq+1;  ?></td>
						<td><?php echo $qrate->itli_itemname;  ?></td>
						<td>1</td>
						<?php
						if(!empty($distinct_supplier))
					     {
					     	$j=0;
					     	$comprat='';
					     	$tmp='';
					     	foreach ($distinct_supplier as $kds => $sup) {
					     		$sup_rate=('sup'.$j);
					     		// $comprat .= $qrate->{$sup_rate}.',';
					     		$main_sup_rate=$qrate->{$sup_rate};

					     		
					     		$bgclass='';
					     		if($main_sup_rate== $minrate)
					     		{
					     			$bgclass='bgclass';
					     		}
					     		?>
					     		<td class="<?php echo $bgclass; ?>"><?php echo $qrate->{$sup_rate} ?></td>
					     		<?php
					     		$j++;

					     	}
					     	// echo $comprat.'<br>';
					     	// $ratecur=compare_rate($comprat);
					     	



					      }
						?>
						

					</tr>
					<?php
				endforeach;
				$i++;
				endif; 
				?>
			</tbody>
			
				<tr>
					<th colspan="3">Total</th>
					<?php echo $sumtemp; ?>
				</tr>
		</table>
	</div>
	</div>
</div>

<?php 
// function compare_rate($charrate)
// {
// 	$value=rtrim($charrate,',');
// 	// echo $charrate;
// 	$newvalue=explode(',',$value);

// 	// print_r($newvalue);
// 	// echo "<br>";

// 	// echo min($newvalue);
// 	return min($newvalue);
// }

?>