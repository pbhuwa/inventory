<div class="searchWrapper">
    <div class="">
        <form>
            
        </form>
    </div>
    <div class="pull-left">
        <!-- <a href="javascript:void(0)" class="btn btn-primary view" data-viewurl="<?php echo base_url('issue_consumption/convert_items/load_convert_items_modal');?>" data-heading="New Convert Item">New</a> -->

        <a href="<?php echo base_url('issue_consumption/convert_items/new_convert_items');?>" class="btn btn-primary" data-heading="New Convert Item"><?php echo $this->lang->line('new'); ?></a>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/convert_items/convert_items_list" data-location="convert_items/convert_items/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/convert_items/convert_items_list" data-location="convert_items/convert_items/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <h3 class="box-title"><?php echo $this->lang->line('convert_items_list'); ?></h3>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width=5%><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('date'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('user'); ?></th>
                </tr>
            </thead>
            <tbody>
                      
            </tbody>
        </table>
    </div>

    <div class="displayChildItemList">
    </div>

</div>

<div class="clearfix"></div>

<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // var frmDate = '';
        // var toDate = ''; 

        var tableid = $('.serverDatatable').data('tableid');

        var firstTR = $(tableid+' tbody tr:first');
        firstTR.addClass('selected');

        var selectedTR = $('.serverDatatable').find('.selected');

        setTimeout(function(){
            var prime_id = $('.serverDatatable').find('.selected').data('id');
            get_child_convert_items(prime_id);
        },1000);

        var dataurl = base_url+"issue_consumption/convert_items/get_parent_convert_items_list";
        var message = '';

        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } 
        else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }

        $(tableid).on("draw.dt", function(){
            var rowsNext = $(tableid).dataTable().$("tr:first");
            rowsNext.addClass("selected");
        });
     
        var dtablelist = $(tableid).dataTable({
            "sPaginationType": "full_numbers"  ,
            "bSearchable": false,
            "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
            'iDisplayLength': 20,
            "sDom": 'ltipr',
            "bAutoWidth":false,
            "autoWidth": true,
            "aaSorting": [[0,'desc']],
            "bProcessing":true,
            "bServerSide":true,    
            "sAjaxSource":dataurl,
            "oLanguage": {
                "sEmptyTable":message  
            }, 
            "aoColumnDefs": [
                {
                    "bSortable": false,
                    "aTargets": [ 0,7 ]
                }
            ],      
            "aoColumns": [
                { "data": "sno"},
                { "data": "conv_condatebs"},
                { "data": "itli_itemcode" },
                { "data": "itli_itemname" },
                { "data": "conv_parentqty" },
                { "data": "conv_parentrate" },
                { "data": "amount" },
                { "data": "conv_username" }
            ],
            "fnServerParams": function (aoData) {
                // aoData.push({ "name": "frmDate", "value": frmDate });
                // aoData.push({ "name": "toDate", "value": toDate });
            },
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var prime_id=aData.prime_id;
                // var viewurl =aData.viewurl;
                // var heading=aData.itemname;

                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1;

                var tbl_id = iDisplayIndex + 1;

                $(nRow).attr('id', 'listid_' + tblid);

                $(nRow).attr('data-rowid',tbl_id);
                $(nRow).attr('data-id',prime_id);
                // $(nRow).attr('data-viewurl',viewurl);
                // $(nRow).attr('data-heading',heading);
                // $(nRow).addClass('view');
            },
        }).columnFilter(
        {
            sPlaceHolder: "head:after",
            aoColumns: [ {type: null},
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: null },
        ]
        });

        // $(document).off('click','#searchBtn')
        // $(document).on('click','#searchBtn',function(){
        //     frmDate=$('#frmDate').val();
        //     toDate=$('#toDate').val();   
        //     dtablelist.fnDraw();  
        // });

        function get_child_convert_items(prime_id){

            var submiturl = base_url+'issue_consumption/convert_items/get_child_convert_items_list_by_id';
            var displaydiv = '.displayChildItemList'; 
            
            $.ajax({
                type: "POST",
                url: submiturl,
                data: {prime_id : prime_id},
                beforeSend: function (){
                    $('.overlay').modal('show');
                },
                success: function(jsons){
                    var data = jQuery.parseJSON(jsons);
                    // console.log(data);
                    if(data.status == 'success'){
                        $(displaydiv).empty().html(data.tempform);
                    }
                    $('.overlay').modal('hide');
                }
            });
        }

    });
</script>