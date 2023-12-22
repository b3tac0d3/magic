document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("click", function(event) {
        // Check if the clicked element is a form element
        if(event.target.form && event.target.tagName == "BUTTON"){
            // If it is a form, check if it's asking to be spaded
            if(event.target.form.classList.contains("spadeMe")) 
                spadeForm(event);
        // If it's not a form, see if it's a spaded element
        }else if(event.target.classList.contains("spadeMe") || event.target.classList.contains("spadeScript")){
            spadeLink(event);
        }
    });
});

/* Ajax any link */
function spadeLink(event){
    event.preventDefault();

    const element = event.target;
    const container = document.querySelector(element.getAttribute("container"));
    let href = element.getAttribute("href");
    const add_data = element.getAttribute("add_data");
    const rel = element.getAttribute("rel");
    const confirm_box = element.getAttribute("confirm_box");
    const callMe = element.getAttribute("callback");
    const parent = element.getAttribute("parent");

    if(element.classList.contains("spadeScript"))
        href = "src/routes/scripts_routes.php?script=" + href;

    // If user set "confirm_box", run confirm message before proceeding
    if (confirm_box) {
        if (!confirm(confirm_box)) return false;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("GET", href);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function() {
        if (xhr.status === 200) {
            let return_data = JSON.parse(xhr.responseText);
            ajaxSuccess(element, container, return_data);
        } else {
            console.error("b3tac0d3-spades Error! There was an error processing this data!! The script returned the following text:");
            console.error(xhr.responseText);
            return;
        }
    };
    xhr.onerror = function() {
        console.error("b3tac0d3-spades Error! There was an error processing this data!! The script returned the following text:");
        console.error(xhr.responseText);
        return;
    };
    xhr.send();
} // spadeLink()
  
/* Ajax any form */
function spadeForm(event){
    event.preventDefault();

    const element = event.target.form;
    const enctype = element.getAttribute("enctype");
    let href = element.getAttribute("action");
    const add_data = new URLSearchParams(new FormData(element)).toString();
    const rel = element.getAttribute("rel");
    const method = element.getAttribute("method") || "POST";
    const container = element.getAttribute("container");
    const current_url = location.href;

    element.querySelectorAll("button").forEach(function(btn) {
        btn.disabled = true;
    });

    if(element.classList.contains("spadeScript"))
        href = "src/routes/forms_routes.php?script=" + href;

    // element.querySelector(".form_message").innerHTML = "Please wait...";

    if (enctype === "multipart/form-data") {
        const formData = new FormData(element);
        const fileInputs = element.querySelectorAll("input[type='file']");
        fileInputs.forEach(function(input) {
            const files = input.files;
            for (const i = 0; i < files.length; i++) {
                const file = files[i];
                formData.append(input.name + "[" + i + "]", file);
            }
        });

        const xhr = new XMLHttpRequest();
        xhr.open("POST", href);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const return_data = JSON.parse(xhr.responseText);
                ajaxSuccess(element, container, return_data);
            }
        };
        xhr.send(formData);
    } else {
        const xhr = new XMLHttpRequest();
        xhr.open(method, href);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
        if (xhr.status === 200) {
            // console.log(xhr.responseText);
            const return_data = JSON.parse(xhr.responseText);
            ajaxSuccess(element, container, return_data);
        } else {
            console.error("b3tac0d3-spades plugin Error report! There was an error processing this data!! The script returned the following text:");
            console.error(xhr.responseText);
            return;
        }
        };
        xhr.onerror = function() {
        console.error("b3tac0d3-spades plugin Error report! There was an error processing this data!! The script returned the following text:");
        console.error(xhr.responseText);
        return;
        };
        xhr.send(add_data + "&current_url=" + encodeURIComponent(current_url));
    }
} // spadeForm()
  
/* Successful callback functions */
function ajaxSuccess(element, container, return_data) {
    // refresh the page
    if (return_data.refresh === 1) {
        location.reload();
        element.querySelectorAll("button").forEach(function(btn) {
            btn.disabled = false;
        });
        return false;
    }

    // open a colorbox (can be a subsequent colorbox called from a colorbox as well)
    if (return_data.redirCb === 1) {
        cbOpen(return_data.redirCbLink);
        return false;
    }

    // redirect if the script calls for it
    if (return_data.redirOn === 1) {
        window.location = return_data.redirect;
        return false;
    }

    // if there"s an external (or internal) container and the status isn"t set to throw a message
    if (container && return_data.status !== 0) {
        container.innerHTML = return_data.html;
        element.querySelectorAll("button").forEach(function(btn) {
            btn.disabled = false;
        });
        return false;
    }

    // if there"s an alert to pop up
    if (return_data.alertOn === 1) {
        alert(return_data.alertTxt);
        return false;
    }

    // show bad inputs
    if (return_data.badInputs) {
        const y = JSON.parse(JSON.stringify(return_data.badInputs));
        for (const i = 0, len = y.length; i < len; i++) {
            document.querySelector(y[i]).classList.add("error");
        }
    }

    // if we make it here (and there"s no container), the message needs to be displayed
    const formMessage = element.querySelector(".form_message");
    formMessage.className += return_data.classes;
    formMessage.innerHTML = return_data.message;
    element.querySelectorAll("button").forEach(function(btn) {
        btn.disabled = false;
    });
    // scroll to top of form 
    document.body.scrollTop = element.offsetTop;
} // ajaxSuccess()