<div class="table-responsive">
        <table id="Dtables" class="table table-striped dataTable serverDatatable" data-tableid="#myTable">
            <thead>
                <tr>
                <th width="5%"><?php echo $this->lang->line('category'); ?></th>
                <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                <th width="10%"><?php echo $this->lang->line('opening'); ?></th>
                <th width="10%"><?php echo $this->lang->line('received'); ?></th>
                <th width="10%"><?php echo $this->lang->line('issue'); ?></th>
                <th width="10%"><?php echo $this->lang->line('balance'); ?></th>
                <th width="10%">
                    <?php
                        $cur_month_new = $this->lang->line(strtolower($cur_month));
                        $monthname_1_new = $this->lang->line(strtolower($monthname_1));
                        $monthname_2_new = $this->lang->line(strtolower($monthname_2));

                        echo $cur_month_new; 
                    ?>
                </th>
                <th width="10%"><?php echo $monthname_1_new; ?></th>
                <th width="10%"><?php echo $monthname_2_new; ?></th>
                <th width="10%"><?php echo $monthname_1_new.' ('.$this->lang->line('qty').')'; ?></th>
                <th width="10%"><?php echo $monthname_2_new.' ('.$this->lang->line('qty').')'; ?></th>
                <th width="10%"><?php echo $this->lang->line('req_no'); ?></th>
                <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($stock_requirement_list)):
                         foreach($stock_requirement_list as $key=>$list):
                       $listar[]=$list->categoryname;
                        endforeach;
                         $uniqueCat=array_unique($listar);
                       
                        foreach($stock_requirement_list as $key=>$list):
                            // $unique_catname=l
                            if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($list->itemnamenp)?$list->itemnamenp:$list->itemname;
                }else{ 
                    $req_itemname = !empty($list->itemname)?$list->itemname:'';
                }

                            
                            if(array_key_exists($key, $uniqueCat))
                            {
                                $catlist= $list->categoryname;
                            }
                            else
                            {
                                 $catlist='';
                            }
                            
                ?>
                    <tr>
                        <td>
                            <?php echo "<strong>".$catlist."</strong>"; //!empty($list->categoryname)?$list->categoryname:''; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->itemcode)?$list->itemcode:''; ?>
                        </td>
                        <td>
                            <?php echo $req_itemname; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->op_qty)?$list->op_qty:0; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->rec_qty)?$list->rec_qty:0; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->issue_qty)?$list->issue_qty:0; ?>
                        </td>
                        <td>
                            <?php 
                                $opening = !empty($list->op_qty)?$list->op_qty:0;
                                $received = !empty($list->rec_qty)?$list->rec_qty:0;
                                $issue = !empty($list->issue_qty)?$list->issue_qty:0;
                                $total = $opening + $received - $issue;
                                echo $total;
                            ?>
                        </td>
                        <td>
                            <?php echo !empty($list->cmonth1)?round($list->cmonth1,2):0; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->cmonth2)?round($list->cmonth2,2):0; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->cmonth3)?round($list->cmonth3,2):0; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->cmonth2_qty)?$list->cmonth2_qty:0; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->cmonth3_qty)?$list->cmonth3_qty:0; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->req_qty)?$list->req_qty:0; ?>
                        </td>
                        <td>
                            <?php echo !empty($list->purchaserate)?$list->purchaserate:0; ?>
                        </td>
                        <td>
                            <?php
                                $qty = !empty($list->req_qty)?$list->req_qty:'';
                                $rate = !empty($list->purchaserate)?$list->purchaserate:'';
                                echo $qty*$rate; ?>
                        </td>
                    </tr>    
                <?php
                        endforeach;
                    endif;
                ?>
            </tbody>
        </table>
    </div>