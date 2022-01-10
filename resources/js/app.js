/*require('./bootstrap');*/
document.addEventListener("click",documentActions);
document.addEventListener("keyup",documentActions);
document.addEventListener("change",documentActions);
function isJson(item) {
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}
async function documentActions(e) {

    let targetElement = e.target;

    if (targetElement.closest('[data-btn="edit"]')) {
        const curTd = targetElement.parentElement;
        const tr = curTd.parentElement;
        const childs = tr.children;
        const headerTable =  document.querySelector("[data-headers]").children;
        let editFields = {};
        Array.prototype.forEach.call(headerTable,function (el,i) {
            if (el.closest('[data-edit-col]')) {
                editFields[i] = {
                    name: el.getAttribute("data-edit-col"),
                    type: el.getAttribute("data-edit-type")
                };
                if (editFields[i].type == "select") {
                    editFields[i].target = el.getAttribute("data-edit-target")
                }
            }
        });
        Array.prototype.forEach.call(childs,function (child,i) {
            if (editFields.hasOwnProperty(i)) {
                switch (editFields[i].type) {
                    case "input":
                        let value = child.innerText;
                        child.innerText ="";
                        let inp = document.createElement("input");
                        inp.name = editFields[i].name;
                        inp.value = value;
                        inp.setAttribute("data-value",value);
                        inp.classList.add('form-control');
                        child.append(inp);
                        break;
                    case "select":
                        let list = child.querySelectorAll("ul li");
                        let filter = false;
                        if (child.querySelector('ul') && child.querySelector('ul').hasAttributes('data-filter')) {
                            filter = child.querySelector('ul').getAttribute('data-filter');
                            filter = JSON.parse(filter);
                            console.log(filter);
                        }
                        let listValue = {};
                        Array.from(list).map(elem => {
                            listValue[elem.getAttribute("data-id")] = elem.innerText;
                        },listValue);
                        child.innerHTML = "";
                        let teamplate = document.querySelector("#"+editFields[i].target);
                        let selectClone = teamplate.content.cloneNode(true);
                        Array.from(selectClone.querySelectorAll("option")).map(opt => {
                            if (filter) {
                                if(!filter.includes(+opt.value)){
                                    opt.remove();
                                }
                            }
                            if (listValue.hasOwnProperty(opt.value)) {
                                opt.selected = true;
                            }
                        },listValue,filter);
                        let select= selectClone.querySelector("select");
                        select.setAttribute("data-value",JSON.stringify(listValue));
                        select.setAttribute("data-filter",JSON.stringify(filter));
                        select.name = editFields[i].name;
                        child.append(select);
                        break;
                }
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
            let childEdit = false;
            for (let j=0; j<childsEl.length; j++) {
                if ((childsEl[j].tagName == "INPUT" && childsEl[j].type == "text")
                    || (childsEl[j].tagName == "SELECT")) {
                    childEdit = childsEl[j];
                }
            }
            if (childEdit) {
                let value = childEdit.getAttribute("data-value");
                if (isJson(value)) {
                    value = JSON.parse(value);
                    let ul = document.createElement("ul");
                    if (childEdit.hasAttribute('data-filter'))
                        ul.setAttribute('data-filter',childEdit.getAttribute('data-filter'));
                    let li;
                    for (const [key, val] of Object.entries(value)) {
                        li = document.createElement("li");
                        li.setAttribute("data-id",key);
                        li.innerText = val;
                        ul.append(li);
                    }
                    el.innerHTML = "";
                    el.append(ul);
                } else{
                    childEdit.remove();
                    el.innerText = value;
                }
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
                    data[childsEl[j].name] = childsEl[j].value;
                }
                if (childsEl[j].tagName == "SELECT") {
                    const selected = el.querySelectorAll('option:checked');
                    data[childsEl[j].name] = Array.from(selected).map(el => el.value);
                }
                if (childsEl[j].tagName == "INPUT" && childsEl[j].type == "checkbox") {
                    data.id = childsEl[j].value;
                }
            }
        });
        if(Object.keys(data).length != 0) {
            fetch(document.location.origin + document.location.pathname + "/edit",{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(res => {
                    if (res.error) {
                        console.log("Error: " + res.error)
                    } else {
                        Array.prototype.forEach.call(childs,function (el,i) {
                            let childsEl = el.children;
                            if (!childsEl.length) {
                                return;
                            }
                            let childInput = false;
                            for (let j=0; j<childsEl.length; j++) {
                                switch (childsEl[j].tagName){
                                    case "INPUT":
                                        if (childsEl[j].type == "text") {
                                            let value = childsEl[j].value;
                                            childsEl[j].remove();
                                            el.innerText = value;
                                        }
                                        break;
                                    case "SELECT":
                                        let selected = childsEl[j].querySelectorAll("option:checked");
                                        let ul = document.createElement("ul");
                                        if (childsEl[j].hasAttribute('data-filter'))
                                            ul.setAttribute('data-filter',childsEl[j].getAttribute('data-filter'));
                                        Array.from(selected).map(opt => {
                                            let li = document.createElement("li");
                                            li.setAttribute("data-id",opt.value);
                                            li.innerText = opt.innerText;
                                            ul.append(li);
                                        }, ul);
                                        el.innerHTML = "";
                                        el.append(ul);
                                        break;
                                }
                            }
                            if (childInput) {
                                let value = childInput.value;
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
                });
        }
    }

    if (targetElement.closest('[data-btn="remove"]')) {
        const table = document.querySelector("table");
        let checkedElem = table.querySelectorAll("[data-checkbox]:checked");
        let delElem = Array.from(checkedElem).map(el => el.value);
        fetch(document.location.origin + document.location.pathname + "/delete",{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(delElem)
        })
            .then(res => res.json())
            .then(res => {
                if (res.error || res.status == "error") {
                    console.log("Error: " + res.message)
                } else {
                    location.reload();
                }
            });
    }

    if (targetElement.closest('[data-btn="newElem"]')) {

        const table = document.querySelector("table");
        if (!table.querySelector('[data-new-elem]')) {
            const template = document.querySelector("#addElement");
            let newTr = template.content.cloneNode(true);
            newTr.querySelector("tr").setAttribute("data-new-elem","");
            table.querySelector("tbody").prepend(newTr);
            let tr = table.querySelector("tbody tr");
            let filter = tr.querySelector("[data-filter-target]");
            if (filter) {
                var evt = new Event("change", {"bubbles":true, "cancelable":false});
                filter.dispatchEvent(evt);
            }
        }
    }

    if (targetElement.closest('[data-btn="decline"]')) {

        let table = document.querySelector("table");
        table.querySelector('[data-new-elem]').remove();
    }

    if (targetElement.closest('[data-btn="add"]')) {
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
                    data[childsEl[j].name] = childsEl[j].value;
                }
                if (childsEl[j].tagName == "SELECT") {
                    const selected = el.querySelectorAll('option:checked');
                    data[childsEl[j].name] = Array.from(selected).map(el => el.value);
                }
                if (childsEl[j].tagName == "INPUT" && childsEl[j].type == "checkbox") {
                    data.id = childsEl[j].value;
                }
            }
        });
        if(Object.keys(data).length != 0) {
            fetch(document.location.origin + document.location.pathname + "/add",{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(res => {
                    if (res.error || res.status == "error") {
                        console.log("Error: " + res.error)
                    } else {
                        location.reload();
                    }
                });
        }
    }

    if (e.type == "click" && targetElement.closest('[data-btn="filterElem"]')) {
        let searchElem = document.querySelector('.findElem');
        if (searchElem.style.display == "none") {
            searchElem.style.display= "";
        } else {
            searchElem.value = "";
            // searchElem.dispatchEvent(new KeyboardEvent("keyup",{"key": "Backspace"}));
            let table = document.querySelector('table');
            for (let i = 1; i < table.rows.length; i++) {
                table.rows[i].style.display = "";
            }
            searchElem.style.display = "none";
        }
    }

    if (targetElement.closest('[data-select-all]')) {
        let status = targetElement.checked;
        let listCheckbox = document.querySelectorAll("[data-checkbox]");
        Array.from(listCheckbox).map(el => el.checked = status);
    }

    if (targetElement.closest("[type='checkbox']")) {
        let status = true;
        let allCheckbox = document.querySelector("[data-select-all]");
        let listCheckBox = document.querySelectorAll("[data-checkbox]");
        Array.from(listCheckBox).map(el => {
            if (!el.checked) {
                status = false;
            }
        },status);
        allCheckbox.checked = status;
    }

    if (e.type == "click" && targetElement.closest('[data-btn="search"]')) {
        let searchTr = targetElement.parentElement.parentElement;
        let listFields = searchTr.querySelectorAll("[name]");
        let searchData = {};
        let strFilter = 'searchField=';
        Array.from(listFields).map(el => {
            switch (el.tagName) {
                case "INPUT":
                    switch (el.type) {
                        case "text":
                            if (el.value) {
                                strFilter += el.name + ',';
                                searchData[el.name] = el.value;
                            }
                            break;
                        case "checkbox":
                            if (el.value) {
                                strFilter += el.name + ',';
                                searchData[el.name] = el.checked;
                            }
                            break;
                    }
                    break;
                case "SELECT":
                    if (el.multiple) {
                        console.log(el.value);
                    } else {
                        if (el.value) {
                            strFilter += el.name + ',';
                            searchData[el.name] = el.value;
                        }
                    }
                    break;
            }
        })
        strFilter = strFilter.replace(/^,+|,+$/g, '')
       for (let key in searchData) {
           strFilter += "&" + key +"="+ searchData[key];
        }

        console.log(location)

        let url = location.pathname;
        url +=  '?page=1&' + strFilter;

        history.pushState({}, "title", url);

        const response = await fetch(url, {
            method: 'GET',
        });

        if (response.ok) { // если HTTP-статус в диапазоне 200-299
                           // получаем тело ответа (см. про этот метод ниже)
            let data = await response;
            data.text().then(function(html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                let new_tbody = doc.querySelector('[data-table-body]');
                document.querySelector('table tbody').innerHTML = new_tbody.innerHTML;
                let new_pagenav = doc.querySelector('[data-pagination]');
                document.querySelector('[data-pagination]').innerHTML = new_pagenav.innerHTML;
            });
            console.log(data);
        } else {
            alert("Ошибка HTTP: " + response.status);
        }
    }

    if(e.type == "change" && targetElement.closest("[data-filter-target]")) {
        let filterIds = JSON.parse(targetElement.querySelector("option:checked").getAttribute("data-filter-id"));
        let targetName = targetElement.getAttribute("data-filter-target");
        let target = document.querySelector(`select[name="${targetName}"]`)
        let list = target.querySelectorAll("option");
        let checked = false;
        Array.from(list).map(opt => {
            if (filterIds.includes(+opt.value)) {
                if(!checked){
                    opt.selected = true;
                    checked = true;
                }
                opt.style.display = "block";
            } else {
                opt.style.display = "none";
            }
        },filterIds,checked);

    }
}

document.addEventListener('DOMContentLoaded', function (e) {
    let search = {};
    location.search.replace('\?','').split('&').map((v,i,a) => {
        let prop = v.split('=');
        search[prop[0]] = decodeURI(prop[1]);
    }, search);

    if (search.hasOwnProperty('searchField')) {
        let filter = document.querySelector('[data-search-filter]');
        filter.style.display = '';
        let listField = filter.querySelectorAll('[name]');
        Array.from(listField).map(field => {
            if (search.hasOwnProperty(field.name)) {
                switch (field.tagName) {
                    case "INPUT":
                        field.value = search[field.name];
                        break;
                    case "SELECT":
                        field.value = search[field.name];
                        break;
                }
            }
        })
    }
})




