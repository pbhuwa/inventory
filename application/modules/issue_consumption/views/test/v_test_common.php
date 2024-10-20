<div class="row wb_form">
  <div class="col-sm-12">
    <div class="white-box">
     <h3 class="box-title"><?php echo $this->lang->line('received_test_details'); ?></h3>
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
            <?php  $this->load->view('common/v_common_tab_header'); ?>
            
          </div>
        </div>
      </div>
      <div class="ov_report_tabs page-tabs pad-5 margin-top-220 tabbable">

        <?php if($tab_type == 'issuedetails'):?>
          <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='issuedetails') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_received_test_list');?>
            </div>
          </div>
        <?php endif; ?>

        <?php if($tab_type == 'report'):?>
          <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='report') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_issue_vs_expenses_report');?>
            </div>
          </div>
        <?php endif; ?>
        <?php if($tab_type == 'cat_report'):?>
          <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='cat_report') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_category_wise_report_form');?>
            </div>
          </div>
        <?php endif; ?>
        <?php if($tab_type == 'item_report'):?>
          <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='item_report') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_items_wise_report_form');?>
            </div>
          </div>
        <?php endif; ?>
        <?php if($tab_type == 'dep_report'):?>
          <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='dep_report') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_departmant_wise_report_form');?>
            </div>
          </div>
        <?php endif; ?>
        <?php if($tab_type == 'date_report'):?>
          <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='date_report') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_date_wise_report_form');?>
            </div>
          </div>
        <?php endif; ?>
        <?php if($tab_type == 'testitemlist'):?>
          <div id="dtl_testitemlist" class="tab-pane fade in <?php if($tab_type=='testitemlist') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_test_item_list');?>
            </div>
          </div>
        <?php endif; ?>
        <?php if($tab_type == 'editform'):?>
          <div id="dtl_editform" class="tab-pane fade in <?php if($tab_type=='editform') echo "active"; ?>">
            <div  id="FormDiv_editform" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_test_item_edit');?>
            </div>
          </div>
        <?php endif; ?>
          <?php if($tab_type == 'search_details'):?>
          <div id="dtl_itemsearch" class="tab-pane fade in <?php if($tab_type=='search_details') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_test_map_item_search');?>
            </div>
          </div>
        <?php endif; ?>
        <?php if($tab_type == 'search_details_department_wise'):?>
          <div id="dtl_dep_wiseiem_search" class="tab-pane fade in <?php if($tab_type=='search_details_department_wise') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_test_map_item_search_department_wise');?>
            </div>
          </div>
        <?php endif; ?>
        <?php if($tab_type == 'stock_list'):?>
          <div id="dtl_dep_wiseiem_search" class="tab-pane fade in <?php if($tab_type=='stock_list') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_reagent_dep_stock');?>
            </div>
          </div>
        <?php endif; ?>
         <?php if($tab_type == 'test_item_stock'):?>
          <div id="dtl_dep_wiseiem_search" class="tab-pane fade in <?php if($tab_type=='test_item_stock') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('test/v_test_stock_department_wise');?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</div>
<script>
  $(document).off('click','.view2');
$(document).on('click','.view2',function(){
  var id=$(this).data('id');
      // alert(id);
      var action=$(this).data('viewurl');
      var heading=$(this).data('heading');
      var postdata={};
      // alert(action);
      var storeid=$(this).data('storeid');
      var location=$(this).data('locationid');
      var store_id=$(this).data('store_id');
      var fiscal_year=$(this).data('fyear');
      var yrs=$(this).data('yrs');
      var month=$(this).data('month');
      var appstatus=$(this).data('appstatus');
      var invoiceno = $(this).data('invoiceno');
      var fromDate=$(this).data('fromdate');
      var toDate=$(this).data('todate');
      var type=$(this).data('type');//this is for loading transfer data into popup

      if(storeid)
      {
        postdata={id:id,storeid:storeid,type:type};// In case of Store 
      }
      else
      {
        postdata={type:type,fromDate:fromDate,toDate:toDate,id:id,appstatus:appstatus,fiscal_year:fiscal_year,store_id:store_id,location:location,month:month,yrs:yrs, invoiceno:invoiceno};
      }
      $('#myView2').modal('show');
      $('#MdlLabel2').html(heading);

      $.ajax({
        type: "POST",
        url: action,
        data:postdata,
        dataType: 'html',
        beforeSend: function() {
          $('.overlay').modal('show');
        },
        success: function(jsons) 
        {

         data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
          console.log(data.tempform);
          $('.displyblock2').html(data.tempform);
        }  
        
        else{
          alert(data.message);
        }
        $('.overlay').modal('hide');
      }
    });
    })

</script>