<?php 
$patientid=$this->session->userdata('patientid');
if($patientid):
$patientinfo=$this->general->getpatieninfo($patientid);
$patientvisit=$this->general->getlastvisit($patientid);
// echo "<pre>";
// print_r($patientinfo);
// die();
if($patientinfo && ($this->uri->segment(1)!='')):
?>
<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box patient_info">

                            <div class="row">
                                <div class="col-sm-2">
                                    <figure><img src="<?php echo base_url(); ?>assets/template/images/profile-default-male.png" alt=""></figure>
                                </div>
                                <div class="col-sm-4">
                                    <ul>
                                        <li><label>Patient ID</label>: <?php echo !empty($patientinfo->pama_patientid)?$patientinfo->pama_patientid:''; ?></li>
                                        <li><label>patient Name</label>: <?php echo !empty($patientinfo->pama_patientname)?$patientinfo->pama_patientname:''; ?></li>
                                        <li><label>Age / Gender</label>: <?php echo $patientinfo->pama_age.''.$patientinfo->pama_agetype[0].'/'.$patientinfo->pama_gender; ?></li>
                                        <li><label>Address</label>: Lamjung</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <ul>
                                        <li><label>Visit Count</label>: <?php echo $patientinfo->pama_visitcount; ?></li>
                                        <li><label>Last Vi.Date</label>: <?php $visitdate=!empty($patientvisit->pavi_visitdate)?$patientvisit->pavi_visitdate:''; $visittime=!empty($patientvisit->pavi_visittime)?$patientvisit->pavi_visittime:''; echo $visitdate.'-'.$visittime; ?></li>
                                        <li><label>Visit Dep.</label>: --</li>
                                        <li><label>Doctor</label>: --</li>
                                    </ul>
                                </div>
                                <div class="col-sm-2 text-right">
                                    
                                </div>
                            </div>
                         <!-- <table class="table table-border">
                             <tr>
                                 <td><label>Patient ID</label></td>
                                 <td><?php echo !empty($patientinfo->pama_patientid)?$patientinfo->pama_patientid:''; ?></td>
                                 <td><label>Patient Name</label></td>
                                 <td><?php echo !empty($patientinfo->pama_patientname)?$patientinfo->pama_patientname:''; ?></td>
                                 <td><label>Age/Gender</label></td>
                                 <td><?php echo $patientinfo->pama_age.''.$patientinfo->pama_agetype[0].'/'.$patientinfo->pama_gender; ?></td>
                                 <td><label>Address</label></td>
                                 <td>Lamjung</td>
                             </tr>
                              <tr>
                                 <td><label>Visit Count</label></td>
                                 <td><?php echo $patientinfo->pama_visitcount; ?></td>
                                 <td><label>Last Vi.Date/Time</label></td>
                                 <td><?php $visitdate=!empty($patientvisit->pavi_visitdate)?$patientvisit->pavi_visitdate:''; $visittime=!empty($patientvisit->pavi_visittime)?$patientvisit->pavi_visittime:''; echo $visitdate.'-'.$visittime; ?></td>
                                 <td><label>Visit Dep.</label></td>
                                 <td>Neuro surgery</td>
                                 <td><label>Doctor</label></td>
                                 <td>--</td>
                             </tr>
                         </table> -->
                        </div>
                    </div>
                </div>




    <?php endif; endif;  ?>


                <div id="ModalPatientSrch" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg patient-search-modal">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Patient Search</h4>
                      </div>
                      <div class="modal-body" id="PatientSearchDiv">
                      
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>

                  </div>
                </div>

<script type="text/javascript">
$('.btn_p_search').off('click');
$('.btn_p_search').on('click',function(){
var loadurl=base_url+'/patients/loadpatient';
$('#ModalPatientSrch').modal('show');
$('#PatientSearchDiv').load(loadurl+'/');  

})
</script>