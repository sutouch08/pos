<div class="divider visible-xs"></div>
<div class="row margin-top-10">
  <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 padding-5">
    <div class="input-group">
      <span class="input-group-addon">รหัส</span>
      <input type="text" class="form-control input-sm" id="code" maxlength="20" value="" autocomplete="off" autofocus />
    </div>
    <div class="error-block" id="code-error"></div>
  </div>
  <div class="col-lg-2-harf col-md-4 col-sm-4 col-xs-12 padding-5">
    <div class="input-group">
      <span class="input-group-addon">ชื่อ</span>
      <input type="text" class="form-control input-sm" id="name" maxlength="50" value="" autocomplete="off" />
    </div>
    <div class="error-block" id="name-error"></div>
  </div>
  <div class="col-lg-2-harf col-md-4 col-sm-4 col-xs-10 padding-5">
    <div class="input-group">
      <span class="input-group-addon">กลุ่ม</span>
      <select id="size-group-id" class="form-control input-sm">
        <option value="">เลือกกลุ่ม</option>
        <?php echo select_size_group(); ?>
      </select>
    </div>
    <div class="error-block" id="group-error"></div>
  </div>
  <div class="col-lg-harf col-md-1 col-sm-1 col-xs-2 padding-5">
    <button type="button" class="btn btn-sm btn-white btn-primary" title="Define new group" onclick="openSizeGroupModal()"><i class="fa fa-plus"></i></button>
  </div>
  <div class="col-lg-2 col-md-2-harf col-sm-2-harf col-xs-8 padding-5">
    <div class="input-group">
      <span class="input-group-addon">ตำแหน่ง</span>
      <input type="number" class="form-control input-sm text-center" id="position" value="" />
    </div>
    <div class="error-block" id="position-error"></div>
  </div>
  <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5 text-center">
    <label style="padding-top: 5px; margin-bottom: 0px; height: 30px;">
      <input class="ace ace-switch ace-switch-6" id="status" type="checkbox" value="1" checked />
      <span class="lbl"></span>
    </label>
  </div>
  <div class="divider-hidden visible-xs"></div>
  <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-12 padding-5">
    <button type="button" class="btn btn-white btn-sm btn-success btn-block" onclick="add()">
      <i class="fa fa-plus"></i>&nbsp; Add
    </button>
  </div>
  <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 error-block" id="error-block"></div> -->
</div>
<hr class="margin-top-10" />

<div class="modal fade" id="size-group-modal" tabindex="-1" role="dialog" aria-labelledby="sizeGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:400px; max-width: 95vw;">
    <div class="modal-content">
      <div class="modal-header border-bottom-1">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">กลุ่มไซส์</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label no-padding-right">ชื่อกลุ่ม</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
              <input type="text" id="group-name" class="form-control input-sm" maxlength="50" value="" autocomplete="off" />
            </div>
            <div class="help-block col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3" id="group-name-error"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-white btn-primary" onclick="addSizeGroup()">Add</button>
      </div>
    </div>
  </div>
</div>

<script id="new-row-template" type="text/x-handlebarsTemplate">
  <tr id="row-{{id}}">
    <td class="middle">
		<?php if ($this->pm->can_edit) : ?>
			<button type="button" class="btn btn-minier btn-warning" onclick="edit({{id}})">
				<i class="fa fa-pencil"></i>
			</button>
		<?php endif; ?>
		<?php if ($this->pm->can_delete) : ?>
			<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete('{{id}}', '{{name}}')">
				<i class="fa fa-trash"></i>
			</button>
		<?php endif; ?>
    </td>
    <td class="middle text-center no"></td>
    <td class="middle text-center">{{{is_active}}}</td>
    <td class="middle">{{code}}</td>
    <td class="middle">{{name}}</td>
    <td class="middle">{{group_name}}</td>
    <td class="middle text-center">{{position}}</td>
    <td class="middle text-center">{{member}}</td>
    <td></td>
  </tr>  
</script>

<script>
  $('#size-group-id').select2();
</script>