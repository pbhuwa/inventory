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
        $searchdtype=$this->input->post('purdatetype');
            if($searchdtype=='range'){
                $frmDate=$this->input->post('fromdate');
                $toDate=$this->input->post('todate');
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
                    <!-- <td width="33%"><strong>Branch</strong> : <?php echo $locname; ?> </td> -->
                     <td width="33%" ><strong>School</strong> :
                    <?php 
                    $schoolid=$this->input->post('school');
                    if(!empty($schoolid)): 
                       $school_result= $this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$schoolid));
                       if(!empty($school_result)){
                        $school_name=!empty($school_result[0]->loca_name)?$school_result[0]->loca_name:'';
                       }
                    ?>
                      <?php else:$school_name='All';endif; ?>
                      <?php echo $school_name; ?>
                    </td>
        
                    <td align="center" width="34%" style="display:inline-block;margin: auto;"><strong><?php echo !empty($report_type)?$report_type:''; ?></strong></td>
                    
                     <td width="33%"><strong>Department</strong> :
                      <?php 
                      $depid=$this->input->post('departmentid');
                      $subdepid=$this->input->post('subdepid');
                      if(!empty($depid)){
                          $department=$depid;
                          if($subdepid){
                              $department=$subdepid;
                          }
                      $check_parentid=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$department),'dept_depname','ASC');
                      $dep_parent_dep_name='';
                      $sub_depname='';          
                     if(!empty($check_parentid)){
                      $dep_parentid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
                      $dep_parent_dep_name=!empty($check_parentid[0]->dept_depname)?$check_parentid[0]->dept_depname:'';
                        if($dep_parentid!=0){
                        $sub_department=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$dep_parentid),'dept_depname','ASC');
                        if(!empty($sub_department)){
                          $sub_depname=!empty($sub_department[0]->dept_depname)?$sub_department[0]->dept_depname:'';
                      }
                    }   
                  }

                      if(!empty($sub_depname)){
                        echo $sub_depname.'('.$dep_parent_dep_name.')';
                      }else{
                        echo $dep_parent_dep_name;
                      }     
                      }
                      else{
                      echo "All";    
                      }
                        
                  ?>
                    </td>
                </tr>
                <tr>
                 
                    <td width="33%"><strong>Supplier</strong> 
                     <?php 
                    $supplierid=$this->input->post('asen_distributor');
                    if(!empty($supplierid)): 
                       $supplier_result= $this->general->get_tbl_data('dist_distributor','dist_distributors',array('dist_distributorid'=>$supplierid));
                       if(!empty($supplier_result)){
                        $supplier_result=!empty($supplier_result[0]->dist_distributor)?$supplier_result[0]->dist_distributor:'';
                       }
                    ?>
                      <?php else:$supplier_result='All';endif; ?>
                      <?php echo $supplier_result; ?>
                  </td>
                    <td align="center" width="34%"> </td>
                    <td width="33%"><strong>Assets Category</strong> :
                      <?php 
                      $asset_category=$this->input->post('asset_category');
                      $asset_result=$this->general->get_tbl_data('*','eqca_equipmentcategory',array('eqca_isnonexp'=>'Y','eqca_equipmentcategoryid'=>$asset_category),'eqca_category','ASC');
                      if(!empty($asset_result)){
                        echo !empty($asset_result[0]->eqca_category)?$asset_result[0]->eqca_category:'';
                    
                    }else{
                        echo "All";
                    }
                      ?>
                      </td>
                </tr>
                <tr>
                    
                    <td width="33%" ><strong>Received by</strong>:
                     <?php 
                    
                    $recm_receivedby=$this->input->post('asen_staffid');
                   
                    if(!empty($recm_receivedby)): 
                     $arrlist=explode(',', $recm_receivedby);
                     if(!empty($arrlist)){
                        $arstaff_id=!empty($arrlist[0])?$arrlist[0]:'';
                         $staff_result= $this->general->get_tbl_data('stin_fname,stin_mname,stin_lname','stin_staffinfo',array('stin_staffinfoid'=>$arstaff_id));
                         $fname=!empty($staff_result[0]->stin_fname)?$staff_result[0]->stin_fname:'';
                         $mname=!empty($staff_result[0]->stin_mname)?$staff_result[0]->stin_mname:'';
                         $lname=!empty($staff_result[0]->stin_lname)?$staff_result[0]->stin_lname:'';

                         echo $fname.' '.$mname. ' '.$lname;

                     }  
                      endif; 
                    ?>
                    </td>
                    <td width="34%"></td>
                </tr>
            </tbody>
        </table>
    </div>