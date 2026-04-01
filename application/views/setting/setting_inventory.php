<form id="inventoryForm" method="post" action="<?php echo $this->home; ?>/update_config">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<span class="form-control left-label">สต็อกติดลบได้</span>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<label>
				<input type="radio" name="ALLOW_UNDER_ZERO" class="ace" value="1" <?php echo is_checked('1', $ALLOW_UNDER_ZERO); ?>>
				<span class="lbl">&nbsp; Yes&nbsp;&nbsp;&nbsp;</span>
			</label>
			<label class="margin-left-20">
				<input type="radio" name="ALLOW_UNDER_ZERO" class="ace" value="0" <?php echo is_checked('0', $ALLOW_UNDER_ZERO); ?>>
				<span class="lbl">&nbsp; No</span>
			</label>
			<span class="help-block">อนุญาติให้สต็อกติดลบได้</span>
		</div>
		<div class="divider"></div>

		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<span class="form-control left-label">รับสินค้าเกินใบสั่งซื้อ</span>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<label>
				<input type="radio" name="ALLOW_RECEIVE_OVER_PO" class="ace" value="1" <?php echo is_checked('1', $ALLOW_RECEIVE_OVER_PO); ?>>
				<span class="lbl">&nbsp; Yes &nbsp;&nbsp;&nbsp;</span>
			</label>
			<label class="margin-left-20">
				<input type="radio" name="ALLOW_RECEIVE_OVER_PO" class="ace" value="0" <?php echo is_checked('0', $ALLOW_RECEIVE_OVER_PO); ?>>
				<span class="lbl">&nbsp; No &nbsp;&nbsp;&nbsp;</span>
			</label>
			<span class="help-block">อนุญาติให้รับสินค้าเกินใบสั่งซื้อหรือไม่</span>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<span class="form-control left-label">รับสินค้าเกินไปสั่งซื้อ</span>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control input-sm input-small text-center" name="RECEIVE_OVER_PO" value="<?php echo $RECEIVE_OVER_PO; ?>" style="display: inline-block;" />
			<span>&nbsp; %</span>
			<span class="help-block">อนุญาติให้รับสินค้าเกินใบสั่งซื้อได้ไม่เกิน % ที่กำหนดนี้ (คำนวณตามรายการสินค้า) หากเกินต้องทำการอนุมัติ</span>
		</div>
		<div class="divider"></div>

		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<span class="form-control left-label">คลังสินค้า เริ่มต้น</span>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<select name="DEFAULT_WAREHOUSE" id="default-warehouse" class="form-control input-sm input-xlarge">
				<option value="">Please Default Warehouse</option>
				<?php echo select_warehouse($DEFAULT_WAREHOUSE); ?>
			</select>
			<span class="help-block">กำหนดคลังซื้อ-ขายเริ่มต้น</span>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<span class="form-control left-label">ที่เก็บสินค้า เริ่มต้น</span>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<select name="DEFAULT_BIN_LOCATION" id="default-zone" class="form-control input-sm input-xlarge">
				<option value="">Please Default BinLocation</option>
				<?php echo select_zone($DEFAULT_BIN_LOCATION, $DEFAULT_WAREHOUSE); ?>
			</select>
			<span class="help-block">กำหนดพื้นที่จัดเก็บสินค้า (Bin Location) เริ่มต้น **จำเป็นต้องสอดคล้องกับคลังสินค้าเริ่มต้น</span>
		</div>
		<div class="divider"></div>

		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 col-sm-offset-3">
			<?php if ($this->pm->can_add or $this->pm->can_edit) : ?>
				<button type="button" class="btn btn-sm btn-success input-small" onClick="updateConfig('inventoryForm')">
					<i class="fa fa-save"></i> บันทึก
				</button>
			<?php endif; ?>
		</div>
	</div><!--/ row -->
</form>