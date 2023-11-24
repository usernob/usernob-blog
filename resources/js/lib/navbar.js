const logo = document.querySelector("#logo");
const tag = document.querySelector("#tags").content.cloneNode(true).children;
let wordCounter = 0;
let dataCounter = 0;
let reverse = false;
let shouldBreak = false;

setInterval(() => {
    if (shouldBreak) return;
    let selected = tag[dataCounter];
    wordCounter += reverse ? -1 : 1;
    logo.querySelector("#tag").innerText = selected.innerText.slice(0, wordCounter);
    logo.setAttribute("href", selected.getAttribute("href"));
    if (wordCounter == selected.innerText.length) {
        shouldBreak = true;
        setTimeout(() => {
            reverse = true;
            shouldBreak = false;
        }, 10000);
    }
    if (wordCounter == 0 && reverse == true) {
        dataCounter++;
        reverse = false;
    }
    if (dataCounter >= tag.length - 1) {
        dataCounter = 0;
    }
}, reverse ? 50 : 150);
