<label for="album_title">[[%sekug.title]]
    <span class="error">[[+error.album_title]]</span>
</label>[[!sekfancybox? &link=`titlemodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%sekug.title.album]]` &text=`[[%sekug.title.album.desc]]`]] <br />
<input type="text" name="album_title" id="album_title" class="ui-widget ui-widget-content ui-corner-all" value="[[+album_title]]" required/><br />

<label for="album_description">[[%sekug.description]]
    <span class="error">[[+error.album_description]]</span>
</label>[[!sekfancybox? &link=`descriptionmodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%sekug.description.album]]` &text=`[[%sekug.description.album.desc]]`]] <br />
<textarea cols="55" rows="4" name="album_description" id="album_description" class="ui-widget ui-widget-content ui-corner-all" value="[[+album_description]]">[[+album_description]]</textarea><br />

<label for="album_keywords">[[%sekug.keywords]]
    <span class="error">[[+error.album_keywords]]</span>
</label>[[!sekfancybox? &link=`keywordsmodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%sekug.keywords.album]]` &text=`[[%sekug.keywords.album.desc]]`]] <br />
<textarea cols="55" rows="4" name="album_keywords" id="album_keywords" class="ui-widget ui-widget-content ui-corner-all" value="[[+album_keywords]]">[[+album_keywords]]</textarea><br />

<label for="ext_field">Extended Field
    <span class="error">[[+error.ext_field]]</span>
</label><br />
<input type="text" name="ext_field" id="ext_field" class="ui-widget ui-widget-content ui-corner-all" value="[[+ext_field]]" /><br />
