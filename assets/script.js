function query(selector) {
    return document.querySelector(selector);
}

let uploadChain = Promise.resolve();

function uploadAttachment(attachment, csrfToken) {
    uploadChain = uploadChain.then(async () => {
        const form = new FormData();
        form.append("_csrf_token", csrfToken.value);
        form.append("file", attachment.file);
        try {
            const res = await fetch("/upload-attachments", {
                method: "POST",
                headers: {"Accept": "application/json"},
                body: form
            });
            const json = await res.json();
            if (!res.ok) {
                console.error("Upload failed: " + json.message ?? "unknown");
                attachment.setUploadProgress(0);
                attachment.remove();
            } else {
                let attr = null;
                let urlStr = json.url ?? "";
                if (urlStr.endsWith("png") || urlStr.endsWith("jpg") || urlStr.endsWith("jpeg") || urlStr.endsWith("webp")) {
                    attr = { url: urlStr };
                } else {
                    attr = { url: urlStr, href: urlStr };
                }
                attachment.setAttributes(attr);
                csrfToken.value = json.newToken;
                attachment.setUploadProgress(100);
                console.info("Upload success: ", json);
            }
        } catch (e) {
            console.error("Upload failed: ", e);
            attachment.remove();
            attachment.setUploadProgress(0);
        }
    });
}