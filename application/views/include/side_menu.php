	<ul class="nav nav-list">
		<li class="<?php echo activeMenu(0,$id_menu); ?>"><a href="<?php echo validMenu(1,"admin/main"); ?>"><i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Dashboard </span></a></li>
        <li class="<?php echo activeMenu(1,$id_menu); ?>"><a href="<?php echo validMenu(1,"admin/product"); ?>"><i class="menu-icon fa fa-tags"></i><span class="menu-text"> เพิ่ม/แก้ไข รายการสินค้า </span></a></li> 
        <li class="<?php echo activeMenu(2,$id_menu); ?>"><a href="<?php echo validMenu(1, "admin/employee"); ?>"><i class="menu-icon fa fa-users"></i><span class="menu-text"> เพิ่ม/แก้ไข พนักงาน </span></a></li>
        <li class="<?php echo activeMenu(3,$id_menu); ?>"><a href="<?php echo validMenu(1, "admin/user"); ?>"><i class="menu-icon fa fa-users"></i><span class="menu-text"> เพิ่ม/แก้ไข ชื่อผู้ใช้งาน </span></a></li>
        <li class="<?php echo isOpen(0,$id_menu); ?>"><a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-bolt"></i><span class="menu-text"> การตลาด</span><b class="arrow fa fa-angle-down"></b></a>
        	<ul class="submenu">
            	<li class="<?php echo activeMenu(4,$id_menu); ?>"><a href="<?php echo validMenu(1,"admin/promotion"); ?>"><i class="menu-icon fa fa-caret-right"></i>โปรโมชั่น</a></li>
                <li class="<?php echo activeMenu(6,$id_menu); ?>"><a href="<?php echo validMenu(1,"admin/rule"); ?>"><i class="menu-icon fa fa-caret-right"></i>เงื่อนไข</a></li>
            </ul>
        </li>
        <li class="<?php echo activeMenu(5,$id_menu); ?>"><a href="<?php echo validMenu(1,"admin/shop"); ?>"><i class="menu-icon fa fa-tags"></i><span class="menu-text"> เพิ่ม/แก้ไข ร้านค้า </span></a></li> 
	</ul>
    