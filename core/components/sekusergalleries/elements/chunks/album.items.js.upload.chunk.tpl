<script id="template-upload" type="text/html">
{% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
    <tr class="template-upload fade">
        <td class="preview">
            <span class="fade"></span><br />{%=file.name%}<br />{%=o.formatFileSize(file.size)%}
            <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
        </td>
        <td class="name">
                <label for="item_title">[[%sekug.title]]</label>
                <input type="text" name="item_title[{%=file.name%}]" id="item_title" value="" />

                <label for="item_description">[[%sekug.description]]</label>
                <textarea cols="65" rows="2" name="item_description[{%=file.name%}]" id="item_description" value=""></textarea>
        </td>
        {% if (file.error) { %}
            <td class="error">
                <span class="label label-important">[[%sekug.error]]</span> {%=fileUploadErrors[file.error] || file.error%}
            </td>
        {% } else if (o.files.valid && !i) { %}
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i> [[%sekug.start]]
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i> [[%sekug.cancel]]
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>