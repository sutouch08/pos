var click = 0;

const addNew = () => {
  window.location.href = `${HOME}add_new`;
}


const edit = (id) => {
  window.location.href = `${HOME}edit/${id}`;  
}


function add() {
  if(click !== 0) {
    return false;
  }

  click = 1;

  const name = $('#name');
  
  name.clearError();
  
  if(name.val().trim() == "") {
    name.hasError('Required');
    click = 0;
    return false;
  }

  $.ajax({
    url:`${HOME}add`,
    type:'POST',
    cache:false,
    data:{      
      'name' : name.val().trim()
    },
    success:function(rs) {
      click = 0;

      if(rs.trim() === 'success') {
        swal({
          title:'Success',
          type:'success',
          timer:1000
        });

        setTimeout(() => {
          addNew();
        }, 1200);
      }
      else {
        showError(rs);
      }
    },
    error:function(rs) {
      click = 0;
      showError(rs);
    }
  })
}


function update() {
  if (click !== 0) {
    return false;
  }

  click = 1;

  const name = $('#name');
  const id = $('#id').val();

  name.clearError();

  if (name.val().trim() == "") {
    name.hasError('Required');
    click = 0;
    return false;
  }

  $.ajax({
    url: `${HOME}update`,
    type: 'POST',
    cache: false,
    data: {
      'id' : id,
      'name': name.val().trim()
    },
    success: function (rs) {
      click = 0;

      if (rs.trim() === 'success') {
        swal({
          title: 'Success',
          type: 'success',
          timer: 1000
        });

        setTimeout(() => {
          addNew();
        }, 1200);
      }
      else {
        showError(rs);
      }
    },
    error: function (rs) {
      click = 0;
      showError(rs);
    }
  })
}


const getDelete = (id, name) => {
  swal({
    title: 'Are sure ?',
    text: `ต้องการลบ ${name} หรือไม่ ?`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#FA5858',
    confirmButtonText: 'ใช่, ฉันต้องการลบ',
    cancelButtonText: 'ยกเลิก',
    closeOnConfirm: true
  }, () => {
    loadIn();

    setTimeout(() => {
      $.ajax({
        url:`${HOME}delete`,
        type:'POST',
        cache:false,
        data:{
          'id' : id
        },
        success:function(rs) {
          loadOut();

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
  });
};
