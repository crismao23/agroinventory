//Ingreso
const buttonIn=document.querySelector('#agregar');
const inputCantidad=document.querySelector('#cantidad');
const inputBrix=document.querySelector('#brix');

inputBrix.addEventListener('input', stateHandleTwo);
inputCantidad.addEventListener('input', stateHandleThree);

buttonIn.disabled = true;
function stateHandleTwo() {
    if (inputBrix.value === "" || inputBrix.value == 0 || inputCantidad.value === "" || inputCantidad.value == 0) {
        buttonIn.disabled = true;
    } else {
        buttonIn.disabled = false;
    }
}

function stateHandleThree() {
    console.log(inputCantidad.value);
    if (inputCantidad.value === "" || inputCantidad.value == 0 || inputBrix.value === "" || inputBrix.value == 0) {
        buttonIn.disabled = true;
    } else {
        buttonIn.disabled = false;
    }
}