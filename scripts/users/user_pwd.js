
window.addEventListener('load', () => {
	const inputPwd = document.getElementById('pwd');
	const inputCmPwd = document.getElementById('cm-pwd');

	if(inputPwd && inputCmPwd) {
		inputPwd.addEventListener('input', debounce(() => validatePwd(), 300));
		inputCmPwd.addEventListener('input', debounce(() => validatePwd(), 300));
	}
});


const validatePassword = (pwd) => {
	if(USE_STRONG_PWD == 1) {
		const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
		return pattern.test(pwd);
	}

	return true;
}

function validatePwd() {
	const pwd = document.getElementById('pwd');
	const cmp = document.getElementById('cm-pwd');
	const pwdError = document.getElementById('pwd-error');
	const cmpError = document.getElementById('cm-pwd-error');

	const p = pwd.value.trim();
	const c = cmp.value.trim();

	if (!p) {
		setError(pwd, pwdError, 'Password is required!');
		validPwd = false;
		return false;
	}

	if (!validatePassword(p)) {
		setError(
			pwd,
			pwdError,
			'รหัสผ่านต้องมีความยาว 8 - 20 ตัวอักษร และต้องประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์เล็ก พิมพ์ใหญ่ และตัวเลขอย่างน้อย อย่างละตัว'
		);
		validPwd = false;
		return false;
	}

	clearError(pwd, pwdError);

	if (p !== c) {
		setError(cmp, cmpError, 'Password mismatch!');
		validPwd = false;
		return false;
	}

	clearError(cmp, cmpError);
	validPwd = true;
	return true;
}

const checkPassword = () => {
	const current = document.getElementById('cu-pwd');
	const newPass = document.getElementById('pwd');
	const conPass = document.getElementById('cm-pwd');
	const pasErr = document.getElementById('pwd-error');
	const cuErr = document.getElementById('cu-pwd-error');
	const cmErr = document.getElementById('cm-pwd-error');
	clearError(current, cuErr);
	clearError(newPass, pasErr);
	clearError(conPass, cmErr);
	
	if(current.value.length === 0) {
		setError(current, cuErr, "กรุณาใส่รหัสผ่านปัจจุบัน");
		return false;
	}

	if(newPass.value.length === 0) {
		setError(newPass, pasErr, 'กรุณากำหนดรหัสผ่าน');
		return false;
	}

	if(newPass.value === current.value) {
		setError(newPass, pasErr, "รหัสใหม่ต้องไม่ซ้ำกับรหัสปัจจุบัน");
		return false;
	}

	if(!validatePassword(newPass.value)) {
		setError(newPass, pasErr, 'รหัสผ่านต้องมีความยาว 8 - 20 ตัวอักษร และต้องประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์เล็ก พิมพ์ใหญ่ และตัวเลขอย่างน้อย อย่างละตัว');
		return false;
	}

	if(newPass.value !== conPass.value) {
		setError(conPass, cmErr, 'ยืนยันรหัสผ่านไม่ตรงกับรหัสผ่านใหม่');
		return false;
	}

	return true;
}


const validateCurrentPassword = async (uid, pwd) => {
	const url = `${BASE_URL}user_pwd/validate_current_password`;
	const data = { uid:uid, pwd:pwd };
	
	try {
		const response = await postData(url, data);
		const res = await response.text();
		return res === 'valid';
	}
	catch (err) {
		showError(err);
		return false;
	}
}

async function changePassword() {
	if(checkPassword()) {
		const uid = document.getElementById('uid').value;
		const current = document.getElementById('cu-pwd');
		const newPass = document.getElementById('pwd');

		if( ! await validateCurrentPassword(uid, current.value.trim()) ) {
			setError(current, document.getElementById('cu-pwd-error'), 'รหัสผ่านปัจจุบันไม่ถูกต้อง');
			return false;
		}

		const url = `${BASE_URL}user_pwd/change_password`;
		const data = { uid:uid, pwd:current.value.trim(), new_pwd:newPass.value.trim() };

		try {
			const response = await postData(url, data);
			const res = await response.text();

			if(res === 'success') {
				swal({
					title:'Success',
					type:'success',
					timer:1000
				})
			}
			else {
				setError(newPass, document.getElementById('pwd-error'), res);
				return false;
			}
		}
		catch (err) {
			showError(err);
			return false;
		}
	}
}

const showPwd = (el, id) => {
	const input = document.getElementById(id);
	if(input.type === 'password') {
		input.type = 'text';
		el.classList.remove('fa-eye');
		el.classList.add('fa-eye-slash');
	}
	else {
		input.type = 'password';
		el.classList.remove('fa-eye-slash');
		el.classList.add('fa-eye');
	}
}