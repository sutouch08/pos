<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>

<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px;'><i class='fa fa-tag'></i>&nbsp; <?php echo label(strtolower($this->title)); ?></h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo $this->home."/add"; ?>">
        		<button class='btn btn-success' <?php echo $access['add']; ?>><i class='fa fa-plus'></i>&nbsp; <?php echo label("add"); ?></button>
             </a>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:10px;' />
<div class='row'>
	<div class='col-xs-12'>
    <table class='table table-striped' id="ac_chart">
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%; text-align:center'><?php echo label("number"); ?></th>
            <th style='width:20%;'><?php echo label("code"); ?></th>
            <th style='width:20%;'><?php echo label("name"); ?></th> 
            <th style="width:10%;"><?php echo label("role"); ?></th>
            <th style="text-align:right"><?php echo label("action"); ?></th>
           </tr>
      </thead>
      <tbody>  
<?php if($data != false) : ?>
    <?php $i = 0;?>
        <?php foreach($data as $rs): ?>
        <?php $i++; ?>
        		<tr>
                    <td style="vertical-align:middle;" align="center"><?php echo $i; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->code; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->name; ?></td>
                    <td style="vertical-align:middle;"><?php if( $rs->consign != 0 ){ echo label("consignment"); }else{ echo label("general"); } ?></td> 
                    <td align="right" style="vertical-align:middle;">
                    	<a href="<?php echo $this->home; ?>/edit/<?php echo $rs->id; ?>">
                        	<button type="button" class="btn btn-warning" <?php echo $access['edit']; ?>><i class="fa fa-pencil"></i></button>
                        </a>
                            <button type="button" class="btn btn-danger" 
                            onclick="confirm_delete('<?php echo label("confirm_delete"); ?>','<?php echo label("delete_warning"); ?>','<?php echo $this->home; ?>/delete/<?php echo $rs->id; ?>','<?php echo label("yes"); ?>','<?php echo label("cancle"); ?>');"  <?php echo $access['delete']; ?>><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr><td colspan="7" align="center" ><h1><?php echo label("empty_content"); ?></h1></td></tr>
    <?php endif; ?>
		</table>
</div><!-- End col-lg-12 -->
</div><!-- End row -->
<?php endif; ?>
