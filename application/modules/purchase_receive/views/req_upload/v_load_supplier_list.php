<select id="supplierid" name="supplierid" class="form-control required_field select2" >
    <option value="">---select---</option>
    <?php
        if($supplier_all):
            foreach ($supplier_all as $ks => $supp):
        ?>
    <option value="<?php echo $supp->dist_distributorid; ?>" 
        <?php echo in_array($supp->dist_distributorid,$quotation_supplier)?'disabled="disabled"':''; ?> >
        <?php echo $supp->dist_distributor; ?> 
    </option>
    <?php
            endforeach;
        endif;
    ?>
</select>