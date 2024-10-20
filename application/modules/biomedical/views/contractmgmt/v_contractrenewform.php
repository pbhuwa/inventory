<form method="post" id="FormContract" action="<?php echo base_url('biomedical/contractmanagement/save_contractmgmt'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/contractmanagement/form_contractmgmt'); ?>' enctype="multipart/form-data" accept-charset="utf-8" class="resp_xs" >
    <input type="hidden" name="id" value="<?php echo !empty($contract_data[0]->coin_contractinformationid)?$contract_data[0]->coin_contractinformationid:'';  ?>">
    <div class="form-group">
        <div class="col-md-4">
            <label for="example-text"><?php echo $this->lang->line('contract_type'); ?><span class="required">*</span> :</label>
            <select id="contractType" class="form-control" name="coin_contracttypeid" r>
                <!-- <option value="">---select---</option> -->
                <!-- <?php
                    if(!empty($contractType)):
                        foreach($contractType as $contract):
                    ?>
                <option value="<?php echo $contract->coty_contracttypeid; ?>"><?php echo $contract->coty_contracttype; ?></option>
                <?php
                    endforeach;
                    endif;
                    ?> -->
                <option value="2" selected>Distributor</option>
            </select>
        </div>
        <div class="col-md-4">
            <?php 
            $dist_id=!empty($contract_data[0]->coin_distributorid)?$contract_data[0]->coin_distributorid:''; ?>
            <span id="distributorsWrapper" style="display:none;">
                <label for="example-text"> <?php echo $this->lang->line('distributor'); ?><span class="required">*</span> :</label>
                <select class="form-control typeSelected" data-id="distributors" name="coin_distributorid">
                    <option value="">---select---</option>
                    <?php
                        if(!empty($distributors)):
                            foreach($distributors as $value):
                        ?>
                    <option value="<?php echo $value->dist_distributorid; ?>"><?php echo $value->dist_distributor; ?></option>
                    <?php
                        endforeach; 
                        endif;
                        ?>
                </select>
            </span>
        </div>
    </div>
    <div class="clear"></div>
    <div id="contractorInfo" class="mtop_5"></div>
    <div id="contractorForm" class="mtop_5" style="display: none;">

        <div class="col-md-4 col-sm-6">
            <label for="example-text">Title <span class="required">*</span>: </label>
            <input type="text" name="coin_contracttitle" class="form-control"  placeholder="Contract Title" value="<?php echo !empty($contract_data[0]->coin_contracttitle)?$contract_data[0]->coin_contracttitle:''; ?>" id="contractTitle">
        </div>
        <div class="col-md-4 col-sm-6">
            <label for="example-text">Start Date <span class="required">*</span>: </label>
            <input type="text" name="coin_contractstartdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="Contract Start Date" value="<?php echo !empty($contract_data[0]->coin_contractstartdate)?$contract_data[0]->coin_contractstartdate:DISPLAY_DATE; ?>" id="ContractStartDate">
        </div>
        <div class="col-md-4 col-sm-6">
            <label for="example-text">End Date <span class="required">*</span>: </label>
            <input type="text" name="coin_contractenddate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="Contract End Date"  value="<?php echo !empty($contract_data[0]->coin_contractenddate)?$contract_data[0]->coin_contractenddate:DISPLAY_DATE; ?>" id="ContractEndDate">
        </div>
        <div class="clear"></div>
        <div class="col-md-4 col-sm-6">
            <label for="example-text">Contract Value <span class="required">*</span>: </label>
            <input type="text" name="coin_contractvalue" class="form-control float"  placeholder="Contract Value" value="<?php echo !empty($contract_data[0]->coin_contractvalue)?$contract_data[0]->coin_contractvalue:''; ?>" id="contractValue">
        </div>
        <div class="col-md-4 col-sm-6">
            <label for="example-text">Renew Type <span class="required">*</span>: </label>
            <!-- <input type="text" name="coin_renewtypeid" class="form-control"  placeholder="Contract Renew Type" value="<?php echo !empty($contract_data[0]->coin_renewtypeid)?$contract_data[0]->coin_renewtypeid:''; ?>" id="renewType"> -->
            <?php $renewtypeid=!empty($contract_data[0]->coin_renewtypeid)?$contract_data[0]->coin_renewtypeid:''; ?>
            <select name="coin_renewtypeid" class="form-control" id="renewType">
                <option value="">---Select---</option>
                <?php
                    if(!empty($renewType)):
                        foreach($renewType as $renew):
                ?>
                    <option value="<?php echo $renew->rety_renewtypeid?>" <?php if($renewtypeid==$renew->rety_renewtypeid) echo "selected=selected"; ?>><?php echo $renew->rety_renewtype;?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>
        <div class="clear"></div>
        <div class="col-sm-12 col-xs-12">
            <label><?php echo $this->lang->line('description'); ?> <span class="required">*</span>:</label>
            <textarea style="width: 100%" name="coin_description" placeholder="Description" ><?php echo !empty($contract_data[0]->coin_description)?$contract_data[0]->coin_description:''; ?></textarea>
        </div>
        <div class="clear"></div>
        <div class="col-sm-6">
            <label>Attachments</label>
            <div class="dis_tab">
                <input type="file" id="coin_attachments" name="coin_attachments[]"/>
                <input type="hidden" name="coin_attach[]">
                <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
            </div>
            <div class="addAttachmentRow">
                <?php 

                $contractAttachments = !empty($contract_data[0]->coin_attachments)?$contract_data[0]->coin_attachments:'';
                if($contractAttachments):
                $attach = explode(', ',$contractAttachments);
                $download = "";
                if($attach):
                    foreach($attach as $key=>$value){
                        $download .= "<a href='".base_url().CONTRACT_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download<a>&nbsp;&nbsp;&nbsp;";
                        }
                endif;
                echo $download;
            endif;
                ?>
            </div>
        </div>
        <div class="clear"></div>

    <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($contract_data)) || (!empty($contract_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($contract_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($contract_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        // $(document).off('change', '#contractType');
        // $(document).on('change', '#contractType',function(){
            var contracttype = $('#contractType option:selected').val();
            var contract_url = '';
            $('#contractorInfo').hide();
            $('#contractorForm').hide();

            if(contracttype == '1'){
                $('#manufacturersWrapper').show();
                $('#distributorsWrapper').hide();
                contract_url = 'biomedical/contractmanagement/getContractTypeData/manufacturers/renew';
            }else if(contracttype == '2'){
                $('#distributorsWrapper').show();
                $('#manufacturersWrapper').hide();
                contract_url = 'biomedical/contractmanagement/getContractTypeData/distributors/renew';
            }else{
                $('#distributorsWrapper').hide();
                $('#manufacturersWrapper').hide();
            }      
    
            $(document).off('change','.typeSelected');
            $(document).on('change','.typeSelected', function(){
                var id = $(this).val();
    
                $.ajax({
                    type: "POST",
                    url: base_url+contract_url,
                    data: {id:id},
                    dataType: 'json',
                    beforeSend: function(){
    
                    },
                    success: function(datas){
                        console.log(datas);
                        $('#contractorInfo').show();
                        $('#contractorInfo').html(datas.tempform);
                        if(datas.tempform != ""){
                            // $('#contractorForm').show();
                        }else{
                            $('#contractorForm').hide();
                        }
                    }
    
                });
            });
        });

        $(document).off('click','#addAttachments');
        $(document).on('click','#addAttachments',function(){
            $(".addAttachmentRow").append('<div class="dis_tab mtop_5"><input type="file" name="coin_attachments[]" "/><input type="hidden" name="coin_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="glyphicon glyphicon-trash"></span></a></div>');
        });

        $(document).off('click','.btnminus');
        $(document).on('click','.btnminus',function(){
            $(this).closest('div').remove();
        });
</script>

<?php if(!empty($contract_data)): ?>
<script type="text/javascript">
    var disid='<?php echo $dist_id; ?>';
    if(disid)
    {
        $('.typeSelected').val(disid).change();
    }
</script>
<?php endif; ?>