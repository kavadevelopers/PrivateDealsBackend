<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Uppy Upload</title>
    <link href="https://releases.transloadit.com/uppy/v4.13.3/uppy.min.css" rel="stylesheet">
</head>

<body>

    <!-- 2. Initialize -->
    <div id="uppy"></div>

    <script type="module">
        import {
            Uppy,
            Dashboard,
            AwsS3
        } from "https://releases.transloadit.com/uppy/v4.13.3/uppy.min.mjs"
        const uppy = new Uppy({
            autoProceed: false,
            debug: true,
            restrictions: {
                maxFileSize: 5 * 1024 * 1024 * 1024, // 5GB
                maxNumberOfFiles: 10,
            }
        });
        uppy.use(Dashboard, {
            inline: true,
            target: '#uppy',
            height: 470,
            note: 'Files up to 5GB supported',
            proudlyDisplayPoweredByUppy: false
        });
        uppy.use(AwsS3, {
            shouldUseMultipart: false, // The PHP backend only supports non-multipart uploads

            getUploadParameters(file) {
                // Send a request to our PHP signing endpoint.
                return fetch('/api/s3/create-multipart', {
                        method: 'post',
                        // Send and receive JSON.
                        headers: {
                            accept: 'application/json',
                            'content-type': 'application/json',
                        },
                        body: JSON.stringify({
                            filename: file.name,
                            contentType: file.type,
                        }),
                    })
                    .then((response) => {
                        // Parse the JSON response.
                        return response.json()
                    })
                    .then((data) => {
                        // Return an object in the correct shape.
                        return {
                            method: data.method,
                            url: data.url,
                            fields: data.fields,
                            headers: data.headers,
                        }
                    })
            },
        })
    </script>
</body>

</html>
