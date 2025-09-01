function remplazos(contenido) {
	var final;
	final =  contenido.replace(/&/gi,"**-**");
	final = escape(final);
    do{final = final.replace('+','%2B');}
    while(final.indexOf('+') >= 0);
    return final;	
	}