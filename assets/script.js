function query(selector) {
    return document.querySelector(selector);
}

function uploadAttachment(attachment, csrfToken) {
    const form = new FormData();
    form.append("_csrf_token", csrfToken.value);
    form.append("file", attachment.file);
    fetch("/upload-attachments", {
        method: "POST",
        headers: {
            "Accept": "application/json"
        },
        body: form
    }).then(res => {
        res.json().then(json => {
            if (!res.ok) {
                console.error("Upload failed: " + json.message)
                alert("File tidak dapat diupload");
                attachment.setUploadProgress(0);
                attachment.remove();
            } else {
                attachment.setAttributes({
                    url: json.url,
                    href: json.url
                });
                csrfToken.value = json.newToken;
                attachment.setUploadProgress(100);
            }
        });
    }).catch(e => {
        console.error("Upload failed: ", e);
        attachment.remove();
        attachment.setUploadProgress(0);
    })
}