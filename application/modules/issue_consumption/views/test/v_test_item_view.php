<div class="form-group white-box pad-5 bg-gray">
    <div class="row">
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('test_item_id'); ?> : </label>
             <span>   <?php echo !empty($test_itemdata[0]->tena_mid)?$test_itemdata[0]->tena_mid:''; ?></span>
        </div>
    

          <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('item_code'); ?> : </label>
            <span>  <?php echo !empty($test_itemdata[0]->tena_code)?$test_itemdata[0]->tena_code:''; ?></span>
        </div>

          <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('item_name'); ?> : </label>
            <span><?php echo !empty($test_itemdata[0]->tena_name)?$test_itemdata[0]->tena_name:''; ?></span>
        </div>

  <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> : </label>
            <span> <?php 
        $db_asen_status=!empty($test_itemdata[0]->tena_isactive)?$test_itemdata[0]->tena_isactive:'';
        if($db_asen_status=='1'){
            $status="Active";
        } else {
            $status="InActive";
        }
        echo $status;
        ?></span>
        </div>
        <div class="col-md-4">
    <label for="example-text">Post Date(AD)</label>:
    <?php echo !empty($test_itemdata[0]->tena_postdatead)?$test_itemdata[0]->tena_postdatead:'' ?>
</div>
<div class="col-md-4">
    <label for="example-text">Post Date(BS)</label>:
    <?php echo !empty($test_itemdata[0]->tena_postdatebs)?$test_itemdata[0]->tena_postdatebs:'' ?>
</div>

    <div class="clearfix"></div>
</div>
 <table class="table table-striped menulist dataTable">
     <thead>
        <tr>
           <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
                    <th scope="col" width="25%"> <?php echo $this->lang->line('code'); ?>  </th>
                    <th scope="col" width="25%"> <?php echo $this->lang->line('particular'); ?> </th>
                    <th scope="col" width="15%">Amount</th>
                    <th scope="col" width="15%">Min Test Count </th>
                    <th scope="col" width="15%"> Max Test Count </th>
           </tr>
    </thead>

    <tbody>

   <?php if($itemmap):
   $i=1; 
   foreach ($itemmap as $kph => $map):?>
   

    <tr>
    <th><?php echo $i; ?></th>
    <td><?php echo $map->itli_itemcode; ?></td>
    <td><?php echo $map->itli_itemname; ?></td>
    <td><?php echo $map->tema_perml; ?></td>
    <td><?php echo $map->tema_mintestcount; ?></td>
    <td><?php echo $map->tema_maxtestcount; ?></td>
    <td></td>
</tr>
<?php $i++;  endforeach; endif; ?>
    </tbody>

</table>
