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
    	<h3 style='margin-bottom:0px;'><i class='fa fa-bar-chart'></i>&nbsp; <?php echo $this->title; ?></h3>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:20px;' />
<div class="tabbable tabs-below">
<div class="tab-content">
<div id="tab1" class="tab-pane active">
<form id="form" action="<?php echo $this->home; ?>/export_report" method="post">
<div class="row">
<div class="col-lg-2 col-md-4 col-sm-6">	
	<label>เริ่มต้น</label>
	<input type="text" id="from_date" name="from_date" class="form-control input-sm" /> 
</div>
<div class="col-lg-2 col-md-4 col-sm-6">	
	<label>สิ้นสุด</label>
	<input type="text" id="to_date" name="to_date" class="form-control input-sm" /> 
</div>
<div class="col-lg-2 col-md-4 col-sm-6">	
	<label style="visibility:hidden; display:block;">report</label>
	<button type="button" class="btn btn-info btn-xs btn-block" id="btn_report" onclick="get_report()"><i class="fa fa-bar-chart-o"></i> รายงาน</button>
</div>
<div class="col-lg-2 col-md-4 col-sm-6">	
	<label style="visibility:hidden; display:block;">export</label>
	<button type="button" class="btn btn-success btn-xs btn-block" onclick="export_report()"><i class="fa fa-file-excel-o"></i> ส่งออก</button>
</div>
</div><!--/ Row -->
</form>
</div><!--/ tab1 -->
</div><!-- tab content -->
</div>

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />

<div class='row'>
<div class='col-lg-12' id="rs">

</div><!-- End col-lg-12 -->
</div><!-- End row -->
<script id="template" type="text/x-handlebars-template">
<table class="table table-striped">
<thead>
	<th style="width:10%;">เลขที่</th>
    <th style="width:15%;">สินค้า</th>
    <th style="width:5%; text-align:center">ราคา</th>
    <th style="width:5%; text-align:center">ส่วนลด</th>
    <th style="width:5%; text-align:center">จำนวน</th>
    <th style="width:10%; text-align:center">มูลค่า</th>
	<th style="width:5%; text-align:center">การชำระ</th>	
    <th style="width:10%; text-align:center">วันที่</th>
	<th style="width:10%; text-align:center">รุ่น</th>
	<th style="width:10%; text-align:center">กลุ่ม</th>
	<th style="width:10%; text-align:center">พนักงาน</th>
</thead>
{{#each this}}
	{{#if @last}}
<tr style="font-size:14px;">
    	<td colspan="3">รวม</td>
        <td align="center">{{ discount }}</td>
        <td align="center">{{ qty }}</td>
        <td align="center">{{ total_amount }}</td>
		<td colspan="5" align="center"></td>
    </tr>	
	
	{{else}}
<tr style="font-size:10px;">
    	<td>{{ reference }}</td>
        <td>{{ item_code }}</td>
        <td align="center">{{ price }}</td>
        <td align="center">{{ discount }}</td>
        <td align="center">{{ qty }}</td>
        <td align="center">{{ total_amount }}</td>
		<td align="center">{{ pay_by }}</td>
        <td align="center">{{ date_upd }}</td>
		<td align="center">{{ style }}</td>
		<td align="center">{{ brand }}</td>
		<td align="center">{{ emp }}</td>
    </tr>
	{{/if}}
{{/each}}	
</table>
</script>
<script>
$("#from_date").datepicker({ dateFormat: "dd-mm-yy", onClose: function(sed){ $("#to_date").datepicker('option', 'minDate', sed);} });
$("#to_date").datepicker({ dateFormat: "dd-mm-yy" , onClose: function(sed){ $("#from_date").datepicker('option', 'maxDate', sed); } });
function get_report()
{
	var from = $("#from_date").val();
	var to = $("#to_date").val();
	if(!isDate(from) || !isDate(to) )
	{
		swal("วันที่ไม่ถูกต้อง");
		return false;
	}
	load_in();
	$.ajax({
		url:"<?php echo $this->home; ?>/get_report",
		type:"POST", cache: false, data:{ "from_date" : from, "to_date" : to },
		 success: function(rs)
		{
			load_out();
			var rs = $.trim(rs);
			if(rs != "fail")
			{
				var source 		= $("#template").html();
				var data 			= $.parseJSON(rs);
				var template 	= Handlebars.compile(source);
				var row 			= template(data);
				var output		= $("#rs");
				render(source, data, output);	
			}
			else
			{
				swal("ไม่พบข้อมูล");
			}
		}
	});
}

function export_report()
{
	var from = $("#from_date").val();
	var to = $("#to_date").val();
	if(!isDate(from) || !isDate(to) )
	{
		swal("วันที่ไม่ถูกต้อง");
		return false;
	}
	$("#form").submit();
}
</script>

<?php endif; ?>