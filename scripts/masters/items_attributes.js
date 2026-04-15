
async function validateAttibuteCode(name) {
  const inputCode = document.getElementById(`${name}-code`);
  const codeError = document.getElementById(`${name}-code-error`);
  const code = inputCode.value.trim();

  if (!code) {
    setError(inputCode, codeError, "Code is Required");
    return false;
  }

  //--- check duplicated
  const url = `${HOME}is_exists_attribute_code`;
  const res = await validateRemote(url, { attribute: name, code: code });

  if (res === 'exists') {
    setError(inputCode, codeError, 'Code already exists');
    return false;
  }

  clearError(inputCode, codeError);
  return true;
}

async function validateAttibuteName(name) {
  const inputName = document.getElementById(`${name}-name`);
  const nameError = document.getElementById(`${name}-name-error`);
  const value = inputName.value.trim();

  if (!value) {
    setError(inputName, nameError, "Name is Required");
    return false;
  }

  //--- check duplicated  
  const url = `${HOME}is_exists_attribute_name`;
  const res = await validateRemote(url, { attribute: name, name: value });

  if (res === 'exists') {
    setError(inputName, nameError, 'Name already exists');
    return false;
  }

  clearError(inputName, nameError);
  return true;
}

async function addAttribute(attribute) {
  const code = document.getElementById(`${attribute}-code`).value.trim();
  const name = document.getElementById(`${attribute}-name`).value.trim();

  if (!await validateAttibuteCode(attribute)) {
    return false;
  }

  if (!await validateAttibuteName(attribute)) {
    return false;
  }

  const data = {
    code: code,
    name: name
  };

  if (attribute === 'color') {
    data.group_id = $('#color-group').val();
  }

  if (attribute === 'size') {
    data.group_id = $('#size-group').val();
  }

  $.ajax({
    url: `${HOME}add_attribute`,
    method: 'POST',
    data: {
      attribute: attribute,
      data: JSON.stringify(data),
    },
    success: function (rs) {
      if (isJson(rs)) {
        const data = JSON.parse(rs);
        if (data.status === 'success') {
          $(`#${attribute}-modal`).modal('hide');
          $(`#${attribute}`).append(new Option(data.data.name, data.data.id, true, true)).trigger('change');
        }
        else {
          showError(data.message);
        }
      }
      else {
        showError(rs);
      }
    },
    error: function (rs) {
      showError(rs);
    }
  });
}



function showAttributeModal(name) {
  clearAttrFields(name);
  setFocus(name);
  $(`#${name}-modal`).modal('show');
}


function clearAttrFields(name) {
  $(`#${name}-code`).val('');
  $(`#${name}-name`).val('');
  $(`#${name}-code-error`).text('');
  $(`#${name}-name-error`).text('');

  if (name === 'color') {
    $('#color-group').val('').trigger('change');
  }

  if (name === 'size') {
    $('#size-group').val('').trigger('change');
  }
}


function setFocus(name) {
  $(`#${name}-modal`).on('shown.bs.modal', function () {
    $(`#${name}-code`).focus();
  });
}