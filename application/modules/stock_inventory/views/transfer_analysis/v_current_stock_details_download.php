<style>
    .format_pdf { border:1px solid #000; border-collapse: initial; }
    .format_pdf thead tr th, .format_pdf tbody tr td { font-size:13px; border:1px solid #000; padding:2px 4px; }
    .format_pdf tbody tr td { font-size:12px; padding:4px; }
    
    .format_sub_tbl_pdf { width:80%; border-collapse:collapse; border-color:#ccc; }
    .format_sub_pdf, .format_sub_tbl_pdf thead tr th, .format_sub_tbl_pdf tbody tr td { background-color:#fff; }
    .format_sub_pdf  { background-color:#f0f0f0; clear:both; }
</style>


<table width="100%" style="font-size:12px;" class="format_pdf_head">
    <tr>
        <td></td>
       <!--  <td class="web_ttl text-center" style="text-align:center;">
            <h2><?php echo ORGA_NAME; ?></h2> -->
            <td class="text-center"><h3 style="color:#101010"><B><?php echo ORGNAME; ?></B></h3></td>
        </td>
        <td></td>
    </tr>
    <tr class="title_sub">
        <td></td>
        <!-- <td style="text-align:center;"><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td> -->
        <td class="text-center"><h4 style="color:black"><?php echo ORGNAMEDESC; ?></h4></td>
        <td style="text-align:right; font-size:10px;">Date/Time: <?php echo CURDATE_NP ?> BS,</td>
    </tr>
    <tr class="title_sub">
        <td></td>
        <!-- <td style="text-align:center;"><b style="font-size:15px;"><span id="rptType"></span></b></td> -->
        <td class="text-center"><b><font color="black"><?php echo LOCATION; ?></font></b></td>
        <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
    </tr>
    <tr class="title_sub">
        <td width="200px"></td>
        <td style="text-align:center;"><b><span id="rptTypeSelect"></span><span id="rptTypeCheck"></span></b></td>
        <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
    </tr>
</table>
<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th >SN</th>
            <th >Code</th>
            <th >Name</th>

            <th >Category</th> 
            <th >Type </th>
            <th >Pur Qty </th>
            <?php if($pdf_details == 'details'){ ?><th >Max Limit </th><?php } ?>
            <th >A Stock </th>
            <th >Unit Price </th>
            <th >Unit </th>
            <?php if($pdf_details == 'details'){ ?>
            <th >Batch  NO </th>
            <th >Expire Date </th> <?php } ?>
            <th >Amount</th> 
        </tr>
    </thead>
    <tbody>
        <?php if($searchResult): 
        $i=1;
        foreach ($searchResult as $key => $pending): 
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $pending->itli_itemcode; ?></td>
            <td><?php echo $pending->itli_itemname; ?></td>
            <td><?php echo $pending->eqca_category; ?></td>
            <td><?php echo $pending->maty_material; ?></td>
            <?php if($pdf_details == 'details'){ ?><td><?php echo $pending->itli_maxlimit; ?></td><?php } ?>
            <td><?php echo $pending->atstock; ?></td>
            <td><?php echo $pending->trde_unitprice; ?></td>
            <td><?php echo $pending->unit_unitname; ?></td>
            <?php if($pdf_details == 'details'){ ?>
            <td><?php echo $pending->batchno; ?></td>
            <td><?php echo $pending->trde_expdatebs; ?></td>
            <?php } ?>
            <td><?php echo $pending->amount; ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        endif;
        ?>
    </tbody>
</table>