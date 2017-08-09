<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access 	= valid_access($id_menu);  ?>
<?php $view		= $access['view']; ?>
<?php $add 		= $access['add']; ?>
<?php $edit 		= $access['edit']; ?>
<?php $delete		= $access['delete']; ?>
<?php if(!$view) : ?>
<?php access_deny();  ?>
<?php else : ?>

<div class='row'>
	<div class='col-lg-12'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-tint'></i>&nbsp; <?php echo $this->title; ?></h3>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<div class="row">
<form id="myform" action="<?php echo $this->home; ?>/import_items" method="post" enctype="multipart/form-data">
<div class="form-group">
<div class="col-lg-4 col-md-4 col-sm-6">
	<label for="search_detail">ไฟล์นำเข้ารายการบาร์โค้ด</label>
	<!-- #section:custom/file-input -->
    	<input id="user_file" type="file" name="user_file" class="input-sm">
														
</div>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_search" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-success btn-xs btn-block" id="btn_upload" onclick="upload()" ><i class="fa fa-upload"></i>&nbsp; นำเข้า</button>
</div>
</div>
</form>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_search" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-success btn-xs btn-block" id="btn_print" onclick="print_barcode()" ><i class="fa fa-print"></i>&nbsp; พิมพ์</button>
</div>    
</div><!--/ Row -->


<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />
<script>
function upload()
{
	var file = $("#user_file").val();
	if(file == "")
	{ 
		swal("กรุณาเลือกไฟล์"); 
	}
	else
	{
		$("#myform").submit();
	}
}

$("#user_file").ace_file_input({
	btn_choose : 'เลือกไฟล์',
	btn_change: 'เปลี่ยน',
	droppable: true,
	thumbnail: 'large',
	maxSize: 5000000,//bytes
	allowExt: ["csv"]
});

$("#user_file").on('file.error.ace', function(ev, info) {
	if(info.error_count['ext'] || info.error_count['mime']) alert('กรุณาเลือกไฟล์นามสกุล .csv เท่านั้น');
	if(info.error_count['size']) alert('ขนาดไฟล์สูงสุดไม่เกิน 5 MB');
});

function print_barcode()
{
	window.open("<?php echo $this->home; ?>/print_barcode", "_blank", "width=800, height=1000, scrollbars=yes");
}
</script>

<?php endif; ?>