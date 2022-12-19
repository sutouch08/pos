<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog" style="width:500px; max-width:95%; margin-left:auto; margin-right:auto;">
   <div class="modal-content">
       <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title" id="modal-title">New User</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="padding-left:12px; padding-right:12px;">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>User name</label>
						<input type="text" id="uname" class="form-control add" maxlength="50"	onkeyup="validCode(this)"	autofocus required />
						<div class="err-label" id="uname-error"></div>
						<input type="hidden" id="user_id" value="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Display name</label>
						<input type="text" id="dname" class="form-control add" maxlength="100" required />
						<div class="err-label" id="dname-error"></div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Employee</label>
						<select class="form-control add" id="emp_id">
							<option value="">Please Select</option>
							<?php echo select_employee(); ?>
						</select>
						<div class="err-label" id="emp-error"></div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Sales Person</label>
						<select class="form-control add" id="sale_id">
							<option value="">Please Select</option>
							<?php echo select_saleman(); ?>
						</select>
						<div class="err-label" id="saleman-error"></div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<label>User Group</label>
						<select class="form-control add" id="group_id">
							<option value="">Please Select</option>
							<?php echo select_user_group(); ?>
						</select>
						<div class="err-label" id="group-error"></div>
					</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 edit">
						<label>Password</label>
						<span class="input-icon input-icon-right width-100">
							<input type="password" name="pwd" id="pwd" class="form-control add" required />
							<i class="ace-icon fa fa-key"></i>
						</span>
						<div class="err-label" id="pwd-error"></div>
					</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 edit">
						<label>Confirm Password</label>
						<span class="input-icon input-icon-right width-100">
							<input type="password" name="cm-pwd" id="cm-pwd" class="form-control add" required />
							<i class="ace-icon fa fa-key"></i>
						</span>
						<div class="err-label" id="cm-pwd-error"></div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<label class="display-block not-show">active</label>
						<label style="margin-top:7px; padding-left:10px;">
							<input type="checkbox" class="ace add" id="active" checked />
							<span class="lbl">&nbsp; Active</span>
						</label>
					</div>

					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 edit">
						<label class="display-block not-show">force</label>
						<label style="margin-top:7px; padding-left:10px;">
							<input type="checkbox" class="ace" id="force_reset" checked />
							<span class="lbl">&nbsp; Force user to change password</span>
						</label>
					</div>
          </div>
        </div>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default btn-100" onclick="closeModal()">Close</button>
				<button type="button" id="btn-add" class="btn btn-sm btn-success btn-100 edit" onclick="saveAdd()">Add</button>
				<button type="button" id="btn-update" class="btn btn-sm btn-success btn-100 edit hide" onclick="update()">Update</button>
      </div>
   </div>
 </div>
</div>
