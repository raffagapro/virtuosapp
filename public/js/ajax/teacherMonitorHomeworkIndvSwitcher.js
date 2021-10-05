$(function() {

    $('.retroBtn').on('click', function(e){
        // e.preventDefault();
        dataObj = {
            studentId: $(this).attr('id'),
            homeworkId: $('#homeworkId').val(),
        }
        // console.log(dataObj);
        $.ajax({
            url: '../sGrabber',
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
                $('#retroForm').attr('action', webUrl+'/coordinador/monitor/newRetro');
            } else {
                $('#retroId').val(data[0].id);
                $("textarea[name='body']").val(data[0].body);
                $('#retroForm').attr('action', webUrl+'/coordinador/monitor/updateRetro');
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