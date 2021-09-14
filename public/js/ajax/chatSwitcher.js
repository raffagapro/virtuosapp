$(function() {
    $('.chatModalBtn').on('click', function(e){
        // e.preventDefault();
        dataObj = {
          senderId: $('#senderId').val(),
          recieverId: $('#recieverId').val(),
        }
        // console.log(dataObj);
        $.ajax({
            url: '../chatGrabber',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('#token').val()},
            data: dataObj,
          })
          .done(data =>{
            console.log("success");
            $('#messageCont').empty();
            if (data[0].length === 0) {
              $('#messageCont').append('<p class="text-muted">Sin mensajes registrados...</p>')
            } else {
              let pros = '';
              data.forEach(i => {
                if (i.user_id === data[1].id) {
                  pros += '<div class="row mr-2">';
                  pros += '<div class="col-2"></div>';
                  pros += '<div class="alert alert-light col" role="alert">';
                  pros += `<p>`+i.body+`</p>`;
                  pros += '<hr class="m-1">';
                  pros += '<small class="mb-0 text-right">11:30am</small>';
                  pros += '</div></div>';
                } else {
                  pros += '<div class="row ml-2">';
                  pros += '<div class="alert alert-info col-10" role="alert">';
                  pros += `<p>`+i.body+`</p>`;
                  pros += '<hr class="m-1">';
                  pros += '<div class="row justify-content-end">';
                  pros += '<small class="mb-0 mr-3">11:30am</small>';
                  pros += '</div></div></div>';
                }
                $('#messageCont').append(pros);
              });
            }
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