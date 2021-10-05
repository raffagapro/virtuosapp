
function dateParser(date){
    
    const ndate = new Date();
    const zdate = new Date(date);
    const days = Math.floor((ndate - zdate) / (1000 * 3600 * 24));
    let finalDate;
    let wdate = date.split('T');
    let wtime = wdate[1].split('.');
    wtime = wtime[0].slice(0, -3);
    const ftime = wtime.split(':');
    if (ftime[0] >= 12) {
        wtime = wtime+'pm';
    } else {
        wtime = wtime+'am';
    }
    if (days > 0) {
        if (days == 1) {
            finalDate = 'Ayer - ' + wtime; 
        } else if(days == 7){
            finalDate = '1 semana - ' + wtime;
        } else if(days > 7){
            finalDate = Math.floor(days/7) + ' semanas - ' + wtime;
        } else {
            finalDate = days+' días - ' + wtime;
        }
    } else {
        finalDate = "Hoy - " + wtime;  
    }
    return finalDate;
}