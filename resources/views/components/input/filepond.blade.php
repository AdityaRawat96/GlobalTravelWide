<div x-data="{pond: null}" x-init="
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginGetFile);
        pond = FilePond.create($refs.input);
        pond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{$attributes['wire:model']}}', file, load, error, progress);
                },
                revert: (filename, load, error) => {
                    @this.removeUpload('{{$attributes['wire:model']}}', filename, load)
                }
            }
        })
        if({{isset($attributes['attachments']) ? 1 : 0}}){
            var attachments = @this.get(`{{$attributes['attachments']}}`);
            if(Array.isArray(attachments)){
                attachments.map(attachment => {
                    var myRequest = new Request(attachment);
                    fetch(myRequest).then(function (response) {
                        response.blob().then(function (myBlob) {
                            pond.addFile(myBlob);
                        });
                    });
                });
            }else if(attachments){
                var myRequest = new Request(attachments);
                fetch(myRequest).then(function (response) {
                    response.blob().then(function (myBlob) {
                        pond.addFile(myBlob);
                    });
                });
            }
        }
    " wire:ignore>
    <input type="file" x-ref="input" name="{{$inputname}}" {{isset($attributes['disabled']) ? 'disabled' : ''}}>
</div>