$(function() {
    // $('#studentSelect').select2();
    $('.addTutorBtn').on('click', function(e){
        // e.preventDefault();
        var tutorNum = $(this).attr('id');
        var workingNum = tutorNum.split('-');
        // console.log(workingNum[1]);
        $('#tutorNum').val(workingNum[1]);
        $('#tutorNumCont').empty().append(workingNum[1]);
    });

    $('#tutorSearch').on('keyup',() =>{
        if ($('#tutorSearch').is(':focus')) {
            dataObj = {
                value: $("#tutorSearch").val(),
                studentId:$('#studentId').val(),
                tutorNUm:$('#tutorNum').val(),
            }
            // console.log(dataObj);
            $.ajax({
                url: '../indv/tutorSearcher',
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
                        pros += `<a href="`+ webUrl +`/admin/estudiantes/tutor/`+ Number(i.id )+`/`+ Number(data[1].id )+`/`+Number(data[2])+`"`;
                        pros += `class="btn btn-sm btn-primary text-white mr-2 float-right"`;
                        pros += `data-toggle="tooltip" data-placement="top" title="Agregar Tutor">`;
                        pros += `<i class="fas fa-plus"></i></a>`;
                        pros += `</td></tr>`;
                        tCount++;
                    });
                    $('#tutorListCont').empty().append(pros);
                }else{
                    let pros = '<tr><td class="text-left">No se encontraron tutores.</td></tr> ';
                    $('#tutorListCont').empty().append(pros);
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

    $('#classSearch').on('keyup',() =>{
        if ($('#classSearch').is(':focus')) {
            dataObj = {
                value: $("#classSearch").val(),
                studentId:$('#studentId').val(),
            }
            // console.log(dataObj);
            $.ajax({
                url: '../indv/claseSearcher',
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
                        pros += `<td class="text-left">`+i.label;
                        pros += `<a href="`+ webUrl +`/admin/clase/student/`+ Number(i.id )+`/`+ Number(data[1].id )+`"`;
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