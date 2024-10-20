
<div class="white-box">
  <label class="dttable_ttl box-title"><center>Project Setup</center></label>

  <a href="javascript:void(0)" data-id='0'
   data-displaydiv="project setup" data-viewurl="<?php echo base_url('/ams/project_setup/project_entry') ?>" class="btn btn-sm btn-primary pull-right view" data-heading="New Project Setup"><i class="fa fa-plus"></i> Add Project</a>

</div>

  <h3 class="box-title"><center>  </center><a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>

  <div class="searchWrapper">

    <div class="">
      <form class="col-sm-12">
        <div class="col-md-2">
          <label>Fiscal Year</label>
          <select name="prin_fiscalyrs" class="form-control select2" id="prin_fiscalyrs">
            <option value="">All</option>
            <?php
            if($fiscal_year):
              foreach ($fiscal_year as $ks => $not):
                ?>
                <option value="<?php echo $not->fiye_fiscalyear_id; ?>"><?php echo $not->fiye_name; ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>

        <div class="col-md-2">
          <label>Contractor</label>
          <select name="prin_contactorid" class="form-control select2" id="prin_contactorid">
            <option value="">All</option>
            <?php
            if($distributors):
              foreach ($distributors as $ks => $sot):
                ?>
                <option value="<?php echo $sot->dist_distributorid; ?>"><?php echo $sot->dist_distributor; ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>

          <div class="col-md-2">
                <label>Date Search:</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_all">All</option>
                    <option value="date_range">By Date Range</option>
                    
                </select>
            </div>
         <div class="dateRangeWrapper" style="display:none">
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
      <label>Search Text</label>
       <input type="text" name="srchtext" class="form-control" id="srchtext">
    </div>
    


   <div class="col-md-2">
    <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
  </div>
  
  <div class="sm-clear"></div>
</form>
</div>

<div class="clearfix"></div>

</div>
<div class="pad-5">
  <div class="table-responsive">
    <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th width="2%">S.N</th>
          <th width="10%">Fiscal Year</th>
          <th width="10%">Code</th>
          <th width="10%">Project Title</th>
          <th width="10%">Description.</th>
          <th width="10%">Start Date</th>
          <th width="10%">Est.Comp.Date</th>
          <th width="10%">Contractor No.</th>
          <!-- <th width="10%">D.Ins.</th> -->
          <!-- <th width="10%"><?php //echo $this->lang->line('purchase_date'); ?></th>
          <th width="10%"><?php //echo $this->lang->line('warrenty_date'); ?></th> -->
         
          <th width="10%"><?php echo $this->lang->line('action'); ?></th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
 $(document).ready(function(){
  
  var frmDate=$('#frmDate').val();
  var toDate=$('#toDate').val(); 
  var dateSearch = $('#dateSearch').val();
  var prin_fiscalyrs=$('#prin_fiscalyrs').val();
  var prin_contactorid=$('#prin_contactorid').val();
  var srchtext=$('#srchtext').val();
           // alert(srchtext);
           

           
           var dataurl = base_url+"ams/project_setup/get_project_setup_list";
           var message='';
           
           
           
           var dtablelist = $('#myTable').dataTable({
            "sPaginationType": "full_numbers"  ,
            
            "bSearchable": false,
            "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
            'iDisplayLength': 10,
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
            "aTargets": [ 0,8 ]
          }
          ],      
          "aoColumns": [
          { "data": "sn"},
          { "data": "prin_fiscalyrs"},
          { "data": "prin_code"},
          { "data": "prin_project_title"},
          { "data": "prin_project_desc"},
          { "data": "prin_startdatebs" },
          { "data": "prin_estenddatebs" },
          { "data": "prin_contractno" },
          { "data": "action" }
          
          
          ],
          "fnServerParams": function (aoData) {
            aoData.push({ "name": "frmDate", "value": frmDate });
            aoData.push({ "name": "toDate", "value": toDate });
            aoData.push({ "name": "dateSearch", "value": dateSearch });
            aoData.push({ "name": "prin_fiscalyrs", "value": prin_fiscalyrs });
            aoData.push({ "name": "prin_contactorid", "value": prin_contactorid });
            aoData.push({ "name": "srchtext", "value": srchtext });

          },


      // "fnRowCallback" : function(nRow, aData, iDisplayIndex){
      //        var oSettings = dtablelist.fnSettings();
      //       $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
      //       return nRow;
      //   },
      "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
       var oSettings = dtablelist.fnSettings();
       var tblid = oSettings._iDisplayStart+iDisplayIndex +1

       $(nRow).attr('id', 'listid_'+tblid);
     },
   }).columnFilter(
   {
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
    
    ]
  });

   $(document).on('click', '#searchByDate', function() {
    frmDate = $('#frmDate').val();
    toDate = $('#toDate').val();
    dateSearch = $('#dateSearch').val(); 
    prin_fiscalyrs = $('#prin_fiscalyrs').val();
    prin_contactorid = $('#prin_contactorid').val();
    srchtext = $('#srchtext').val();
    
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
