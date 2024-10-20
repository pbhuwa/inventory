
<table id="Dtable" class="table table-striped menulist" >
<thead>
    <tr>
        <th>S.n.</th>
        <th>Organization Name</th>
        <th> Email</th>
        <th>Contact No</th>
         <th>Logo Image</th>
         <th>Header Image</th>
         <th>Footer Image</th>

          
        <th>Action</th>
    </tr>
</thead>
<tbody>
     <?php
            if($orga_setup_all):
                $i=1;
                foreach ($orga_setup_all as $kpc => $orga):
        ?>
            <tr id="listid_<?php echo $orga->orga_orgid; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $orga->orga_organame; ?></td>
             <td><?php echo $orga->orga_email; ?></td>
               <td><?php echo $orga->orga_contactno; ?></td>
               <td> 
                   <?php
                            if(!empty($orga->orga_image)): 
                            ?>
             <img class="img-polaroid" src="<?php echo base_url(LOGO_PATH.$orga->orga_image); ?>" style="width: 212px;height: 90px;">
         <?php endif;?>
                
            </td>
            <td>
                 <?php
                            if(!empty($orga->orga_headerimg)): 
                            ?>

             <img class="img-polaroid" src="<?php echo base_url(LOGO_PATH.$orga->orga_headerimg); ?>" style="width: 212px;height: 90px;">
                <?php endif;?>
                   
            </td>
            <td> 
                 <?php
                            if(!empty($orga->orga_footerimg)): 
                            ?>
             <img class="img-polaroid" src="<?php echo base_url(LOGO_PATH.$orga->orga_footerimg); ?>" style="width: 212px;height: 90px;">
                <?php endif;?>
                   
            </td>

            
           
            <td>
            <a href="javascript:void(0)" data-id='<?php echo $orga->orga_orgid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a> |
            <a href="javascript:void(0)" data-id='<?php echo $orga->orga_orgid; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>
            </td>
            </tr>
        <?php
        $i++;
        endforeach;
    endif;
     ?>
 </tbody>
</table>

