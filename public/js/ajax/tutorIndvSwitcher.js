$(function() {
    $('#studentSearch').on('keyup',() =>{
        if ($('#studentSearch').is(':focus')) {
            dataObj = {
                value: $("#studentSearch").val(),
                tutorId:$('#tutorId').val(),
            }
            // console.log(dataObj);
            $.ajax({
                url: '../../clase/indv/studentSearcher',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('#token').val()},
                data: dataObj,
            })
            .done(data =>{
                // console.log("success");
                if (data[0].length !== 0) {
                    let pros = '';
                    let url= '//localhost:3000';
                    // let url= '//virtuousapp.herokuapp.com';
                    let token= $('#token').val();
                    let tCount = 0;
                    data[0].forEach(i => {
                        pros += '<tr>';
                        pros += `<td class="text-left">`+i.name;
                        pros += `<a href="`+ url +`/admin/tutores/student/`+ Number(data[2].id )+`/`+ Number(i.id )+`"`;
                        pros += `class="btn btn-sm btn-primary text-white mr-2 float-right"`;
                        pros += `data-toggle="tooltip" data-placement="top" title="Agregar Alumno">`;
                        pros += `<i class="fas fa-plus"></i></a>`;
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