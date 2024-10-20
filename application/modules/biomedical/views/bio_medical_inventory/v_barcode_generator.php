<div class="col-md-3">
	<label>Select Department</label>
	<select name="departmentid" class="form-control select2" id="depid">
	    <option value="">---select---</option>

	    <?php if($dep_information):
	    foreach ($dep_information as $kdi => $depin):?>

	    <option value="<?php echo $depin->dept_depid; ?>"><?php echo $depin->dept_depname; ?></option>

	    <?php endforeach; endif; ?>
	</select>
</div>

<script>
	$(document).off('change','#depid');
	$(document).on('change','#depid',function(){
		var depid = $('#depid').val();

		// console.log(depid);
		$.ajax({
            type: "POST",
            url: base_url+'biomedical/bio_medical_inventory/getEquipKeyByDepid',
            data: {depid:depid},
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
            url: base_url+'biomedical/bio_medical_inventory/get_multiple_barcode',
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