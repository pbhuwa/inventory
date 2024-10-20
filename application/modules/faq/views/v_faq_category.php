<form method="post" id="FormFaqCategorySetup" action="<?php echo base_url('faq/save_faq_category'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('faq/faq/form_faqcategory'); ?>' >
    <input type="hidden" name="id" value="<?php echo!empty($item_data[0]->faca_faqcatid)?$item_data[0]->faca_faqcatid:'';  ?>">
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('category_name'); ?> <span class="required">*</span>:</label>
                <?php $facq_catname=!empty($item_data[0]->facq_catname)?$item_data[0]->facq_catname:'';?>
            <input type="text" name="facq_catname" class="form-control" value="<?php echo $facq_catname; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('category_name'); ?> <?php echo $this->lang->line('in_nepali'); ?> <span class="required">*</span>:</label>
               <?php $itemcatnamenp=!empty($item_data[0]->facq_catnamenp)?$item_data[0]->facq_catnamenp:''; ?>
            <input type="text" class="form-control" name="facq_catnamenp"  value="<?php echo $itemcatnamenp; ?>">
        </div>
        <div class="col-md-2">
            <label for="example-text"><?php echo $this->lang->line('active'); ?>  ? </label><br>
            <?php $activestatus=!empty($item_data[0]->facq_isactive)?$item_data[0]->facq_isactive:'';
                $facq_isactive = !empty($item_data[0]->facq_isactive)?$item_data[0]->facq_isactive:'';
                // echo $facq_isactive;
                if($facq_isactive)
                {
                    
                    if($facq_isactive == 'Y')
                    {
                        $cat_isactive = "checked ='checked'";
                        $cat_isinactive = "";
                    }
                    else
                    {
                    $cat_isactive = "";
                    $cat_isinactive = "checked ='checked'";
                    } 
                }
                else
                {
                     $cat_isactive = "checked ='checked'";
                     $cat_isinactive='';
                }
                ?>
            <input type="radio" class="mbtm_13 isactive" name="facq_isactive" data-reqtype="issue" value="Y" <?php echo $cat_isactive; ?>" id="catactive" ><?php echo $this->lang->line('yes'); ?>
                    &nbsp;&nbsp;&nbsp;
            <input type="radio" class="mbtm_13 isactive" name="facq_isactive" data-reqtype="transfer" value="N" <?php echo $cat_isinactive; ?>"" id="catisinactive" ><?php echo $this->lang->line('no'); ?>
        </div>
        <div class="col-md-2">
          <?php $update_var= $this->lang->line('update');
            $save_var= $this->lang->line('save'); ?>
           <button type="submit" class="btn btn-info margintop17 save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?$update_var:$save_var; ?></button>
        </div>
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>
<div class="table-responsive">
    <table id="myTable" class="table table-striped">
        <thead>
            <tr>
                <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                <th width="15%"><?php echo $this->lang->line('category'); ?></th>
                <th width="15%"><?php echo $this->lang->line('category'); ?> <?php echo $this->lang->line('in_nepali'); ?></th>
                <th width="15%"><?php echo $this->lang->line('active'); ?></th>
                <th width="10%"><?php echo $this->lang->line('action'); ?></th>
                
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
</div>


<script type="text/javascript">
        $(document).ready(function(){

        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();
        //var dataurl = base_url+"stock_inventory/item/get_item_category_list";
        var dataurl = base_url+"faq/faq/get_faq_category_list";
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
        "aTargets": [0,4]
        }
        ],
        "aoColumns": [
        {"data": null},
        {"data": "facq_catname"},
        {"data": "facq_catnamenp"},
        {"data": "facq_isactive"},
        {"data": "action"},



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
        var tblid = oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
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
        { type: null},

        ]
        });
        });
</script>





