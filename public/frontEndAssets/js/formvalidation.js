const uName = document.getElementById('name');
const phone = document.getElementById('mobile');
const password = document.getElementById('new_password');
const confPassword = document.getElementById('confirm_password');
const error = document.getElementsByClassName('error');
const reg = /^(?=.*?[a-zA-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;

function validation() {
	if (uName != null) {
		if (!/^([a-zA-Z])(?=.*?[a-zA-Z ]$).{3,}/.test(uName.value)) {
			uName.classList.add('is-invalid');
			error[0].style.display = 'block';
			return false;
		}
	}

	if (phone != null) {
		console.log(phone.value.length);
		if (!/^([0-9]).{9}$/.test(phone.value)) {
			phone.classList.add('is-invalid');
			error[0].style.display = 'block';
			return false;
		}
	}

	if (password != null) {
		if (!reg.test(password.value)) {
			password.classList.add('is-invalid');
			return false;
		}
		if (password.value != confPassword.value) {
			confPassword.classList.add('is-invalid');
			return false;
		}
	}

	return true;
}

if (password != null) {
	password.addEventListener('keyup', function() {
		console.log('fgdfg');
		if (reg.test(password.value)) {
			password.classList.remove('is-invalid');
			error[0].style.display = 'none';
		} else {
			error[0].style.display = 'block';
		}
	});
}

if (confPassword != null) {
	confPassword.addEventListener('blur', function() {
		if (password.value == confPassword.value) {
			confPassword.classList.remove('is-invalid');
			error[1].style.display = 'none';
		} else {
			error[1].style.display = 'block';
		}
	});
}
