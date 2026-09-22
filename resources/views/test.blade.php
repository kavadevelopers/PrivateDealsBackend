<!DOCTYPE html>
<html>

<head>
    <title>Chunk File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
    <style>
        .progress {
            height: 25px;
            margin: 10px 0;
        }

        .progress-bar {
            transition: width 0.3s;
        }

        #file-list {
            margin-top: 20px;
        }

        .progress-bar {
            min-width: 2em;
            /* Ensure percentage is always visible */
            position: relative;
        }

        .progress-text {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: #000;
            font-weight: bold;
        }

        .file-size-info {
            color: #666;
            font-size: 0.8em;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">File Upload</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" id="file-input" class="form-control" multiple>
                        </div>
                        <button id="start-upload" class="btn btn-primary">Start Upload</button>

                        <div class="progress mt-3">
                            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%">0%</div>
                        </div>

                        <div id="file-list" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resumable = new Resumable({
                target: '{{ route('upload.chunk') }}',
                // chunkSize: 1 * 1024 * 1024,
                chunkSize: 256 * 1024, // 256KB chunks
                simultaneousUploads: 1,
                testChunks: false,
                throttleProgressCallbacks: 1,
                query: {
                    _token: '{{ csrf_token() }}'
                }
            });

            // Assign browse to file input
            resumable.assignBrowse(document.getElementById('file-input'));

            // Start upload button
            document.getElementById('start-upload').addEventListener('click', function() {
                resumable.upload();
                this.disabled = true;
            });

            // File added
            resumable.on('fileAdded', function(file) {
                const fileItem = document.createElement('div');
                fileItem.className = 'alert alert-info';
                fileItem.innerHTML = `
            ${file.fileName} 
            <div class="file-size-info mt-1 small"></div>
            <div class="progress mt-2">
                <div class="progress-bar" role="progressbar" style="width: 0%">
                    <span class="progress-text">0%</span>
                </div>
            </div>
        `;
                document.getElementById('file-list').appendChild(fileItem);

                // Store references to progress elements
                file.progressBar = fileItem.querySelector('.progress-bar');
                file.progressText = fileItem.querySelector('.progress-text');
                file.sizeInfo = fileItem.querySelector('.file-size-info');

                // Display initial size info
                file.sizeInfo.textContent = `0 of ${formatFileSize(file.size)}`;
            });

            // File progress
            resumable.on('fileProgress', function(file) {
                const progress = Math.floor(file.progress() * 100);
                const uploadedBytes = file.size * file.progress();

                // Update progress bar
                file.progressBar.style.width = `${progress}%`;
                file.progressText.textContent = `${progress}%`;

                // Update size info
                file.sizeInfo.textContent =
                    `${formatFileSize(uploadedBytes)} of ${formatFileSize(file.size)}`;

                // Update main progress bar (if you have one)
                document.getElementById('progress-bar').style.width = `${progress}%`;
                document.getElementById('progress-bar').textContent = `${progress}%`;
            });

            // File success
            resumable.on('fileSuccess', function(file, message) {
                const response = JSON.parse(message);
                const fileItem = file.progressBar.closest('.alert');

                fileItem.className = 'alert alert-success';
                fileItem.innerHTML += `
                    <div class="mt-2">
                        <a href="${response.path}" target="_blank" class="btn btn-sm btn-success">Download</a>
                    </div>
                `;
            });

            // File error
            resumable.on('fileError', function(file, message) {
                const fileItem = file.progressBar.closest('.alert');
                fileItem.className = 'alert alert-danger';
                fileItem.innerHTML += ' - Upload failed';
            });

            // Helper function to format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
</body>

</html>
