<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
        <div class="form-group row resp_xs">
            <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
                <table class="table table-striped dt_alt dataTable" id="reqTable" tabindex="1" >
                    <tbody>
                        <tr>
                            <th width="25%">Main Store Stock</th>
                            <td width="25"><?php echo !empty($stock_check[0]->stockqty)?round($stock_check[0]->stockqty):0; ?></td>
                            <th width="25%">In Transaction</th>
                            <td width="25"><span style="font-weight: bold">0</span></td>
                        </tr>
                        <tr>
                            <th width="25%">Store 1 Stock</th>
                            <td width="25%"><?php echo !empty($stock_check[1]->stockqty)?round($stock_check[1]->stockqty):0; ?></td>
                            <th width="25%">In Transaction</th>
                            <td width="25"><span style="font-weight: bold">0</span></td>
                        </tr>
                        <tr>
                            <th width="25%">Store 2 Stock</th>
                            <td width="25%"><?php echo !empty($stock_check[2]->stockqty)?round($stock_check[2]->stockqty):0; ?></td>
                            <th width="25%">In Transaction</th>
                            <td width="25"><span style="font-weight: bold">0</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>