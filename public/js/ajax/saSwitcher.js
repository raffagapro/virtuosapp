$(function() {
    $('.modBtn').on('click', function(e){
        // e.preventDefault();
        dataObj = {
            roleId: $(this).attr('id'),
        }
        // console.log(dataObj);
        $.ajax({
            url: 'sa/rGrabber',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('#token').val()},
            data: dataObj,
          })
          .done(data =>{
            console.log("success");
            $('#roleNameCont').empty().append(data.name);
            $("#modRoleFrom").attr('action', webUrl+'/admin/sa/updateRole/'+data.id);
            $("#modNombre").val(data.name);
          })
          .fail(e =>{
            console.log("error");
            console.log(e);
            console.log(e.responseText);
          })
          .always(data =>{
            console.log("always");
            console.log(dataObj);
            console.log(data);
          }); 
    });
});