<form method="post" id="FormMenufacturer" action="<?php echo base_url('biomedical/manufacturers/save_manufacturers'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/manufacturers/form_manufacturers'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($manufacturers_data[0]->manu_manlistid)?$manufacturers_data[0]->manu_manlistid:'';  ?>">
    <div class="clearfix"></div>

    <div class="form-group resp_xs">
        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Manufacturer <span class="required">*</span>:</label>
            <input type="text" name="manu_manlst" class="form-control" placeholder="Manufacturer Name" value="<?php echo !empty($manufacturers_data[0]->manu_manlst)?$manufacturers_data[0]->manu_manlst:''; ?>" autofocus="true">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Phone1  <span class="required">*</span>:</label>
            <input type="text" name="manu_phone1" class="form-control number" placeholder="Phone 1" value="<?php echo !empty($manufacturers_data[0]->manu_phone1)?$manufacturers_data[0]->manu_phone1:''; ?>" maxlength="15" >
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Phone2:</label>
            <input type="text" name="manu_phone2" class="form-control number" placeholder="Phone 2" value="<?php echo !empty($manufacturers_data[0]->manu_phone2)?$manufacturers_data[0]->manu_phone2:''; ?>" maxlength="15">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">PO.Box :</label>
            <input type="text" name="manu_pobox" class="form-control" placeholder="PO.Box" value="<?php echo !empty($manufacturers_data[0]->manu_pobox)?$manufacturers_data[0]->manu_pobox:''; ?>" >
        </div>
    </div>

    <div class="form-group resp_xs">
        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Country  :</label>
            <div class="dis_tab">
                <?php $pmenu = !empty($manufacturers_data[0]->manu_countryid)?$manufacturers_data[0]->manu_countryid:'';?>

                <select name="manu_countryid" class="form-control" id="dist_countryid">
                    <option>---select---</option>

                    <?php 
                    if($country_list):
                    foreach ($country_list as $kcl => $country): 
                    ?>

                    <option value="<?php echo $country->coun_countryid; ?>" <?php if($pmenu==$country->coun_countryid) echo 'selected=selected'; ?>><?php echo $country->coun_countryname; ?></option>

                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
                <a href="javascript:void(0)" class="table-cell btncountryref frm_add_btn width_30" ><i class="fa fa-refresh"></i></a>
                <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 btncountry" ><i class="fa fa-plus"></i></a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">City:</label>
            <input type="text" name="manu_city" class="form-control" placeholder="City" value="<?php echo !empty($manufacturers_data[0]->manu_city)?$manufacturers_data[0]->manu_city:''; ?>">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Address1:</label>
            <input type="text" name="manu_address1" class="form-control" placeholder="Manufacturer Address1" value="<?php echo !empty($manufacturers_data[0]->manu_address1)?$manufacturers_data[0]->manu_address1:''; ?>">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Addres2 :</label>
            <input type="text" name="manu_address2" class="form-control" placeholder="Manufacturer Address 2" value="<?php echo !empty($manufacturers_data[0]->manu_address2)?$manufacturers_data[0]->manu_address2:''; ?>" >
        </div>
    </div>

    <div class="form-group resp_xs">
        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Fax:</label>
            <input type="text" name="manu_fax" class="form-control" placeholder="Fax Number" value="<?php echo !empty($manufacturers_data[0]->manu_fax)?$manufacturers_data[0]->manu_fax:''; ?>">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Email :</label>
            <input type="text" name="manu_email" class="form-control" placeholder="Email Address" value="<?php echo !empty($manufacturers_data[0]->manu_email)?$manufacturers_data[0]->manu_email:''; ?>">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Website :</label>
            <input type="text" name="manu_website" class="form-control" placeholder="Website" value="<?php echo !empty($manufacturers_data[0]->manu_website)?$manufacturers_data[0]->manu_website:''; ?>">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Contact. :</label>
            <input type="text" name="manu_contact" class="form-control" placeholder="Contact Number" value="<?php echo !empty($manufacturers_data[0]->manu_contact)?$manufacturers_data[0]->manu_contact:''; ?>">
        </div>
    </div>

    <div class="form-group resp_xs">
        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Con. Home Phone :</label>
            <input type="text" name="manu_conhomephone" class="form-control" placeholder="Contact Home Phone" value="<?php echo !empty($manufacturers_data[0]->manu_conhomephone)?$manufacturers_data[0]->manu_conhomephone:''; ?>">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Con. Mobile :</label>
            <input type="text" name="manu_conmobilephone" class="form-control number" placeholder="Contact Mobile Phone" value="<?php echo !empty($manufacturers_data[0]->manu_conmobilephone)?$manufacturers_data[0]->manu_conmobilephone:''; ?>" maxlength="10">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Con. Email :</label>
            <input type="text" name="manu_conemail" class="form-control" placeholder="Contact Email" value="<?php echo !empty($manufacturers_data[0]->manu_conemail)?$manufacturers_data[0]->manu_conemail:''; ?>">
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Distributor :</label>

            <?php $destribut = !empty($manufacturers_data[0]->manu_distributorid)?$manufacturers_data[0]->manu_distributorid:'';?>

            <select name="manu_distributorid" class="form-control">
                <option value="">---select---</option>

                <?php 
                if($distributor_list):
                foreach ($distributor_list as $kd => $dist):
                ?>

                <option value="<?php echo $dist->dist_distributorid; ?>" <?php if($destribut==$dist->dist_distributorid) echo 'selected=selected'; ?>><?php echo $dist->dist_distributor; ?></option>

                <?php
                endforeach;
                endif;
                ?>
                ?>
            </select>
        </div>
    </div>

    <div class="form-group resp_xs">
        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Dist Contact :</label>
            <input type="text" name="manu_distcontact" class="form-control" placeholder="Distrubtor Contact" value="<?php echo !empty($manufacturers_data[0]->manu_distcontact)?$manufacturers_data[0]->manu_distcontact:''; ?>">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Service Tech1 :</label>

            <?php $service1 = !empty($manufacturers_data[0]->manu_servicetech1)?$manufacturers_data[0]->manu_servicetech1:'';?>

            <select name="manu_servicetech1" class="form-control">
                <option value="">---select---</option>
                
                <?php if($service_techlist):
                foreach ($service_techlist as $kst => $servicetech):
                ?> 

                <option value="<?php echo $servicetech->sete_techid;  ?>" <?php if($service1==$servicetech->sete_techid) echo 'selected=selected'; ?>><?php echo $servicetech->sete_name;  ?></option> 

                <?php  endforeach;endif;?>
            </select> 
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Service Tech2 :</label>
            
            <?php $service2 = !empty($manufacturers_data[0]->manu_servicetech2)?$manufacturers_data[0]->manu_servicetech2:'';?>

            <select name="manu_servicetech2" class="form-control">
                <option value="">---select---</option>
                
                <?php if($service_techlist):
                foreach ($service_techlist as $kst => $servicetech2):
                ?>

                <option value="<?php echo $servicetech2->sete_techid;  ?>" <?php if($service2 == $servicetech2->sete_techid) echo 'selected=selected'; ?>><?php echo $servicetech2->sete_name;  ?></option> 

                <?php endforeach; endif;  
                ?>
            </select> 
        </div>

        <div class="col-md-3 col-sm-6 col-xs-6">
            <label for="example-text">Service Tech3 :</label>

            <?php $service3 = !empty($manufacturers_data[0]->manu_servicetech3)?$manufacturers_data[0]->manu_servicetech3:'';?>

            <select name="manu_servicetech3" class="form-control">
                <option value="">---select---</option>

                <?php if($service_techlist):
                foreach ($service_techlist as $kst => $servicetech3):
                ?> 

                <option value="<?php echo $servicetech3->sete_techid;  ?>" <?php if($service3 == $servicetech3->sete_techid) echo 'selected=selected'; ?>><?php echo $servicetech3->sete_name;  ?></option> 

                <?php  endforeach; endif;
                ?>
            </select> 
        </div>
    </div>

    <div class="clearfix"></div>
     <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($manufacturers_data)) || (!empty($manufacturers_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($manufacturers_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($manufacturers_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>
     <?php if(!empty($manufacturers_data)): ?>
      <a href="javascript:void(0)" data-reloadform="<?php echo base_url('biomedical/manufacturers/form_manufacturers'); ?>" class="btn btn-success btnreset">Reset</a>
  <?php endif; ?>
    <div  class=" alert-success success"></div>
    <div class=" alert-danger error"></div>

</form>
 <div class="clearfix"></div>

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content xyz-modal-123">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Country List</h4>
                </div>

                <form method="post" id="FormCountry" action="<?php echo base_url('settings/Department/save_country'); ?>" class="form-material form-horizontal form"  >
                    <div class="form-group">
                        <div class="pad-sides-15">
                            <div class="col-md-3">
                                <label for="example-text">Code</label><span class="required">*</span>:
                                <input type="text" name="coun_countrycode" class="form-control" placeholder="Country Code Eg.NP" autofocus="true">
                            </div>
                            <div class="col-md-4">
                                <label for="example-text">Name</label><span class="required">*</span>:
                                <input type="text" name="coun_countryname" class="form-control" placeholder="Country Name">
                            </div>
                            <div class="col-md-2">
                                <label for="">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-info  savelist mtop_0" data-isdismiss='Y'>Save</button>
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
                                <th>Code</th>
                                <th>Name</th>
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