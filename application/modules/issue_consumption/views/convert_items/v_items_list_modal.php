 <div class="table-responsive">
    <table id="myTable_item" class="table table-striped keypresstable">
        <thead>
            <tr>
                <th width="5%">S.n.</th>
                <th width="10%">Item Code</th>
                <th width="25%">Item Name</th>
                <th width="15%">Stock</th>
                <th width="15%">Req Qty</th>
                <th width="15%">Unit</th>
            </tr>
        </thead>
        <tbody>
                  
        </tbody>
    </table>
</div>


<script type="text/javascript">
     $(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl = base_url+"issue_consumption/convert_items/get_item_list";
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
        "aTargets": [0,4]
      }
      ],      
      "aoColumns": [
      {"data": null},
      {"data": "itemcode"},
      {"data": "itemname"},
      {"data": "issueqty" },
      {"data": "req_qty" },
      {"data": "unitname" },
      ],
      "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
            // console.log(aData);
            var unitname =aData.unitname;
            var rowno=aData.rowno;
            var rate=aData.salesrate;
            var itemcode=aData.itemcode
            var itemname=aData.itemname;
            var itemid=aData.itemlistid;
            var issueqty=aData.issueqty;
            var unitname=aData.unitname;
            var mtdid=aData.mtdid;
            var supplierid=aData.supplierid;
            var supplierbillno=aData.supplierbillno;
            var mfgdatebs=aData.mfgdatebs;
            var mfgdatead=aData.mfgdatead;
            var selprice=aData.selprice;
            var unitprice=aData.unitprice;

            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1

            $(nRow).attr('id', 'listid_'+tblid);
            $(nRow).attr('data-rate',rate);
            $(nRow).attr('data-unit',unitname);
            $(nRow).attr('data-rowid',tblid);
            $(nRow).attr('data-rowno',rowno);
            $(nRow).attr('data-itemcode',itemcode);
            $(nRow).attr('data-itemname',itemname);
            $(nRow).attr('data-itemid',itemid);
            $(nRow).attr('data-issueqty',issueqty);
            $(nRow).attr('data-unitname',unitname);
            $(nRow).attr('data-mtdid',mtdid);
            $(nRow).attr('data-supplierid',supplierid);
            $(nRow).attr('data-supplierbillno',supplierbillno);
            $(nRow).attr('data-mfgdatebs',mfgdatebs);
            $(nRow).attr('data-mfgdatead',mfgdatead);
            $(nRow).attr('data-selprice',selprice);
            $(nRow).attr('data-unitprice',unitprice);
            $(nRow).addClass('itemDetail');

      },
    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ { type: null },
      {type: "text"},
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: null },
       { type: "text" },
     { type: "text" },
      ]
    });

  });
</script>

<script type="text/javascript">
  // $(document).ready(function(){
    var dtablelist = $('#myTable_item').dataTable();
    setTimeout(function(){
    model_keypress();
       }, 500);
  // })
</script>

<script type="text/javascript">
    var rowno = "<?php echo $rowno; ?>";
    $(document).off('click','.itemDetail');
    $(document).on('click','.itemDetail',function(){
        // var rowno=$(this).data('rowno');
        var unit=$(this).data('unit');
        var rate=$(this).data('rate');
        var itemcode=$(this).data('itemcode');
        var itemname=$(this).data('itemname');
        var itemid=$(this).data('itemid');
        var issueqty=$(this).data('issueqty');
        var mtdid = $(this).data('mtdid');
        var supplierid = $(this).data('supplierid');
        var supplierbillno = $(this).data('supplierbillno');
        var selprice = $(this).data('selprice');
        var unitprice = $(this).data('unitprice');
        var mfgdatebs = $(this).data('mfgdatebs');
        var mfgdatead = $(this).data('mfgdatead');

        // alert(rowno);

        if(rowno == '1'){
            $('#itemcode_parent').val(itemcode);
            $('#conv_parentid').val(itemid);
            $('#conv_parentmtdid').val(mtdid);
            $('#conv_parentqty').val(issueqty);
            $('#supplierid').val(supplierid);
            $('#supplierbillno').val(supplierbillno);
            $('#selprice').val(selprice);
            $('#unitprice').val(unitprice);
            $('#mfgdatebs').val(mfgdatebs);
            $('#mfgdatead').val(mfgdatead);
        }else if(rowno == '2'){
            $('#itemcode_child').val(itemcode);
            $('#conv_childid').val(itemid);
            $('#conv_childmtdid').val(mtdid);
        }
        
        $('#myView').modal('hide');
        // $('#itemqty_'+rowno).focus();
    });
</script>
