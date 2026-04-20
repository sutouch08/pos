<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5" id="right-column">
  <div class="form-horizontal">
    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ตำแหน่งงาน</label>
      <div class="col-lg-4 col-md-3 col-sm-4 col-xs-12">
        <select id="position" class="form-control input-sm e">
          <option value="">เลือกตำแหน่งงาน</option>
          <?php echo select_position(); ?>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-xs-12" id="position-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">แผนก</label>
      <div class="col-lg-4 col-md-3 col-sm-4 col-xs-12">
        <select id="department" class="form-control input-sm e">
          <option value="">เลือกแผนก</option>
          <?php echo select_department(); ?>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-xs-12" id="department-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สถานะการจ้าง</label>
      <div class="col-lg-4 col-md-3 col-sm-4 col-xs-12">
        <select id="employment-status" class="form-control input-sm e">
          <?php echo select_employment_status(); ?>
        </select>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-xs-12" id="employment-status-error"></div>
    </div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">วันที่เริ่มงาน (พ.ศ.)</label>
      <div class="col-lg-2-harf col-md-1-harf col-sm-1-harf col-xs-6">
        <input type="text" id="hire-date" class="form-control input-sm text-center e" value="" autocomplete="off" placeholder="วัน/เดือน/ปี พ.ศ." />
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12" id="hire-date-error"></div>
    </div>

    <div class="divider-hidden"></div>

    <div class="form-group">
      <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">สถานะ</label>
      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="padding-top:7px;">
        <label>
          <input type="radio" class="ace" name="active" value="1" checked />
          <span class="lbl">&nbsp; Active &nbsp;&nbsp;</span>
        </label>
        <label class="margin-left-20">
          <input type="radio" class="ace" name="active" value="0" />
          <span class="lbl">&nbsp; Inactive</span>
        </label>
      </div>
      <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-xs-12" id="active-error"></div>
    </div>
  </div>
</div>