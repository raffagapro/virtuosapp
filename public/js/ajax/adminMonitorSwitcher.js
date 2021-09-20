$(function() {
    $('.zoomModalBtn').on('click', function(e){
        // e.preventDefault();
        dataObj = {
            claseId: $(this).attr('id'),
        }
        // console.log(dataObj);
        $.ajax({
            url: '../cGrabber',
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
            url: '../chatGrabber',
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

    $('.homeworkBtn').on('click', function(e){
      // e.preventDefault();
      dataObj = {
          homeworkId: $(this).attr('id'),
      }
      // console.log(dataObj);
      $.ajax({
          url: '../../hGrabber',
          type: 'POST',
          headers: {'X-CSRF-TOKEN': $('#token').val()},
          data: dataObj,
      })
      .done(data =>{
          // console.log("success");
          $('#hwTitleCont').empty().append(data[0].title)
          $('#homeworkId').val(data[0].id);
          $('#modTitulo').val(data[0].title);
          //$("textarea[name='modBody']").val(data[0].body);
          tinymce.get('modBody').setContent(data[0].body);
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
          $('#modHWForm').attr('action', webUrl+'/admin/monitor/teacher/updateHomework/'+data[0].id);
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
          url: '../../sGrabber',
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
              $('#retroFrom').attr('action', webUrl+'/admin/monitor/teacher/newRetro');
          } else {
              $('#retroId').val(data[0].id);
              $("textarea[name='body']").val(data[0].body);
              $('#retroFrom').attr('action', webUrl+'/admin/monitor/teacher/updateRetro');
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