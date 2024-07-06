
function controlTag(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; 
    else if (tecla==0||tecla==9)  return true;
    patron =/[0-9\s]/;
    n = String.fromCharCode(tecla);
    return patron.test(n); 
}

function testText(txtString){
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}

function testEntero(intCant){
    var intCantidad = new RegExp(/^([0-9])*$/);
    if(intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}

function fntEmailValidate(email){
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})$/);
    if (stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }
}

function fntValidText(){
	let validText = document.querySelectorAll(".validText");
    validText.forEach(function(validText) {
        validText.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testText(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
    validNumber.forEach(function(validNumber) {
        validNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEntero(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
    validEmail.forEach(function(validEmail) {
        validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}				
		});
	});
}

function fntValidPhoneNumber() {
    let validPhoneNumbers = document.querySelectorAll(".validPhoneNumber");
    validPhoneNumbers.forEach(function (input) {
        input.addEventListener('input', function () {
            let inputValue = this.value.trim(); // Trimming leading and trailing spaces

            var phoneNumberPattern = /^[9]\d{8}$/;

            if (!phoneNumberPattern.test(inputValue)) {
                this.classList.add('is-invalid'); // Add invalid class
            } else {
                this.classList.remove('is-invalid'); // Remove invalid class
            }
            if (inputValue.length > 9) {
                this.value = inputValue.substring(0, 9);
            }
        });
    });
}


// function validarIdentificacion() {
//     const validDNIs = document.querySelectorAll('.validDNI');
//     validDNIs.forEach(function (input) {
//         input.addEventListener('input', function () {
//             let valor = this.value.trim();

//             // Limpiar consola
//             console.clear();

//             // No hacer nada si el valor está vacío
//             if (valor.length === 0) {
//                 return;
//             }
//             if (valor.length < 8) {
//                 console.log("11")
//                 this.classList.add('is-invalid'); // Agregar clase de inválido
//             }else{
//                 console.log("22")

//             this.classList.remove('is-invalid');

//             }

//             // Verificar el primer carácter
//             const primerCaracter = valor.charAt(0);

//             // Permitir solo letras o números en el primer carácter
//             if (!/^[A-Za-z0-9]$/.test(primerCaracter)) {
//                 valor = valor.slice(0, -1);
//                 this.value = valor;
//                 this.classList.add('is-invalid'); // Agregar clase de inválido
//                 console.error('El primer carácter debe ser una letra o un número.');
//                 return; // Salir de la función temprano si no cumple con la validación
//             } else {
//                 this.classList.remove('is-invalid'); // Quitar clase de inválido si es válido
//             }

//             // Verificar los caracteres restantes
//             const numeros = valor.slice(1);

//             // Permitir solo números en los caracteres restantes
//             if (!/^\d{0,7}$/.test(numeros)) { // Aquí permitimos hasta 7 números después del primer carácter
//                 this.value = primerCaracter + numeros.replace(/\D/g, '');
//                 this.classList.add('is-invalid'); // Agregar clase de inválido
//                 console.error('Los siguientes caracteres deben ser números.');
//                 return; // Salir de la función temprano si no cumple con la validación
//             } else {
//                 this.classList.remove('is-invalid'); // Quitar clase de inválido si es válido
//             }

//             // Si pasa todas las validaciones, remover la clase de inválido si está presente
//             this.classList.remove('is-invalid');
//         });
//     });
// }

function validarIdentificacion() {
    const validDNIs = document.querySelectorAll('.validDNI');
    validDNIs.forEach(function (input) {
        input.addEventListener('input', function () {
            let valor = this.value.trim();

            // Limpiar consola (opcional)
            console.clear();

            let esValido = true;

            // No hacer nada si el valor está vacío
            if (valor.length === 0) {
                this.classList.add('is-invalid');
                return;
            }

            // Verificar la longitud mínima
            if (valor.length < 8) {
                esValido = false;
            }

            // Verificar el primer carácter
            const primerCaracter = valor.charAt(0);
            if (!/^[A-Za-z0-9]$/.test(primerCaracter)) {
                valor = valor.slice(0, -1);
                this.value = valor;
                esValido = false;
                console.error('El primer carácter debe ser una letra o un número.');
            }

            // Verificar los caracteres restantes
            const numeros = valor.slice(1);
            if (!/^\d{0,7}$/.test(numeros)) {
                this.value = primerCaracter + numeros.replace(/\D/g, '');
                esValido = false;
                console.error('Los siguientes caracteres deben ser números.');
            }

            // Agregar o quitar la clase 'is-invalid' basado en la validación
            if (esValido) {
                this.classList.remove('is-invalid');
            } else {
                this.classList.add('is-invalid');
            }
        });
    });
}













window.addEventListener('load', function() {
	fntValidText();
	fntValidEmail(); 
	fntValidNumber();
    fntValidPhoneNumber(); // Agregar la función de validación de número de teléfono
    validarIdentificacion();
}, false);