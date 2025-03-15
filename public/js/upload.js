document.getElementById('dropzone-file').addEventListener('change', async function (event) {
    const file = event.target.files[0];
    if (!file) return;

    let formData = new FormData();
    formData.append('file', file);

    try {
        const response = await fetch('/upload', {
            method: 'POST',
            body: formData
        });

        // console.log('Raw Response:', response);
        //
        // const text = await response.text();
        // console.log('Response Text:', text);
        //
        // const contentType = response.headers.get("content-type");
        // if (!contentType || !contentType.includes("application/json")) {
        //     console.error("Server did not return valid JSON:", text);
        //     alert("Server error. Please check logs.");
        //     return;
        // }
        //
        // const result = JSON.parse(text);
        //
        // if (response.ok) {
        //     const imageElement = document.getElementById('uploadedImage');
        //     imageElement.src = result.url;
        //     imageElement.classList.remove('hidden');
        // } else {
        //     alert(result.error);
        //     console.error("Error from server:", result.error);
        // }
    } catch (error) {
        console.error("Upload failed:", error);
        alert('Upload failed');
    }
});