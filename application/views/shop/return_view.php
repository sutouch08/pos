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
    	<h3 style='margin-bottom:0px;'><i class='fa fa-retweet'></i>&nbsp; <?php echo $this->title; ?></h3>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<div class="tabbable tabs-below">
<div class="tab-content">
<div id="tab1" class="tab-pane active">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-6">
	<form id="search_form" action="<?php echo $this->home; ?>" method="post">
	<label for="search_detail">ค้นหาบิล</label>
	<input type="text" id="search_text" name="bill_search" placeholder="ระบุรายการค้นหา" class="form-control input-sm" value="<?php echo $bill_search; ?>" />
    </form>
</div>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_search" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-info btn-xs btn-block" id="btn_search" onclick="get_search()" ><i class="fa fa-search"></i>&nbsp; ค้นหา</button>
</div>
<div class="col-lg-2 col-md-2 col-sm-6">
	<label for="btn_reset" style="display:block;">&nbsp;</label>
	<button type="button" class="btn btn-warning btn-xs btn-block" id="btn_reset" onClick="clearFilter()" ><i class="fa fa-refresh"></i>&nbsp; เคลีร์ยตัวกรอง</button>
</div>
</div><!--/ Row -->
</div><!--/ tab1 -->
</div><!-- tab content -->
<ul class="nav nav-tabs" id="myTab" style="visibility:hidden">
<li class="active"><a aria-expanded="false" data-toggle="tab" href="#tab1"><i class="fa fa-search"></i>&nbsp; ค้นหาพนักงาน</a></li>
<li class="" onclick="set_focus('code')"><a aria-expanded="true" data-toggle="tab" href="#tab2"><i class="fa fa-plus"></i>&nbsp; เพิ่มพนักงานใหม่</a></li>
</ul>
<div class="row">
<div class="col-lg-12" style="height:1px !important">
<p class="pull-right" style="margin-top:-25px;">
จำนวนแถวต่อหน้า 
<input type="text" class="input-sm" id="set_rows" value="<?php echo $row; ?>" style="width:50px; text-align:center; margin-left:15px; margin-right:15px;" />
<button class="btn btn-success btn-mini" onclick="set_rows()">เปลี่ยน</button>
</p>
</div>
</div>
</div>

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />

<div class='row'>
	<div class='col-xs-12'>
    <table class='table table-striped'>
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%; text-align:center'>ลำดับ</th>
            <th style='width:10%;'>เลขที่เอกสาร</th>
             <th style="width:15%;">พนักงาน</th>
             <th style="width:5%; text-align:right">ยอดเงิน</th>
             <th style="width:5%; text-align:right">ส่วนลด</th>
             <th style="width:5%; text-align:right">รับเงิน</th>
             <th style="width:5%; text-align:right">เงินทอน</th>
             <th style="width:10%; text-align:center">เวลา</th>
             <th style="width:10%; text-align:center">ชำระโดย</th>
            <th style="width:15%; text-align:right"></th>
           </tr>
      </thead>
      <tbody id="rs">
<?php if($data != false) : ?>
		<?php $n = $this->uri->segment(4)+1; ?>		
        <?php foreach($data as $rs): ?>
        <?php 	$id = $rs->id_order; ?>
        		<tr id="row_<?php echo $id; ?>" style="font-size:10px;">
                    <td style="vertical-align:middle;" align="center"><?php echo $n; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->reference; ?></span></td>
                    <td style="vertical-align:middle;"><?php echo employee_name($rs->id_employee); ?></span></td>
                    <td align="right" style="vertical-align:middle;"><?php echo number_format($rs->order_amount, 2); ?></span></td>
                    <td align="right" style="vertical-align:middle;"><?php echo number_format($rs->discount, 2); ?></span></td>
                    <td align="right" style="vertical-align:middle;"><?php echo number_format($rs->received, 2); ?></span></td>
                    <td align="right" style="vertical-align:middle;"><?php echo number_format($rs->changed, 2); ?></span></td>
                    <td align="center" style="vertical-align:middle;"><?php echo thaiDate($rs->date_upd, true); ?></span></td>
                    <td align="center" style="vertical-align:middle;"><?php echo $rs->pay_by == 'credit_card' ? 'บัตรเครดิต' : 'เงินสด'; ?></td>
                    <td align="right" style="vertical-align:middle;">
                        <button type="button" class="btn btn-info btn-minier" onclick="return_product(<?php echo $rs->id_order; ?>)" ><i class="fa fa-tags"></i> คืนสินค้า</button>
                    </td>
                </tr>
                <?php $n++; ?>
        <?php endforeach; ?>
        <?php else : ?>
        <tr id="nocontent"><td colspan="11" align="center" ><h1><?php echo label("empty_content"); ?></h1></td></tr>
    <?php endif; ?>
		</table>
        <?php echo $this->pagination->create_links(); ?>
</div><!-- End col-lg-12 -->
</div><!-- End row -->

<script>

function return_product(id){
	window.location.href = '<?php echo $this->home; ?>/returnProduct/'+id;	
}

function get_search()
{
	var txt = $.trim($("#search_text").val());
	if(txt != "")
	{
		$("#search_form").submit();
	}
}

$("#search_text").keyup(function(e) {
    if(e.keyCode == 13 )
	{
		get_search();
	}
});

function set_rows()
{
		var row = $("#set_rows").val();
		$.ajax({
			url:"<?php echo base_url(); ?>admin/tool/set_rows",
			type:"POST", cache:false, data:{ "rows" : row },
			success: function(rs)
			{
				window.location.href = "<?php echo $this->home; ?>";
			}
		});
}
$("#set_rows").keyup(function(e) {
    if(e.keyCode == 13 )
	{
		set_rows();
	}
});

function clearFilter()
{
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/clearFilter",
		type:"POST", cache:"false", success: function(rs){
			load_out();
			window.location.href = '<?php echo current_url(); ?>';
		}
	});
}
</script>

<?php endif; ?>