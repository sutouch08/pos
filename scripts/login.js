function showPwd() {
	var x = document.getElementById("pwd");
	var y = document.getElementById("pwd-btn");

	if (x.type === "password") {
		x.type = "text";
		y.classList.remove('fa-eye');
		y.classList.add('fa-eye-slash');
	}
	else {
		x.type = "password";
		y.classList.remove('fa-eye-slash');
		y.classList.add('fa-eye');
	}
}


const validateLogin = function () {
	const username = document.getElementById('uname');
	const password = document.getElementById('pwd');

	username.classList.remove('has-error');
	password.classList.remove('has-error');

	if (username.value.trim() === '') {
		username.classList.add('has-error');
		username.focus();
		return false;
	}

	if (password.value.trim() === '') {
		password.classList.add('has-error');
		password.focus();
		return false;
	}

	return true;
}


async function doLogin() {
	if (!validateLogin()) {
		return false;
	}

	const uname = document.getElementById('uname').value.trim();
	const pwd = document.getElementById('pwd').value.trim();
	const remember = document.getElementById('remember').checked ? 1 : 0;
	const url = `${BASE_URL}users/authentication/validate_credentials`;
	const data = {
		uname: uname,
		pwd: pwd,
		remember: remember
	};

	try {
		const response = await postData(url, data);
		const res = await response.json();

		if (res.status === 'success') {
			window.location.href = BASE_URL;
		} else {
			$('#login-error').text(res.message);
		}
	} catch (error) {
		console.error('Error during login:', error);
		$('#login-error').text('An error occurred. Please try again.');
	}
}

const unameInput = document.getElementById('uname');
unameInput.addEventListener('keyup', function (e) {
	if (e.key === 'Enter') {
		const pwd = document.getElementById('pwd');

		if(pwd.value.trim() === '') {
			pwd.focus();
		} else {
			doLogin();
		}		
	}
});

const pwdInput = document.getElementById('pwd');
pwdInput.addEventListener('keyup', function (e) {
	if (e.key === 'Enter') {
		doLogin();
	}	
});

const loginButton = document.getElementById('btn-login');
loginButton.addEventListener('click', function () {
	doLogin();
});
