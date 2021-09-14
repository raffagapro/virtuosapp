$(function() {
    $('.messageBtn').on('click', function(e){
        dataObj = {
            chatId: $(this).attr('id'),
        }
        console.log(dataObj);
        $.ajax({
            url: '../chatMarker',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('#token').val()},
            data: dataObj,
        })
        .done(data =>{
            // console.log("success");
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