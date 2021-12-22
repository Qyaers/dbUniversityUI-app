/*require('./bootstrap');*/
document.addEventListener("click",documentActions);

function documentActions(e) {
    var targetElement = e.target;
    if (targetElement.closest('[data-btn="edit"]')) {
        const curTd = targetElement.parentElement;
        const tr = curTd.parentElement;
        const childs = tr.children;
        const headerTable =  document.querySelector("[data-headers]").children;
        let editFields = {};
        Array.prototype.forEach.call(headerTable,function (el,i) {
            if (el.closest('[data-edit-col]')) {
                editFields[i] = el.getAttribute("data-edit-col");
            }
        });
        Array.prototype.forEach.call(childs,function (child,i) {
            if (editFields.hasOwnProperty(i)) {
                let value = child.innerText;
                child.innerText ="";

                let inp = document.createElement("input");
                inp.name = editFields[i];
                inp.value = value;
                inp.setAttribute("data-value",value);
                child.append(inp);
            }
        });
        curTd.innerHTML = "";
        let btnSave = document.createElement("input");
        let btnAbort = document.createElement("input");
        btnSave.type = "button";
        btnAbort.type = "button";
        btnSave.value = "✔";
        btnAbort.value = "✖";
        btnSave.setAttribute("data-btn","save");
        btnAbort.setAttribute("data-btn","abort");
        curTd.append(btnSave);
        curTd.append(btnAbort);
    }
    if (targetElement.closest('[data-btn="abort"]')) {
        const curTd = targetElement.parentElement;
        const tr = curTd.parentElement;
        const childs = tr.children;
        Array.prototype.forEach.call(childs,function (el,i) {
            let childsEl = el.children;
            if (!childsEl.length) {
                return;
            }
            let childInput = false;
            for (let j=0; j<childsEl.length; j++) {
                if (childsEl[j].tagName == "INPUT" && childsEl[j].type == "text") {
                    childInput = childsEl[j];
                }
            }
            if (childInput) {
                console.log(childInput,i);
                let value = childInput.getAttribute("data-value");
                childInput.remove();
                el.innerText = value;

            }
        });
        curTd.innerHTML = "";
        let btnEdit = document.createElement("input");
        btnEdit.type = "button";
        btnEdit.value = "✎";
        btnEdit.setAttribute("data-btn","edit");
        curTd.append(btnEdit);
    }
    if (targetElement.closest('[data-btn="save"]')) {
        const curTd = targetElement.parentElement;
        const tr = curTd.parentElement;
        const childs = tr.children;
        const data = {};
        Array.prototype.forEach.call(childs,function (el,i) {
            let childsEl = el.children;
            if (!childsEl.length) {
                return;
            }
            let childInput = false;
            for (let j=0; j<childsEl.length; j++) {
                if (childsEl[j].tagName == "INPUT" && childsEl[j].type == "text") {
                    childInput = childsEl[j];
                }
                if (childsEl[j].tagName == "INPUT" && childsEl[j].type == "checkbox") {
                    data.id = childsEl[j].value;
                }
            }
            if (childInput) {
                data[childInput.name] = childInput.value;
                console.log(data);
            }
        });
        if(Object.keys(data).length != 0) {
            console.log(document.location);
            let response =  fetch(document.location.origin + document.location.pathname + "/edit",{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                let json =  response.json();
            } else {
                alert("Ошибка HTTP: " + response.status);
            }
        }
   /*     // curTd.innerHTML = "";
        // let btnEdit = document.createElement("input");
        // btnEdit.type = "button";
        // btnEdit.value = "✎";
        // btnEdit.setAttribute("data-btn","edit");
        // curTd.append(btnEdit);*/
    }
}


