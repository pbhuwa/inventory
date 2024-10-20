<div class="row wb_form">
   <div class="col-sm-12">
      <div class="white-box">
         <div class="ov_report_tabs pad-5 tabbable">
            <div class="margin-bottom-30">
               <div class="dropdown-tabs">
                  <div class="mobile-tabs">
                     <a href="#" class="tabs-dropdown_toogle">
                     <i class="fa fa-bar"></i>
                     <i class="fa fa-bar"></i>
                     <i class="fa fa-bar"></i>
                     </a>
                  </div>
                  <div class="self-tabs">
                     <?php  $this->load->view('common/v_report_header'); ?>   
                     <h3 class="box-title" style="text-align: center;"><?php echo $this->lang->line('received_detail_list'); ?></h3>
                  </div>
               </div>
            </div>
            <div class="ov_report_tabs page-tabs pad-5 margin-top-220 tabbable">
               <div class="pad-5">
                  <div class="table-responsive">
                     <table id="" class="format_pdf" width="100%">
                        <thead>
                           <tr class="tr_issue">
                              <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                              <th width="8%" ><?php echo $this->lang->line('received_date').'('.$this->lang->line('bs').')'; ?></th>
                              <th width="8%" ><?php echo $this->lang->line('received_date').'('.$this->lang->line('ad').')'; ?></th>
                              <th width="8%"><?php echo $this->lang->line('received_no'); ?></th>
                              <th width="6%"><?php echo $this->lang->line('no_of_item'); ?></th>
                              <th width="5%"><?php echo $this->lang->line('total_amount'); ?></th>
                              <th width="6%"><?php echo $this->lang->line('issued_by'); ?></th>
                              <th width="6%"><?php echo $this->lang->line('received_by'); ?></th>
                              <th width="4%"><?php echo $this->lang->line('req_no'); ?></th>
                              <th width="5%"><?php echo $this->lang->line('issue_time'); ?></th>
                              <th width="5%"><?php echo $this->lang->line('f_year'); ?> </th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $apptype = $this->input->get('apptype');
                        if($apptype == 'received' || $apptype =='receivedreturn' || empty($apptype) ){
                              if($searchResult): 
                              $i=1;
                              foreach($searchResult as $row):
                              ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo !empty($row->sama_billdatebs)?$row->sama_billdatebs:'';?></td>
                              <td><?php echo !empty($row->sama_billdatead)?$row->sama_billdatead:'';?></td>
                              <td><?php echo !empty($row->sama_invoiceno)?$row->sama_invoiceno:'';?></td>
                              <td><?php echo !empty($row->totcnt)?$row->totcnt:'';?></td>
                              <td><?php echo !empty($row->totalamt)?$row->totalamt:'';?></td>
                              <td><?php echo !empty($row->sama_username)?$row->sama_username:'';?></td>
                              <td><?php echo !empty($row->sama_receivedby)?$row->sama_receivedby:'';?></td>
                              <td><?php echo !empty($row->sama_requisitionno)?$row->sama_requisitionno:'';?></td>
                              <td><?php echo !empty($row->sama_billtime)?$row->sama_billtime:'';?></td>
                              <td><?php echo !empty($row->sama_fyear)?$row->sama_fyear:'';?></td>
                           </tr>
                           <?php
                              $i++;
                              endforeach;
                              endif;
                          }
                              ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>