<div class="searchWrapper">
    <form id="synchform">
        <div class="col-md-2 col-sm-3">
            <label for="example-text">Source DB:<span class="required">*</span>:</label>
            <select name="sourcedb" class="form-control togglechange" data-type="source" id="source" >
              <option value="local" selected="selected">Local</option>
              <option value="remote">Remote</option>
            </select>
        </div>
        

        <div class="col-md-2 col-sm-2">
            <label>Destination DB</label>
           <select name="destinationdb" class="form-control togglechange" data-type="destination" id="destination">
              <option value="local">Local</option>
              <option value="remote" selected="selected">Remote</option>
            </select>
        </div>

        <div class="col-md-2">
            <a class="btn btn-info searchReport" style="margin-top: 18px;" data-url="api/api_tablemanage/get_compare_data"><?php echo $this->lang->line('search'); ?></a>
        </div>
    </form>
    <div class="clear"></div>
</div>

<div id="displayReportDiv"></div>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>
<script type="text/javascript">
  $(document).off('change','.togglechange');
  $(document).on('change','.togglechange',function(e){
    var dtype=$(this).data('type');
    var selval=$(this).val();
    if(dtype=='source' && selval=='remote'){
      $('#destination').val('local');
    }
    else if(dtype=='source' && selval=='local'){
      $('#destination').val('remote');
    }
     if(dtype=='destination' && selval=='remote'){
      $('#source').val('local');
    }
    else if(dtype=='destination' && selval=='local'){
      $('#source').val('remote');
    }

  });
</script>