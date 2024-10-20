 <table class="table table-border table-striped table-site-detail dataTable">
                        <thead>
                            <th width="5%">S.n. </th>
                            <th width="10%">Date(AD)</th>
                            <th width="10%">Date(BS)</th>
                            <th width="10%">Time</th>
                            <th width="20%">Old Data</th>
                            <th width="20%">New Data</th>
                            <th width="10%">Action By</th>
                            <th width="10%">Action</th>
                            <th width="10%">IP.</th>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        if($audit_list) :
                            foreach ($audit_list as $ka => $audit):
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $audit->colt_postdatead; ?></td>
                                <td><?php echo $audit->colt_postdatebs; ?></td>
                                <td><?php echo $audit->colt_posttime; ?></td>
                                <td>
                                    <strong><?php echo $audit->colt_tablename; ?></strong>
                                    <div class="scroll h212"><?php echo $audit->colt_dataold; ?>
                                </div></td>
                                <td>
                                     <strong><?php echo $audit->colt_tablename; ?></strong>
                                    <div class="scroll h212"><?php echo $audit->colt_datanew; ?></div></td>
                                <td></td>
                                <td><?php echo $audit->colt_action; ?></td>
                                <td><?php echo $audit->colt_postip; ?></td>
                            </tr>
    
                        <?php
                        $i++;
                    endforeach;
                        endif;
                        ?>
                        </tbody>
                    </table>