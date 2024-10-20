<div class="searchWrapper">
    <div class="">
        <form>
            <div class="col-md-2">
                <label><th width="10%"><?php echo $this->lang->line('date'); ?>:</label>
                <input type="text" id="frmDate" class="form-control" maxlength="7" placeholder="YYYY/MM"/> 
            </div>

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><th width="10%"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-6">
        <div  class="alert-success success"></div>
        <div class="alert-danger error"></div>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file_download" id="excel" data-type="excel" data-dataurl="stock_inventory/stock_requirement/stock_requirement_list" data-location="stock_inventory/stock_requirement/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <!-- <a class="btn btn-info btn_pdf generate_export_file_download" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/stock_requirement/stock_requirement_list" data-location="stock_inventory/stock_requirement/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a> -->
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="FormList_StockRequirement"> 
    <div class="pad-5 mtop_10">
        <!-- <h3 class="box-title">Stock Check List</h3> -->
        <div class="table-responsive">
            <table id="Dtables" class="table table-striped dataTable serverDatatable" data-tableid="#myTable">
                <thead>
                    <tr>
                <th width="5%"><th width="10%"><?php echo $this->lang->line('category'); ?></th>
                <th width="10%"><th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="10%"><th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                <th width="10%"><th width="10%"><?php echo $this->lang->line('opening'); ?></th>
                <th width="10%"><?php echo $this->lang->line('received'); ?></th>
                <th width="10%"><?php echo $this->lang->line('issue'); ?></th>
                <th width="10%"><?php echo $this->lang->line('balance'); ?></th>
                <th width="10%"><?php echo $this->lang->line('current_month'); ?></th>
                <th width="10%"><?php echo $this->lang->line('previous_month1'); ?></th>
                <th width="10%"><?php echo $this->lang->line('previous_month2'); ?></th>
                <th width="10%"><?php echo $this->lang->line('previous_month1_quantity'); ?></th>
                <th width="10%"><?php echo $this->lang->line('previous_month2_quantity'); ?></th>
                <th width="10%"><?php echo $this->lang->line('req_no'); ?></th>
                <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>

<script>
    $(document).off('change','#frmDate');
    $(document).on('change','#frmDate',function(){
        var frmDate = $('#frmDate').val();
        isValidDate(frmDate);
    });
    function isValidDate(dateString) {
        var regEx = /^(\d{4})(\/)(\d{1,2})$/;
        var checkDate = dateString.match(regEx);
        var dateError = 'Please enter correct date format.';

        // console.log(checkDate);
        if(checkDate == null){
            $('.error').html(dateError);
            return false;  
        }else{
            var date = checkDate[3];
            if(date > 12){
                $('.error').html(dateError);
                return false;    
            }else{
                $('.error').html('');
                return true;
            }
        }
    }
</script>

<script>
    $(document).off('click','#searchByDate');
    $(document).on('click','#searchByDate',function(){
        var frmDate = $('#frmDate').val();
        var action = base_url+'stock_inventory/stock_requirement/stock_requirement_list';
        $.ajax({
            type: "POST",
            url: action,
            data:{frmDate:frmDate},
            beforeSend: function() {
                $('.overlay').modal('show');
            },
            success: function(jsons){
                data = jQuery.parseJSON(jsons);   
                if(data.status == 'success'){
                    $('.FormList_StockRequirement').html(data.list);    
                }
                $('.overlay').modal('hide');
            }
        });
    });
</script>

<script>
    $(document).off('click','.generate_export_file_download');
    $(document).on('click','.generate_export_file_download',function(){
        var dataurlLink = $(this).data('dataurl');
        var moduleLocation = $(this).data('location');
        var frmDate = $('#frmDate').val();
        var checkvalidate = isValidDate(frmDate);

        if(checkvalidate){
            var type = $(this).data('type');
            var dataurl = base_url + dataurlLink;
        
            if(type == 'excel'){
                window.location = base_url + moduleLocation + '?'+'frmDate='+frmDate;
            }else if(type == 'pdf'){
                window.open(base_url + moduleLocation + '?'+'frmDate='+frmDate,'_blank');
            }
        }else{
            return false;
        }  
    });
</script>