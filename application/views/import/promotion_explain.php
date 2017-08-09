
<div class='modal fade' id='conditionTypeModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:800px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>คำอธิบาย "ประเภทเงื่อนไข"</h4>
		  </div>
		  <div class='modal-body'> 
          <table class="table table-bordered">
          	<tr><td colspan="2">ประเภทเงื่อนไข  หมายถึง ประเภทของเงื่อนไขที่ใช้ในการกำหนดการตรวจสอบโปรโมชั่น (การผูกโปรโมชั่น) มี 3 ตัวเลือกคือ ตัวสินค้า ยอดเงิน และทั้งคู่ ซิ่งควรระบุให้ตรงวัตถุประสงค์</td></tr>
          	<tr>
            	<td>ตัวสินค้า</td>
                <td> คือการกำหนดเงื่อนไขให้กับสินค้า ระบบจะทำการตรวจสอบเฉพาะรายการสินค้าและจำนวนชิ้น ไม่สนใจยอดเงิน หากมีสินค้าที่ตรงกับที่กำหนดไว้โปรโมชั่นจึงจะทำงานต่อไป</td>
          	</tr>
            <tr>
            	<td>ยอดเงิน</td>
                <td> คือการกำหนดเงื่อนไขกับยอดซื้อ ระบบจะตรวจสอบเฉพาะยอดซื้อ ไม่สนใจรายการสินค้า หากยอดซื้อเท่ากับหรือมากกว่าเป้าหมายที่กำหนดไว้ โปรโมชั่นจึงจะทำงานต่อไป</td>
            </tr>
             <tr>
            	<td>สินค้าและยอดเงิน</td>
                <td>คือการกำหนดเงื่อนไขกับสินค้าและยอดซื้อ เช่น ซื้อสินค้า A ครบ 1000 บาท รับส่วนลด 10%</td>
            </tr>
          </table>
         
          </div><!--- modal-body -->
          <div class="modal-footer">
          	<button data-dismiss='modal' type="button" class="btn btn-default">รับทราบ</button>
          </div>
		</div>
	</div>
</div>

<div class='modal fade' id='ruleTypeModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog' style='width:800px;'>
		<div class='modal-content'>
		  <div class='modal-header'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class='modal-title' id='myModalLabel'>คำอธิบาย "รูปแบบเงื่อนไข"</h4>
		  </div>
		  <div class='modal-body'> 
          <table class="table table-bordered">
          	<tr><td colspan="2">รูปแบบเงื่อนไข คือรูปแบบของวิธีการเชื่อมโยงเงื่อนไขมี 4 อย่างคือ แบบตายตัว แบบร่วมรายการ แบบจับคู่ และ แบบอะไรก็ได้</td></tr>
          	<tr>
            	<td>fixed</td>
                <td>แบบตายตัว คือวิธีการเชื่อมโยงแบบ 1 ต่อ 1 เช่น ซื้อสินค้า A จำนวน 2 ชิ้นแถม สินค้า B 1 ชิ้น เป็นต้น นั่นหมายถึง ถ้า ซื้อ 4 ชิ้น ก็จะได้ของแถมเป็น 2 ชิ้น และมีผลเฉพาะกับสินค้า A เท่านั้น </td>
          	</tr>
            <tr>
            	<td>include</td>
                <td>แบบร่วมรายการ คือวิธีการเชื่มโยงสินค้าแบบกลุ่ม เช่น ซื้อสินค้าสโมสรครบ 3 ชิ้นขึ้นไปรับส่วนลด 10% ซึ่งสินค้า 3 ชิ้นนั้น อาจ เป็น A, B, C อย่างละชิ้น หรือ A 2 ชิ้น, B 1 ชิ้น ก็ได้ </td>
            </tr>
            <tr>
            	<td>combine</td>
                <td>แบบจับคู่ คือวิธีการเชื่อมโยงสินค้าแบบจับคู่ตายตัว เช่น ซื้อ A กับ B แถม C </td>
            </tr>
            <tr>
            	<td>any</td>
                <td>แบบอะไรก็ได้ คือการเชื่อมโยงที่ไม่ได้มีการกำหนดสินค้า จะซื้อสินค้าอะไรก็ได้ ตามจำนวน หรือ มูลค่าที่กำหนดไว้</td>
            </tr>
          </table>
         
          </div><!--- modal-body -->
          <div class="modal-footer">
          	<button data-dismiss='modal' type="button" class="btn btn-default">รับทราบ</button>
          </div>
		</div>
	</div>
</div>



<script>
function showConditionType()
{
	$("#conditionTypeModal").modal('show');	
}

function showRuleType()
{
	$("#ruleTypeModal").modal('show');	
}


</script>