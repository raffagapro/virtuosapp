$(function() {
    $('.classBtnModal').on('click', function(e){
        // e.preventDefault();
        dataObj = {
            claseId: $(this).attr('id'),
        }
        // console.log(dataObj);
        $.ajax({
            url: 'cGrabber',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('#token').val()},
            data: dataObj,
          })
          .done(data =>{
            // console.log("success");
            $('#modTitleCont').removeClass('text-danger');
            if (data[0].status === 0) {
              $('#modTitleCont').addClass('text-danger');
            }
            $("#claseNameCont").empty().append(data[0].label);
            $("#claseModID").val(data[0].id);
            $("#materiaModID").val(data[0].materia_id);
            $("#modLabel").val(data[0].label);
            $("#modSdate").val(data[0].sdate);
            $("#modEdate").val(data[0].edate);
            teacherSelect = '<option value=0>Sin Maestro</option>';
            if (data[1].length > 0) {
              data[1].forEach(t => {
                if (t.id == data[0].teacher) {
                  teacherSelect += '<option value='+t.id+' selected>'+t.name+'</option>';
                } else {
                  teacherSelect += '<option value='+t.id+'>'+t.name+'</option>';
                }
              });
            } else {
              teacherSelect += '<option value=0 disabled>No hay maestros registrados</option>';
            }
            $("#teacherId").empty().append(teacherSelect);
            $("#modalForm").attr('action', webUrl+'/admin/clase/'+data[0].id);
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