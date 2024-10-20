<style>
.table>tbody>tr>td,
.table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important;
}
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php
        $category_to_hide = "";
        // echo $stock_new_type;
        //die();
        $this->load->view('common/v_report_header');

        if (!empty($stock_result)) :
            $grand_openqty = 0;
            $grand_opamt = 0;
            $grand_purqty = 0;
            $grand_puramt = 0;
            $grand_issqty = 0;
            $grand_issamt = 0;
            $grand_balanceqty = 0;
            $grand_balanceamt = 0;
            $db_array = array();

            foreach ($stock_result as $ci => $category) :

        ?>

        <?php

                if (!empty($category['stock_details'])) :

                ?>
        <div id="category_<?= $ci ?>">
            <div class="pad-5">
                <h4><?php echo $category['name']; ?></h4>
            </div>
            <table class="table table-striped alt_table">
                <thead>
                    <tr>
                        <th rowspan="2" width="5%">S.n</th>
                        <th rowspan="2" width="10%">Item code</th>
                        <th rowspan="2" width="20%">Item Name</th>
                        <th rowspan="2" width="10%">Unit</th>
                        <th colspan="3" width="15%" style="text-align:center;">Opening</th>
                        <th colspan="3" width="15%" style="text-align:center;">Purchase</th>
                        <th colspan="3" width="15%" style="text-align:center;">Issue</th>
                        <th colspan="3" width="15%" style="text-align:center;">Balance</th>
                    </tr>
                    <tr>
                        <th width="5%">Qty</th>
                        <th width="7%">Rate</th>
                        <th width="7%">Amount</th>
                        <th width="5%">Qty</th>
                        <th width="7%">Rate</th>
                        <th width="7%">Amount</th>
                        <th width="5%">Qty</th>
                        <th width="7%">Rate</th>
                        <th width="7%">Amount</th>
                        <th width="5%">Qty</th>
                        <th width="7%">Rate</th>
                        <th width="7%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                                $i = 1;
                                $sum_openqty = 0;
                                $sum_opamt = 0;
                                $sum_purqty = 0;
                                $sum_puramt = 0;
                                $sum_issqty = 0;
                                $sum_issamt = 0;
                                $sum_balanceqty = 0;
                                $sum_balanceamt = 0;
                                $is_empty = true;

                                foreach ($category['stock_details'] as $ksr => $srslt) :
                                    $ad_qty = 0;
                                    $ad_amount = 0;
                                    if (ORGANIZATION_NAME == 'NPHL') {
                                        if (!empty($srslt->auction_disposal_data)) {
                                            $ad_data = explode('@', $srslt->auction_disposal_data);
                                            $ad_qty = (float)$ad_data[0];
                                            $ad_amount = (float)$ad_data[1];
                                        }
                                    }
                                    $bal_qty = (float)($srslt->opqty + $srslt->purqty) - ($srslt->issqty + $ad_qty);
                                    $db_array[] = array(
                                        'item_id' => $srslt->itemid,
                                        'item_code' => $srslt->itli_itemcode,
                                        'item_name' => $srslt->itli_itemname,
                                        'balance' => $bal_qty
                                    );
                                    if ($stock_new_type == 'include_zero_stock') {
                                        if ($bal_qty < 0) {
                                            // echo "here";
                                            continue;
                                        }
                                        $is_empty = false;
                                    } else {
                                        if ($bal_qty <= 0) {
                                            continue;
                                        }
                                        $is_empty = false;
                                    }

                                    // $bal_amount_db=($srslt->opamt + $srslt->puramt) - ($srslt->issamt);
                                    //   $save_temp_array=array(
                                    //     'item_code'=>$srslt->itli_itemcode,
                                    //     'item_name'=>$srslt->itli_itemname, 
                                    //     'unit'=>'',
                                    //     'stock_qty'=>$bal_qty,
                                    //     'rate'=>$srslt->trde_unitprice,
                                    //     'total_amt'=>$bal_qty*$srslt->trde_unitprice
                                    // );
                                    //   if(!empty($save_temp_array)){
                                    //         $this->db->insert('temp_store_stock',$save_temp_array);
                                    //   }

                                ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><?php echo $srslt->itli_itemcode ?></td>
                        <td><?php echo $srslt->itli_itemname ?></td>
                        <td><?php echo !empty($srslt->unit_unitname) ? $srslt->unit_unitname : ''; ?></td>
                        <td><?php echo sprintf('%g', $srslt->opqty);
                                            $sum_openqty += $srslt->opqty;
                                            ?>
                        </td>
                        <td><?php if ($srslt->opamt > 0) {
                                                $orate = $srslt->opamt / $srslt->opqty;
                                                echo number_format($orate, 2);
                                            } else {
                                                echo '';
                                            }; ?></td>
                        <td><?php echo ($srslt->opamt > 0) ? number_format($srslt->opamt, 2) : '';
                                            $sum_opamt += $srslt->opamt;
                                            ?></td>

                        <td><?php if ($srslt->purqty > 0) echo sprintf('%g', $srslt->purqty);
                                            $sum_purqty += $srslt->purqty; ?></td>
                        <td><?php if ($srslt->puramt > 0) {
                                                $rrate = $srslt->puramt / $srslt->purqty;
                                                echo number_format($rrate, 2);
                                            } else {
                                                echo '';
                                            }
                                            ?></td>
                        <td><?php if ($srslt->puramt > 0) echo number_format($srslt->puramt, 2);
                                            $sum_puramt += $srslt->puramt; ?></td>

                        <td><?php if ($srslt->issqty > 0 || $ad_qty > 0) echo sprintf('%g', ($srslt->issqty + $ad_qty));
                                            $sum_issqty += ($srslt->issqty + $ad_qty); ?></td>
                        <td>
                            <?php
                                            if ($srslt->issamt > 0 || $ad_amount > 0) {
                                                $irate = ($srslt->issamt + $ad_amount) / ($srslt->issqty + $ad_qty);
                                                echo number_format($irate, 2);
                                            } else {
                                                echo '';
                                            } ?>
                        </td>
                        <td>
                            <?php
                                            if ($srslt->issamt > 0 || $ad_amount > 0) {
                                                echo number_format(($srslt->issamt + $ad_amount), 2);
                                                $sum_issamt += ($srslt->issamt + $ad_amount);
                                            }
                                            ?>
                        </td>
                        <td>
                            <?php

                                            $sum_balanceqty += $bal_qty;
                                            echo sprintf('%g', $bal_qty);
                                            ?>
                        </td>
                        <td>
                            <?php
                                            $bal_rate = ($srslt->trde_unitprice);
                                            echo ($bal_rate > 0) ? number_format($bal_rate, 2) : '';
                                            ?>
                        </td>
                        <td>
                            <?php
                                            $bal_amt = ($srslt->opamt + $srslt->puramt) - $srslt->issamt;
                                            $sum_balanceamt += $bal_amt;
                                            echo ($bal_amt > 0) ? number_format($bal_amt, 2) : '';
                                            ?>
                        </td>
                    </tr>
                    <?php
                                    $i++;
                                endforeach;
                                if ($is_empty) {
                                    // echo "here  #category_$ci";
                                    $category_to_hide .= "#category_$ci,";
                                }
                                ?>
                    <tr style="font-weight: bold;">
                        <td colspan="4">Sub Total</td>
                        <td>
                            <?php
                                        if ($sum_openqty > 0) {
                                            $grand_openqty += $sum_openqty;
                                            echo sprintf('%g', $sum_openqty);
                                            // echo number_format($sum_openqty,2);
                                        } ?>
                        </td>
                        <td></td>
                        <td>
                            <?php
                                        if ($sum_opamt > 0) {
                                            $grand_opamt += $sum_opamt;
                                            echo number_format($sum_opamt, 2);
                                        }
                                        ?>
                        </td>
                        <td>
                            <?php
                                        if ($sum_purqty > 0) {
                                            $grand_purqty += $sum_purqty;
                                            echo sprintf('%g', $sum_purqty);
                                            // echo number_format($sum_purqty,2);
                                        }
                                        ?>
                        </td>
                        <td></td>
                        <td>
                            <?php
                                        if ($sum_puramt > 0) {
                                            $grand_puramt += $sum_puramt;
                                            echo number_format($sum_puramt, 2);
                                        }
                                        ?>
                        </td>
                        <td>
                            <?php
                                        if ($sum_issqty > 0) {
                                            $grand_issqty += $sum_issqty;
                                            echo sprintf('%g', $sum_issqty);
                                            // echo number_format($sum_issqty,2);
                                        }
                                        ?>
                        </td>
                        <td></td>
                        <td>
                            <?php
                                        if ($sum_issamt > 0) {
                                            $grand_issamt += $sum_issamt;
                                            echo number_format($sum_issamt, 2);
                                        }
                                        ?>
                        </td>
                        <td>
                            <?php
                                        if ($sum_balanceqty > 0) {
                                            $grand_balanceqty += $sum_balanceqty;
                                            echo sprintf('%g', $sum_balanceqty);
                                            // echo number_format($sum_balanceqty,2);
                                        }

                                        ?>
                        </td>
                        <td></td>
                        <td>
                            <?php
                                        if ($sum_balanceamt > 0) {
                                            $grand_balanceamt += $sum_balanceamt;
                                            echo number_format($sum_balanceamt, 2);
                                        }
                                        ?>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
        <?php endif;
            endforeach;

            if (!empty($db_array)) {
                if (!$this->db->table_exists('xw_stock_balance')) {
                    $create_stockrecord_table = "CREATE TABLE xw_stock_balance  (
          id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              item_code VARCHAR(20),
              item_name VARCHAR(250),
              item_id BIGINT(15),
              balance DECIMAL(15,2)
          )";
                    $this->db->query($create_stockrecord_table);
                } else {
                    $this->db->query("TRUNCATE TABLE xw_stock_balance");
                }
                $this->db->insert_batch('stock_balance', $db_array);
            }
        endif; ?>
        <?php //if(count($stock_result) > 1): 
        ?>
        <table class="table table-striped alt_table">
            <thead>
                <tr>
                    <th colspan="16"></th>
                </tr>
                <tr>
                    <th colspan="4" width="30%">Grand Total</th>
                    <th width="5%">
                        <?php
                        if ($grand_openqty > 0) {
                            echo sprintf('%g', $grand_openqty);
                            // echo number_format($grand_openqty,2);
                        } ?>
                    </th>
                    <th width="7%"></th>
                    <th width="7%">
                        <?php
                        if ($grand_opamt > 0) {
                            echo number_format($grand_opamt, 2);
                        }
                        ?>
                    </th>
                    <th width="5%">
                        <?php
                        if ($grand_purqty > 0) {
                            echo sprintf('%g', $grand_purqty);

                            // echo number_format($grand_purqty,2);
                        }
                        ?>
                    </th>
                    <th width="7%"></th>
                    <th width="7%">
                        <?php
                        if ($grand_puramt > 0) {
                            echo number_format($grand_puramt, 2);
                        }
                        ?>
                    </th>
                    <th width="5%">
                        <?php
                        if ($grand_issqty > 0) {
                            echo sprintf('%g', $grand_issqty);
                            // echo number_format($grand_issqty,2);
                        }
                        ?>
                    </th>
                    <th width="7%"></th>
                    <th width="7%">
                        <?php
                        if ($grand_issamt > 0) {
                            echo number_format($grand_issamt, 2);
                        }
                        ?>
                    </th>
                    <th width="5%">
                        <?php
                        if ($grand_balanceqty > 0) {
                            echo sprintf('%g', $grand_balanceqty);
                            // echo number_format($grand_balanceqty,2);
                        }

                        ?>
                    </th>
                    <th width="7%"></th>
                    <th width="7%">
                        <?php
                        if ($grand_balanceamt > 0) {
                            echo number_format($grand_balanceamt, 2);
                        }
                        ?>
                    </th>
                </tr>
            </thead>
        </table>
        <?php //endif;
        $category_to_hide = rtrim($category_to_hide, ',');
        ?>
    </div>
</div>
<script>
$(document).ready(function() {
    let categories = "<?php echo $category_to_hide; ?>";
    // console.log(categories);
    if (categories) {
        $(categories).hide();
    }
});
</script>