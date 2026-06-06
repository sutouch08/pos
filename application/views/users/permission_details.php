<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5">
		<h3 class="title text-center">&nbsp; <?php echo $this->title; ?></h3>
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
								<table class="table table-narrow table-striped table-bordered table-hover" style="margin-bottom: 0px;">
									<?php if (! empty($groups['menu'])) : ?>
										<tr class="font-size-11">
											<td class="fix-width-250 text-center font-size-12"></td>
											<td class="fix-width-80 text-center">View</td>
											<td class="fix-width-80 text-center">Add</td>
											<td class="fix-width-80 text-center">Edit</td>
											<td class="fix-width-80 text-center">Delete</td>
											<td class="fix-width-80 text-center">Approve</td>
										</tr>
												
										<?php foreach ($groups['menu'] as $menu) : ?>
											<?php $code = $menu['menu_code']; ?>
											<?php $pm = $menu['permission']; ?>
											<tr>
												<td class="middle" style="padding-left:20px;"> - <?php echo $menu['menu_name']; ?></td>
												<td class="middle text-center"><?php echo is_active($pm->can_view, FALSE); ?></td>
												<td class="middle text-center"><?php echo is_active($pm->can_add, FALSE); ?></td>
												<td class="middle text-center"><?php echo is_active($pm->can_edit, FALSE); ?></td>
												<td class="middle text-center"><?php echo is_active($pm->can_delete, FALSE); ?></td>
												<td class="middle text-center"><?php echo is_active($pm->can_approve, FALSE); ?></td>
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
</div><!-- End Row -->

<script src="<?php echo base_url(); ?>scripts/users/permission.js?v=<?php echo date('Ymd'); ?>"></script>

<?php $this->load->view('include/footer'); ?>