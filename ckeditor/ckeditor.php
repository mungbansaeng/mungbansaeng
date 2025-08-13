<script>

    var <?=$ckeditorId?>objEditor;
        
    ClassicEditor
        .create( document.querySelector( "#<?=$ckeditorId?>" ), {

            language: 'ko'

        } )
        .then( <?=$ckeditorId?>editor => {

            <?=$ckeditorId?>objEditor = <?=$ckeditorId?>editor;

            <?=$ckeditorId?>editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {

                return new <?=$ckeditorId?>UploadAdapter(loader);

            };

            $('style').append('.ck-editor__editable { min-height: ' + $("#<?=$ckeditorId?>").height() + 'px !important; }');

        } )
        .catch( error => {
            console.error( 'Oops, something went wrong!' );
            console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
            console.error( error );
        } );

    class <?=$ckeditorId?>UploadAdapter {

        constructor(loader) {

            this.loader = loader;

        }

        upload() {

            return this.loader.file

                .then(file => new Promise((resolve, reject) => {

                    this._initRequest();

                    this._initListeners(resolve, reject, file);

                    this._sendRequest(file);

                }));

        }

        abort() {

            if (this.xhr) { this.xhr.abort(); }

        }

        _initRequest() {

            const xhr = this.xhr = new XMLHttpRequest();

            xhr.open('POST', '/ckeditor/editor_upload.php', true);

            xhr.responseType = 'json';

        }

        _initListeners(resolve, reject, file) {

            const xhr = this.xhr;

            const loader = this.loader;

            const genericErrorText = `Couldn't upload file: ${ file.name }.`;

            xhr.addEventListener('error', () => reject(genericErrorText));

            xhr.addEventListener('abort', () => reject());

            xhr.addEventListener('load', () => {

                const response = xhr.response;

                if (!response || response.error) {

                    return reject(response && response.error ? response.error.message : genericErrorText);

                }

                resolve({

                    default: response.url

                });

            });

            if (xhr.upload) {

                xhr.upload.addEventListener('progress', evt => {

                    if (evt.lengthComputable) {

                        loader.uploadTotal = evt.total;

                        loader.uploaded = evt.loaded;

                    }

                });

            }

        }

        _sendRequest(file) {

            const data = new FormData();

            data.append('upload', file);

            this.xhr.send(data);

        }

    }
</script>