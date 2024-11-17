'use strict';

const ticketSelect = document.querySelector("#ticket-select");
const quantitySelect = document.querySelector("#quantity-select");
const returnTicketSelect = document.querySelector("#returnticket-checkbox")
const classSelect = document.getElementsByName("travelclass");
const budgetText = document.querySelector("#budget-text");
const priceShow = document.querySelector("#total-price"); 
const chcekBudget = document.querySelector("#checkbudget-button");
const messageText = document.querySelector("#message-textarea");

let totalPrice;

function CalculateTotalPrice() {
    for (let i = 0; i < classSelect.length; i++) {
        if (classSelect[i].checked) {
            totalPrice = ticketSelect.value * quantitySelect.value * classSelect[i].value;
            break;
        }
    }  
    if (returnTicketSelect.checked)
    {
        totalPrice *= 2;
    }
    priceShow.textContent = totalPrice;
}
function SpecialCharNotAllowed(e){
    if (!(e.key >= String.fromCharCode(97) && e.key <= String.fromCharCode(122))
        && !(e.key >= String.fromCharCode(65) && e.key <= String.fromCharCode(90))
        && !(e.key >= String.fromCharCode(48) && e.key <= String.fromCharCode(57))
        && e.key !== '.' && e.key !== ",") 
        e.preventDefault();
  }

CalculateTotalPrice();
messageText.value = null;

document.addEventListener("click", CalculateTotalPrice);
chcekBudget.addEventListener("click", function() {
    parseInt(budgetText.value) >= totalPrice ? alert("Your budget is fine.") : alert("You do not have enough money. Shame on you.");
});


