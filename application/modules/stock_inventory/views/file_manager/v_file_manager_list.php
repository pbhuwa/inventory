<!-- v distributers lists -->

    <h3 class="box-title">List of File Management <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
    <div class="pad-5">
      <form class="col-sm-12">
        <div class="col-md-2">
           <label for="example-text">File Type:</label>
           
              
                <select name="fire_file_type" id="fire_file_type" class="form-control select2 " >
                          <option value="">All</option>
                          <?php
                          if($file_type):
                            foreach ($file_type as $kfy => $ftype):
                              ?> 
                          <option value="<?php echo $ftype->fity_filetypeid; ?>"> <?php echo $ftype->fity_typename; ?></option>
                              <?php 
                            endforeach;
                          endif;
                           ?>
                </select>
              </div>
            <div class="col-md-2">
              <label>File No.</label>
               <input type="text" name="fire_file_no" class="form-control" id="fire_file_no">
            </div>
            <div class="col-md-2">

                <label>Date Search:</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>

            <div class="dateRangeWrapper">
                <div class="col-md-2">
                    <label><?php echo $this->lang->line('from_date'); ?> :</label>
                    <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>
                
                <div class="col-md-2">
                    <label><?php echo $this->lang->line('to_date'); ?>:</label>
                    <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
            </div>
            

            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
        </form>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped ">
                <thead>
                    <tr>
                        <th width="5%">S.N</th>
                        <th width="20%">File Type</th>
                        <th width="20%">File No.</th>
                        <th width="15%">Date</th>
                        <th width="15%">Remarks</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
<script type="text/javascript">


 $(document).ready(function()

  {

    var frmDate=$('#frmDate').val();

    var toDate=$('#toDate').val();
    // var fire_filetypeid=$('#fire_filetypeid').val();
    var fire_file_no=$('#fire_file_no').val(); 
    var fire_file_type=$('#fire_file_type').val(); 
    

    var dataurl = base_url+"stock_inventory/file_manager/get_file_list";

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

 

 

 

    var dtablelist = $('#myTable').dataTable({

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

        "aTargets": [ 5 ]

      }

      ],      

      "aoColumns": [

       { "data": null},
      
       { "data": "fity_typename"},
       { "data": "fire_file_no"},
       { "data": "fire_datebs"},
       { "data": "fire_remarks"},
       { "data": "action" }

      ],

      "fnServerParams": function (aoData) {

        aoData.push({ "name": "frmDate", "value": frmDate });

        aoData.push({ "name": "toDate", "value": toDate });
        // aoData.push({ "name": "fire_filetypeid", "value": fire_filetypeid });
        aoData.push({ "name": "fire_file_type", "value": fire_file_type });
        aoData.push({ "name": "fire_file_no", "value": fire_file_no });


      },

      "fnRowCallback" : function(nRow, aData, iDisplayIndex){

             var oSettings = dtablelist.fnSettings();

            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);

            return nRow;

        },

        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {

             var oSettings = dtablelist.fnSettings();

            var tblid = oSettings._iDisplayStart+iDisplayIndex +1



        $(nRow).attr('id', 'listid_'+tblid);

      },

    }).columnFilter(

    {

      sPlaceHolder: "head:after",

      aoColumns: [ { type: null },

      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      { type: null },

     

      ]

    });

   $(document).on('click', '#searchByDate', function() {
    frmDate = $('#frmDate').val();
    toDate = $('#toDate').val();
    dateSearch = $('#dateSearch').val(); 
    // fire_filetypeid = $('#fire_filetypeid').val();
    fire_file_type = $('#fire_file_type').val();
    fire_file_no = $('#fire_file_no').val();
    // alert(fire_file_type);
    dtablelist.fnDraw();
  });


  });

</script>
<script type="text/javascript">
    $(document).off('change','#searchDateType');
    $(document).on('change','#searchDateType',function(){
        var search_date_val = $(this).val();

        if(search_date_val == 'date_all'){
            $('.dateRangeWrapper').hide();
        }else{
            $('.dateRangeWrapper').show();
        }
    });
</script>
