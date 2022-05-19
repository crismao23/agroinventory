//Salida
const button = document.querySelector('#update');
const input = document.querySelector('#cantidadOut');

input.addEventListener('input', stateHandle);

function stateHandle() {
  if (input.value === "" || input.value == 0) {
    button.disabled = true
  } else {
    button.disabled = false
  }
}