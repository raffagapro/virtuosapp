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

    $('.chatModalBtn').on('click', function(e){
        // e.preventDefault();
        var workingIds = $(this).attr('id');
        workingIds = workingIds.split('_');
        dataObj = {
            chatId: workingIds[0],
            recieverId: workingIds[1],
            senderId: $('#senderId').val(),
        }
        // console.log(dataObj);

        $.ajax({
            url: 'chatGrabber',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('#token').val()},
            data: dataObj,
          })
          .done(data =>{
            // console.log("success");
            $('#chatId').val(data[2])
            $('#nameCont').empty().append(data[1].name)
            if (data[1].perfil) {
                $('#profCont').empty().append('<img src="'+data[1].perfil+'" class="mini-img">') 
            } else {
                $('#profCont').empty().append('<i class="fas fa-circle fa-stack-2x text-light"></i><i class="fas fa-user fa-stack-1x fa-sm text-secondary"></i>')
            }
            $('#messageCont').empty();
            if (data[0].length === 0) {
              $('#messageCont').append('<p class="text-muted">Sin mensajes registrados...</p>')
            } else {
              let pros = '';
              data[0].reverse().forEach(i => {
                if (i.user_id !== data[1].id) {
                  pros += '<div class="row mr-2">';
                  pros += '<div class="col-2"></div>';
                  pros += '<div class="alert alert-light col" role="alert">';
                  pros += `<p>`+i.body+`</p>`;
                  pros += '<hr class="m-1">';
                  pros += '<small class="mb-0 text-right">'+dateParser(i.created_at)+'</small>';
                  pros += '</div></div>';
                } else {
                  pros += '<div class="row ml-2">';
                  pros += '<div class="alert alert-info col-10" role="alert">';
                  pros += `<p>`+i.body+`</p>`;
                  pros += '<hr class="m-1">';
                  pros += '<div class="row justify-content-end">';
                  pros += '<small class="mb-0 mr-3">'+dateParser(i.created_at)+'</small>';
                  pros += '</div></div></div>';
                }
            });
            $('#messageCont').append(pros);
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

    $('#studentSearch').on('keyup',() =>{
        if ($('#studentSearch').is(':focus')) {
            dataObj = {
                value: $("#studentSearch").val(),
                senderId:$('#senderId').val(),
            }
            // console.log(dataObj);
            $.ajax({
                url: '../maestro/studentSearcher',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('#token').val()},
                data: dataObj,
            })
            .done(data =>{
                // console.log("success");
                if (data[0].length !== 0) {
                    let pros = '';
                    let token= $('#token').val();
                    let tCount = 0;
                    data[0].forEach(i => {
                        pros += '<tr>';
                        pros += `<td class="text-left">`+i.name;
                        pros += `<a href="`+ webUrl +`/maestro/chat/`+ Number(i.id )+`"`;
                        pros += `class="btn btn-sm btn-primary text-white mr-2 float-right"`;
                        pros += `data-toggle="tooltip" data-placement="top" title="Mandar Mensaje">`;
                        pros += `<i class="fas fa-comment-medical"></i></a>`;
                        pros += `</td></tr>`;
                        tCount++;
                    });
                    $('#stidentListCont').empty().append(pros);
                }else{
                    let pros = '<tr><td class="text-left">No se encontraron estudiantes.</td></tr> ';
                    $('#stidentListCont').empty().append(pros);
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
        }
    });
});