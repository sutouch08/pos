<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5" id="left-column">
  <div class="form-horizontal">    
    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>      
      <div class="col-lg-4 col-md-4-harf col-sm-4-harf col-xs-6">
        <input type="text" class="form-control input-sm e" id="code" maxlength="20" value="<?php echo $emp->code; ?>"  disabled/>        
      </div>      
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="code-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" id="fname" class="form-control input-sm" maxlength="100" value="<?php echo $emp->firstName; ?>" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="fname-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">นามสกุล</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" id="lname" class="form-control input-sm" maxlength="100" value="<?php echo $emp->lastName; ?>" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="lname-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เบอร์โทรศัพท์</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" id="phone" class="form-control input-sm" maxlength="20" value="<?php echo $emp->phone; ?>" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="phone-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">อีเมล</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" id="email" class="form-control input-sm" maxlength="100" value="<?php echo $emp->email; ?>" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="email-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เพศ</label>
      <div class="col-lg-2-harf col-md-4 col-sm-4-harf col-xs-6">
        <select id="gender" class="form-control input-sm">
          <option value="">เลือกเพศ</option>
          <option value="M" <?php echo $emp->gender == 'M' ? 'selected' : ''; ?>>ชาย</option>
          <option value="F" <?php echo $emp->gender == 'F' ? 'selected' : ''; ?>>หญิง</option>
          <option value="O" <?php echo $emp->gender == 'O' ? 'selected' : ''; ?>>อื่นๆ</option>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="gender-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">วัน/เดือน/ปีเกิด</label>
      <div class="col-lg-2-harf col-md-4 col-sm-4-harf col-xs-6">
        <input type="text" id="birth-date" class="form-control input-sm text-center r" value="<?php echo $emp->birthDate; ?>" autocomplete="off" placeholder="วัน/เดือน/ปี พ.ศ." />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="birth-date-error"></div>
    </div>
    <input type="hidden" id="id" value="<?php echo $emp->id; ?>">
  </div>
</div>