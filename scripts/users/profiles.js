const addNew = () => {
  window.location.href = `${BASE_URL}users/profiles/add_profile`;
}

const edit = (id) => {
  window.location.href = `${BASE_URL}users/profiles/add_profile`;
  window.location.href = BASE_URL + 'users/profiles/edit_profile/'+id;
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
    closeOnConfirm: false
  }, () => {
    window.location.href = `${BASE_URL}users/profiles/delete_profile/${id}`;
  });
};


// function getDelete(id, name){
//   swal({
//     title:'Are sure ?',
//     text:'ต้องการลบ '+ name +' หรือไม่ ?',
//     type:'warning',
//     showCancelButton: true,
// 		confirmButtonColor: '#FA5858',
// 		confirmButtonText: 'ใช่, ฉันต้องการลบ',
// 		cancelButtonText: 'ยกเลิก',
// 		closeOnConfirm: false
//   },function(){
//     window.location.href = BASE_URL + 'users/profiles/delete_profile/'+id;
//   })
// }
