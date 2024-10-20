<form method="post" action="" id="formAccessLog" >
    <!-- <div class="col-md-1">
                            <label>Table<span class="required">*</span> :</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="tablename" name="tablename">
                                <option value="">----All----</option>
                                <?php if($table_list):
                                foreach ($table_list as $ktl => $tlist):
                                    ?>
                                <option value="<?php echo $tlist->colt_tablename; ?>"><?php echo $tlist->tana_tabledisplay; ?></option>

                                <?php
                                endforeach;
                            endif;
                                 ?>
                            </select>
                        </div> -->
                        <div class="col-md-1">From</div>
                        <div class="col-md-2">
                            <!-- <input type="text" name="fromDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>">
                             -->
                             <input type="text" name="fromDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"   value="<?php echo DISPLAY_DATE; ?>" id="fromDate">
                        </div>
                        <div class="col-md-1">To</div>
                        <div class="col-md-2">
                            <!-- <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>">
                             -->
                              <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"   value="<?php echo DISPLAY_DATE; ?>" id="toDate">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn_site btnSearch">Search</button>
                        </div>
                        <div class="clearfix"></div>

</form>
