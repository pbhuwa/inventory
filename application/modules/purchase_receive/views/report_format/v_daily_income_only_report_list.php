<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>

        <div class="table-responsive">
            <h2>आम्दानी तर्फ</h2>
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th colspan="10">बजार खरीद</th>
                    </tr>
                     </thead>
                    <?php 
                        if(!empty($daily_market_income_master)): 
                        foreach($daily_market_income_master as $kdm =>$dincome ):
                            $recmasterid=$dincome->recm_receivedmasterid;
                            $mar_income_detail=$this->report_mdl->daily_market_income_master_detail($recmasterid);

                        ?>
                        <table class="alt_table">
                        <tr>
                        <td colspan="2"><strong>Branch:</strong><?php echo $dincome->loca_name; ?></td>
                        <td colspan="2"><strong>Invoice No:</strong><?php echo $dincome->recm_invoiceno; ?></td>
                        <td colspan="2"><strong>Sup.:</strong><?php echo $dincome->dist_distributor; ?></td>
                        <td colspan="2"><strong>Sup.Bill No:</strong><?php echo $dincome->recm_supplierbillno; ?></td>
                        <td colspan="2"><strong>PO No.:</strong><?php echo $dincome->recm_purchaseorderno; ?></td>
                        </tr>
                        <tr>
                        <td><strong>Amount:</strong><?php echo $dincome->recm_amount; ?></td>
                        
                        <td><strong>Insurance:</strong><?php echo $dincome->recm_insurance; ?></td>
                        <td><strong>Carr.Freight:</strong><?php echo $dincome->recm_carriagefreight; ?></td>
                        <td><strong>Packing:</strong><?php echo $dincome->recm_packing; ?></td>
                        <td><strong>Tran.Courier:</strong><?php echo $dincome->recm_transportcourier; ?></td>
                        <td><strong>Other:</strong><?php echo $dincome->recm_others; ?></td>
                        <td><strong>Discount:</strong><?php echo $dincome->recm_discount; ?></td>
                        <td><strong>Tax:</strong><?php echo $dincome->recm_taxamount; ?></td>
                        <td><strong>G.Total:</strong><?php echo $dincome->recm_clearanceamount; ?></td>
                        </tr>
                        <?php
                        if(!empty($mar_income_detail)):
                            $i=1;
                            ?>
                            <table class="alt_table">
                            <tr>
                                <td>S.n.</td>
                                <td>Item Code</td>
                                <td>Item Name</td>
                                <th>Unit</th>
                                <th>Category</th>
                                <td>Qty</td>
                                <td>Unit Price</td>
                                <td>VAT</td>
                                <td>Total</td>

                            </tr>
                            <?php
                            foreach ($mar_income_detail as $kid => $mind) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $mind->itli_itemcode; ?></td>
                                <td><?php echo $mind->itli_itemname; ?></td>
                                <td><?php echo $mind->eqca_category; ?></td>
                                <td><?php echo $mind->unit_unitname; ?></td>
                                <td><?php echo $mind->recd_purchasedqty; ?></td>
                                <td><?php echo $mind->recd_unitprice; ?></td>
                                <?php 
                                    $vatper=($mind->recd_vatpc)/100;
                                    $cost=($mind->recd_purchasedqty)*($mind->recd_unitprice);
                                    $totalcost=$cost*$vatper+$cost;
                                    
                                 ?>
                                <td><?php echo  $cost*$vatper; ?></td>
                                <td><?php echo  $totalcost;; ?></td>
                            </tr>
                            </table>
                            <?php
                            $i++;
                            }
                        endif;
                        ?>
                        </table>
                   
                   <table class="alt_table"><tr><td colspan="9"></td></tr></table>
                <?php endforeach; endif; ?>
            </table>
             <table class="table table-striped alt_table">
                <thead>
                    <tr><td> हस्तान्तरण  </td></tr>
                </thead>
            </table>

           
        </div>
    </div>
</div>
