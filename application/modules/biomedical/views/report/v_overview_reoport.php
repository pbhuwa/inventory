<div class="clearfix"></div>
  <div class="white-box ov_report">
    <!-- <h3 class="box-title">Equipment Overview  Report</h3> -->
    <div class="row">
      <div class="col-sm-12">  
        <div class="pad-10" id="FormDiv_searchReports">
          <?php $this->load->view('report/v_overview_form') ;?>
        </div>
       <!--  <div class="col-sm-8">
          <?php //$this->load->view('bio_medical_inventory/v_bio_medical_list') ;?>
        </div>  -->  
      </div>
      <div id="FormDiv_PmData" class="search_pm_data">
        
      </div>
    </div>
  </div>
<script type="text/javascript">
 $(document).off('click','.btn_pdf');
     $(document).on('click','.btn_pdf',function(){
      var id =$(this).data('id');

      var redirecturl=base_url+'biomedical/reports/overview_reports_pdf'+'?=1';
        $.redirectPost(redirecturl, {id:id});
     })

    $(document).off('click','.btn_print');
     $(document).on('click','.btn_print',function(){
      $('#printrpt').printThis();
     })
</script>