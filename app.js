const fragment = document.createDocumentFragment();
const li = fragment
    .appendChild(document.createElement("section"))
    .appendChild(document.createElement("ul"))
    .appendChild(document.createElement("li"));
li.textContent = "hello world";

document.body.appendChild(fragment);