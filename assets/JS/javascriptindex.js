
var NAME = document.querySelector('#form1');
var LASTNAME = document.querySelector('#form2');
var EMAIL = document.querySelector('#form3');
var password = document.querySelector('#form4');


var NAMEregex = /^[a-zA-Z]{4,}$/;
var LASTregex = /^[a-zA-Z]{4,}$/;
var EMAILregex = /^[a-zA-Z0-9_\-.]+@[a-zA-Z]+\.[a-zA-Z]{2,10}$/;

function validateInput(input, regex) {
  if (regex.test(input.value)) {
    input.classList.remove("is-invalid");
    input.classList.add("is-valid");
  } else {
    input.classList.remove("is-valid");
    input.classList.add("is-invalid");
  }
}

NAME.addEventListener("input", () => {
  validateInput(NAME, NAMEregex);
});

LASTNAME.addEventListener("input", () => {
  validateInput(LASTNAME, LASTregex);
});

EMAIL.addEventListener("input", () => {
  validateInput(EMAIL, EMAILregex);
});


// document.querySelectorAll('form').forEach(function (ele) {
//   ele.addEventListener("click" ,function (event) {
//     event.preventDefault();
//   })
// })




