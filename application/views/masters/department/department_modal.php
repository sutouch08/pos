<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog" style="width:500px; max-width:95%; margin-left:auto; margin-right:auto;">
   <div class="modal-content">
       <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title">New Department</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="padding-left:12px; padding-right:12px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label>Department name</label>
						<input type="text" id="add-name" class="form-control" maxlength="100"	autofocus required />
						<div class="err-label" id="add-name-error"></div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label style="margin-top:7px; padding-left:10px;">
							<input type="checkbox" class="ace" id="add-active" checked />
							<span class="lbl">&nbsp; Active</span>
						</label>
					</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default btn-100" onclick="closeModal('add-modal')">Close</button>
				<button type="button" id="btn-add" class="btn btn-sm btn-success btn-100" onclick="saveAdd()">Add</button>

      </div>
   </div>
 </div>
</div>




<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog" style="width:500px; max-width:95%; margin-left:auto; margin-right:auto;">
   <div class="modal-content">
       <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title">Edit Department</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="padding-left:12px; padding-right:12px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label>Department name</label>
						<input type="text" id="edit-name" class="form-control" maxlength="100" autofocus required />
						<div class="err-label" id="edit-name-error"></div>
            <input type="hidden" id="edit-id"/>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label style="margin-top:7px; padding-left:10px;">
							<input type="checkbox" class="ace" id="edit-active" checked />
							<span class="lbl">&nbsp; Active</span>
						</label>
					</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default btn-100" onclick="closeModal('edit-modal')">Close</button>
				<button type="button" id="btn-update" class="btn btn-sm btn-success btn-100" onclick="update()">Update</button>
      </div>
   </div>
 </div>
</div>


<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog" style="width:500px; max-width:95%; margin-left:auto; margin-right:auto;">
   <div class="modal-content">
       <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title">Edit Department</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="padding-left:12px; padding-right:12px;">
          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
						<label>Department name</label>
						<input type="text" id="view-name" class="form-control" readonly/>
					</div>

          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label>Status</label>
						<input type="text" id="view-active" class="form-control text-center" readonly />
					</div>

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label>Create at</label>
						<input type="text" id="create-at" class="form-control text-center" readonly />
					</div>

          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<label>Create by</label>
						<input type="text" id="create-by" class="form-control" readonly />
					</div>

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label>Update at</label>
						<input type="text" id="update-at" class="form-control text-center" readonly />
					</div>

          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<label>Update by</label>
						<input type="text" id="update-by" class="form-control" readonly />
					</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default btn-100" onclick="closeModal('view-modal')">Close</button>
      </div>
   </div>
 </div>
</div>
