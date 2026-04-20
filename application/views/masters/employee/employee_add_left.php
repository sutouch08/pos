<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5" id="left-column">
  <div class="form-horizontal">
    <?php $attr = $auto_gen == 'force' ? 'disabled' : ''; ?>
    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">รหัส</label>
      <?php if ($auto_gen != 'off') : ?>
        <div class="col-lg-2 col-md-2 col-sm-2-harf col-xs-3 padding-right-0">
          <select id="prefix" class="form-control input-sm e">
            <?php if (! empty($prefixList)) : ?>
              <?php foreach ($prefixList as $prefix) : ?>
                <option value="<?php echo $prefix; ?>"><?php echo $prefix; ?></option>
              <?php endforeach; ?>
            <?php else : ?>
              <option value="">Please defined</option>
            <?php endif; ?>
          </select>
        </div>
      <?php endif; ?>
      <div class="col-lg-4 col-md-4-harf col-sm-4-harf col-xs-6">
        <input type="text" class="form-control input-sm e" id="code" maxlength="20" value="" placeholder="a-z, A-Z, -, _, ., @" autocomplete="off" autofocus <?php echo $attr; ?> />
        <i class="fa fa-times fa-lg red" id="clear-code" style="position:absolute; top:8px; right:15px; cursor:pointer;" title="Clear" onclick="clearInputCode()"></i>
      </div>
      <?php if ($auto_gen != 'off') : ?>
        <div class="col-lg-2 col-md-2-harf col-sm-2 col-xs-3 padding-left-0">
          <button type="button" class="btn btn-sm btn-white btn-success btn-block visible-sm" onclick="genEmployeeCode()">Gen</button>
          <button type="button" class="btn btn-sm btn-white btn-success btn-block hidden-sm" onclick="genEmployeeCode()">Generate</button>
        </div>
      <?php endif; ?>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="code-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อ</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" id="fname" class="form-control input-sm e" maxlength="100" value="" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="fname-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">นามสกุล</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" id="lname" class="form-control input-sm e" maxlength="100" value="" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="lname-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เบอร์โทรศัพท์</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" id="phone" class="form-control input-sm e" maxlength="20" value="" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="phone-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">อีเมล</label>
      <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
        <input type="text" id="email" class="form-control input-sm e" maxlength="100" value="" autocomplete="off" />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="email-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">เพศ</label>
      <div class="col-lg-2-harf col-md-4 col-sm-4-harf col-xs-6">
        <select id="gender" class="form-control input-sm">
          <option value="">เลือกเพศ</option>
          <option value="M">ชาย</option>
          <option value="F">หญิง</option>
          <option value="O">อื่นๆ</option>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="gender-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">วัน/เดือน/ปีเกิด</label>
      <div class="col-lg-2-harf col-md-4 col-sm-4-harf col-xs-6">
        <input type="text" id="birth-date" class="form-control input-sm text-center e" value="" autocomplete="off" placeholder="วัน/เดือน/ปี พ.ศ." />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="birth-date-error"></div>
    </div>
    <input type="hidden" id="auto-gen" value="<?php echo $auto_gen; ?>">
  </div>
</div>