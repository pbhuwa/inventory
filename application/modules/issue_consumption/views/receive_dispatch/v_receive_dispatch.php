<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('receive_dispatch_analysis_report'); ?> </h3>
            <div  id="FormDiv_DirectReceive" class="formdiv frm_bdy">
            	<div class="searchWrapper">
				    <div class="">
				        <form>
				        	 <?php echo $this->general->location_option(2,'locationid'); ?>
          

				            <div class="col-md-2">
				                <label><?php echo $this->lang->line('materials_type_category'); ?></label>
				                <select class="form-control" name="materialsid"  id="materialsid">
				                    <option value="">----All----</option>
				                 <?php
				                 if($material_type): 
				                 foreach ($material_type as $ket => $mty):
				                 ?>
				                <option value="<?php echo $mty->maty_materialtypeid; ?>" ><?php echo $mty->maty_material; ?></option>
				                 <?php endforeach; endif; ?>
				                </select>
				            </div>
				            <div class="col-md-3">
				            <label><?php echo $this->lang->line('category'); ?></label>
				                <select class="form-control select2" name="category"  id="category">
				                    <option value="">----All----</option>
				                 <?php
				                 if($subcategory): 
				                 foreach ($subcategory as $ket => $eqt):
				                 ?>
				                <option value="<?php echo $eqt->eqca_equipmentcategoryid; ?>" ><?php echo $eqt->eqca_category; ?></option>
				                 <?php endforeach; endif; ?>
				                </select>
				            </div>
				            <div class="col-md-3">
				                <label><?php echo $this->lang->line('item_name'); ?></label>
				                <select class="form-control select2" name="itemsid"  id="itemsid">
				                    <option value="">----All----</option>
				                 <?php
				                 if($items): 
				                 foreach ($items as $ket => $etype):
				                 ?>
				                <option value="<?php echo $etype->itli_itemlistid; ?>" ><?php echo $etype->itli_itemname; ?></option>
				                 <?php endforeach; endif; ?>
				                </select>
				            </div>
				            <div class="col-md-3">
				                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
				            </div>
				        </form>
				    </div>
				    <div class="pull-right" style="margin-top:15px;">
				        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/receive_dispatch_analysis/receive_dispatch_analysis_report" data-location="issue_consumption/receive_dispatch_analysis/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

				        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="sissue_consumption/receive_dispatch_analysis/receive_dispatch_analysis_report" data-location="issue_consumption/receive_dispatch_analysis/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
				    </div>
				    <div class="clear"></div>
				</div>
				<?php $this->load->view('receive_dispatch/v_receive_dispatch_lists'); ?>
            </div>
        </div>
    </div>
</div>