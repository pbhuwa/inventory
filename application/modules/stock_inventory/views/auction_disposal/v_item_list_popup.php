<style type="text/css">
.table>tbody>tr>td:not(:last-child),
    .table>tbody>tr>th {
        vertical-align: middle !important;
        white-space: normal !important;
    }
</style>
<?php $type = !empty($type) ? $type : '';?>
    <div class="row">
    <div class="form-group">
        <div class="col-sm-12">
         <input style="width:200px" type="text" name="srchtxt" class="form-control text_filter" id="srchtxt" placeholder="<?php echo $this->lang->line('enter') ?> <?php echo $this->lang->line('item_code') ?>/<?php echo $this->lang->line('item_name') ?>"  >
        </div>
    </div>
    </div>
    <div class="table-responsive">
        <table id="TableItems" class="table table-striped keypresstable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="25%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="5%">Pur. Qty</th>
                    <th width="5%">Dep.Issued Qty</th>
                    <th width="5%">Rem.Qty</th>
                    <th width="5%">P.Rate</th>
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
    var distype=$('#disposaltypeid').val();
    var srchtxt=$('#srchtxt').val();
    var dataurl = base_url+"stock_inventory/auction_disposal/get_item_list_for_auction_disposal/<?php echo $rowno; ?>";
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

 // var dtable = $('#TableItems').dataTable();

    var dtablelist = $('#TableItems').dataTable({
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
        "aTargets": [0,3,4,5,6,7]
      }
      ],
      "aoColumns": [
      {"data": null},
      {"data": "itemcode"},
      {"data": "itemname"},
      {"data": "unitname"},
      {"data": "purqty" },
      {"data": "dep_issqty"},
      {"data": "remqty"},
      {"data": "purchaserate"},
      {"data": "category"},

      ],

      "fnServerParams": function (aoData) {
         aoData.push({ "name": "searchtext", "value": srchtxt });
         aoData.push({ "name": "distype", "value": distype });
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
            var purchaserate=aData.purchaserate;
            var purqty=aData.purqty;
            var dep_issqty=aData.dep_issqty;
            var remqty=aData.remqty;
            var unitname=aData.unitname;
            var mattypeid=aData.mattypeid;

            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1
            var statusclass=aData.statusClass;
            $(nRow).attr('class', statusclass);
            $(nRow).attr('id', 'listid_'+tblid);
            $(nRow).attr('data-rowid',tblid);
            $(nRow).attr('data-rowno',rowno);
            $(nRow).attr('data-itemcode',itemcode);
            $(nRow).attr('data-itemname',itemname);
            $(nRow).attr('data-itemid',itemid);
            $(nRow).attr('data-purrate',purchaserate);
            $(nRow).attr('data-purqty',purqty);
            $(nRow).attr('data-dep_issqty',dep_issqty);
            $(nRow).attr('data-remqty',remqty);
            $(nRow).attr('data-unitname',unitname);
            $(nRow).attr('data-mattypeid',mattypeid);
            $(nRow).addClass('itemDetail');
            if(tblid==1)
            {

               $(nRow).addClass('selected');

            }

      },

    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ { type: null },
      {type: "text"},
      { type: "text" },
      { type: null },
      { type: null },
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

});

</script>

<script type="text/javascript">
  // $(document).ready(function(){
    var dtablelist = $('#TableItems').dataTable();
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

