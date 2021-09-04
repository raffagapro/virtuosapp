$(function() {
    $('.zoomModalBtn').on('click', function(e){
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
            $('#classNameCont').empty().append(data[0].label)
            $('#claseID').val(data[0].id);
            if (data[0].zlink !== null) {
                $('#zlink').val(data[0].zlink);
                $('#zoomBtn').removeClass('disabled');
                $('#zoomBtn').attr('href', data[0].zlink);
            }else{
                $('#zlink').val('');
                $('#zoomBtn').addClass('disabled');
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