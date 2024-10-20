 <style type="text/css">
    .sub-header td {
        padding:2px 5px;
        vertical-align: top;
        display: inline-flex;
        align-items: baseline;
        font-size: 12px
    }
    .sub-header td strong {
        padding-right: 3px
    }
    .sub-header-div {
        margin:0px 0 10px !important;
        padding:8px 5px;
        background: #eaeaea;
        border-top: 1px solid;
    }

</style>
 <?php 
        $searchdtype=$this->input->post('searchDateType');
            if($searchdtype=='date_range'){
                $frmDate=$this->input->post('frmDate');
                $toDate=$this->input->post('toDate');
                $range=$frmDate.'-'.$toDate;
            }else{
                $range='All';
            }
            
         ?>

        <table width="100%" style="margin: -15px 0 10px 0;">
          <tr>
            <td width="33%"></td>
            <td align="center" width="34%"><strong>Date Range</strong> : <?php echo $range; ?></td>
            <td width="33%"></td>
          </tr>
        </table>
        <div class="sub-header-div">
        <table style="width: 100%" class="organizationInfo sub-header">
            <tbody>
                <tr>
                    <?php 
                        $locationid=$this->input->post('locationid');
                    if(!empty($locationid)): 
                       $loca_result= $this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
                       if(!empty($loca_result)){
                        $locname=!empty($loca_result[0]->loca_name)?$loca_result[0]->loca_name:'';
                       }
                    ?>
            
                    <?php else:$locname='All';endif; ?>
                    <td width="33%"><strong>Branch</strong> : <?php echo $locname; ?> </td>
        
                    <td align="center" width="34%" style="display:inline-block;margin: auto;"><strong><?php echo !empty($report_type)?$report_type:''; ?></strong></td>
                    
                    <td width="33%"><strong>Supplier</strong> 
                       <?php 
                      $supplierid=$this->input->post('supplierid');
                      if(!empty($supplierid)): 
                         $supplier_result= $this->general->get_tbl_data('dist_distributor','dist_distributors',array('dist_distributorid'=>$supplierid));
                         if(!empty($supplier_result)){
                          $supplier_result=!empty($supplier_result[0]->dist_distributor)?$supplier_result[0]->dist_distributor:'';
                         }
                      ?>
                        <?php else:$supplier_result='All';endif; ?>
                        <?php echo $supplier_result; ?>
                    </td>
                    
                </tr>
                <tr>
                   <td width="33%"><strong>Material</strong> :
                    <?php 
                    $mattypeid=$this->input->post('puro_mattypeid');
                    if(!empty($mattypeid)){
                    $mat_result=$this->general->get_tbl_data('maty_material','maty_materialtype',array('maty_materialtypeid'=>$mattypeid));
                    if(!empty($mat_result)){
                        echo !empty($mat_result[0]->maty_material)?$mat_result[0]->maty_material:'';
                    }
                    }else{
                        echo "All";
                    }
                    ?>
                    </td>
                    <td align="center" width="34%"> </td>
                    <td width="33%">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>