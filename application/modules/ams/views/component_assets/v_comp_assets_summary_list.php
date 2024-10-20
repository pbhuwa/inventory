<div class="pad-5">
   <div class="row">
                 <div class="col-md-4">
                
                        <label>Network Components<span class="required">*</span>:</label>
                        <?php 
                            $comopnenttypeid=!empty($assets_data[0]->asen_component_typeid)?$assets_data[0]->asen_component_typeid:'';
                        ?>
                            <select class="form-control required_field " name="asen_component_typeid" id="ncomponentid">
                                <option value="0">---select---</option>
                                <?php 
                                    if($network_component_list):
                                        foreach ($network_component_list as $kcl => $nc):
                                ?>
                                <option value="<?php echo $nc->coty_id; ?>" <?php if($comopnenttypeid==$nc->coty_id) echo "selected=selected"; ?>> <?php echo $nc->coty_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                            </select>
                   
                
                
            </div>
             <div class="col-md-4">
                     <?php 
                            $assettypeid=!empty($assets_data[0]->asen_assettypeid)?$assets_data[0]->asen_assettypeid:'';
                        ?>
                     <label>Assets Type<span class="required">*</span>:</label>
                     <select class="form-control required_field" name="asen_assettypeid" id="assettypeid">
                         <option value="0">---select---</option>
                         <?php 
                                    if($assettype_list):
                                        foreach ($assettype_list as $ka => $al):
                                ?>
                                <option value="<?php echo $al->asty_astyid; ?>" <?php if($assettypeid==$al->asty_astyid) echo "selected=selected"; ?>> <?php echo $al->asty_typename; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                     </select>
                 </div>
                   <?php echo $this->general->location_option(3,'asen_locationid','asen_locationid'); ?>
                    <div class="col-md-1">
                      <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
             </div>
  <div class="table-responsive">
    <table id="myTable" class="table table-striped">
      <thead>
        <tr>
          <th width="10%">Assets ID</th>
          <th width="10%">Facility Code</th>
          <th width="10%">Component ID</th>
          <th width="10%">Branch</th>
          <th width="10%"><?php echo $this->lang->line('action'); ?></th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
 $(document).ready(function(){
  var ncomponentid=$('#ncomponentid').val();
  var assettypeid=$('#assettypeid').val();
  var asen_locationid=$('#asen_locationid').val();
  var srchtext=$('#srchtext').val();
  var dataurl = base_url+"ams/assets/get_comp_assets_list_summary";
  var message='';
  var dtablelist = $('#myTable').dataTable({
            "sPaginationType": "full_numbers"  ,
            
            "bSearchable": false,
            "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
            'iDisplayLength': 10,
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
            "aTargets": [ 0,4 ]
          }
          ],      
          "aoColumns": [
          { "data": "asen_assetcode"},
          { "data": "asen_ncomponentid"}, 
          { "data": "asen_faccode"},
          { "data": "loca_name"},
           { "data": "action" }
          
          ],
          "fnServerParams": function (aoData) {
            aoData.push({ "name": "asen_component_typeid", "value": ncomponentid });
            aoData.push({ "name": "assettypeid", "value": assettypeid });
            aoData.push({ "name": "asen_locationid", "value": asen_locationid });
          },


      // "fnRowCallback" : function(nRow, aData, iDisplayIndex){
      //        var oSettings = dtablelist.fnSettings();
      //       $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
      //       return nRow;
      //   },
      "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
       var oSettings = dtablelist.fnSettings();
       var tblid = oSettings._iDisplayStart+iDisplayIndex +1

       $(nRow).attr('id', 'listid_'+tblid);
     },
   }).columnFilter(
   {
    sPlaceHolder: "head:after",
    aoColumns: [ 
    { type: "text" },
    { type: "text" },
    { type: "text" },
    { type: "text" },
    { type: null },
    
    ]
  });

   $(document).on('click', '#searchByDate', function() {
     ncomponentid=$('#ncomponentid').val();
   assettypeid=$('#assettypeid').val();
   asen_locationid=$('#asen_locationid').val();
    dtablelist.fnDraw();
  });

 });
</script>
