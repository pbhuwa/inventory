<table id="Dtable" style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="padding-left: 15px;padding-bottom: 10px;padding-top: 15px;border:1px solid #d7d7d7;">Name</th>
                                <th style="padding-left: 15px;padding-bottom: 10px;padding-top: 15px;border:1px solid #d7d7d7; color: #2a3f54;">Value</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        if($constant_list):
                            foreach ($constant_list as $km => $constant):
                            ?>
                            <tr>

                            <td style="padding-bottom: 10px;padding-left: 15px;padding-top: 10px;   width: 30%;font-size: 13px;border:1px solid #d7d7d7;"><?php echo $constant->cons_display; ?></td>
                            <td style="padding-bottom: 10px;padding-left: 10px;padding-top: 10px;   width: 50%;border:1px solid #d7d7d7;"><input  type="hidden" name="cons_id[]" value="<?php echo $constant->cons_id; ?>">
                                <input style="padding-left: 5px;font-size: 13px;padding-top: 5px;padding-bottom: 5px;border:0px;" type="text" name="cons_value[]" value="<?php echo $constant->cons_value; ?>" ></td>
                            
                            </tr>
                            <?php
                            endforeach;
                        endif;
                         ?>
                        </tbody>
                    </table>