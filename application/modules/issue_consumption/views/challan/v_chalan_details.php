<div class="form-group row">
    <div class="col-md-3">
        <label for="example-text">Challan Receive No : </label>
        <?php echo !empty($challans[0]->chma_challanrecno)?$challans[0]->chma_challanrecno:''; ?>
    </div>
    <div class="col-md-3">
        <label for="example-text">Supplier: </label>  
       <?php echo !empty($challans[0]->dist_distributor)?$challans[0]->dist_distributor:''; ?>
    </div>
    <div class="col-md-3">
        <label for="example-text"> Challan Receive Date :</label>
        <?php echo !empty($challans[0]->chma_receivedatebs)?$challans[0]->chma_receivedatebs:''; ?>
    </div>
    <div class="col-md-3">
        <label for="example-text">Sup Challan No :</label>
    <?php echo !empty($challans[0]->chma_suchallanno)?$challans[0]->chma_suchallanno:'';?>
    </div>
    <div class="col-md-3">
        <label for="example-text">Sup.Challan Date :</label>

       <?php echo !empty($challans[0]->chma_challanrecdatebs)?$challans[0]->chma_challanrecdatebs:''; ?>
    </div>
     <div class="col-md-3">
        <label for="example-text">Branch :</label>

       <?php echo !empty($challans[0]->loca_name)?$challans[0]->loca_name:''; ?>
    </div>
    <div class="col-md-3">
        <label for="example-text">Fiscal Year:</label>

       <?php echo !empty($challans[0]->chma_fyear)?$challans[0]->chma_fyear:''; ?>
    </div>
      <div class="col-md-3">
        <label for="example-text">Order No:</label>

       <?php echo !empty($challans[0]->chma_puorid)?$challans[0]->chma_puorid:''; ?>
    </div>

    <div class="col-md-12">
        <div class="btn-group pull-right" style="margin-top: 18px;">
            <?php if($challans[0]->chma_received == 'N'){ ?>
          <!--   <button style="margin-right: 5px;" data-displaydiv="directpurchase" data-mid="<?php echo $challans[0]->chma_challanmasterid; ?>" data-viewurl="<?php echo base_url('issue_consumption/challan/challan_bill_entry'); ?>" class="btn btn-info redirectedit">Bill Entry</button> -->
            <?php } ?>
            <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-id="<?php echo !empty($challans[0]->chma_challanmasterid)?$challans[0]->chma_challanmasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>
        </div>
    </div>
</div>
<div class="clearfix"></div>   
<div class="table-responsive">
    <table id="myTable" class="table table-striped dataTable">
        <thead>
            <tr>

                <th>S.n.</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Sup Challan No</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php if($chalan_details){  //echo"<pre>"; print_r($chalan_details);die;
            foreach ($chalan_details as $key => $value) 
            {
                if(ITEM_DISPLAY_TYPE=='NP'){
                $req_itemname = !empty($value->itli_itemnamenp)?$value->itli_itemnamenp:$value->itli_itemname;
            }else{ 
                $req_itemname = !empty($value->itli_itemname)?$value->itli_itemname:'';
            }
             ?>
            <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $value->itli_itemcode; ?></td>
                <td><?php echo $req_itemname; ?></td>
                <td><?php echo $value->chde_qty; ?></td>
                <td><?php echo $value->chma_challanrecno; ?></td>
                <td><?php echo $value->chde_remarks; ?></td>
            </tr> 
            <?php } } ?>
        </tbody>
    </table>
</div>

<div id="FormDiv_Reprint" class="printTable"></div>

<script>
    $(document).off('click','.ReprintThis');
    $(document).on('click','.ReprintThis',function(){
    var print =$(this).data('print');
    var iddata=$(this).data('id');
    var id=$('#id').val();
    if(iddata)
    {
      id=iddata;
    }
    else
    {
      id=id;
    }
    $.ajax({
        type: "POST",
        url:  base_url+'/issue_consumption/challan/reprint_challan_details',
        data:{id:id},
        dataType: 'html',
        beforeSend: function() {
          $('.overlay').modal('show');
        },
        success: function(jsons) //we're calling the response json array 'cities'
        {
           data = jQuery.parseJSON(jsons);   
            // alert(data.status);
            if(data.status=='success')
            {
                $('#FormDiv_Reprint').html(data.tempform);
                $('.printTable').printThis();
            }
            else
            {
              alert(data.message);
            }
            setTimeout(function(){
                $('.newPrintSection').hide();
                
                $('#myView').modal('hide');
            },2000);
            $('.overlay').modal('hide');
        }
      });
    })
</script>