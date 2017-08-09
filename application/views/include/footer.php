<!-- PAGE CONTENT ENDS --> 
		</div><!-- /.page-content -->
</div><!-- /.main-content -->
	</div><!-- /.main-content-inner -->        
        
<div class="footer">
    <div class="footer-inner">
        <!-- #section:basics/footer -->
        <div class="footer-content">
            <span class="bigger-120">
            <span class="blue bolder">POS</span>
            Online &copy; 2013-2014
            </span>
        </div>
    <!-- /section:basics/footer -->
    </div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
	<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
            
</div><!-- /.main-container -->
<style>
.centered {
	width: 150px;
  	position: fixed;
  	top: 50%;
 	left: 50%;
 	margin-top: -50px;
  	margin-left: -75px;
}
</style>
    <div id="loader" class="centered" style="width: 150px; height:100px; padding-top: 15px; display:none; opacity:0;">
        <div style="width:100%;  text-align:center; margin-bottom:10px;">
        	<img src='<?php echo base_url(); ?>assets/images/loading.gif' width="50px">
        </div>
    	<div style="width:100%;  text-align:center; margin-top:15px; font-size:12px;">
    		<span><strong>Loading....</strong></span>
    	</div>
    </div> 

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url(); ?>assets/js/ace/elements.scroller.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/elements.fileinput.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/elements.typeahead.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/elements.wysiwyg.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/elements.spinner.js"></script>
        
		<script src="<?php echo base_url(); ?>assets/js/ace/elements.treeview.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/elements.wizard.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/elements.aside.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/ace.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/ace.ajax-content.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/ace.touch-drag.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/ace.sidebar.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/ace.sidebar-scroll-1.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/ace.submenu-hover.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/ace.widget-box.js"></script>

		<script src="<?php echo base_url(); ?>assets/js/ace/ace.widget-on-reload.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ace/ace.searchbox-autocomplete.js"></script>
        <script src="<?php echo base_url(); ?>assets/script/main.js"></script>
        

		<!-- inline scripts related to this page -->
<script> 
function load_in(){
	var x = ($(document).innerWidth()/2)-50;
	$("#loader").css("display","");
	$("#loader").css("left",x);
	$("#loader").animate({opacity:0.8},100);		
}
function load_out(){
	$("#loader").animate({opacity:0},100, function(){ $("#loader").css("display","none");});
}   

function removeCommas(str) {
    while (str.search(",") >= 0) {
        str = (str + "").replace(',', '');
    }
    return str;
};

function addCommas(input){
	 return (
	 	input.toString()).replace(/^([-+]?)(0?)(\d+)(.?)(\d+)$/g, function(match, sign, zeros, before, decimal, after) { 
	 		var reverseString = function(string) { return string.split('').reverse().join(''); };
	 		var insertCommas  = function(string) { 
					var reversed   = reverseString(string);
					var reversedWithCommas = reversed.match(/.{1,3}/g).join(',');
					return reverseString(reversedWithCommas);
					};
				return sign + (decimal ? insertCommas(before) + decimal + after : insertCommas(before + after));
				});
}

function isDate(txtDate){
	  var currVal = txtDate;
	  if(currVal == '')
	    return false;  
	  //Declare Regex 
	  var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
	  var dtArray = currVal.match(rxDatePattern); // is format OK?
	  if (dtArray == null){
		     return false;
	  }
	  //Checks for mm/dd/yyyy format.	  
	  dtDay= dtArray[1];
	  dtMonth = dtArray[3];
	  dtYear = dtArray[5];
	  if (dtMonth < 1 || dtMonth > 12){
	      return false;
	  }else if (dtDay < 1 || dtDay> 31){
	      return false;
	  }else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31){
	      return false;
	  }else if (dtMonth == 2){
	     var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
	     if (dtDay> 29 || (dtDay ==29 && !isleap)){
	          return false;
		 }
	  }
	  return true;
	}

function checkerror(){
    if($("#error").length){
		var mess = $("#error").val();
		swal("เกิดข้อผิดพลาด!", mess, "error");
	}else if($("#success").length){
		var mess = $("#success").val();
		swal({ title: "สำเร็จ", text: mess, timer: 1000, type: "success"});
	}else if($("#info").length){
		var mess = $("#info").val();
		swal({ title: "สำเร็จ", text: mess, html : true, type: "success"});
	}
}  

//**************  Handlebars.js  **********************//
function render(source, data, output){
	var template = Handlebars.compile(source);
	var html = template(data);
	output.html(html);
}

function render_append(source, data, output)
{
	var template 	= Handlebars.compile(source);
	var html 			= template(data);
	output.append(html);
}

function render_prepend(source, data, output)
{
	var template		= Handlebars.compile(source);
	var html			= template(data);
	output.prepend(html);	
}

var downloadTimer;
function get_download(token)
{
	load_in();
	downloadTimer = window.setInterval(function(){
		var cookie = $.cookie("file_download_token");
		if(cookie == token)
		{
			finished_download();
		}
	}, 1000);
}

function finished_download()
{
	window.clearInterval(downloadTimer);
	$.removeCookie("file_down_load_token");
	load_out();
}

$("#set_rows").keyup(function(e){
	if(e.keyCode == 13 ){ set_rows(); }
});

function set_rows()
{
	
	var rows =$("#set_rows").val();
	if(rows == "")
	{
		swal("จำนวนแถวต้องเป็นตัวเลขเท่านั้น");
		return false;
	}else{
		load_in();
		$.ajax({
			url:"<?php echo base_url(); ?>admin/tool/set_rows",type:"POST",cache:false,
			data:{ "rows" : rows },
			success: function(rs)
			{
				load_out();
				var rs = $.trim(rs);
				if(rs == "success")
				{
					window.location.reload();
				}else{
					swal("ไม่สามารถเปลี่ยนจำนวนแถวต่อหน้าได้ กรุณาลองใหม่อีกครั้งภายหลัง");
				}
			}
		});
	}
}

</script>
</body>
</html>