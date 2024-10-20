 <style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<form method="post" id="FormDistributor" action="<?php echo base_url('biomedical/distributors/save_distributor'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/distributors/form_distributor'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($distributor_data[0]->dist_distributorid)?$distributor_data[0]->dist_distributorid:'';  ?>">
    <div class="clearfix"></div>

    <div class="form-group resp_xs">
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('distributor_code'); ?>:</label>
            <input type="text" name="dist_distributorcode" class="form-control" placeholder="Supplier Code" value="<?php echo !empty($distributor_data[0]->dist_distributorcode)?$distributor_data[0]->dist_distributorcode:''; ?>" autofocus="true" required>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('distributor_name'); ?> <span class="required">*</span>:</label>
            <input type="text" id="id" autocomplete="off" name="dist_distributor" class="form-control searchText" placeholder="Supplier Name" value="<?php echo !empty($distributor_data[0]->dist_distributor)?$distributor_data[0]->dist_distributor:''; ?>" autofocus="true" data-srchurl="<?php echo base_url(); ?>biomedical/distributors/list_of_supplier" required>
            <div class="DisplayBlock" id="DisplayBlock_id"></div>
        </div>
         <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('phone1'); ?> <span class="required">*</span>:</label>
            <input type="text" name="dist_phone1" class="form-control number" placeholder="Phone 1" value="<?php echo !empty($distributor_data[0]->dist_phone1)?$distributor_data[0]->dist_phone1:''; ?>" maxlength="15">
        </div>  
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('phone2'); ?>:</label>
            <input type="text" name="dist_phone2" class="form-control number" placeholder="Phone 2" value="<?php echo !empty($distributor_data[0]->dist_phone2)?$distributor_data[0]->dist_phone2:''; ?>" maxlength="15">
        </div>
        
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('government_reg_no'); ?> :</label>
            <input type="text" name="dist_govtregno" class="form-control number" placeholder="Government Reg.No" value="<?php echo !empty($distributor_data[0]->dist_govtregno)?$distributor_data[0]->dist_govtregno:''; ?>" autofocus="true" required>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('government_reg_date'); ?>: </label>
            <input type="text" name="dist_govtregdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo !empty($distributor_data[0]->dist_govtregdatebs)?$distributor_data[0]->dist_govtregdatebs:DISPLAY_DATE; ?>" id="ServiceStart">
        </div>
        
        <div class="col-md-4 col-sm-6 col-xs-6">
             <label for="example-text">VAT/PAN No.: </label>
            <input type="text" name="dist_vatno" class="form-control" placeholder="VAT/PAN No" value="<?php echo !empty($distributor_data[0]->dist_vatno)?$distributor_data[0]->dist_vatno:''; ?>" >
        </div>

        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('vat_reg_date'); ?>: </label>
            <input type="text" name="dist_vatregdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo !empty($distributor_data[0]->dist_vatregdatebs)?$distributor_data[0]->dist_vatregdatebs:DISPLAY_DATE; ?>" id="vatRegDate">
        </div>
        

         <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('sales_rep_email'); ?>  :</label>
            <input type="text" name="dist_repemail" class="form-control" placeholder="Sales Rep. Email" value="<?php echo !empty($distributor_data[0]->dist_repemail)?$distributor_data[0]->dist_repemail:''; ?>">
        </div>
        
     </div>
     <div class="form-group resp_xs">

       

        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('pobox'); ?> :</label>
            <input type="text" name="dist_pobox" class="form-control number" placeholder="PO.Box" value="<?php echo !empty($distributor_data[0]->dist_pobox)?$distributor_data[0]->dist_pobox:''; ?>" >
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('country'); ?>  :</label>

            <?php $count = !empty($distributor_data[0]->dist_countryid)?$distributor_data[0]->dist_countryid:'';?>            

            <div class="dis_tab">
                <select name="dist_countryid" class="form-control" id="dist_countryid">
                    <option value="">---select---</option>

                    <?php 
                    if($country_list):
                    foreach ($country_list as $kcl => $country):
                    ?>

                    <option value="<?php echo $country->coun_countryid; ?>" <?php if($count==$country->coun_countryid) echo 'selected=selected';?>><?php echo $country->coun_countryname; ?></option>

                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
                <a href="javascript:void(0)" class="table-cell btncountryref frm_add_btn width_30" ><i class="fa fa-refresh"></i></a>
                <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 btncountry" ><i class="fa fa-plus"></i></a>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('city'); ?>:</label>
            <input type="text" name="dist_city" class="form-control" placeholder="City" value="<?php echo !empty($distributor_data[0]->dist_city)?$distributor_data[0]->dist_city:''; ?>">
        </div>
        
    </div>

    <div class="form-group resp_xs">
      
<div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('address1'); ?>  :</label>
            <input type="text" name="dist_address1" class="form-control" placeholder="Distributor Address1" value="<?php echo !empty($distributor_data[0]->dist_address1)?$distributor_data[0]->dist_address1:''; ?>" maxlength="50">
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('address2'); ?> :</label>
            <input type="text" name="dist_address2" class="form-control" placeholder="Distributor Address2" value="<?php echo !empty($distributor_data[0]->dist_address2)?$distributor_data[0]->dist_address2:''; ?>" maxlength="50" >
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('fax'); ?>:</label>
            <input type="text" name="dist_fax" class="form-control" placeholder="Enter Fax Number" value="<?php echo !empty($distributor_data[0]->dist_fax)?$distributor_data[0]->dist_fax:''; ?>">
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('sales_rep'); ?>:</label>
            <input type="text" name="dist_salesrep" class="form-control" placeholder="Sales Representive" value="<?php echo !empty($distributor_data[0]->dist_salesrep)?$distributor_data[0]->dist_salesrep:''; ?>">
        </div>
         <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('home_phone'); ?> :</label>
            <input type="text" name="dist_homephone" class="form-control number" placeholder="Home Phone" value="<?php echo !empty($distributor_data[0]->dist_homephone)?$distributor_data[0]->dist_homephone:''; ?>">
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('email'); ?>  :</label>
            <input type="text" name="dist_email" class="form-control" placeholder="Email Address" value="<?php echo !empty($distributor_data[0]->dist_email)?$distributor_data[0]->dist_email:''; ?>" maxlength="50">
        </div>

        <div class="col-md-2">
             <?php $isactive=!empty($distributor_data[0]->dist_isactive)?$distributor_data[0]->dist_isactive:''; ?>
            <label>Is Active:</label>
            <select name="dist_isactive" class="form-control">
                <option value="Y" >Yes</option>
                <option value="N" <?php if($isactive=='N') echo "selected=selected"; ?>>No</option>
            </select>
        </div>
    </div>

    <!-- <div class="form-group resp_xs">
        
       
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('email'); ?>  :</label>
            <input type="text" name="dist_email" class="form-control" placeholder="Email Address" value="<?php echo !empty($distributor_data[0]->dist_email)?$distributor_data[0]->dist_email:''; ?>" maxlength="50">
        </div>
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('mobile_no'); ?>:</label>
            <input type="text" name="dist_mobilephone" class="form-control number" placeholder="Mobile Number" value="<?php echo !empty($distributor_data[0]->dist_mobilephone)?$distributor_data[0]->dist_mobilephone:''; ?>" minlength="10" maxlength="10">
        </div>
        
    </div> -->

    <div class="form-group resp_xs">
        
       <!--  <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('government_reg_date'); ?>: </label>
            <input type="text" name="dist_govtregdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo !empty($distributor_data[0]->dist_govtregdatebs)?$distributor_data[0]->dist_govtregdatebs:DISPLAY_DATE; ?>" id="ServiceStart">
        </div>
        
        <div class="col-md-4 col-sm-6 col-xs-6">
             <label for="example-text"><?php echo $this->lang->line('vat_reg_no'); ?>: </label>
            <input type="text" name="dist_vatno" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo !empty($distributor_data[0]->dist_vatno)?$distributor_data[0]->dist_vatno:''; ?>" >
        </div>

        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('vat_reg_date'); ?>: </label>
            <input type="text" name="dist_vatregdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo !empty($distributor_data[0]->dist_vatregdatebs)?$distributor_data[0]->dist_vatregdatebs:DISPLAY_DATE; ?>" id="vatRegDate">
        </div>
        
         -->
        <!-- <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('service_tech1'); ?> :</label>

            <?php $serv = !empty($distributor_data[0]->dist_servicetech1)?$distributor_data[0]->dist_servicetech1:'';?>

            <select name="dist_servicetech1" class="form-control">
                <option value="">---select---</option>

                <?php if($service_techlist):
                foreach ($service_techlist as $kst => $servicetech):
                ?> 

                <option value="<?php echo $servicetech->sete_techid;  ?>" <?php if($serv==$servicetech->sete_techid) echo 'selected=selected';?>><?php echo $servicetech->sete_name;  ?></option> 

                <?php  endforeach;endif;
                ?>
            </select> 
        </div> -->
        <!-- <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('service_tech2'); ?> :</label>

            <?php $serv = !empty($distributor_data[0]->dist_servicetech2)?$distributor_data[0]->dist_servicetech2:'';?>

            <select name="dist_servicetech2" class="form-control">
                <option value="">---select---</option>

                <?php if($service_techlist):
                foreach ($service_techlist as $kst => $servicetech):
                ?> 

                <option value="<?php echo $servicetech->sete_techid;  ?>" <?php if($serv==$servicetech->sete_techid) echo 'selected=selected';?>><?php echo $servicetech->sete_name;  ?></option> 

                <?php endforeach; endif;  
                ?>

            </select> 
        </div>   -->

       <!--  <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('service_tech3'); ?> :</label>

            <?php $serv = !empty($distributor_data[0]->dist_servicetech2)?$distributor_data[0]->dist_servicetech2:'';?>

            <select name="dist_servicetech2" class="form-control">
                <option value="">---select---</option>

                <?php if($service_techlist):
                foreach ($service_techlist as $kst => $servicetech):
                ?> 

                <option value="<?php echo $servicetech->sete_techid;  ?>" <?php if($serv==$servicetech->sete_techid) echo 'selected=selected';?>><?php echo $servicetech->sete_name;  ?></option> 

                <?php  endforeach; endif;
                ?>
            </select> 
        </div>  -->

    </div>
    <div class="clearfix"></div>
  
        <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($distributor_data)) || (!empty($distributor_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
                <?php
                    if(!empty($modal) && $modal == 'modal'):
                      $saveclass= 'savelist';
                    else:
                      $saveclass='save';
                    endif;
                    ?>
        <button type="submit" class="btn btn-info  <?php echo $saveclass; ?>" data-operation='<?php echo !empty($distributor_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($distributor_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>
 <?php if(!empty($distributor_data)): ?>

    <a href="javascript:void(0)" data-reloadform="<?php echo base_url('biomedical/distributors/form_distributor'); ?>" class="btn btn-success btnreset">Reset</a>

    <?php endif; ?>
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>

</form>
<div class="clearfix"></div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content xyz-modal-123">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('country_list'); ?></h4>
            </div>
            <form method="post" id="FormCountry" action="<?php echo base_url('settings/Department/save_country'); ?>" class="form-material form-horizontal form"  >
                <div class="form-group">
                    <div class="pad-sides-15">
                        <div class="col-md-4">
                            <label for="example-text"><?php echo $this->lang->line('code'); ?></label><span class="required">*</span>:
                            <input type="text" name="coun_countrycode" class="form-control" placeholder="Country Code Eg.NP" autofocus="true">
                        </div>
                        <div class="col-md-4">
                            <label for="example-text"><?php echo $this->lang->line('name'); ?></label><span class="required">*</span>:
                            <input type="text" name="coun_countryname" class="form-control" placeholder="Country Name">
                        </div>
                        <div class="col-md-2">
                            <label for="">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-info savelist" data-isdismiss='Y'><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div id="ResponseSuccess_FormCountry" class="alert-success success"></div>
                            <div id="ResponseError_FormCountry" class="alert-danger error"></div>
                        </div>
                    </div>
                </div>      
            </form>  
            <div class="modal-body scroll vh80">
                <table class="table table-border table-striped table-site-detail dataTable">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('code'); ?></th>
                            <th><?php echo $this->lang->line('name'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                        if($country_list):
                        foreach ($country_list as $kcl => $country):
                        ?>

                        <tr>
                            <td>
                                <?php echo $country->coun_countrycode;  ?>
                            </td>
                            <td>
                                <?php echo $country->coun_countryname; ?>
                            </td>  
                        </tr>

                        <?php
                        endforeach;
                        endif;
                        ?>  
                        
                    </tbody>
                </table>  
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).off('click','.btncountry');
    $(document).on('click','.btncountry',function(){
        $('#myModal1').modal('show');
    })

     $(document).off('click','.btncountryref');
     $(document).on('click','.btncountryref',function(){
      var action=base_url+'settings/department/get_country';
    // alert(depid);
     $.ajax({
          type: "POST",
          url: action,
          
          dataType: 'json',
        success: function(datas) 
          {
            console.log(datas);
            var opt='';
                opt='<option value="">---select---</option>';
                $.each(datas,function(i,k)
                {
                  opt += '<option value='+k.coun_countryid+'>'+k.coun_countryname+'</option>';
                });
          $('#dist_countryid').html(opt);
          }
      });
    })
</script>
 