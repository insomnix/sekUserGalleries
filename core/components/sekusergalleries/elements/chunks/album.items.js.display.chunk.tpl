<script id="template-download" type="text/html">
{% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
<tr class="template-download fade">
{% if (file.error) { %}
<td class="name">{%=file.name%}<br />
{%=o.formatFileSize(file.size)%}</td>
<td class="error" colspan="3"><span class="label label-important">[[%sekug.error]]</span> {%=fileUploadErrors[file.error] || file.error%}</td>
{% } else { %}
<td class="preview">{% if (file.thumbnail_url) { %}
[[!sekfancybox?
  &type=`media`
  &modalclass=`album_gallery`
  &group=`album_gal`
  &title=`{%=file.title%}`
  &linktext=`<img src="{%=file.thumbnail_url%}" alt="{%=file.title%}" />`
  &link=`{%=file.primary_url%}`
  &mousewheel=`1`
  &thumbnailhelper=`1`
]]<br />
{% } %}
[[!sekfancybox?
  &type=`media`
  &modalclass=`album_item`
  &title=`{%=file.name%}`
  &linktext=`{%=file.name%}`
  &link=`{%=file.primary_url%}`
]]<br />
{%=o.formatFileSize(file.size)%}
</td>
<td class="name">
<form>
    <input type="hidden" name="id[{%=file.id%}]" id="item_id" value="{%=file.id%}" />
    <label for="item_title">[[%sekug.title]]</label>
    <input type="text" name="item_title[{%=file.id%}]" id="item_title" value="{%=file.title%}" />
    <label for="item_description">[[%sekug.description]]</label>
    <textarea cols="65" rows="2" name="item_description[{%=file.id%}]" id="item_description" value="{%=file.description%}">{%=file.description%}</textarea>
</form>
</td>
            <td></td>
        <td class="update">
            <button class="btn btn-primary" data-type="{%=file.update_type%}" data-url="{%=file.update_url%}">
                <i class="icon-edit icon-white"></i> [[%sekug.update]]
            </button>
        </td>

        {% } %}

        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i> [[%sekug.delete]]
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
