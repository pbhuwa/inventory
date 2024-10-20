<style type="text/css">
    .mtop_17{
        margin-top: 19px;
    }
    .item-overview .dis-inline{
        display: inline-block;
    }
    .item-overview input.dis-inline{
        width: 85%;
    }
    .item-overview a.dis-inline{
        width: 12%;
        height: 26px;
        position: relative;
        top: -1px;
    }
    .item-overview-tabs .nav >li >a{
        padding: 10px 7px;
    }
    .wb_form label{
    display: block;
}
</style>
<div class="row wb_form">
    <div class="pad-5">
                <h3 class="box-title"><?php echo $this->lang->line('item_overview'); ?></h3>
<div class="searchWrapper">
    <div class="row">
    <div class="col-md-12">
        <form id="PmData">
           
           <div class="form-group pad-5">
            <div class="row">
            <div class="col-md-6">
                <div class="item-overview">
                <input type="hidden" name="id" id="id" >
                <label><?php echo $this->lang->line('item_name'); ?></label>
                <input type="text" id="itli_itemname" autocomplete="off" name="itemname" value="" class="form-control dis-inline form-control searchText" placeholder="Enter Item Name/Item Code " data-srchurl="<?php echo base_url(); ?>stock_inventory/item_life_cycle/list_of_item_auto_suggest">
                
                <a href="javascript:void(0)" data-viewurl="<?php echo base_url('stock_inventory/item_life_cycle/list_of_item'); ?>" class="view dis-inline width_30 btn btn-success" data-heading="Item" ><i class="fa fa-upload"></i></a>
                </div>
                 <div class="DisplayBlock" id="DisplayBlock_id"></div>
                
            </div>

            <div class="col-md-3">
                <button type="button" id="searchByItem" data-viewurl='<?php echo base_url('stock_inventory/item_life_cycle/get_overview_item') ?>' class="btn btn-success btnEdit mtop_17" data-displaydiv='PmData' ><?php echo $this->lang->line('search'); ?></button> 
            </div>

            </div>
        </div>
     </form>
    </div>
    </div>
      <div id="FormDiv_PmData" class="search_pm_data item-overview-tabs">
      </div>
      </div>
   
</div>


</div>
<script type="text/javascript">
     $(document).off('click','.itemDetail');      
$(document).on('click','.itemDetail',function(){
      
        var itli_itemlistid=$(this).data('itli_itemlistid');
         var itli_itemname=$(this).data('itli_itemname');
        // var itemname_display=$(this).data('itemname_display');

        
        $('#id').val(itli_itemlistid);
         $('#itli_itemname').val(itli_itemname);
    // $('#itemname_'+rowno).val(itemname_display);

        
        $('#myView').modal('hide');
       
    });
</script>




