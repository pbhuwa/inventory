<div class="searchWrapper">
    <div class="">
        <form>
             <?php echo $this->general->location_option(2,'locationid'); ?>
          
           
            <div class="col-md-2">
                <label><?php echo $this->lang->line('supplier_name'); ?></label>
                <select class="form-control select2" id="supplierid">
                    <option value="">All</option>
                    <?php
                        if($supplier_all):
                            foreach ($supplier_all as $ks => $supp):
                        ?>
                    <option value="<?php echo $supp->dist_distributorid; ?>"><?php echo $supp->dist_distributor; ?></option>
                    <?php
                        endforeach;
                        endif;
                        ?>
                </select>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('material_type'); ?></label>
                <select class="form-control select2" id="materialid">
                    <option value="">All</option>
                    <?php
                        if($mat_type_list):
                            foreach ($mat_type_list as $km => $mli):
                        ?>
                    <option value="<?php echo $mli->maty_materialtypeid; ?>"><?php echo $mli->maty_material; ?></option>
                    <?php
                        endforeach;
                        endif;
                        ?>
                </select>
            </div>

            <div class="col-md-2">
                <label><?php echo $this->lang->line('category'); ?></label>
                <select class="form-control select2" id="categoryid">
                    <option value="">All</option>
                    <?php
                        if($eqcat_all):
                            foreach ($eqcat_all as $kcs => $cat):
                        ?>
                    <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>"><?php echo $cat->eqca_code.' | '.$cat->eqca_category; ?></option>
                    <?php
                        endforeach;
                        endif;
                        ?>
                </select>
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
         <div class="dateRangeWrapper">
            <div class="col-md-1">
                <label><?php echo $this->lang->line('from'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>

            <div class="col-md-1">
                <label><?php echo $this->lang->line('to'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('headed_by'); ?></label><br>
                <select class=" form-control select2" id="reportby">
                    <option value="cat">Category</option>
                    <option value="sup">Supplier</option>
                </select>
            </div>
                <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>

            <div class="col-md-2">
                <a class="btn btn-info" id="searchBtn" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/purchase_analysis_ii/purchase_analysis_ii_detail_list" data-location="purchase_receive/purchase_analysis_ii/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/purchase_analysis_ii/purchase_analysis_ii_detail_list" data-location="purchase_receive/purchase_analysis_ii/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('mrno'); ?></th>
                    <th width="11%"><?php echo $this->lang->line('supplier_bill_no'); ?></th>
                    <th width="11%"><?php echo $this->lang->line('supplier_bill_date'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('net_rate'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('amount'); ?></th>
                </tr>
            </thead>
            <tbody>
                      
            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var frmDate = $('#frmDate').val();
        var toDate = $('#toDate').val();
        var supplierid= $('#supplierid').val();
        var materialid= $('#materialid').val();
        var categoryid= $('#categoryid').val();
        var reportby=$('#reportby').val();
        var locationid = $('#locationid').val();
         var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }


        var message='';
        var showview='<?php echo MODULES_VIEW; ?>';
        if(showview=='N')
        {
          message="<p class='text-danger'>Permission Denial</p>";
        }
        else
        {
          message="<p class='text-danger'>No Record Found!! </p>";
        }
        var dataurl = base_url + "purchase_receive/purchase_analysis_ii/purchase_analysis_ii_detail_list";
        
        
       var dtablelist = $('#myTable').dataTable({
            "sPaginationType": "full_numbers",

            "bSearchable": false,
            "lengthMenu": [
                [15, 30, 45, 60, 100, 200, 500, -1],[15, 30, 45, 60, 100, 200, 500, "All"]
            ],
            'iDisplayLength': 20,
            "sDom": 'ltipr',
            "bAutoWidth": false,

            "autoWidth": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": dataurl,
            "oLanguage": {
                "sEmptyTable": message
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 12]
            }],
            "aoColumns": [
                { "data": "category" },
                { "data": "category" },
                { "data": "distributor" },
                { "data": "itemcode" },
                { "data": "itemname" },
                { "data": "invoiceno" }, 
                { "data": "supplierbill" },  
                { "data": "receiveddatebs" },  
                { "data": "purchasedqty" },
                { "data": "unitprice" },
                { "data": "discount" },
                { "data": "vat" },
                { "data": "net_rate" },
                { "data": "net_amount" },    
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
                    aoData.push({"name": "supplierid","value": supplierid});
                    aoData.push({"name": "materialid","value": materialid});
                    aoData.push({"name": "categoryid","value": categoryid});
                    aoData.push({"name": "reportby","value": reportby});
                    aoData.push({"name": "locationid","value": locationid});
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

                $(nRow).attr('id', 'listid_' + tblid);
            },
        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: null },
                { type: null },
                { type: null },
                { type: null },
                { type: null },

            ]
        });

        $(document).on('click', '#searchBtn', function() {
        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        supplierid= $('#supplierid').val();
        materialid= $('#materialid').val();
        categoryid= $('#categoryid').val();
        reportby=$('#reportby').val();
        locationid = $('#locationid').val();
         searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }


            dtablelist.fnDraw();
        });

    });

    $(document).off('change', '#searchDateType');
       $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });
</script>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>
