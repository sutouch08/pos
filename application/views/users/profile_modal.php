<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" style="max-width:500px;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:solid 1px #f4f4f4;">
        <h3 class="text-center" style="margin:0;">Profile</h3>
      </div>
      <div class="modal-body">        
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label>Profile Name</label>
            <input type="text" class="form-control input-sm" id="profile-name" maxlength="100" />
            <div class="red font-size-11 width-100 padding-top-5" id="profile-error">xxxxxx</div>
          </div>
        </div>
        <input type="hidden" id="profile-uid" />
        <input type="hidden" id="profile-mode" value="add" />
      </div>
      <div class="modal-footer">
        <button class="btn btn-white btn-sm btn-default btn-100" onclick="closeModal('profileModal')">Cancel</button>
        <button class="btn btn-white btn-sm btn-success btn-100" id="profile-save-btn" onclick="save()">Save</button>
      </div>
    </div>
  </div>
</div>