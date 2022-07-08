    let httpRequest;

    deleteEventListener();

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
