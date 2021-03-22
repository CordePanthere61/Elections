
let optionsContainer = document.querySelector(".options-container");
let buttonContainer = document.querySelector(".add-button-container");
let buttonElem = buttonContainer.firstChild;
let inputElem = document.querySelector(".row-option").firstElementChild;
document.querySelector(".add-choice").addEventListener("click", addChoice);

function addChoice() {
    if (!areChoicesEmpty()) {
        let div = document.createElement("div");
        div.classList.add("row", "row-option", "py-3");
        div.innerHTML += inputElem.outerHTML;
        div.innerHTML += buttonContainer.outerHTML;
        optionsContainer.appendChild(div)
        updateButton();
    }
}

function updateButton() {
    document.querySelectorAll('.add-choice').forEach(e => e.remove());
    let buttonContainers = document.querySelectorAll(".add-button-container");
    buttonContainers[buttonContainers.length -1].appendChild(buttonElem);
    document.querySelector(".add-choice").addEventListener("click", addChoice);
}

function areChoicesEmpty() {
    let inputs = document.querySelectorAll(".poll-input");
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === "") {
            return true;
        }
    }
    return false;
}
