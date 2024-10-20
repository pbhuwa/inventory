<div class="white-box">
  <?php $orgid=$this->session->userdata(ORG_ID);
  if($orgid=='2'){
    $title=$this->lang->line('assets_comment_list');
  }else{
    $title=$this->lang->line('equipment_comment_list');

  } ?>
    <h3 class="box-title"><?php echo $title; ?><a href="javascript:void(0)" class="commentRefresh" data-tableid="repairRequesttble"><i class="fa fa-refresh pull-right"></i></a></h3>
    <div class="pad-5">
        <div class="table-responsive">
          <?php $this->load->view('common/v_biomedical_status_bar'); ?>
            <table id="repairRequesttble" class="table table-striped dataTable">
                <thead>
                    <tr>

                        <th width="5%"> <?php echo $this->lang->line('sn'); ?></th>
                        <?php if($orgid=='2'){ ?>
                        <th width="10%"> <?php echo $this->lang->line('assets_code'); ?></th>
                        <?php }else{ ?>
                        <th width="10%"> <?php echo $this->lang->line('equipment_id'); ?></th>
                        <?php } ?>
                        <th width="10%">Request No.</th>
                        <th width="20%"> <?php echo $this->lang->line('description'); ?></th>
                        <th width="15%"> <?php echo $this->lang->line('department'); ?></th>
                        <th width="15%"> <?php echo $this->lang->line('comments'); ?></th>
                        <th width="10%"> <?php echo $this->lang->line('comment_by'); ?></th>
                        <th width="15%"> <?php echo $this->lang->line('date'); ?></th>
                        <th width="10%"> <?php echo $this->lang->line('status'); ?></th>
                        <th></th>
                        
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
</div>
    <div id="myModal1" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Equipment Repair Request</h4>
                </div>
                <div class="pad-5 resultrRepairComment search_pm_data scroll vh80 h_hidden">
                            
                </div>

                
            </div>

        </div>
    </div>

<script type="text/javascript">
  $(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl_rr = base_url+"home/get_repair_request";
    var message='';
    
      message="<p class='text-danger'>No Record Found!! </p>";

   var dtablelist = $('#repairRequesttble').dataTable({
      "sPaginationType": "full_numbers"  ,
      
      "bSearchable": false,
      "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
      'iDisplayLength': 5,
      "sDom": 'ltipr',
      "bAutoWidth":false,
            "fnDestroy":true,
            "Destroy":true,
      "autoWidth": true,
      "aaSorting": [[0,'desc']],
      "bProcessing":true,
      "bServerSide":true,    
      "sAjaxSource":dataurl_rr,
      "oLanguage": {
        "sEmptyTable":   message,
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 0,1,2,3,4,5,6,7,8 ]
      }
      ],      
      "aoColumns": [
       { "data": "eqco_equipmentcommentid"},
       { "data": "equipmentkey" },
       { "data": "request_no" },
       { "data": "description" },
       { "data": "department" },
       { "data": "comment" },
       { "data": "reported_by" },
       { "data": "repairdatead" },
       { "data": "status" },
       { "data": "action" },
       
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
      var oSettings = dtablelist.fnSettings();
      var rowClass = aData.row_class;
      var tblid= oSettings._iDisplayStart+iDisplayIndex +1
      $(nRow).attr('id', 'listid_'+tblid);
      $(nRow).addClass(rowClass);
    },   

    }).columnFilter(
    {
      sPlaceHolder: "head:after",
      aoColumns: [ {type: null},
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
      { type: null },
     
      ]
    });
  });
</script>


<script>
    $(document).off('click','#approveRepair');
    $(document).on('click','#approveRepair',function(){
        var commentid = $(this).data('eqco_equipmentcommentid');
        var commentStatus = $(this).data('status');
        if(commentStatus == 1){
            alert('Already Approved');
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: base_url+'home/approveRepairRequest',
                data:{commentid:commentid},
                dataType: 'json',
                success: function(datas) {
                    alert(datas.message);
                    $('#myModal1').modal('hide');
                }
            });
        }
    });
</script>

<script type="text/javascript">
    
    $(document).off('click','.btnviewd');
    $(document).on('click','.btnviewd',function(){
        var urlload=$(this).data('viewurl');
        var result = $(this).data('resultval');
        var orgid=$(this).data('orgid');
        $('.displaydetail').load(urlload+'/'+result+'/'+orgid);
        //alert(urlload);alert(result);
    })
</script>

<script>
    $(document).on('change mouseleave keyup','#rere_techcost, #rere_partcost, #rere_othercost, #rere_totalcost',function(){
        var techcost = $('#rere_techcost').val();
        var partcost = $('#rere_partcost').val();
        var othercost = $('#rere_othercost').val();
        var totalcost = parseInt(techcost) + parseInt(partcost) + parseInt(othercost);
        totalcost = isNaN(totalcost)?'0':totalcost;
        $('#rere_totalcost').val(totalcost);
    });
</script>

<script type="text/javascript">
  $(document).off('click','.problemtype');
  $(document).on('click','.problemtype',function(){
    var prbmtype=$(this).val();
    if(prbmtype=='Ex')
    {
      $('#internalform').hide();
      $('#externalform').show();
    }
    else
    {
      $('#internalform').show();
      $('#externalform').hide();
    }

  })
</script>

<script type="text/javascript">
 $(document).on('click', '.commentRefresh', function() {
  var tableid=$(this).data('tableid');
    var dtablelist = $('#'+tableid).dataTable();       
    dtablelist.fnDraw();
  });
</script>