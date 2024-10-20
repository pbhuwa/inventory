<div class="col-md-3">
	<label>Select Assets</label>
	<select name="departmentid" class="form-control select2" id="catid">
	    <option value="">---select---</option>

	    <?php if($eqca_category):
	    foreach ($eqca_category as $kdi => $eqcat):?>

	    <option value="<?php echo $eqcat->eqca_equipmentcategoryid; ?>"><?php echo $eqcat->eqca_category; ?></option>

	    <?php endforeach; endif; ?>
	</select>
</div>

<script>
	$(document).off('change','#catid');
	$(document).on('change','#catid',function(){
		var catid = $('#catid').val();

		// console.log(depid);
		$.ajax({
            type: "POST",
            url: base_url+'ams/assets/getAssetsKeyByCatid',
            data: {catid:catid},
            dataType: 'json',
            beforeSend: function() {
      			$('.overlay').modal('show');
    		},
            success: function(datas) {
                // alert(datas.tempform);
                console.log(datas);
                if(datas.status == 'success'){
                    $('.equipmentList').show();
                    $('.equiplist').html(datas.tempform);
                    
                    setTimeout(function(){
                        $('.Dtable').dataTable({
                            "scrollCollapse": true,
                            "autoWidth": false,
                            "aoColumnDefs": [{ 
                            'bSortable': false, 'aTargets': [ "_all" ]
                            }]
                        });
                    }, 500);
                }
                $('.overlay').modal('hide');
                $('.white-box').hide();
            }
        });

	});
</script>

<div class="equipmentList" style="display: none;">
	<button id="getMultipleBarcode" class="btn btn-primary pull-right">Generate Barcode</button>
	<div id="multiplebarcode"></div>
	<br/>
	<div class="equiplist"></div>
</div>

</div>

<script>
    $(document).off('click','#getMultipleBarcode');
    $(document).on('click','#getMultipleBarcode',function(){
        $('.white-box').show();
       	var keys = [];

       	$('input[type=checkbox]:checked').not('#checkall').each(function(){
       		keys.push($(this).data('key'));
       	});
        // console.log(keys);
        $.ajax({
            type: "POST",
            url: base_url+'ams/assets/get_multiple_barcode_assets',
            data: {keys:keys},
            dataType: 'json',
            beforeSend: function() {
                $('.overlay').modal('show');
            },
            success: function(datas) {
                // alert(datas.tempform);
                // console.log(datas);
                if(datas.status == 'success'){
                    $('#multiplebarcode').html(datas.tempform);
                }
                $('.overlay').modal('hide');
            }
        });
    }); 
    
</script>

<script>
    $(document).on('change','#checkall',function(){
        $('[id^="equipid_"]').prop('checked', $(this).prop("checked"));
        return false;
    });

    $(document).on( 'click','.paginate_button', function ( ) {
        $('#checkall').prop('checked',false);
        $('[id^="equipid_"]').prop('checked',false);
    });
</script>