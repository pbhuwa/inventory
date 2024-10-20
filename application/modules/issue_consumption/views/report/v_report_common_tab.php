<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">Issue Analysis Report</h3>
            <div  id="FormDiv_item" class="formdiv frm_bdy issue_cons">
                
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="tab" href="#home">Category Wise Issue</a></li>
                    <li><a data-toggle="tab" href="#menu2">Sub Category Wise Issue</a></li>
                    <li><a data-toggle="tab" href="#menu3">Item Wise Issue</a></li> 
                    <li><a data-toggle="tab" href="#menu4">Issue Book</a></li>
                    <li><a data-toggle="tab" href="#menu5">Issue Summary</a></li>
                    <li><a data-toggle="tab" href="#menu6">Issue Detail</a></li>
                </ul>
                    
                <div class="tab-content white-box pad-5">
                    <div id="home" class="tab-pane fade in active">
                        <h3>Category Wise Issue</h3>
                        <?php $this->load->view('report/v_categories');?>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <h3>Sub Category Wise Issue</h3>
                        <p><?php $this->load->view('report/v_sub_categories');?></p>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <h3>Item Wise Issue</h3>
                        <?php $this->load->view('report/v_itemswise');?>
                    </div>
                    <div id="menu4" class="tab-pane fade">
                        <h3>Issue Book Report</h3>
                        <?php $this->load->view('report/v_issue_book');?>
                    </div>
                    <div id="menu5" class="tab-pane fade">
                        <h3>Issue Summary</h3>
                        <?php $this->load->view('report/v_issue_summary');?>
                    </div>
                    <div id="menu6" class="tab-pane fade">
                        <h3>Issue Details</h3>
                        <?php $this->load->view('report/v_issue_details');?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div id="itemWiseReport">
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(".nav-pills a").click(function(){
        $(this).tab('show');
    });
</script>