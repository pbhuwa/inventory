<div class="row wb_form">
	<div class="col-sm-12">
		<div class="white-box">
			<h3 class="box-title"><?php echo $this->lang->line('receive_ordered_items'); ?></h3>

			<div class="ov_report_tabs pad-5 tabbable">
				<div class="ov_report_tabs pad-5 tabbable">
					<div class="margin-bottom-30">
						<div class="dropdown-tabs">
							<div class="mobile-tabs">
								<a href="#" class="tabs-dropdown_toogle">
									<i class="fa fa-bar"></i>
									<i class="fa fa-bar"></i>
									<i class="fa fa-bar"></i>
								</a>
							</div>
							<?php $this->load->view('common/v_common_tab_header'); ?>
						</div>
					</div>
				</div>
				<div class="ov_report_tabs page-tabs margin-top-30 pad-5 tabbable">
					<?php if ($tab_type == 'entry') : ?>
						<div id="dtl_rpt" class="tab-pane fade in  <?php if ($tab_type == 'entry') echo "active"; ?>">
							<div id="FormDiv_stockreqform" class="formdiv frm_bdy">
								<?php
								if (ORGANIZATION_NAME == 'KU' ||  ORGANIZATION_NAME == 'ARMY' ||  ORGANIZATION_NAME == 'PU') {
									$this->load->view('receive_against_order/'.REPORT_SUFFIX.'/v_receive_against_order_form');
								} else {
									$this->load->view('receive_against_order/v_receive_against_order_form');
								}

								?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($tab_type == 'no_supplier') : ?>
						<div id="dtl_rpt" class="tab-pane fade in  <?php if ($tab_type == 'entry') echo "active"; ?>">
							<div id="FormDiv_stockreqform" class="formdiv frm_bdy">
								<?php
								
								$this->load->view('receive_against_order/pu/v_receive_against_order_form_no_supplier');
							

								?>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($tab_type == 'list') : ?>
						<div id="dtl_supplier" class="tab-pane fade in <?php if ($tab_type == 'list') echo "active"; ?>">
							<div id="FormDiv_stockreqlist" class="formdiv frm_bdy">
								<?php
								if (ORGANIZATION_NAME == 'KU' ||  ORGANIZATION_NAME == 'ARMY' ||  ORGANIZATION_NAME == 'PU') {
									$this->load->view('receive_against_order/'.REPORT_SUFFIX.'/v_against_order_list');
								} else {
									$this->load->view('receive_against_order/v_against_order_list');
								}

								?>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($tab_type == 'detailslist') : ?>
						<div id="dtl_supplier" class="tab-pane fade in <?php if ($tab_type == 'detailslist') echo "active"; ?>">
							<div id="FormDiv_stockreqlist" class="formdiv frm_bdy">
								<?php
								if (ORGANIZATION_NAME == 'KU' ||  ORGANIZATION_NAME == 'ARMY' ||  ORGANIZATION_NAME == 'PU') {
									$this->load->view('receive_against_order/'.REPORT_SUFFIX.'/v_against_order_details_list');
								} else {
									$this->load->view('receive_against_order/v_against_order_details_list');
								}

								?>

							</div>
						</div>
					<?php endif; ?>
					<?php if ($tab_type == 'cancel') : ?>
						<div id="dtl_supplier" class="tab-pane fade in <?php if ($tab_type == 'cancel') echo "active"; ?>">
							<div id="FormDiv_stockreqlist" class="formdiv frm_bdy">
								<?php $this->load->view('receive_against_order/v_against_order_details_cancel'); ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($tab_type == 'edit') : ?>
						<div id="dtl_supplier" class="tab-pane fade in <?php if ($tab_type == 'edit') echo "active"; ?>">
							<div id="FormDiv_stockreqlist" class="formdiv frm_bdy">

								<?php
								if (ORGANIZATION_NAME == 'KU' ||  ORGANIZATION_NAME == 'ARMY' ||  ORGANIZATION_NAME == 'PU') {
									$this->load->view('receive_against_order/'.REPORT_SUFFIX.'/v_against_order_details_edit');
								} else {
									$this->load->view('receive_against_order/v_against_order_details_edit');
								}
								?>

								<?php //$this->load->view('receive_against_order/v_against_order_details_edit');
								?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>