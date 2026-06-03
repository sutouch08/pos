<?php $this->load->view('include/header'); ?>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
    <h4 class="title"><?php echo $this->title; ?></h4>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
    <?php if ($this->pm->can_add) : ?>
      <button type="button" class="btn btn-white btn-success top-btn" onclick="addNew()"><i class="fa fa-plus"></i> Add New</button>
    <?php endif; ?>
  </div>
</div><!-- End Row -->
<hr class="padding-5" />
<form id="search-form" method="post" action="<?php echo current_url(); ?>">
  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 padding-5">
      <label>User name</label>
      <input type="text" class="form-control input-sm search" name="uname" value="<?php echo $uname; ?>" />
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 padding-5">
      <label>Display name</label>
      <input type="text" class="form-control input-sm" name="dname" value="<?php echo $dname; ?>" />
    </div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 padding-5">
      <label>Profile</label>
      <select class="form-control input-sm filter" name="profile" id="profile">
        <option value="all">ทั้งหมด</option>
        <?php echo select_profile($profile); ?>
      </select>
    </div>

    <div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
      <label>Status</label>
      <select class="form-control input-sm filter" name="status">
        <option value="all">ทั้งหมด</option>
        <option value="1" <?php echo is_selected('1', $status); ?>>Active</option>
        <option value="0" <?php echo is_selected('0', $status); ?>>Inactive</option>
      </select>
    </div>

    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
      <label class="display-block not-show">buton</label>
      <button type="submit" class="btn btn-xs btn-primary btn-block"><i class="fa fa-search"></i> Search</button>
    </div>
    <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-4 padding-5">
      <label class="display-block not-show">buton</label>
      <button type="button" class="btn btn-xs btn-warning btn-block" onclick="clearFilter()"><i
          class="fa fa-retweet"></i> Reset</button>
    </div>
  </div>
  <input type="hidden" name="search" value="1" />
</form>
<hr class="margin-top-15 padding-5">
<?php echo $this->pagination->create_links(); ?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive" style="min-height: 300px;">
    <table class="table table-striped table-narrow dataTable border-1" style="min-width:1000px;">
      <thead>
        <tr>
          <th class="fix-width-80 middle"></th>
          <th class="fix-width-50 middle text-center">#</th>
          <th class="fix-width-50 middle text-center">Status</th>
          <th class="fix-width-200 middle">User name</th>
          <th class="min-width-200 middle">Display name</th>
          <th class="fix-width-200 middle">Profile</th>
          <th class="fix-width-100 middle">Create at</th>
          <th class="fix-width-100 middle">Pwd changed</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($data)) : ?>
          <?php $no = $this->uri->segment($this->segment) + 1; ?>
          <?php foreach ($data as $rs) : ?>
            <tr id="row-<?php echo $rs->id; ?>">
              <td class="middle">
                <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-white btn-xs btn-primary dropdown-toggle" aria-expanded="false" style="border-radius: 5px !important;">
                    Actions
                    <i class="ace-icon fa fa-angle-down icon-on-right"></i>
                  </button>

                  <ul class="dropdown-menu dropdown-menu-left">
                    <li class="info">
                      <a href="javascript:viewDetail('<?php echo $rs->uid; ?>')"><i class="fa fa-eye"></i>&nbsp; View Detail</a>
                    </li>
                    <li class="purple">
                      <a href="javascript:getPermission('<?php echo $rs->uid; ?>')"><i class="fa fa-lock fa-lg"></i>&nbsp; Permissions</a>
                    </li>

                    <?php if ($rs->active == -1) : ?>
                      <?php if (($this->pm->can_approve && $rs->id_profile > 0) or $this->_SuperAdmin) : ?>
                        <li class="success">
                          <a href="javascript:confirmRestore('<?php echo $rs->uid; ?>', '<?php echo $rs->uname; ?>')"><i class="fa fa-refresh"></i>&nbsp; Restore User</a>
                        </li>
                      <?php endif; ?>
                    <?php else : ?>
                      <?php if (($this->pm->can_edit && $rs->id_profile >= 0) or $this->_SuperAdmin) : ?>
                        <li class="warning">
                          <a href="javascript:edit('<?php echo $rs->uid; ?>')"><i class="fa fa-pencil"></i>&nbsp; Edit User</a>
                        </li>
                        <li class="primary">
                          <a href="javascript:getReset('<?php echo $rs->uid; ?>')"><i class="fa fa-key"></i>&nbsp; Reset Password</a>
                        </li>
                      <?php endif; ?>
                      <?php if (($this->pm->can_delete && $rs->id_profile > 0) or $this->_SuperAdmin) : ?>
                        <li class="danger">
                          <a href="javascript:confirmDelete(<?php echo $rs->id; ?>, '<?php echo $rs->uid; ?>', '<?php echo $rs->uname; ?>')">
                            <i class="fa fa-trash"></i>&nbsp; Delete User
                          </a>
                        </li>
                      <?php endif; ?>
                    <?php endif; ?>
                  </ul>
                </div>
              </td>
              <td class="middle text-center no"><?php echo $no; ?></td>
              <td class="middle text-center"><?php echo is_active($rs->active); ?></td>
              <td class="middle"><?php echo $rs->uname; ?></td>
              <td class="middle"><?php echo $rs->dname; ?></td>
              <td class="middle"><?php echo ($rs->id_profile == -987654321 ? 'Super admin' : $rs->pname); ?></td>
              <td class="middle"><?php echo thai_date($rs->create_at, FALSE, '/'); ?></td>
              <td class="middle"><?php echo empty($rs->last_pass_change) ? "" : thai_date($rs->last_pass_change, FALSE, '/'); ?></td>
            </tr>
            <?php $no++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="permission-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width:95%; margin-left:auto; margin-right:auto;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="permission-text">Permission</h4>
        <form id="permission-form" method="post" action="<?php echo $this->home; ?>/export_permission/">
          <input type="hidden" id="uid" name="uid" value="" />
          <input type="hidden" id="token" name="token" value="" />
        </form>
      </div>
      <div class="modal-body" style="border-top:solid 1px #ccc;">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="max-height:400px; overflow:auto;">
            <table class="table table-striped table-bordered" style="min-width:550px;">
              <tbody id="permission-result"></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-success" onclick="exportPermission()"><i class="fa fa-download"></i> Export to excel</button>
        <button type="button" class="btn btn-sm btn-default" onclick="closeModal('permission-modal')">Close</button>
      </div>
    </div>
  </div>
</div>


<template id="template" type="text/html">
  {{#each group}}
    <tr class="font-size-14" style="background-color:#428bca73;">
      <td class="fix-width-250 middle">{{group_name}}</td>
      <td class="fix-width-60 middle text-center">ดู</td>
      <td class="fix-width-60 middle text-center">เพิ่ม</td>
      <td class="fix-width-60 middle text-center">แก้ไข</td>
      <td class="fix-width-60 middle text-center">ลบ</td>
      <td class="fix-width-60 middle text-center">อนุมัติ</td>
    </tr>
    {{#each menu}}
      <tr>
        <td class="middle">{{menu_name}}</td>
        <td class="middle text-center">{{#if cv}}<i class="fa fa-check green"></i>{{else}}<i class="fa fa-times red"></i>{{/if}}</td>
        <td class="middle text-center">{{#if ca}}<i class="fa fa-check green"></i>{{else}}<i class="fa fa-times red"></i>{{/if}}</td>
        <td class="middle text-center">{{#if ce}}<i class="fa fa-check green"></i>{{else}}<i class="fa fa-times red"></i>{{/if}}</td>
        <td class="middle text-center">{{#if cd}}<i class="fa fa-check green"></i>{{else}}<i class="fa fa-times red"></i>{{/if}}</td>
        <td class="middle text-center">{{#if cp}}<i class="fa fa-check green"></i>{{else}}<i class="fa fa-times red"></i>{{/if}}</td>
      </tr>
    {{/each}}
  {{/each}}
</template>

<script>
  $('#profile').select2();
</script>

<script src="<?php echo base_url(); ?>scripts/users/users.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>