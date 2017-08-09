<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access 	= validAccess($id_menu);  ?>
<?php $view		= $access['view']; ?>
<?php $add 		= $access['add']; ?>
<?php $edit 		= $access['edit']; ?>
<?php $delete		= $access['delete']; ?>
<?php if(!$view) : ?>
<?php access_deny();  ?>
<?php else : ?>

<div class='row'>
	<div class='col-lg-8'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-tint'></i>&nbsp; <?php echo $page_title; ?> - <?php echo $code; ?></h3>
    </div>
    <div class="col-lg-4">
    	<p class="pull-right">
    	<button type="button" class="btn btn-sm btn-warning" style="margin-top: 15px;" onClick="goBack()"><i class="fa fa-arrow-left"></i> กลับ</button>
    	<button type="button" class="btn btn-sm btn-success" style="margin-top: 15px;" onClick="addSelectedItems()"><i class="fa fa-plus"></i> เพิ่มรายการที่เลือก</button>
        </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 5px; margin-bottom:20px;' />
<div class="tabbable tabs-below">
<div class="tab-content">
<div id="tab1" class="tab-pane active">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-6">
	<form id="search_form" action="<?php echo $this->home; ?>/addPromotionItems/<?php echo $code; ?>" method="post">
	<label for="search_detail">ค้นหาสินค้า</label>
	<input type="text" id="search_text" name="search_text" placeholder="ระบุรายการค้นหา" class="form-control input-sm" value="<?php echo $search_text; ?>" />
    </form>
</div>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_search" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-info btn-xs btn-block" id="btn_search" onclick="get_search()" ><i class="fa fa-search"></i>&nbsp; ค้นหา</button>
</div>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_reset" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-warning btn-xs btn-block" id="btn_reset" onClick="clearFilter()"><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button>
</div>
</div><!--/ Row -->
</div><!--/ tab1 -->
</div><!-- tab content -->
<ul class="nav nav-tabs" id="myTab">
<li class="active"><a aria-expanded="false" data-toggle="tab" href="#tab1"><i class="fa fa-search"></i>&nbsp; ค้นหาสินค้า</a></li>
</ul>
<div class="row">
<div class="col-lg-12" style="height:1px !important">
<p class="pull-right" style="margin-top:-25px;">
ทั้งหมด <?php echo number_format($total_rows); ?> แถว 
จำนวนแถวต่อหน้า 
<input type="text" class="input-sm" id="set_rows" value="<?php echo $row; ?>" style="width:50px; text-align:center; margin-left:15px; margin-right:15px;" />
<button class="btn btn-success btn-mini" onclick="set_rows()">บันทึก</button>
</p>
</div>
</div>
</div>

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />
<form id="add-form">
<div class='row'>
	<div class='col-xs-12' style="padding-bottom:20px;">
    <table class='table table-striped' >
    <thead>
    	<tr style='font-size:10px;'>
        	<th style="width: 5%; text-align:center"><input type="checkbox" id="check_all" onClick="checkAll()" /></th>
             <th style="width:20%;">รุ่นสินค้า</th>
             <th style="width:40%;">ชื่อสินค้า</th>
            <th style="width:10%; text-align:center">ทุน</th>
            <th style="width:10%; text-align:center">ราคา</th>
            <th style="width:15%; text-align:center">กลุ่ม</th>
           </tr>
      </thead>
      <tbody id="rs">
<?php if($data != false) : ?>
        <?php foreach($data as $rs): ?>
        		<tr>
                	 <td style="text-align:center; vertical-align:middle;">
                    	<input type="checkbox" class="item_check" name="style[<?php echo $rs->id_item; ?>]" id="style_<?php echo $rs->id_item; ?>" value="<?php echo $rs->style; ?>" />
                    </td>
                    <td style="vertical-align:middle;"><label for='style_<?php echo $rs->id_item; ?>'><?php echo $rs->style; ?></label></td>
                    <td style="vertical-align:middle;"><?php echo $rs->item_name; ?></td>
                    <td style="vertical-align:middle;" align="center"><?php echo number_format($rs->cost,2); ?></td>
                    <td style="vertical-align:middle;" align="center"><?php echo number_format($rs->price,2); ?></td>
                     <td style="vertical-align:middle;" align="center"><?php echo brandName($rs->id_brand); ?></td>                
                   
                </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr id="nocontent"><td colspan="11" align="center" ><h1> ไม่พบรายการ</h1></td></tr>
    <?php endif; ?>
    	</tbody>
		</table>
        <?php echo $this->pagination->create_links(); ?>
</div><!-- End col-lg-12 -->
</div><!-- End row -->
<input type="hidden" name="code" id="code" value="<?php echo $code; ?>" />
</form>

<script>
function addSelectedItems()
{
	var code = $("#code").val();
	var items 	= $("#add-form").serialize();
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/applyPromotion/"+code,
		type:"POST", cache:"false", data: items,
		success: function(rs){
			load_out();
			var rs = $.trim(rs);
			if( rs == 'success' ){
				swal({ title : 'สำเร็จ' , text : 'เพิ่มรายการสินค้าโปรโมชั่นเรียบร้อยแล้ว', timer: 1000, type: 'success' });
				uncheck_all();
			}else{
				swal('ไม่สำเร็จ', 'เพิ่มสินค้าโปรโมชั่นไม่สำเร็จ', 'error');
			}
		}
	});
}
function uncheck_all()
{
	$(".item_check").each(function(index, element) {
        $(this).prop("checked", false);
    });
}

function checkAll()
{
	var ck = $("#check_all").is(":checked");
	if( ck == true ){
		$(".item_check").each(function(index, element) {
			$(this).prop("checked", true);
		});
	}else{
		$(".item_check").each(function(index, element) {
            $(this).prop("checked", false);
        });
	}
}
function get_search()
{
	var txt = $("#search_text").val();
	if(txt != "")
	{
		$("#search_form").submit();
	}
}

$("#set_rows").keyup(function(e){
	if(e.keyCode == 13 ){ set_rows(); }
});

function set_rows()
{
	load_in();
	var rows =$("#set_rows").val();
	if(rows == "")
	{
		load_out();
		swal("จำนวนแถวต้องเป็นตัวเลขเท่านั้น");
		return false;
	}else{
		$.ajax({
			url:"<?php echo base_url(); ?>admin/tool/set_rows",type:"POST",cache:false,
			data:{ "rows" : rows },
			success: function(rs)
			{
				var rs = $.trim(rs);
				if(rs == "success")
				{
					load_out();
					window.location.reload();
				}else{
					load_out();
					swal("ไม่สามารถเปลี่ยนจำนวนแถวต่อหน้าได้ กรุณาลองใหม่อีกครั้งภายหลัง");
				}
			}
		});
	}
}

function goBack()
{
	window.location.href = '<?php echo $this->home; ?>';	
}

function clearFilter()
{
	var url = '<?php echo current_url(); ?>';
	$.ajax({
		url:"<?php echo $this->home; ?>/clear_filter",
		type: "POST", cache: "false", success: function(rs){
			window.location.href = url;
		}
	});
}
</script>

<?php endif; ?>