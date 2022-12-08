function goBack() {
	window.location.href = HOME;
}


function goToPage(page) {
	window.location.href = HOME + page;
}


function history() {
	window.location.href = HOME + 'history';
}


function viewDetail(code) {
	window.location.href = HOME + 'view_detail/'+code;
}


function placeOrder() {

	var na = 0;

	$('.na').each(function() {
		if($(this).val() == '1') {
			na++;
		}
	});

	if(na > 0) {
		swal({
			title:'Oops!',
			text:"สินค้าคงเหลือไม่เพียงพอกรุณาตรวจสอบรายการที่เป็นสีแดง",
			type:'warning'
		});

		return false;
	}

	//--- check free item
	var balance = 0;

	$('.free-item').each(function() {
		let bf = parseDefault(parseInt($(this).data('balance')),0);

		balance += bf;
	});

	if(balance > 0) {
		title = 'พบรายการที่ได้รับของแถม แต่ยังไม่ได้เลือกของแถม เมื่อคุณบันทึกออเดอร์แล้ว คุณจะไม่สามารถกลับมาเลือกของแถมภายหลังได้อีก ต้องการบันทึกออเดอร์หรือไม่ ?';
		swal({
			title:'Warning!',
			text:title,
			type:'warning',
			showCancelButton:true,
			cancelButtonText:'กลับไปแก้ไข',
			confirmButtonText:'บันทึกออเดอร์',
			closeOnConfirm:true
		},
		function(){
			saveAdd();
		});
	}
	else {
		saveAdd();
	}
}


function saveAdd() {
	const customer_code = $('#customer_code').val();
	const payToCode = $('#billToCode').val();
	const address = $('#BillTo').val();
	const shipToCode = $('#shipToCode').val();
	const address2 = $('#ShipTo').val();
	const priceList = $('#priceList').val();
	const payment = $('#payment').val();
	const channels = $('#channels').val();
	const remark = $('#remark').val();

	load_in();

	$.ajax({
		url:HOME + 'confirm_order',
		type:'POST',
		cache:false,
		data:{
			'CardCode' : customer_code,
			'PayToCode' : payToCode,
			'Address' : address,
			'ShipToCode' : shipToCode,
			'Address2' : address2,
			'PriceList' : priceList,
			'Payment' : payment,
			'Channels' : channels,
			'remark' : remark
		},
		success:function(rs) {
			load_out();

			if(rs === 'success') {
				swal({
					title:'Success',
					type:'success',
					timer:1000
				});

				setTimeout(function() {
					goBack();
				}, 1200);
			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});
			}
		}
	})
}


function getShipToAddress() {
	let code = $('#customer_code').val();
	let shipCode = $('#shipToCode').val();

	load_in();

	$.ajax({
		url:HOME + 'get_ship_to_address',
		type:'GET',
		cache:false,
		data:{
			'CardCode' : code,
			'ShipToCode' : shipCode
		},
		success:function(rs) {
			load_out();
			if(isJson(rs)) {
				let ds = $.parseJSON(rs);
				$('#ShipTo').val(ds.address);
			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});
			}
		}
	});
}


function getBillToAddress() {
	let code = $('#customer_code').val();
	let billCode = $('#billToCode').val();

	load_in();

	$.ajax({
		url:HOME + 'get_bill_to_address',
		type:'GET',
		cache:false,
		data:{
			'CardCode' : code,
			'BillToCode' : billCode
		},
		success:function(rs) {
			load_out();
			if(isJson(rs)) {
				let ds = $.parseJSON(rs);
				$('#BillTo').val(ds.address);
			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});
			}
		}
	});
}


function addTocart() {
	setTimeout(function() {
		const quota = $('#quotaNo').val();
		const cardCode = $('#customer_code').val();
		const payment = $('#payment').val();
		const channels = $('#channels').val();

		$('#itemModal').modal('hide');

		ds = [];
		items = [];

		$('.input-qty').each(function() {
			let id = $(this).data('id');
			let qty = parseDefault(parseInt($(this).val()), 0);

			if(qty > 0) {

				let code = $('#product-code-'+id).val();
				let arr = {"ItemCode" : code, "Qty" : qty};
				items.push(arr);
			}
		});


		if(items.length == 0) {
			setTimeout(function() {
				swal({
					title:'Warning',
					text:'กรุณาระบุจำนวนสินค้าอย่างน้อย 1 รายการ',
					type:'warning',
					showCancelButton:false,
					closeOnConfirm:true
				}, function() {
					$('#itemModal').modal('show');
				})
			}, 500)


			return false;
		}

		load_in();

		$.ajax({
			url:HOME + 'add_to_cart',
			type:'POST',
			cache:false,
			data:{
				'quotaNo' : quota,
				'CardCode' : cardCode,
				'Payment' : payment,
				'Channels' : channels,
				'items' : items
			},
			success:function(rs) {
				load_out();

				if(rs === 'success') {
					swal({
						title:'Success',
						type:'success',
						timer:1000
					});

					updateCart();
				}
				else {
					swal({
						title:'Error',
						text:rs,
						type:'error'
					})
				}
			}
		})

	}, 200); //-- setTimeout
}



function updateCart() {
	$.ajax({
		url:HOME + 'get_cart_table',
		type:'GET',
		cache:false,
		data:{
			'CardCode' : $('#customer_code').val()
		},
		success:function(rs) {
			if(isJson(rs))
			{
				let ds = $.parseJSON(rs);
				let source = $('#cart-template').html();
				let output = $('#cart-table');
				render(source, ds, output);

				recalTotal();
			}
		}
	});
}



function viewCart() {
	let vh = $(window).height();
	let hh = 61; //$('#modal-header').outerHeight();
	let fh = $('#modal-footer').outerHeight();
	let bh = vh - hh - fh;
	$('#modal-body').outerHeight(bh);

	$('#cartModal').modal('show');

}




function showCategoryItem(categoryCode) {
	const quota = $('#quotaNo').val();
	const cardCode = $('#customer_code').val();
	const payment = $('#payment').val();
	const channels = $('#channels').val();

	load_in();

	$.ajax({
		url:HOME + 'get_category_items',
		type:'GET',
		cache:false,
		data:{
			'category_code' : categoryCode,
			'CardCode' : cardCode,
			'quotaNo' : quota,
			'Payment' : payment,
			'Channels' : channels
		},
		success:function(rs) {
			load_out();
			if(isJson(rs)) {
				let ds = $.parseJSON(rs);
				let source = $('#item-template').html();
				let output = $('#item-table');

				render(source, ds, output);
			}

			$('#itemModal').modal('show');
		}
	})
}



function showItem(code, id) {
	const quota = $('#quotaNo').val();
	const cardCode = $('#customer_code').val();
	const payment = $('#payment').val();
	const channels = $('#channels').val();

	load_in();

	$.ajax({
		url:HOME + 'get_item',
		type:'GET',
		cache:false,
		data:{
			'ItemCode' : code,
			'CardCode' : cardCode,
			'quotaNo' : quota,
			'Payment' : payment,
			'Channels' : channels
		},
		success:function(rs) {
			load_out();
			if(isJson(rs)) {
				let ds = $.parseJSON(rs);
				let source = $('#item-template').html();
				let output = $('#item-table');

				render(source, ds, output);
			}

			$('#itemModal').on('shown.bs.modal', function() {
				$('#qty-'+id).focus();
			});

			$('#itemModal').modal('show');
		}
	})
}



function removeNonCheck() {
	$('.item-chk').each(function() {
		if($(this).is(':checked') == false) {
			id = $(this).val();

			$('#item-row-'+id).remove();
		}
	})
}


function closeModal() {
	$('#itemModal').modal('hide');
}



$('#item-qty').keyup(function() {
	let qty = parseDefault(parseInt($('#item-qty').val()), 0);
	let price = parseDefault(parseFloat($('#sell-price').val()), 0.00);

	if(qty <= 1) {
		qty = 1;
	}

	amount = qty * price;
	$('#item-qty').val(qty);
	$('#btn-price').text(addCommas(amount.toFixed(2)));
});


function recalTotal() {
	let totalAmount = 0;
	let totalQty = 0;

	$('.line-qty').each(function() {
		let no = $(this).data('no');
		let qty = parseDefault(parseInt($(this).val()), 0);
		let amount = parseDefault(parseFloat($('#line-total-'+no).val()), 0.00);
		totalQty += qty;
		totalAmount += amount;
	});

	$('#total-qty').text(addCommas(totalQty));
	$('#total-amount').text(addCommas(totalAmount.toFixed(2)));

	$('#bar-amount').text(addCommas(totalAmount.toFixed(2)));
	$('#top-amount').text(addCommas(totalAmount.toFixed(2)));
}



function removeRow(id){
	swal({
		title:"ต้องการลบสินค้าจากตะกร้า ?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: 'ยืนยัน',
		cancelButtonText: 'ยกเลิก',
		closeOnConfirm: true
		},
		function(){
			load_in();
			$.ajax({
				url:HOME + 'remove_cart_row',
				type:'POST',
				cache:false,
				data:{
					'id' : id
				},
				success:function(rs) {
					load_out();
					if(rs == 'success') {
						$('#cart-row-'+id).remove();
						recalTotal();
					}
					else {
						setTimeout(function() {
							swal({
								title:'Error!',
								type:'error',
								text:rs
							});
						}, 500);
					}
				}
			});
	});
}



function recalAmount(id) {
	qty = parseDefault(parseInt($('#qty-'+id).val()), 0);
	qty = qty < 0 ? 1 : qty;
	$('#qty-'+id).val(qty);
	sellPrice = parseDefault(parseFloat($('#sellPrice-'+id).val()), 0);

	amount = roundNumber(qty * sellPrice);

	$('#line-amount-'+id).text(addCommas(amount.toFixed(2)));
}



function checkout() {
	$('#cartModal').modal('hide');

	load_in();
	setTimeout(function() {
		window.location.href = HOME + 'checkout';
	}, 500)
}


function checkOutAll(el) {
	if(el.is(':checked')) {
		$('.chk-out').prop('checked', true);
	}
	else {
		$('.chk-out').prop('checked', false);
	}
}


function removeCheckRow() {
	var ids = [];

	$('.chk-out').each(function() {
		if($(this).is(':checked')) {
			ids.push($(this).val());
		}
	});

	if(ids.length > 0) {
		swal({
			title:"ต้องการลบสินค้าจากตะกร้า ?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก',
			closeOnConfirm: true
			},
			function(){
				load_in();
				$.ajax({
					url:HOME + 'remove_multi_cart_rows',
					type:'POST',
					cache:false,
					data:{
						'ids' : ids
					},
					success:function(rs) {
						load_out();
						if(rs == 'success') {
							setTimeout(function() {
								swal({
									title:'Deleted',
									type:'success',
									timer:1000
								});
							}, 200);


							$('.chk-out').each(function() {
								if($(this).is(':checked')) {
									id = $(this).val();
									$('#row-'+id).remove();
								}
							});

							window.location.reload();
						}
						else {
							setTimeout(function() {
								swal({
									title:'Error!',
									type:'error',
									text:rs
								});
							}, 500);
						}
					}
				});
		});
	}
}



function getFreeItemRule()
{
	cardCode = $.trim($('#customer_code').val());
	today = new Date();
	dd = String(today.getDate()).padStart(2, '0');
	mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	yyyy = today.getFullYear();

	docDate = dd + '-' + mm + '-' + yyyy;

	$.ajax({
		url:HOME + 'remove_free_rows',
		type:'POST',
		cache:false,
		data:{
			"CardCode" : cardCode
		},
		success:function(rs) {
			rs = $.trim(rs);

			if(rs === 'success') {

				$('.free-row').remove();

				ds = {
					'DocDate' : docDate,
					'CardCode' : cardCode,
					'Payment' : $('#payment').val(),
					'Channels' : $('#channels').val()
				};


				var items = {};
				//--- get sum item qty, amount
				$('.item-code').each(function() {
					itemCode = $(this).val();
					if(itemCode.length) {
						no = $(this).data('id');
						is_free = $('#is-free-'+no).val();
						if(is_free == 0) {
							product_id = $('#product-id-'+no).val();
							qty = parseDefault(parseInt($('#line-qty-'+no).val()), 0);
							amount = parseDefault(parseFloat($('#line-total-'+no).val()), 0.00);

							if(items.hasOwnProperty(product_id)) {
								qty += parseInt(items[product_id].qty);
								amount += parseFloat(items[product_id].amount);
							}

							items[product_id] = {"itemCode" : itemCode, "qty" : qty, "amount" : amount};
						}
					}
				});

				ds.items = items;

				if(Object.keys(items).length) {
					load_in();
					$.ajax({
						url:HOME + 'get_free_item_rule',
						type:'POST',
						cache:false,
						data:{
							"json" : JSON.stringify(ds)
						},
						success:function(rs) {
							load_out();

							if(isJson(rs)) {
								ds = $.parseJSON(rs);
								$.each(ds, function(index, value) {
									if($('#free-'+value.rule_id).length) {
										$('#free-'+value.rule_id).val(value.freeQty);
									}
									else {
										source = $('#free-input-template').html();
										output = $('#free-temp');
										render_append(source, value, output);

										source = $('#free-btn-template').html();
										output = $('#free-box');
										render_append(source, value, output);
									}
								});
							}
						}
					})
				}

			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});
			}
		}
	});

	$('#btn-save').removeClass('hide');
	$('#btn-draft').removeClass('hide');
}


function pickFreeItem(rule_id) {
	freeQty = $('#free-'+rule_id).val();
	uid = $('#free-'+rule_id).data('uid');
	picked = $('#free-'+rule_id).data('picked');

	if(rule_id != "" && rule_id > 0 && freeQty > 0 && picked < freeQty) {
		load_in();

		$.ajax({
			url:HOME + 'get_free_item',
			type:'GET',
			cache:false,
			data:{
				'rule_id' : rule_id,
				'freeQty' : freeQty,
				'picked' : picked,
				'uid' : uid
			},
			success:function(rs) {
				load_out();
				setTimeout(function() {
					$('#free-item-list').html(rs);
					$('.auto-select').focus(function() {
						$(this).select();
					});
					$('#free-item-modal').modal('show');

				}, 500)
			}
		});
	}
}


function addFreeRow(uuid) {
	let el = $('#input-'+uuid);
	let qty = parseDefault(parseInt(el.val()), );
	let product_id = el.data('item');
	let product_code = el.data('pdcode');
	let product_name = el.data('pdname');
	let parent_uid = el.data('parent');
	let rule_id = el.data('rule');
	let policy_id = el.data('policy');
	let img = el.data('img');
	let uom_code = el.data('uomcode');
	let uom_name = el.data('uom');
	let vat_code = el.data('vatcode');
	let vat_rate = el.data('vatrate');
	let price = el.data('price');
	let priceLabel = addCommas(price);
	let uid = uuid;
	let picked = 0;
	let freeQty = 0;
	let parent_row = "";

	$('.free-item').each(function() {
		if($(this).data('uid') == parent_uid) {
			parent_row = rule_id;
			freeQty = parseDefault(parseInt($(this).val()), 0);
			//picked = parseDefault(parseInt($(this).data('picked')), 0);
		}
	});


	$('.is-free').each(function() {
		if($(this).data('parent') == parent_uid) {
			let no = $(this).data('id');
			let pick = parseDefault(parseInt($('#line-qty-'+no).val()), 0);
			picked += pick;
		}
	});

	picked = picked + qty;
	balance = freeQty - picked;

	if(balance >= 0) {
		$('#btn-free-'+rule_id).text("Free "+balance);
	}

	if(freeQty == picked) {
		$('#free-item-modal').modal('hide');
	}

	if(freeQty < picked) {
		$('#free-item-modal').modal('hide');
		swal("Error!", "จำนวนเกิน", "error");
		return false;
	}

	$('.item-code').each(function() {
		if($(this).val() == '') {
			no = $(this).data('id');
			$('#row-'+no).remove();
		}
	})

	let cardCode = $('#customer_code').val();
	let channels_id = $('#channels').val();
	let payment_id = $('#payment').val();
	let quotaNo = $('#quotaNo').val();


	var data = {
		"uid" : uid,
		"CardCode" : cardCode,
		"channels_id" : channels_id,
		"payment_id" : payment_id,
		"quotaNo" : quotaNo,
		"parent_uid" : parent_uid,
		"product_id" : product_id,
		"ItemCode" : product_code,
		"ItemName" : product_name,
		"Qty" : qty,
		"rule_id" : rule_id,
		"policy_id" : policy_id
	};

	$.ajax({
		url:HOME + 'add_free_row',
		type:'POST',
		cache:false,
		data: data,
		success:function(rs) {
			if(isJson(rs)) {
				var ds = $.parseJSON(rs);
				if($('#'+uid).length) {
					let no = $('#'+uid).data('id');
					let cqty = parseDefault(parseInt($('#line-qty-'+no).val()), 0);
					let nqty = cqty + qty;
					$('#line-qty-'+no).val(nqty);
					$('#qtyLabel-'+no).text(addCommas(nqty));
				}
				else {
					var source = $('#free-row-template').html();
					var output = $('#checkout-table');
					render_append(source, ds, output);
				}
			}
		}
	});


	$('#free-' + parent_row).data('picked', picked);
	$('#free-' + parent_row).data('balance', balance);

	if(picked == freeQty) {
		$('#btn-free-' + parent_row).addClass('hide');
	}
}


function search() {
	$('#search-form').submit();
}

function clearText(page) {
	goToPage(page);
}

function clear_search_filter() {
	$.get(HOME + 'clear_item_filter', function() {
		goToPage('items');
	});
}


function clear_filter() {
	$.get(HOME + 'clear_filter', function() {
		history();
	});
}


$('#from_date').datepicker({
	dateFormat:'dd-mm-yy',
	onClose:function(sd) {
		$('#to_date').datepicker('option', 'minDate', sd);
	}
});

$('#to_date').datepicker({
	dateFormat:'dd-mm-yy',
	onClose:function(sd) {
		$('#from_date').datepicker('option', 'maxDate', sd);
	}
})
