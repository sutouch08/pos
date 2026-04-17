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
  
  <div class="divider-hidden visible-xs"></div>
  <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-12 padding-5" style="display: inline-flex; align-items: center;">
    <span class="visible-xs margin-right-15"> Active</span>
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
</div>
<hr class="margin-top-10" />

<script id="new-row-template" type="text/x-handlebarsTemplate">
  <tr id="row-{{id}}">
    <td class="middle">
		<?php if ($this->pm->can_edit) : ?>
			<button type="button" class="btn btn-minier btn-warning" onclick="edit({{id}})">
				<i class="fa fa-pencil"></i>
			</button>
		<?php endif; ?>
		<?php if ($this->pm->can_delete) : ?>
			<button type="button" class="btn btn-minier btn-danger" onclick="confirmDelete({{id}}, '{{code}} | {{name}}')">
				<i class="fa fa-trash"></i>
			</button>
		<?php endif; ?>
    </td>
    <td class="middle text-center no"></td>
    <td class="middle text-center">{{{is_active}}}</td>
    <td class="middle">{{code}}</td>
    <td class="middle">{{name}}</td>    
    <td class=""></td>
    <td class="middle">{{date_upd}}</td>
  </tr>  
</script>