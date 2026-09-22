<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Uppy S3 Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://releases.transloadit.com/uppy/v3.19.0/uppy.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .debug-info {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .info {
            background: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>

<body>
    <h1>Debug Uppy S3 Upload</h1>

    <div id="debug-log" class="debug-info">
        <h3>Debug Log:</h3>
        <div id="log-content"></div>
    </div>

    <div id="drag-drop-area"></div>

    <script src="https://releases.transloadit.com/uppy/v3.19.0/uppy.min.js"></script>
    <script>
        // Debug logging function
        function debugLog(message, data = null, type = 'info') {
            const logContent = document.getElementById('log-content');
            const timestamp = new Date().toLocaleTimeString();
            const logEntry = document.createElement('div');
            logEntry.className = `debug-entry ${type}`;
            logEntry.innerHTML = `
                <strong>[${timestamp}]</strong> ${message}
                ${data ? `<br><pre>${JSON.stringify(data, null, 2)}</pre>` : ''}
            `;
            logContent.appendChild(logEntry);
            logContent.scrollTop = logContent.scrollHeight;

            // Also log to console
            console.log(`[${timestamp}] ${message}`, data);
        }

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        debugLog('CSRF Token loaded', {
            token: csrfToken ? 'Present' : 'Missing'
        });

        const uppy = new Uppy.Uppy({
                autoProceed: false, // Change to false for better debugging
                debug: true,
                restrictions: {
                    maxFileSize: 5 * 1024 * 1024 * 1024, // 5GB
                    maxNumberOfFiles: 10,
                }
            })
            .use(Uppy.Dashboard, {
                inline: true,
                target: '#drag-drop-area',
                showProgressDetails: true,
                note: 'Files up to 5GB supported'
            })
            .use(Uppy.AwsS3Multipart, {
                createMultipartUpload: async function(file) {
                    debugLog('🚀 Creating multipart upload', {
                        fileName: file.name,
                        fileSize: file.size,
                        fileType: file.type
                    });

                    try {
                        const response = await fetch('/api/s3/create-multipart', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                fileName: file.name,
                                contentType: file.type || 'application/octet-stream'
                            }),
                        });

                        debugLog('📡 Create multipart response status', {
                            status: response.status,
                            statusText: response.statusText
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            debugLog('❌ Create multipart failed', {
                                status: response.status,
                                error: errorText
                            }, 'error');
                            throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                        }

                        const data = await response.json();
                        debugLog('✅ Multipart upload created successfully', data, 'success');

                        if (!data.uploadId || !data.key) {
                            debugLog('❌ Invalid response structure', data, 'error');
                            throw new Error('Invalid response from server - missing uploadId or key');
                        }

                        return {
                            uploadId: data.uploadId,
                            key: data.key
                        };
                    } catch (error) {
                        debugLog('❌ Error in createMultipartUpload', {
                            error: error.message
                        }, 'error');
                        throw error;
                    }
                },

                prepareUploadParts: async function(file, {
                    uploadId,
                    key,
                    parts
                }) {
                    debugLog('🔧 Preparing upload parts', {
                        fileName: file.name,
                        uploadId,
                        key,
                        partsCount: parts.length
                    });

                    try {
                        const partPromises = parts.map(async (part) => {
                            debugLog(`📋 Requesting presigned URL for part ${part.number}`);

                            const response = await fetch('/api/s3/get-presigned-url', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: JSON.stringify({
                                    key: key,
                                    uploadId: uploadId,
                                    partNumber: part.number,
                                }),
                            });

                            debugLog(`📡 Presigned URL response for part ${part.number}`, {
                                status: response.status,
                                statusText: response.statusText
                            });

                            if (!response.ok) {
                                const errorText = await response.text();
                                debugLog(`❌ Presigned URL failed for part ${part.number}`, {
                                    status: response.status,
                                    error: errorText
                                }, 'error');
                                throw new Error(
                                    `HTTP error! status: ${response.status}, message: ${errorText}`);
                            }

                            const data = await response.json();
                            debugLog(`✅ Presigned URL received for part ${part.number}`, {
                                hasUrl: !!data.url,
                                urlLength: data.url ? data.url.length : 0
                            }, 'success');

                            if (!data.url) {
                                debugLog(`❌ Presigned URL is missing for part ${part.number}`, data,
                                    'error');
                                throw new Error(`Presigned URL is undefined for part ${part.number}`);
                            }

                            return {
                                method: 'PUT',
                                url: data.url,
                                partNumber: part.number,
                                headers: {}
                            };
                        });

                        const results = await Promise.all(partPromises);
                        // debugLog('✅ All presigned URLs prepared', {
                        //     count: results.length
                        // }, 'success');

                        // Add detailed URL logging
                        // results.forEach(result => {
                        //     debugLog(`Presigned URL details for part ${result.partNumber}`, {
                        //         urlStart: result.url.substring(0, 30) + '...',
                        //         urlEnd: '...' + result.url.substring(result.url.length - 20),
                        //         method: result.method
                        //     }, 'success');
                        // });

                        // return results;

                        return results.map(result => ({
                            method: 'PUT',
                            url: result.url, // Key change - use 'url' instead of 'uploadUrl'
                            partNumber: result.partNumber,
                            headers: {}
                        }));
                    } catch (error) {
                        debugLog('❌ Error in prepareUploadParts', {
                            error: error.message
                        }, 'error');
                        throw error;
                    }
                },

                completeMultipartUpload: async function(file, {
                    key,
                    uploadId,
                    parts
                }) {
                    debugLog('🏁 Completing multipart upload', {
                        fileName: file.name,
                        uploadId,
                        key,
                        partsCount: parts.length
                    });

                    try {
                        const response = await fetch('/api/s3/complete-multipart', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                key: key,
                                uploadId: uploadId,
                                parts: parts,
                            }),
                        });

                        debugLog('📡 Complete multipart response', {
                            status: response.status,
                            statusText: response.statusText
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            debugLog('❌ Complete multipart failed', {
                                status: response.status,
                                error: errorText
                            }, 'error');
                            throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                        }

                        const data = await response.json();
                        debugLog('✅ Multipart upload completed successfully', data, 'success');

                        if (!data.location) {
                            debugLog('❌ No location in response', data, 'error');
                            throw new Error('No location returned from server');
                        }

                        return {
                            location: data.location
                        };
                    } catch (error) {
                        debugLog('❌ Error in completeMultipartUpload', {
                            error: error.message
                        }, 'error');
                        throw error;
                    }
                },

                abortMultipartUpload: async function(file, {
                    key,
                    uploadId
                }) {
                    debugLog('🚫 Aborting multipart upload', {
                        fileName: file.name,
                        uploadId,
                        key
                    });

                    try {
                        const response = await fetch('/api/s3/abort-multipart', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                key: key,
                                uploadId: uploadId,
                            }),
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            debugLog('❌ Abort multipart failed', {
                                status: response.status,
                                error: errorText
                            }, 'error');
                            throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                        }

                        const data = await response.json();
                        debugLog('✅ Multipart upload aborted successfully', data, 'success');
                        return data;
                    } catch (error) {
                        debugLog('❌ Error in abortMultipartUpload', {
                            error: error.message
                        }, 'error');
                        throw error;
                    }
                },

                companionUrl: null,
            });

        // Enhanced event listeners
        uppy.on('file-added', (file) => {
            debugLog('📁 File added', {
                name: file.name,
                size: file.size,
                type: file.type
            });
        });

        uppy.on('upload-started', (file) => {
            debugLog('🚀 Upload started', {
                fileName: file?.name || 'Unknown'
            });
        });

        uppy.on('upload-progress', (file, progress) => {
            if (progress.percentage % 10 === 0) { // Log every 10%
                debugLog(`📊 Upload progress: ${progress.percentage}%`, {
                    fileName: file?.name || 'Unknown',
                    uploaded: progress.bytesUploaded,
                    total: progress.bytesTotal
                });
            }
        });

        uppy.on('upload-success', (file, response) => {
            debugLog('✅ Upload successful', {
                fileName: file.name,
                response: response
            }, 'success');
        });

        uppy.on('upload-error', (file, error, response) => {
            debugLog('❌ Upload error', {
                fileName: file?.name || 'Unknown',
                error: error.message,
                response: response
            }, 'error');
        });

        uppy.on('complete', (result) => {
            debugLog('🎉 Upload complete', {
                successful: result.successful.length,
                failed: result.failed.length
            }, result.failed.length === 0 ? 'success' : 'error');
        });

        uppy.on('error', (error) => {
            debugLog('💥 General Uppy error', {
                error: error.message
            }, 'error');
        });

        // Initial status
        debugLog('🔧 Uppy initialized successfully');
    </script>
</body>

</html>
