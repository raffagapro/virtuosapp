$(function() {

    $('#classSearch').on('keyup',() =>{
        if ($('#classSearch').is(':focus')) {
            dataObj = {
                value: $("#classSearch").val(),
                studentId:$('#teacherId').val(),
            }
            // console.log(dataObj);
            $.ajax({
                url: '../../estudiantes/indv/claseSearcher',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('#token').val()},
                data: dataObj,
            })
            .done(data =>{
                // console.log("success");
                if (data[0].length !== 0) {
                    let pros = '';
                    let url= '//localhost:3000';
                    let token= $('#token').val();
                    let tCount = 0;
                    data[0].forEach(i => {
                        pros += '<tr>';
                        if (i.teacher === 0) {
                            pros += `<td class="text-left">`+i.label;
                        } else {
                            pros += `<td class="text-left text-danger">`+i.label;
                        }
                        pros += `<a href="`+ url +`/admin/maestros/clase/`+ Number(i.id )+`/`+ Number(data[1].id )+`"`;
                        pros += `class="btn btn-sm btn-primary text-white mr-2 float-right"`;
                        pros += `data-toggle="tooltip" data-placement="top" title="Agregar Clase">`;
                        pros += `<i class="fas fa-plus"></i></a>`;
                        pros += `</td></tr>`;
                        tCount++;
                    });
                    $('#classListCont').empty().append(pros);
                }else{
                    let pros = '<tr><td class="text-left">No se encontraron clases.</td></tr> ';
                    $('#classListCont').empty().append(pros);
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