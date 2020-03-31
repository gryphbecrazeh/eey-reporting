document.addEventListener("DOMContentLoaded", () => {
    let pagespeedButton = document.querySelector('button.pagespeed');
    let results = document.querySelector('div.results');
    if (pagespeedButton) {
        pagespeedButton.onclick = () => {
            pagespeedButton.innerText = "Loading Data..."

            let xmlHttp = new XMLHttpRequest();
            let body = {
                url: frontend_js_obj.ajax_url,
                type: 'post',
                data: {
                    _wpnonce: frontend_js_obj.ajax_nonce,
                    action: 'eey_pagespeed_report'
                }
            }
            xmlHttp.onload = () => {
                if (xmlHttp.readyState == XMLHttpRequest.DONE) {
                    if (xmlHttp.status == 200) {
                        results.innerHTML = xmlHttp.responseText
                        pagespeedButton.innerText = "Successfully retrieved data"
                    }
                    else if (xmlHttp.status == 400) {
                        alert("There as a 400 error")
                        pagespeedButton.innerText = "Failed to get data"
                    }
                    else
                        alert("Something other than 200 was returned")
                }
            }
            xmlHttp.open("POST", frontend_js_obj.ajax_url, true)
            xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xmlHttp.send("action=eey_pagespeed_report")
        }

    }
})