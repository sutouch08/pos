<?php $this->load->view('include/header'); ?>
<?php $this->load->view('masters/customers/style'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
		<button type="button" class="btn btn-white btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
	</div>
</div>
<hr />
<?php
$tab1 = $tab == 'infoTab' ? 'active in' : '';
$tab2 = $tab == 'addressTab' ? 'active in' : '';
?>
<div class="row">
	<div class="col-lg-1-harf col-md-2 col-sm-2 padding-5 padding-top-15 hidden-xs">
		<ul id="myTab1" class="setting-tabs width-100" style="margin-left:0px;">
			<li class="li-block <?php echo $tab1; ?>" onclick="changeURL('<?php echo $ds->id; ?>','infoTab', 'view_detail')">
				<a href="#infoTab" data-toggle="tab" style="text-decoration:none;">ข้อมูลลูกค้า</a>
			</li>
			<li class="li-block <?php echo $tab2; ?>" onclick="changeURL('<?php echo $ds->id; ?>','addressTab', 'view_detail')">
				<a href="#addressTab" data-toggle="tab" style="text-decoration:none;">ที่อยู่</a>
			</li>
		</ul>
	</div>

	<div class="col-xs-12 padding-5 visible-xs">
		<ul id="myTab1" class="setting-tabs width-100" style="margin-left:0px;">
			<li class="li-block inline border-1 <?php echo $tab1; ?>" onclick="changeURL('<?php echo $ds->id; ?>','infoTab', 'view_detail')">
				<a href="#infoTab" data-toggle="tab" style="text-decoration:none;">ข้อมูลลูกค้า</a>
			</li>
			<li class="li-block inline border-1 <?php echo $tab2; ?>" onclick="changeURL('<?php echo $ds->id; ?>','addressTab', 'view_detail')">
				<a href="#addressTab" data-toggle="tab" style="text-decoration:none;">ที่อยู่</a>
			</li>
		</ul>
	</div>

	<div class="divider visible-xs" style="margin-bottom:0px;"></div>

	<div class="col-lg-10-harf col-md-10 col-sm-10 col-xs-12 padding-5" id="content-block" style="min-height:600px; ">
		<div class="tab-content" style="border:0">
			<div class="tab-pane fade <?php echo $tab1; ?>" id="infoTab">
				<form class="form-horizontal">
					<div class="form-group margin-top-30">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
							<input type="text" class="form-control input-sm" value="<?php echo $ds->code; ?>" disabled />
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="code-error"></div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
						<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
							<input type="text" id="name" class="form-control input-sm" maxlength="100" value="<?php echo $ds->name; ?>" autocomplete="off" autofocus />
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="name-error"></div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เลขประจำตัว/Tax ID</label>
						<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
							<input type="text" id="tax-id" class="form-control input-sm" maxlength="32" value="<?php echo $ds->tax_id; ?>" autocomplete="off" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">กลุ่มลูกค้า</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
							<select id="group" class="form-control input-sm">
								<option value="">เลือกรายการ</option>
								<?php echo select_customer_group($ds->group_code); ?>
							</select>
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="group-error"></div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เกรดลูกค้า</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
							<select id="grade" class="form-control input-sm">
								<option value="">เลือกรายการ</option>
								<?php echo select_customer_class($ds->class_code); ?>
							</select>
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="class-error"></div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ประเภทลูกค้า</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
							<select id="kind" class="form-control input-sm">
								<option value="">เลือกรายการ</option>
								<?php echo select_customer_kind($ds->kind_code); ?>
							</select>
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="kind-error"></div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชนิดลูกค้า</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
							<select id="type" class="form-control input-sm">
								<option value="">เลือกรายการ</option>
								<?php echo select_customer_type($ds->type_code); ?>
							</select>
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="type-error"></div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">พื้นที่ขาย</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
							<select id="area" class="form-control input-sm">
								<option value="">เลือกรายการ</option>
								<?php echo select_customer_area($ds->area_code); ?>
							</select>
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="area-error"></div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">พนักงานขาย</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
							<select id="sale" class="form-control input-sm">
								<option value="">เลือกรายการ</option>
								<?php echo select_saleman($ds->sale_id); ?>
							</select>
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="sale-error"></div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สถานะ</label>
						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" style="padding-top:7px;">
							<?php echo $ds->active == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Inactive</span>'; ?>
						</div>
						<div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="sale-error"></div>
					</div>
					<input type="hidden" id="id" value="<?php echo $ds->id; ?>">
					<input type="hidden" id="code" value="<?php echo $ds->code; ?>">
				</form>
			</div>

			<div class="tab-pane fade <?php echo $tab2; ?>" id="addressTab">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 padding-5">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0 table-responsive">
							<table class="table table-striped tableFixHead border-1">
								<thead>
									<tr>
										<th class="min-width-100" style="font-size:14px;">
											Bill To Address
										</th>
										<th class="fix-width-100 text-right"></th>
									</tr>
								</thead>
								<tbody id="bill-to-list">
									<?php if (! empty($bill_to)) : ?>
										<?php foreach ($bill_to as $rs) : ?>
											<tr id="address-<?php echo $rs->id; ?>">
												<td class="middle min-width-100"><?php echo $rs->alias; ?> | <?php echo $rs->name; ?></td>
												<td class="middle fix-width-100 text-right">
													<input type="hidden" id="address-data-<?php echo $rs->id; ?>" value="<?php echo htmlspecialchars(json_encode($rs)); ?>" data-id="<?php echo $rs->id; ?>" />
													<button type="button" class="btn btn-minier btn-info" title="แสดงรายละเอียด" onclick="viewAddress(<?php echo $rs->id; ?>)"><i class="fa fa-eye"></i></button>													
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr id="no-bill-to">
											<td colspan="2" class="text-center" style="font-size:14px;">No Bill To Address</td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
						<div class="divider"></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0 table-responsive">
							<table class="table table-striped tableFixHead border-1">
								<thead>
									<tr>
										<th class="min-width-100" style="font-size:14px;">
											Ship To Address
										</th>
										<th class="fix-width-100 text-right"></th>
									</tr>
								</thead>
								<tbody id="ship-to-list">
									<?php if (! empty($ship_to)) : ?>
										<?php foreach ($ship_to as $rs) : ?>
											<tr id="address-<?php echo $rs->id; ?>">
												<td class="middle min-width-100"><?php echo $rs->alias; ?> | <?php echo $rs->name; ?></td>
												<td class="middle fix-width-100 text-right">
													<input type="hidden" id="address-data-<?php echo $rs->id; ?>" value="<?php echo htmlspecialchars(json_encode($rs)); ?>" data-id="<?php echo $rs->id; ?>" />
													<button type="button" class="btn btn-minier btn-info" title="แสดงรายละเอียด" onclick="viewAddress(<?php echo $rs->id; ?>)"><i class="fa fa-eye"></i></button>													
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr id="no-ship-to">
											<td colspan="2" class="text-center" style="font-size:14px;">No Ship To Address</td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 padding-5 not-show" id="address-panel">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center font-size-16" id="address-title">Ship To Address</div>
						<div class="divider" style="margin-top:5px;"></div>
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อเรียก</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="alias" class="form-control input-sm r ad" maxlength="50" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="alias-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ผู้รับ</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="consignee" class="form-control input-sm r ad" maxlength="50" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="consignee-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัสสาขา</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="branch-code" class="form-control input-sm r ad" maxlength="50" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="branch-code-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อสาขา</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="branch-name" class="form-control input-sm r ad" maxlength="50" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="branch-name-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ที่อยู่</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="address" class="form-control input-sm r ad" maxlength="250" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="address-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ตำบล/แขวง</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="sub-district" class="form-control input-sm r ad" maxlength="100" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="sub-district-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">อำเภอ/เขต</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="district" class="form-control input-sm r ad" maxlength="100" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="district-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">จังหวัด</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="province" class="form-control input-sm r ad" maxlength="100" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="province-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัสไปรษณีย์</label>
								<div class="col-lg-3 col-md-3-harf col-sm-6 col-xs-12">
									<input type="text" id="postcode" class="form-control input-sm ad" maxlength="12" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="postcode-error"></div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เบอร์โทร</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<input type="text" id="phone" class="form-control input-sm r ad" maxlength="20" value="" autocomplete="off" />
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="phone-error"></div>
							</div>

							<input type="hidden" id="address-type" class="ad" value="S" />
							<input type="hidden" id="address-id" class="ad" value="" />
							<div class="divider-hidden"></div>
							<div class="divider-hidden"></div>
							<div class="form-group">
								<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">&nbsp;</label>
								<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
									<button type="button" class="btn btn-sm btn-default" id="cancel-btn" onclick="clearFields()">Cancel</button>
									<button type="button" class="btn btn-sm btn-success pull-right btn-100" id="save-btn" onclick="saveAddress()">Save</button>
								</div>
								<div class="help-block col-xs-12 col-sm-reset inline" id="postcode-error"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--/ col-sm-9  -->
</div><!--/ row  -->

<input type="hidden" id="customer-code" value="<?php echo $ds->code; ?>">

<script src="<?php echo base_url(); ?>scripts/masters/customers.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/masters/address.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/masters/customer_address.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>