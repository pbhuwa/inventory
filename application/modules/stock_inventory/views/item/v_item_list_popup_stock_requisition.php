<style type="text/css">
.table>tbody>tr>td:not(:last-child),
    .table>tbody>tr>th {
        vertical-align: middle !important;
        white-space: normal !important;
    }
</style>
<?php $type=!empty($type)?$type:''; ?>
<div class="table-responsive">
  <div class="row">
    <div class="form-group">
      <div class="col-sm-7">
         <input style="width:200px" type="text" name="srchtxt" class="form-control text_filter" id="srchtxt" placeholder="<?php echo $this->lang->line('enter') ?> <?php echo $this->lang->line('item_code') ?>/<?php echo $this->lang->line('item_name') ?>"  >
        <!--  <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btnOtheritem" data-heading='Add Items'>Add Other Item</a> -->
        <!-- <p> Item that you want to demande is not in item list select unknown item and  write item name in remasks</p> -->
        <?php if(ORGANIZATION_NAME=='KUKL'): ?>
          <?php   if($this->unknown=='Y'):?>  <p> </p><?php else: ?>
        <p style="margin-top:15px"> यदी तपाइले माग गर्न चाहेको समान लिस्टमा छैन  अथवा नाम थाहा छैन भने Unknown Item छान्नुहोस् र Remarks मा के माग गर्न खोज्नुभयकोहो लेखानुहोस। </p>
      <?php endif;endif;  ?>
      </div>
    </div>
  </div>
  <?php
  if(ORGANIZATION_NAME=='KUKL'):
    if(in_array($this->usergroup, $this->stock_view_group)):
  ?>
<div class="white-box pad-5 width200">
                <ul class="index_chart">
                    <li>
                        <div class="success"></div> <a href="javascript:void(0)" data-approvedtype="available" class="approvetype">Available</a>
                        <!-- <span id="available">283</span> -->
                    </li>
                    <li>
                        <div class="danger"></div><a href="javascript:void(0)" data-approvedtype="zero" class="approvetype"> Out of Stock</a> 
                        <!-- <span id="zero">829</span> -->
                    </li>
                    
                    <li>
                        <div class="warning"></div> <a href="javascript:void(0)" data-approvedtype="limited" class="approvetype">Limited </a>
                        <!-- <span id="limited">213</span> -->
                    </li>
                    <div class="clearfix"></div>
                    
                </ul>
            </div>
     <?php
        endif;
        else:
        ?>
        <div class="white-box pad-5 width200">
                <ul class="index_chart">
                    <li>
                        <div class="success"></div> <a href="javascript:void(0)" data-approvedtype="available" class="approvetype">Available</a>
                        <!-- <span id="available">283</span> -->
                    </li>
                    <li>
                        <div class="danger" style="    background-color: #dc143c;"></div><a href="javascript:void(0)" data-approvedtype="zero" class="approvetype"> Out of Stock</a> 
                        <!-- <span id="zero">829</span> -->
                    </li>
                    
                    <li>
                        <div class="warning" style="    background-color: #ffb700;"></div> <a href="javascript:void(0)" data-approvedtype="limited" class="approvetype">Limited </a>
                        <!-- <span id="limited">213</span> -->
                    </li>
                    <div class="clearfix"></div>
                    
                </ul>
            </div>
        <?php
        endif;
      ?>
            <div class="clear"></div>
 <div class="table-responsive">
                    <table id="myTable_item" class="table table-striped keypresstable">
                        <thead>
                            <tr>
                                <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                                <th width="25%"><?php echo $this->lang->line('item_name'); ?></th>
                                  <th width="25%"><?php echo $this->lang->line('item_name_np'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('stock'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('purchase_rate'); ?></th>
                               <th width="5%">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                                  
                        </tbody>
                    </table>
                </div>
  


<script type="text/javascript">
     $(document).ready(function(e){
    var rowno='<?php echo $rowno; ?>'
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
     var srchtxt=$('#srchtxt').val();
    var dataurl = base_url+"stock_inventory/item/get_item_list_stock_requisition/<?php echo $rowno.'/'.$storeid.'/'.$type;?>";
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

    // need to check modules permission in general
    message="<p class='text-danger'>No Record Found!! </p>";
 
 // var dtable = $('#myTable_item').dataTable();

 
    var dtablelist = $('#myTable_item').dataTable({
      "sPaginationType": "full_numbers"  ,
      "bSearchable": false,
      "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
      'iDisplayLength': 20,
      "sDom": 'ltipr',
      "bAutoWidth":false,
      "autoWidth": true,
      "aaSorting": [[0,'asc']],
      "bProcessing":true,
      "bServerSide":true,    
      "sAjaxSource":dataurl,
      "oLanguage": {
       "sEmptyTable":message   
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [0,4,5,6]
      }
      ],      
      "aoColumns": [
      {"data": null},
      {"data": "itemcode"},
      {"data": "itemname"},
       {"data": "itemnamenp"},
      {"data": "unitname"},
      {"data": "issue_qty" },
      {"data": "purchaserate"},
      {"data": "category"},
      
      ],
     
      "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
         aoData.push({ "name": "searchtext", "value": srchtxt });
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);


            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
            var rowno=aData.rowno;
           // alert('A'+rowno);
            var itemid=aData.itemlistid;
            var itemcode=aData.itemcode
            var itemname=aData.itemname;
            var itemnamenp=aData.itemnamenp;
            var itemname_display=aData.itemname_display;
            var purchaserate=aData.purchaserate;
            var salesrate=aData.salesrate;
            var issue_qty=aData.issue_qty;
            var unitname=aData.unitname;
            var unitid=aData.unitid;
            var is_perm=aData.is_perm;
            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1
            var statusclass=aData.statusClass;
            $(nRow).attr('class', statusclass);
            $(nRow).attr('id', 'listid_'+tblid);
            $(nRow).attr('data-rowid',tblid);
            $(nRow).attr('data-rowno',rowno);
            $(nRow).attr('data-itemcode',itemcode);
            $(nRow).attr('data-itemname',itemname);
            $(nRow).attr('data-itemnamenp',itemnamenp);
            $(nRow).attr('data-itemname_display',itemname_display);
            $(nRow).attr('data-itemid',itemid);
            $(nRow).attr('data-purrate',purchaserate);
            $(nRow).attr('data-salesrate',salesrate);
            $(nRow).attr('data-issueqty',issue_qty);
            $(nRow).attr('data-unitname',unitname);
            $(nRow).attr('data-unitid',unitid);
            $(nRow).attr('data-is_perm',is_perm);
            $(nRow).addClass('itemDetail');
            if(tblid==1)
            {

               $(nRow).addClass('selected');
                 // var keyevent=e.keyCode;
               
                 // setTimeout(function(){
                  // $('#modal-title').click();
                  // model_keypress();
                   // }, 1000);
               // $('#modal-title').click();
            }

             // model_keypress();
      },
       
    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ { type: null },
      {type: "text"},
      { type: "text" },
      { type: "text" },
       { type: null },
      { type: null },
       { type: null },
        { type: "text" },
    
      ]
    });

     $(document).on('keyup','#srchtxt',function(){
      srchtxt=$('#srchtxt').val();
       dtablelist.fnDraw();       
    })

      // $('#myTable_item input').unbind();
      //       $('#myTable_item input').bind('keyup', function(e) {
      //           if (e.keyCode == 13) {
      //               // dtablelist.fnFilter($(this).val());
      //               dtablelist.search( $(this).val() ).draw();
      //           }
      //       });

});



</script>

<script type="text/javascript">
  // $(document).ready(function(){
    var dtablelist = $('#myTable_item').dataTable();
     setTimeout(function(){
    model_keypress();
       }, 500);
  // })

$(document).ready(function(){
  setTimeout(function(){
  $('#srchtxt').focus();
    }, 700);
});

$(document).off('click','#btnOtheritem');
$(document).on('click','#btnOtheritem',function(e){
  var action=base_url+'stock_inventory/item/addotheritem';
      var heading=$(this).data('heading');
      $('#myView2').modal('show');
      $('#MdlLabel2').html(heading);
      // return false;
      $.ajax({
         type: "POST",
         url: action,
         data:{},
         dataType: 'html',
         beforeSend: function() {
            $('.overlay').modal('show');
         },
         success: function(jsons) 
         {
            data = jQuery.parseJSON(jsons);   
         // alert(data.status);
            if(data.status=='success'){
               console.log(data.tempform);
               $('.displyblock2').html(data.tempform);
            }  
            else{
               alert(data.message);
            }
            $('.overlay').modal('hide');
         }
      });
      return false;
   })
</script>


