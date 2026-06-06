<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><a href="javascript:goBack()"><i class="fa fa-chevron-left"></i></a>&nbsp; <?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padding-5 text-right">
		<?php if ($this->permission === TRUE) : ?>
			<button type="button" class="btn btn-white btn-success top-btn" onclick="setPermission('<?php echo $profile->uid; ?>')"><i class="fa fa-save"></i> บันทึก</button>
		<?php endif; ?>
	</div>
</div><!-- End Row -->
<hr />
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
		<button type="button" class="btn btn-white btn-mini btn-info top-btn" id="btn-toggle-collapse" data-collapse="false" onclick="toggleCollapseAll()">
			<i class="fa fa-minus"></i>&nbsp;&nbsp;Collapse All
		</button>
	</div>
	<div class="divider-hidden"></div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
		<div id="accordion" class="accordion-style1 panel-group">
			<?php if (! empty($menus)) : ?>
				<?php foreach ($menus as $groups) : ?>
					<?php $gCode = $groups['group_code']; ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle"
									data-toggle="collapse"
									href="#collapse-<?php echo $gCode; ?>">
									<i class="bigger-110 ace-icon fa fa-angle-right" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
									&nbsp;<?php echo $groups['group_name']; ?>
								</a>
							</h4>
						</div>
						<div class="panel-collapse collapse in" id="collapse-<?php echo $gCode; ?>" style="height: auto;">
							<div class="panel-body" style="padding: 0px;">
								<table class="table table-narrow table-striped table-bordered table-hover" style="width:850px; margin-bottom: 0px;">
									<?php if (! empty($groups['menu'])) : ?>
										<tr class="font-size-11">
											<td class="fix-width-250 text-center font-size-12"></td>
											<td class="fix-width-80 text-center">
												<label class="font-size-11 pointer" title="Check/Uncheck All View Permission in this group">
													View
													<input id="view-group-<?php echo $gCode; ?>" type="checkbox" class="hide" onchange="groupCheck('view','<?php echo $gCode; ?>')" />
												</label>
											</td>
											<td class="fix-width-80 text-center">
												<label class="font-size-11 pointer" title="Check/Uncheck All Add Permission in this group">
													Add
													<input id="add-group-<?php echo $gCode; ?>" type="checkbox" class="hide" onchange="groupCheck('add','<?php echo $gCode; ?>')" />
												</label>
											</td>
											<td class="fix-width-80 text-center">
												<label class="font-size-11 pointer" title="Check/Uncheck All Edit Permission in this group">
													Edit
													<input id="edit-group-<?php echo $gCode; ?>" type="checkbox" class="hide" onchange="groupCheck('edit','<?php echo $gCode; ?>')" />
												</label>
											</td>
											<td class="fix-width-80 text-center">
												<label class="font-size-11 pointer" title="Check/Uncheck All Delete Permission in this group">
													Delete
													<input id="delete-group-<?php echo $gCode; ?>" type="checkbox" class="hide" onchange="groupCheck('delete','<?php echo $gCode; ?>')" />
												</label>
											</td>
											<td class="fix-width-80 text-center"><label class="font-size-11 pointer" title="Check/Uncheck All Approve Permission in this group">
													<input id="approve-group-<?php echo $gCode; ?>" type="checkbox" class="hide" onchange="groupCheck('approve','<?php echo $gCode; ?>')" />
													Approve
												</label>
											</td>
											<td class="fix-width-80 text-center"><label class="font-size-11 pointer" title="Check/Uncheck All Permissions in this group">
													<input id="all-group-<?php echo $gCode; ?>" type="checkbox" class="hide" onchange="groupCheckAll('<?php echo $gCode; ?>')" />
													All
												</label>
											</td>
										</tr>
										<?php foreach ($groups['menu'] as $menu) : ?>
											<?php $code = $menu['menu_code']; ?>
											<?php $pm = $menu['permission']; ?>
											<tr class="pm-row" data-code="<?php echo $code; ?>">
												<td class="middle" style="padding-left:20px;"> - <?php echo $menu['menu_name']; ?></td>
												<td class="middle text-center">
													<input id="view-<?php echo $code; ?>" type="checkbox" class="ace view-<?php echo $gCode . ' ' . $code; ?>" <?php echo is_checked($pm->can_view, 1); ?> value="1">
													<span class="lbl"> &nbsp;&nbsp;&nbsp;</span>
												</td>
												<td class="middle text-center">
													<input id="add-<?php echo $code; ?>" type="checkbox" class="ace add-<?php echo $gCode . ' ' . $code; ?>" <?php echo is_checked($pm->can_add, 1); ?> value="1">
													<span class="lbl"></span>
												</td>
												<td class="middle text-center">
													<input id="edit-<?php echo $code; ?>" type="checkbox" class="ace edit-<?php echo $gCode . ' ' . $code; ?>" <?php echo is_checked($pm->can_edit, 1); ?> value="1">
													<span class="lbl"></span>
												</td>
												<td class="middle text-center">
													<input id="delete-<?php echo $code; ?>" type="checkbox" class="ace delete-<?php echo $gCode . ' ' . $code; ?>" <?php echo is_checked($pm->can_delete, 1); ?> value="1">
													<span class="lbl"></span>
												</td>
												<td class="middle text-center">
													<input id="approve-<?php echo $code; ?>" type="checkbox" class="ace approve-<?php echo $gCode . ' ' . $code; ?>" <?php echo is_checked($pm->can_approve, 1); ?> value="1">
													<span class="lbl"></span>
												</td>
												<td class="middle text-center">
													<input id="all-<?php echo $code; ?>" type="checkbox" class="ace all-<?php echo $gCode; ?>" onchange="rowCheck('<?php echo $code; ?>')">
													<span class="lbl font-size-11"></span>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</table>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="divider-hidden"></div>
<?php if ($this->permission === TRUE) : ?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 text-right">
			<button type="button" class="btn btn-white btn-success top-btn" onclick="setPermission('<?php echo $profile->uid; ?>')">
			<i class="fa fa-save"></i> บันทึก
			</button>			
		</div>
	</div>
<?php endif; ?>

<script src="<?php echo base_url(); ?>scripts/users/permission.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>