    let httpRequest;

    deleteEventListener();
    addQty();

    function makeRequest(e, value) {
        e.preventDefault();
        httpRequest = new XMLHttpRequest();

        if (!httpRequest) {
            alert('Something went wrong');
            return false;
        }
        httpRequest.onreadystatechange = alertContents;
        httpRequest.open('GET', 'src/forms/index_form_delete.php?id=' + value)
        httpRequest.send();
    }

    function alertContents() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                let node = document.querySelector('#main_card');
                node.innerHTML = httpRequest.responseText;
                deleteEventListener();
                addQty();
            } else {
                alert('An error has occured');
            }
        }
    }

    function deleteEventListener() {
        let btns = document.getElementsByClassName('index_delete');
        for (let i = 0; i < btns.length; i++) {
            btns[i].addEventListener('click', function (e) {
                makeRequest(e, btns[i].value);
            });
        }
    }

    function addQty() {
        let add = document.getElementsByClassName('index_qty');
        let qty = document.getElementsByClassName('add_qty');
        for (let i = 0; i < add.length; i++) {
            add[i].addEventListener('click', function (e) {
                attachQty(e, qty[i].value, add[i].value);
            });
        }
    }

    function attachQty(e, qtyValue, addValue) {
        e.preventDefault();
        window.location = "/index.php?add=" + addValue + "&qty=" + qtyValue;
    }