$(function() {
    // $('#studentSelect').select2();

    $('#teacherSearch').on('keyup',() =>{
        if ($('#teacherSearch').is(':focus')) {
            dataObj = {
                value: $("#teacherSearch").val(),
                coordId:$('#coordId').val(),
            }
            // console.log(dataObj);
            $.ajax({
                url: '../teacherSearcher',
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
                        pros += `<a href="`+ webUrl +`/admin/coordinator/addTeacher/`+ Number(data[1].id )+`/`+ Number(i.id )+`"`;
                        pros += `class="btn btn-sm btn-primary text-white mr-2 float-right"`;
                        pros += `data-toggle="tooltip" data-placement="top" title="Agregar Maestro">`;
                        pros += `<i class="fas fa-plus"></i></a>`;
                        pros += `</td></tr>`;
                        tCount++;
                    });
                    $('#teacherListCont').empty().append(pros);
                }else{
                    let pros = '<tr><td class="text-left">No se encontraron maestros.</td></tr> ';
                    $('#teacherListCont').empty().append(pros);
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