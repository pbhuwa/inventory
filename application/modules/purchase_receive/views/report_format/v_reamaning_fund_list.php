<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
        <div class="table-responsive">
            <table class="table table-striped alt_table">
                <thead>
                
                  
                    <tr>
                    <th scope="col">जि.नं.</th>
                    <th scope="col" >खाता नं. </th>
                    <th scope="col" >सामानको कोड </th>
                    <th scope="col" >सामानको विवरण</th> 
                    <th scope="col" >इकाइ </th>
                    <th scope="col" >परिमाण  </th>
                    <th scope="col" >दर</th>
                    <th scope="col" >जम्मा </th>
                    <th scope="col" >कैफियत  </th>
                      
                    </tr>
                  
                </thead>
                 <tbody>
                <?php 
                $i=1;
                $gtotal=0;
                if(!empty($current_stock_rpt)): 
                foreach ($current_stock_rpt as $kcst => $stk):
                $gtotal +=$stk->tamount;
                ?>
                
                <tr>
                <td> <?php echo $i; ?></td>
                <td><?php echo $stk->trde_itemsid ?></td>
                <td><?php echo $stk->itli_itemcode; ?></td>
                <td><?php echo $stk->itli_itemname; ?></td>
                <td><?php echo $stk->unit_unitname; ?></td>
                <td align="right"><?php echo sprintf('%0.2f', round($stk->trde_issueqty, 2))   ?> </td>
                <td align="right"><?php echo sprintf('%0.2f', round($stk->trde_unitprice, 2)) ; ?> </td>
                <td align="right"><?php echo sprintf('%0.2f', round($stk->tamount, 2))  ?> </td>
                <td> </td>
                </tr>
            <?php 
            $i++;
            endforeach;
            endif; ?>
                </tbody>
                <tr>
                    <td colspan="7" align="right"><strong>Grand Total</strong></td>
                    <td align="right"><strong><?php echo sprintf('%0.2f', round($gtotal, 2))  ?></strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9"><?php echo $this->lang->line('in_words'); ?>:<?php echo $this->general->number_to_word($gtotal); ?></td>
                </tr>
            </table>
        </div>

       

        </div>

      
    </div>
</div>