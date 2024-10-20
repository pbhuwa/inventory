<form method="post" id="FormInventory" action="<?php echo base_url('biomedical/Bio_medical_inventory/save_biomedicalinven'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/bio_medical_inventory/form_bio_inventory'); ?>' enctype="multipart/form-data" accept-charset="utf-8" class="resp_xs" >
  <input type="hidden" name="id" value="<?php echo!empty($equip_data[0]->bmin_equipid)?$equip_data[0]->bmin_equipid:'';  ?>">
 
<div class="form-group resp_xs">
    <div class="col-md-4 col-sm-6 col-xs-6"><label>Equipment Type<span class="required">*</span>:</label>
      
       <?php  $eqtype= !empty($equip_data[0]->bmin_equipmenttypeid)?$equip_data[0]->bmin_equipmenttypeid:''; ?>
            <select class="form-control" name="bmin_equipmenttypeid" autofocus="true" id="bmin_equipmenttypeid" <?php if(!empty($equip_data)) echo 'disabled="disabled"'; ?>>
              <?php if($this->session->userdata(USER_ACCESS_TYPE)=='B'): ?>
                <option value="">---select----</option>
             <?php endif; ?>
             <?php
             if($equipmnt_type): 
             foreach ($equipmnt_type as $ket => $etype):
             ?>
            <option value="<?php echo $etype->eqty_equipmenttypeid; ?>" <?php if($eqtype==$etype->eqty_equipmenttypeid) echo "selected=selected"; ?>><?php echo $etype->eqty_equipmenttype; ?></option>
         <?php endforeach; endif; ?>
       </select>
    </div>
   <div class="col-md-4 col-sm-6 col-xs-6"><label for="example-text">Equip. Description 
            <span class="required">*</span> : </label>

          <?php $descriptionid=!empty($equip_data[0]->bmin_descriptionid)?$equip_data[0]->bmin_descriptionid:''; ?>
          <!-- eqli_description -->
          <?php if(!empty($equip_data)):
          ?>
          <input type="hidden" name="bmin_descriptionid" value="<?php echo $descriptionid; ?>">
           <input type="hidden" name="bmin_equipmenttypeid" value="<?php echo $eqtype; ?>">
          <?php
                endif;
          ?>
      
          <select name="bmin_descriptionid" class="form-control  equipmentdescform codegen " autofocus="true" <?php if(!empty($equip_data)) echo 'disabled="disabled"'; ?> id="descriptionid">
           <option value="">---select----</option>
          
           <?php
                 if($equipment_list): 
                 foreach ($equipment_list as $ket => $etype):
                 ?>
                <option value="<?php echo $etype->eqli_equipmentlistid; ?>"><?php echo $etype->eqli_description; ?></option>
             <?php endforeach; endif; ?>
             </select>
        </div>
    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Department <span class="required">*</span>:</label>
      <?php 
      $bmin_departmentid=!empty($equip_data[0]->bmin_departmentid)?$equip_data[0]->bmin_departmentid:'';
      // echo $deptype;
      // die();
      ?>

      <select name="bmin_departmentid" class="form-control codegen " id="departmentid">
        <option value="">---select---</option>

        <?php if($dep_information):
        foreach ($dep_information as $kdi => $depin):?>

        <option value="<?php echo $depin->dept_depid; ?>" <?php if($bmin_departmentid==$depin->dept_depid) echo 'selected=selected'; ?>><?php echo $depin->dept_depname; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </div>

<div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Room:</label>
      <select name="bmin_roomid" class="form-control" id="bmin_roomid">
        <option value="">---select---</option>
      </select>
    </div>
    


</div>

  <div class="clearfix"></div>

<div class="form-group resp_xs">
     
  
           
    <div class="col-md-4 col-sm-6 col-xs-6"><label>Equipment ID</label>
      
      <input type="text" name="bmin_equipmentkey" readonly="true" id="equipmentid" class="form-control" value="<?php echo !empty($equip_data[0]->bmin_equipmentkey)?$equip_data[0]->bmin_equipmentkey:'';?>">
    </div>

    
        <!-- <div id="ResultFormSelected"></div> -->

        <div class="col-md-4 col-sm-6 col-xs-6"><label for="example-text">Model No : </label>
          
          <input type="text" name="bmin_modelno" class="form-control" placeholder="Model No" value="<?php echo !empty($equip_data[0]->bmin_modelno)?$equip_data[0]->bmin_modelno:''; ?>" >
        </div>

        <div class="col-md-4 col-sm-6 col-xs-6"><label for="example-text">Serial No : </label>
          <input type="text" name="bmin_serialno" class="form-control" placeholder="Serial No" value="<?php echo !empty($equip_data[0]->bmin_serialno)?$equip_data[0]->bmin_serialno:''; ?>" >
        </div>
</div>

     <div class="clearfix"></div>

<div class="form-group resp_xs">

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Make Year <span class="required">*</span> : </label>
      <input type="text" name="bmin_makeyear" class="form-control number" placeholder="Make year" value="<?php echo !empty($equip_data[0]->bmin_makeyear)?$equip_data[0]->bmin_makeyear:''; ?>"  maxlength="4" >
    </div>
  
    
    
</div>

<div class="clearfix"></div>

<div class="form-group resp_xs">
    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Risk <span class="required">*</span> : </label>

      <?php
      $bmin_riskid=!empty($equip_data[0]->bmin_riskid)?$equip_data[0]->bmin_riskid:'';
      // echo $deptype;
      // die();
      ?>

      <select name="bmin_riskid" class="form-control ">
        <option value="">---select---</option>

        <?php if($riskval_list):
        foreach ($riskval_list as $krv => $riskval):?>

        <option value="<?php echo $riskval->riva_riskid; ?>" <?php if($bmin_riskid==$riskval->riva_riskid) echo 'selected=selected'; ?>><?php echo $riskval->riva_risk; ?></option>

        <?php endforeach; endif; ?>
      </select>

    </div>


    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Equip. Operational: </label>

      <?php $bmin_equip_oper=!empty($equip_data[0]->bmin_equip_oper)?$equip_data[0]->bmin_equip_oper:''; ?>

      <select name="bmin_equip_oper" class="form-control">
       <option value="Yes" >Yes</option>
        <option value="No" <?php if($bmin_equip_oper=='No') echo "selected=selected"; ?>>No</option>
       
      </select>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Manufacturer: </label>

      <?php
      $bmin_manufacturerid=!empty($equip_data[0]->bmin_manufacturerid)?$equip_data[0]->bmin_manufacturerid:'';
      // echo $deptype;
      // die();
      ?>

      <select name="bmin_manufacturerid" class="form-control ">
        <option value="">---select---</option>

        <?php if($manufacturer_list):
        foreach ($manufacturer_list as $kml => $manufacturer):?>

        <option value="<?php echo $manufacturer->manu_manlistid; ?>" <?php if($bmin_manufacturerid==$manufacturer->manu_manlistid) echo 'selected=selected'; ?>><?php echo $manufacturer->manu_manlst; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </div>
</div>

    <div class="clearfix"></div>

<div class="form-group resp_xs">
    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Distributor: </label>

      <?php 
      $bmin_distributorid=!empty($equip_data[0]->bmin_distributorid)?$equip_data[0]->bmin_distributorid:'';
      // echo $deptype;die();
      ?>

      <select name="bmin_distributorid" class="form-control " >
        <option value="">---select---</option>

        <?php if($distributor_list):
        foreach ($distributor_list as $kdl => $distrubutor):?>

        <option value="<?php echo $distrubutor->dist_distributorid; ?>" <?php if($bmin_distributorid==$distrubutor->dist_distributorid) echo 'selected=selected'; ?>><?php echo $distrubutor->dist_distributor; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">AMC  : </label><br>

      <?php
      $bmin_amc=!empty($equip_data[0]->bmin_amc)?$equip_data[0]->bmin_amc:'';
      // echo $deptype;
      // die();
      ?>

      <input type="radio" class="mbtm_13" name="bmin_amc" value="Y" <?php if($bmin_amc=='Y') echo "checked=checked"; ?>  >Yes
      <input type="radio" class="mbtm_13" name="bmin_amc" value="N" checked="checked" >No
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Installation Date: </label>
      <?php
      if(DEFAULT_DATEPICKER=='NP')
      {
        $servicedate=!empty($equip_data[0]->bmin_servicedatebs)?$equip_data[0]->bmin_servicedatebs:'';
        $warrenty_date=!empty($equip_data[0]->bmin_endwarrantydatebs)?$equip_data[0]->bmin_endwarrantydatebs:'';
      }
      else
      {
        $servicedate=!empty($equip_data[0]->bmin_servicedatead)?$equip_data[0]->bmin_servicedatead:'';
        $warrenty_date=!empty($equip_data[0]->bmin_endwarrantydatead)?$equip_data[0]->bmin_endwarrantydatead:'';
      }

       ?>
      <input type="text" name="bmin_servicedate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="<?php echo !empty($servicedate)?$servicedate:DISPLAY_DATE; ?>" id="ServiceStart">
      <span class="errmsg"></span>
    </div>
</div>

  <div class="clearfix"></div>

<div class="form-group resp_xs">

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Warrenty Date : </label>
      <input type="text" name="bmin_endwarranty" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service End Date"  value="<?php echo !empty($warrenty_date)?$warrenty_date:DISPLAY_DATE_NEXT_YR; ?>" id="WarrentyEnd">
       <span class="errmsg"></span>
    </div>
    


    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">AMC Contractor  : </label>

      <?php $distrubutorpe= !empty($equip_data[0]->bmin_amcontractorid)?$equip_data[0]->bmin_amcontractorid:'';?>

      <select name="bmin_amcontractorid" class="form-control " >
        <option value="">---select---</option>

        <?php if($distributor_list):
        foreach ($distributor_list as $kdl => $distrubutor):?>

        <option value="<?php echo $distrubutor->dist_distributorid; ?>" <?php if($distrubutorpe==$distrubutor->dist_distributorid) echo 'selected=selected'; ?>><?php echo $distrubutor->dist_distributor; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Manual: </label>

      <?php 
      $bmin_isope= !empty($equip_data[0]->bmin_isoperation)?$equip_data[0]->bmin_isoperation:'';
      $bmin_ismaintenance= !empty($equip_data[0]->bmin_ismaintenance)?$equip_data[0]->bmin_ismaintenance:''; ?>
      <br>

      <input type="checkbox" class="mbtm_13" name="bmin_isoperation" value="Y" <?php if($bmin_isope!='' || $bmin_isope!='' || $bmin_isope=='Y') echo "checked=checked"; ?>>Opera.
      <input type="checkbox" class="mbtm_13" name="bmin_ismaintenance" value="Y" <?php if($bmin_ismaintenance!='' || $bmin_ismaintenance!='' || $bmin_ismaintenance=='Y') echo "checked=checked"; ?>>Maint.
    </div>
</div>

  <div class="clearfix"></div>

<div class="form-group resp_xs">
    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="Purchase/Donate">Source: </label>

      <?php 
      $bmin_purch_donated=!empty($equip_data[0]->bmin_purch_donatedid)?$equip_data[0]->bmin_purch_donatedid:'';
      //echo $deptype;
      // die();
      ?>

      <select name="bmin_purch_donatedid" class="form-control " id="purchaseCost">
        <option value="">---Select---</option>

        <?php if($purchase_donate):
        foreach ($purchase_donate as $kpd => $purdo):?>

        <option value="<?php echo $purdo->pudo_purdonatedid; ?>" <?php if($bmin_purch_donated==$purdo->pudo_purdonatedid) echo 'selected=selected'; ?>><?php echo $purdo->pudo_purdonated; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </div>
   <!--  <div class="clearfix"></div> -->

    <div id="donatediv" style="display: none;">
         <div class="col-md-4 col-sm-6 col-xs-6">
        <label>Donated Org.</label>
        <input type="text" name="bmin_donateorg" class="form-control" id="donateOrg" value="<?php echo !empty($equip_data[0]->bmin_donateorg)?$equip_data[0]->bmin_donateorg:''; ?>">
       </div>
         <div class="col-md-4 col-sm-6 col-xs-6">
        <label>Donated Address.</label>
        <input type="text" name="bmin_donateaddress" class="form-control" value="<?php echo !empty($equip_data[0]->bmin_donateaddress)?$equip_data[0]->bmin_donateaddress:''; ?>" >
       </div>
         <div class="col-md-4 col-sm-6 col-xs-6">
           <?php
      if(DEFAULT_DATEPICKER=='NP')
      {
        $donatedate=!empty($equip_data[0]->bmin_donatedatenp)?$equip_data[0]->bmin_donatedatenp:'';
      }
      else
      {
        $donatedate=!empty($equip_data[0]->bmin_donatedatead)?$equip_data[0]->bmin_donatedatead:'';
      }

       ?>

        <label>Donated Date.</label>
        <input type="text" name="bmin_donatedate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Donate Date" value="<?php echo !empty($donatedate)?$donatedate:DISPLAY_DATE; ?>" id="DonateDate">
      <span class="errmsg"></span>
       </div>
</div>

    

<div class="col-md-4 col-sm-6 col-xs-6">
      <div class="row">
        <div class="col-xs-7 donateCost" style="display: none;">
          <label for="example-text">Cost : </label>
          <input type="text"  name="bmin_cost" class="form-control float" value="<?php echo !empty($equip_data[0]->bmin_cost)?$equip_data[0]->bmin_cost:''; ?>" placeholder="Cost">
        </div>
        <div class="col-xs-5 donateCost" style="display: none;">
          <label for="example-text">&nbsp;</label>

          <?php 
          $bmin_currencytypeid=!empty($equip_data[0]->bmin_currencytypeid)?$equip_data[0]->bmin_currencytypeid:'';
          //echo $bmin_currencytypeid;die();
          ?>

          <select name="bmin_currencytypeid" class="form-control">

            <?php if($currencry):
            foreach ($currencry as $kdl => $curr):
            ?>

            <option value="<?php echo $curr->cuty_currencytypeid; ?>" <?php if($bmin_currencytypeid==$curr->cuty_currencytypeid) echo 'selected=selected'; ?>><?php echo $curr->cuty_currencytypename; ?></option>

            <?php endforeach; endif; ?>
          </select>
        </div>
      </div>
    </div>
</div>

    <div class="clearfix"></div>
   
<div class="form-group resp_xs">

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Bill No : </label>
      <input type="text" id="bmin_billno" name="bmin_billno" class="form-control " value="<?php echo !empty($equip_data[0]->bmin_billno)?$equip_data[0]->bmin_billno:''; ?>" placeholder="Bill No">
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Bill Attachment : </label>
      <div class="dis_tab">
        <input type="file" name="bmin_billattachment" class="form-control" >

        <?php if(!empty($equip_data[0]->bmin_billattachment)): ?>
        
        <input type="hidden" name="bmin_old_billattachment" value="<?php echo $equip_data[0]->bmin_billattachment?>">
        <a href="<?php echo base_url(BILL_ATTACHMENT_PATH).'/'.$equip_data[0]->bmin_billattachment; ?>" target="_blank" class="table-cell frm_add_btn width_30" title="Download"><i class="fa fa-download"></i></a>

        <?php endif; ?>
      </div>
      
      

     
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Known Person Attachment: </label>
      <div class="dis_tab">
        <input type="file" name="bmin_personattachment" class="form-control" >
        
        <?php if(!empty($equip_data[0]->bmin_personattachment)): ?>
        <input type="hidden" name="bmin_old_personattachment" value="<?php echo $equip_data[0]->bmin_billattachment?>">
        <a href="<?php echo base_url(KNOWN_ATTACHMENT_PATH).'/'.$equip_data[0]->bmin_personattachment; ?>" target="_blank" class="table-cell frm_add_btn width_30" title="Download"><i class="fa fa-download"></i></a>

        <?php endif; ?>
      </div>

    </div>

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Known Person Name: </label>

      <input type="text"  name="bmin_known_person" class="form-control personname " value="<?php echo !empty($equip_data[0]->bmin_known_person)?$equip_data[0]->bmin_known_person:''; ?>" placeholder="Person name">
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text">Known Person's Email: </label>

      <input type="text"  name="bmin_known_person_email" class="form-control personemail " value="<?php echo !empty($equip_data[0]->bmin_known_person_email)?$equip_data[0]->bmin_known_person_email:''; ?>" placeholder="Person email">
    </div>

  </div>

  <div class="form-group resp_xs">
    <div class="col-sm-6 col-xs-6">
      <label>Accessories</label>
      <textarea style="width: 100%" name="bmin_accessories" placeholder="Accessories" ><?php echo !empty($equip_data[0]->bmin_accessories)?$equip_data[0]->bmin_accessories:''; ?></textarea>
    </div>
    <div class="col-sm-6 col-xs-6">
      <label>Comment</label>
      <textarea style="width: 100%" name="bmin_comments" placeholder="Comment"><?php echo !empty($equip_data[0]->bmin_comments)?$equip_data[0]->bmin_comments:''; ?></textarea>
    </div>
    <div class="col-md-4">
      <input type="checkbox"  value="Y" name="bmin_isprintsticker" id="is_printsticker"> <label>Is Print Sticker</label>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($equip_data)) || (!empty($equip_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
        <button type="submit" class="btn btn-info mtop_0  save" data-operation='<?php echo !empty($equip_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($equip_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>


      <?php if(!empty($equip_data)): ?>

      <a href="javascript:void(0)" data-reloadform="<?php echo base_url('biomedical/bio_medical_inventory/form_bio_inventory') ?>" class="btn btn-danger btnreset">Reset</a>

      <?php endif; ?>
    </div>
    <div class="col-md-12">
      <div  class="alert-success success"></div>
      <div class="alert-danger error"></div>
    </div>
  </div>
</form>

<div class="showBarcode"></div>



<?php 
if(!empty($equip_data)):
?>
<script type="text/javascript">
    $('#bmin_equipmenttypeid').change();
    // $('#departmentid').change();
    setTimeout(function(){$('#purchaseCost').change()},500);
  
    var roomid='<?php echo !empty($equip_data[0]->bmin_roomid)?$equip_data[0]->bmin_roomid:''; ?>';
    var descriptionid='<?php echo !empty($equip_data[0]->bmin_descriptionid)?$equip_data[0]->bmin_descriptionid:''; ?>';
    // alert(roomid);
    if(descriptionid)
    {
      setTimeout(function(){
             // $(".equipmentdescform").find('option[value="' + descriptionid + '"]').attr("selected", "selected");
              $(".equipmentdescform").val(descriptionid);
         },1200);
    }
    if(roomid)
    {
      setTimeout(function(){
          $("#bmin_roomid").val(roomid);
           },2000);

    }
</script>
<?php endif; ?>

<script type="text/javascript">
  $(document).off('change','#departmentid');
  $(document).on('change','#departmentid',function(){
      //   var equipment=$(this).val();
    var action=base_url+'biomedical/equipments/check_for_incharge';
    var depid=$('#departmentid').val();
    //alert(valued);
    $.ajax({
          type: "POST",
          url: action,
          data:{depid:depid},
          dataType: 'json',
         success: function(response) 
          {            
            console.log(response);
            // console.log('t'+response.datas);

            if(response.status=='success')
            {
              if(response.datas)
              {
              var db_pname=response.datas[0].PersonName;
             var db_pemail=response.datas[0].Email;
              $('.personname').val(db_pname);
              $('.personemail').val(db_pemail);
              }
            }

          }
      });
    })
</script>


  <?php if(($this->session->userdata(USER_ACCESS_TYPE)=='S') && empty($equip_data) ): ?>
    <script type="text/javascript">
      // alert('test');
      setTimeout(function(){
            $('#bmin_equipmenttypeid').change();
      },500);
  
    </script>
  <?php endif; ?>



<script type="text/javascript">
  $(document).off('change','.codegen');
  $(document).on('change','.codegen',function(e){
  var deptid=$('#departmentid').val();
  // alert(deptid);
  var desc=$('#descriptionid').val();
  // alert(desc);
  var action_url=base_url+'biomedical/bio_medical_inventory/generate_equipment_code_nphl';
  $.ajax({
          type: "POST",
          url: action_url,
          data:{depid:deptid,desc:desc},
          dataType: 'json',
         success: function(response) 
          {            
            console.log(response);
            // console.log('t'+response.datas);

            if(response.status=='success')
            {
             $('#equipmentid').val(response.data);
            }

          }
      });
  return false;
});

  
</script>