$(function() {
    $('.homeworkBtn').on('click', function(e){
        // e.preventDefault();
        dataObj = {
            homeworkId: $(this).attr('id'),
        }
        // console.log(dataObj);
        $.ajax({
            url: 'hGrabber',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('#token').val()},
            data: dataObj,
        })
        .done(data =>{
            // console.log("success");
            $('#hwTitleCont').empty().append(data[0].title)
            $('#homeworkId').val(data[0].id);
            $('#modTitulo').val(data[0].title);
            $("textarea[name='modBody']").val(data[0].body);
            $('#modVlink').val(data[0].vlink);
            $('#modEdate').val(data[0].edate);
            let pros = '';
            pros += `<option value=0>Grupal</option>`;
            data[1].forEach(s => {
                if (Number(s.id) === Number(data[0].student)) {
                    pros += `<option value=`+Number(s.id)+` selected>`+s.name+`</option>`;
                } else {
                    pros += `<option value=`+Number(s.id)+`>`+s.name+`</option>`;
                }
            });
            $('#modStudentId').empty().append(pros);
            $('#modHWForm').attr('action', '//localhost:3000/maestro/homework/'+data[0].id);
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

    $('.retroBtn').on('click', function(e){
        // e.preventDefault();
        dataObj = {
            studentId: $(this).attr('id'),
            homeworkId: $('#homeworkId').val(),
        }
        // console.log(dataObj);
        $.ajax({
            url: '../clase/sGrabber',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('#token').val()},
            data: dataObj,
        })
        .done(data =>{
            // console.log("success");
            $('#studentNameCont').empty().append(data[1].name)
            $('#studentId').val(data[1].id);
            if (data[0] === 0) {
                $("textarea[name='body']").val('');
                $('#retroFrom').attr('action', '//localhost:3000/maestro/tarea/newRetro');
            } else {
                $('#retroId').val(data[0].id);
                $("textarea[name='body']").val(data[0].body);
                $('#retroFrom').attr('action', '//localhost:3000/maestro/tarea/updateRetro');
            }
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