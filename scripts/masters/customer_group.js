let click = 0;
let validCode = false;
let validName = false;

const inputCode = document.getElementById('code');
const inputName = document.getElementById('name');
const regex = /[^a-zA-Z0-9-_.@]+/gi;

if(inputCode) {
  inputCode.addEventListener('keyup', () => validInput(inputCode, regex));
  inputCode.addEventListener('focusout', () => validateCode());
}

if(inputName) {
  inputName.addEventListener('focusout', () => validateName());
}


function addNew() {
  window.location.href = `${HOME}add_new`;
}


function edit(id) {
  window.location.href = `${HOME}edit/${id}`;
}


async function add() {
  if(click !== 0) {
    return false;
  }

  click = 1;

  if(!validCode || !validName) {
    click = 0;
    return false;
  }

  clearErrorByClass('e');

  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');
  const url = `${HOME}add`;
  const data = {
    code : inputCode.value.trim(),
    name : inputName.value.trim()
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method:'POST',
      headers:{'Content-Type' : 'application/json'},
      body:JSON.stringify(data)
    });

    const text = await response.text();
    
    setTimeout(() => {
      loadOut();

      if(text.trim() === 'success') {
        swal({
          title:'Success',
          type:'success',
          timer:1000
        });

        setTimeout(() => { addNew() }, 1200);
      }
      else {
        showError(text);
      }
    }, 500);

    click = 0;
  }
  catch (err) {
    click = 0;
    loadOut();
    showError(err);
  }  
}


async function update() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  if (!validCode || !validName) {
    click = 0;
    return false;
  }

  clearErrorByClass('e');

  const id = document.getElementById('id').value;
  const inputCode = document.getElementById('code');
  const inputName = document.getElementById('name');
  const url = `${HOME}update`;
  const data = {
    id: id,
    code: inputCode.value.trim(),
    name: inputName.value.trim()
  };

  loadIn();

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const text = await response.text();

    setTimeout(() => {
      loadOut();
      click = 0;

      if (text.trim() === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });        
      }
      else {
        showError(text);
      }
    }, 500);

    click = 0;
  }
  catch (err) {
    click = 0;
    loadOut();
    showError(err);
  }
}


async function validateCode() {
  const input = document.getElementById('code');
  const errorBox = document.getElementById('code-error');
  const id = document.getElementById('id').value.trim();
  const value = input.value.trim();

  if(!value) {
    setError(input, errorBox, 'Code is Required');
    validCode = false;
    return false;
  }

  const url = `${HOME}is_exists_code`;
  const result = await validateRemote(url, {code : value, id : id});

  if (result === 'exists') {
    setError(input, errorBox, 'Code already exists!');
    validCode = false;
    return false;
  }

  clearError(input, errorBox);
  validCode = true;
  return true;
}


async function validateName() {
  const input = document.getElementById('name');
  const errorBox = document.getElementById('name-error');
  const id = document.getElementById('id').value.trim();
  const value = input.value.trim();

  if (!value) {
    setError(input, errorBox, 'Name is Required');
    validName = false;
    return false;
  }

  const url = `${HOME}is_exists_name`;
  const result = await validateRemote(url, { name: value, id: id });

  if (result === 'exists') {
    setError(input, errorBox, 'Name already exists!');
    validName = false;
    return false;
  }

  clearError(input, errorBox);
  validName = true;
  return true;
}


function getDelete(id, code, name){
  swal({
    title:'Are sure ?',
    text:`ต้องการลบ ${code} : ${name} หรือไม่ ?`,
    type:'warning',
    showCancelButton: true,
		confirmButtonColor: '#FA5858',
		confirmButtonText: 'ใช่, ฉันต้องการลบ',
		cancelButtonText: 'ยกเลิก',
		closeOnConfirm: true
  },function() {
    
    load_in();

    setTimeout(() => {
      $.ajax({
        url:`${HOME}delete`,
        type:'POST',
        cache:false,
        data:{
          'id' : id
        },
        success:function(rs) {
          load_out();

          if(rs.trim() === 'success') {
            swal({
              title:'Success',
              type:'success',
              timer:1000
            });

            $(`#row-${id}`).remove();
            reIndex();
          }
          else {
            showError(rs);
          }
        },
        error:function(rs) {
          showError(rs);
        }
      })
    }, 500);    
  })
}
