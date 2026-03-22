<?php
$menuGroups = $this->menu_model->get_active_menu_groups('side');
$menu_sub_group_code = isset($this->menu_sub_group_code) ? $this->menu_sub_group_code : NULL;
?>

<div class="sidebar-shortcuts" id="sidebar-shortcuts">
	<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">		
		<a href="<?php echo base_url(); ?>orders/order_pos" class="btn btn-purple" title="สต็อกคงเหลือ"><i class="ace-icon fa fa-tags"></i></a>		
		<a href="<?php echo base_url(); ?>orders/orders" class="btn btn-info" title="ออเดอร์"><i class="ace-icon fa fa-shopping-basket"></i></a>		
		<a href="<?php echo base_url(); ?>find_stock" class="btn btn-warning" title="สต็อกคงเหลือ"><i class="ace-icon fa fa-laptop"></i></a>
		<a href="<?php echo base_url(); ?>setting/configs" class="btn btn-danger" title="ตั้งค่า"><i class="ace-icon fa fa-cogs"></i></a>
	</div>
	<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
		<span class="btn btn-success"></span>
		<span class="btn btn-info"></span>
		<span class="btn btn-warning"></span>
		<span class="btn btn-danger"></span>
	</div>
</div>


<ul class="nav nav-list">
<?php if(!empty($menuGroups)) : ?>
<?php 	foreach($menuGroups as $menuGroup) : ?>
	<li class="<?php echo isActiveOpenMenu($this->menu_group_code, $menuGroup->code); ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa <?php echo $menuGroup->icon; ?>"></i>
			<span class="menu-text"><?php echo $menuGroup->name; ?></span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<?php $count_menu = $this->menu_model->count_menu($menuGroup->code); ?>
		<?php if($count_menu > 0) : ?>
			<ul class="submenu">
			<?php $subGroups = $this->menu_model->get_menus_sub_group($menuGroup->code); ?>
			<?php if(!empty($subGroups)) : ?>
				<?php foreach($subGroups as $subGroup) : ?>
					<?php $menus = $this->menu_model->get_menus_by_sub_group($subGroup->code, $menuGroup->code); ?>
					<?php if(!empty($menus)) : ?>
						<li class="<?php echo isActiveOpenMenu($menu_sub_group_code, $subGroup->code); ?>">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i> <?php echo $subGroup->name; ?> <b class="arrow fa fa-angle-down"></b>
							</a>
							<ul class="submenu">
						<?php foreach($menus as $menu) : ?>
								<?php echo side_menu($this->menu_code, $menu->code,  $menu->url, $menu->name); ?>
							<?php endforeach; ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php $menus = $this->menu_model->get_menus_by_group($menuGroup->code, FALSE); ?>
			<?php if(!empty($menus)) : ?>
				<?php foreach($menus as $menu) : ?>
						<?php echo side_menu($this->menu_code, $menu->code,  $menu->url, $menu->name); ?>
					<?php endforeach; ?>
			<?php endif; ?>
		</ul> <!-- level 1 -->
		<?php endif; //--- end count menu ?>
	</li> <!-- / menu group -->
<?php endforeach; ?>
<?php endif; ?>
</ul><!-- /.nav-list -->
