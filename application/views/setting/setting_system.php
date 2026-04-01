<form id="systemForm">
  <div class="row">
    <?php if ($cando === TRUE): ?>
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><span class="form-control left-label">เปิด/ปิดระบบ</span></div>
      <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
        <label>
          <input type="radio" name="CLOSE_SYSTEM" class="ace" value="0" <?php echo is_checked('0', $CLOSE_SYSTEM); ?>>
          <span class="lbl">&nbsp;&nbsp; เปิดระบบ</span>
        </label>
        <label class="margin-left-20">
          <input type="radio" name="CLOSE_SYSTEM" class="ace" value="1" <?php echo is_checked('1', $CLOSE_SYSTEM); ?>>
          <span class="lbl">&nbsp;&nbsp; ปิดระบบ</span>
        </label>
        <label class="margin-left-20">
          <input type="radio" name="CLOSE_SYSTEM" class="ace" value="2" <?php echo is_checked('2', $CLOSE_SYSTEM); ?>>
          <span class="lbl">&nbsp;&nbsp; อ่านอย่างเดียว</span>
        </label>
        <span class="help-block">กรณีปิดระบบจะไม่สามารถเข้าใช้งานระบบได้ในทุกส่วน โปรดใช้ความระมัดระวังในการกำหนดค่านี้</span>
      </div>
      <div class="divider"></div>
    <?php endif; ?>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><span class="form-control left-label">App title</span></div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="form-control input-sm input-medium" name="APP_TITLE" value="<?php echo $APP_TITLE; ?>" />
      <span class="help-block">กำหนดชื่อ App สำหรับแสดงผลที่มุมซ้ายบนหน้า Web App</span>
    </div>
    <div class="divider"></div>


    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><span class="form-control left-label">วันที่ในการบันทึกขาย</span></div>
    <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
      <label>
        <input type="radio" name="ORDER_SOLD_DATE" class="ace" value="D" <?php echo is_checked('D', $ORDER_SOLD_DATE); ?>>
        <span class="lbl">&nbsp;&nbsp; วันที่เอกสาร</span>
      </label>
      <label class="margin-left-20">
        <input type="radio" name="ORDER_SOLD_DATE" class="ace" value="B" <?php echo is_checked('B', $ORDER_SOLD_DATE); ?>>
        <span class="lbl">&nbsp;&nbsp; วันที่เปิดบิล</span>
      </label>
      <span class="help-block">กำหนดประเภทวันที่ที่ใช้ในการบันทึกขายและตัดสต็อกในระบบ</span>
    </div>
    <div class="divider"></div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><span class="form-control left-label">Use strong password</span></div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
      <label>
        <input type="radio" name="USE_STRONG_PWD" class="ace" value="1" <?php echo is_checked('1', $USE_STRONG_PWD); ?>>
        <span class="lbl">&nbsp;&nbsp; Yes</span>
      </label>
      <label class="margin-left-20">
        <input type="radio" name="USE_STRONG_PWD" class="ace" value="0" <?php echo is_checked('0', $USE_STRONG_PWD); ?>>
        <span class="lbl">&nbsp;&nbsp; No</span>
      </label>
      <span class="help-block">
        เมื่อเปิดใช้งาน การกำหนดรหัสผ่านจะต้องประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์ใหญ่ พิมพ์เล็ก ตัวเลข
        และสัญลักษณ์พิเศษ อย่างน้อย อย่างล่ะ 1 ตัว และต้องมีความยาว 8 ตัวอักษรขึ้นไป
        (การเปิด/ปิดการใช้งาน ไม่มีผลย้อนหลัง)
      </span>
    </div>
    <div class="divider"></div>


    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><span class="form-control left-label">Password Age</span></div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
      <input type="number" class="form-control input-sm input-mini text-center" name="USER_PASSWORD_AGE" id="pwd-age" value="<?php echo $USER_PASSWORD_AGE; ?>" />
      <span class="help-block">กำหนดอายุของรหัสผ่าน(วัน) User จำเป็นต้องเปลี่ยนรหัสผ่านหากรหัสผ่านหมดอายุ (กำหนดเป็น 0 เพื่อปิดการใช้งาน)</span>
    </div>
    <div class="divider"></div>

    <div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3">
      <?php if ($this->pm->can_add or $this->pm->can_edit) : ?>
        <button type="button" class="btn btn-sm btn-success btn-100" onClick="updateConfig('systemForm')"><i class="fa fa-save"></i> บันทึก</button>
      <?php endif; ?>
    </div>
    <div class="divider-hidden"></div>

  </div><!--/row-->
</form>