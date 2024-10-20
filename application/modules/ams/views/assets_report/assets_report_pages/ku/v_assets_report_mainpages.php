<style type="text/css">
    .file {
        position: relative;
        margin-top: 25px;
    }
   
    .file label {
        background: #00653c;
        padding: 15px 20px;
        color: #fff;
        font-weight: 600;
        font-size: .9em;
        transition: all .4s;
        text-transform: capitalize;
    }
    .file input {
        position: absolute;
        display: inline-block;
        left: 0;
        top: 0;
        opacity: 0.01;
        cursor: pointer;
    }
    
    .file input:hover + label,
    
    .file input:focus + label {
        background: #34495E;
        color: #fff;
    }
    
    .assets-title h4{
        border-bottom: 1px solid #e2e2e2;
        padding-bottom: 5px;
        margin-bottom: 10px;
        padding-top: 5px;
        text-transform: capitalize;
        font-weight: 500;
        font-size: 16px;
    }
    
    .submit-btn{
        margin-top: 19px;
    }
    .assets-title + .assets-title{
        margin-top: 20px;
    }
</style>

<div class="tab-content" id="tabs">
    <div class="tab-pane active" id="asset_entryForm" >
        <?php $this->load->view('v_assets_entryreport');?>
    </div> 

 
    
</div>

