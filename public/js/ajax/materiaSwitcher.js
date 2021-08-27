$(function() {
    $('.materiaBtn').on('click', function(e){
        // e.preventDefault();
        dataObj = {
            materiaId: $(this).attr('id'),
        }
        console.log(dataObj);
        $.ajax({
            url: 'materias/mGrabber',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('#token').val()},
            data: dataObj,
          })
          .done(data =>{
            console.log("success");
            $("#materiaModID").val(data.id);
            $("#modNombre").val(data.name);
            $("#modalForm").attr('action', '//localhost:3000/admin/materias/'+data.id);
          })
          .fail(e =>{
            // console.log("error");
            // console.log(e);
            // console.log(e.responseText);
          })
          .always(data =>{
            // console.log("always");
            // console.log(dataObj);
            // console.log(data);
          }); 
    });
});