<div class="modal fade" id="pwd-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog" style="width:500px; max-width:95%; margin-left:auto; margin-right:auto;">
   <div class="modal-content">
       <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title">Reset Password</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="padding-left:12px; padding-right:12px;">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>User name</label>
						<input type="text" id="x-uname" class="form-control" disabled />
						<div class="err-label" id="x-uname-error"></div>
						<input type="hidden" id="x-id" value="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Display name</label>
						<input type="text" id="x-dname" class="form-control" disabled />
						<div class="err-label" id="x-dname-error"></div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>New Password</label>
						<span class="input-icon input-icon-right width-100">
							<input type="password" id="x-pwd" class="form-control" autofocus required />
							<i class="ace-icon fa fa-key"></i>
						</span>
						<div class="err-label" id="x-pwd-error"></div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Confirm Password</label>
						<span class="input-icon input-icon-right width-100">
							<input type="password" id="x-cm-pwd" class="form-control" required />
							<i class="ace-icon fa fa-key"></i>
						</span>
						<div class="err-label" id="x-cm-pwd-error"></div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 edit">
						<label class="display-block not-show">force</label>
						<label style="margin-top:7px; padding-left:10px;">
							<input type="checkbox" class="ace" id="x-force_reset" checked />
							<span class="lbl">&nbsp; Force user to change password</span>
						</label>
					</div>
          </div>
        </div>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default btn-100" onclick="closeResetModal()">Close</button>
				<button type="button" class="btn btn-sm btn-success btn-100" onclick="changePassword()">Change Password</button>
      </div>
   </div>
 </div>
</div>
