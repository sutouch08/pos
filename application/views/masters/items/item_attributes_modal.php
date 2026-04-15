<div class="modal fade" id="color-modal" tabindex="-1" role="dialog" aria-labelledby="colorModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มสี</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสสี</label>
              <input type="text" id="color-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="color-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อสี</label>
              <input type="text" id="color-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="color-name-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>กลุ่มสี</label>
              <select class="form-control input-sm" id="color-group">
                <option value="">เลือก</option>
                <?php echo select_color_group(); ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('color')">Add</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="size-modal" tabindex="-1" role="dialog" aria-labelledby="sizeModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มไซส์</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสไซส์</label>
              <input type="text" id="size-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="size-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อไซส์</label>
              <input type="text" id="size-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="size-name-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>กลุ่มไซส์</label>
              <select class="form-control input-sm" id="size-group">
                <option value="">เลือก</option>
                <?php echo select_size_group(); ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('size')">Add</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="main-group-modal" tabindex="-1" role="dialog" aria-labelledby="mainGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มกลุ่มหลัก</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสกลุ่มหลัก</label>
              <input type="text" id="main-group-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="main-group-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อกลุ่มหลัก</label>
              <input type="text" id="main-group-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="main-group-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('main-group')">Add</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="group-modal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มกลุ่ม</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสกลุ่ม</label>
              <input type="text" id="group-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="group-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อกลุ่ม</label>
              <input type="text" id="group-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="group-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('group')">Add</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="gender-modal" tabindex="-1" role="dialog" aria-labelledby="genderModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มเพศ</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสเพศ</label>
              <input type="text" id="gender-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="gender-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อเพศ</label>
              <input type="text" id="gender-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="gender-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('gender')">Add</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มหมวดหมู่</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสหมวดหมู่</label>
              <input type="text" id="category-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="category-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อหมวดหมู่</label>
              <input type="text" id="category-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="category-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('category')">Add</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="kind-modal" tabindex="-1" role="dialog" aria-labelledby="kindModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มประเภท</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสประเภท</label>
              <input type="text" id="kind-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="kind-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อประเภท</label>
              <input type="text" id="kind-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="kind-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('kind')">Add</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="type-modal" tabindex="-1" role="dialog" aria-labelledby="typeModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มชนิด</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสชนิด</label>
              <input type="text" id="type-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="type-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อชนิด</label>
              <input type="text" id="type-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="type-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('type')">Add</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="brand-modal" tabindex="-1" role="dialog" aria-labelledby="brandModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:350px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">เพิ่มยี่ห้อ</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>รหัสยี่ห้อ</label>
              <input type="text" id="brand-code" class="form-control input-sm" maxlength="20" value="" autocomplete="off" oninput="validInput(this, regex)" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="brand-code-error"></div>
          </div>
          <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>ชื่อยี่ห้อ</label>
              <input type="text" id="brand-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="error-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="brand-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addAttribute('brand')">Add</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#color-group').select2();
  $('#size-group').select2();
</script>