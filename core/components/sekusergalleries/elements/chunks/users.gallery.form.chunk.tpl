<div id="sekUserGallery">
    <div id="sekug_content">
        <h2>[[%sekug.gallery.edit.settings]]</h2>
        <form class="form" action="[[~[[*id]]]]" method="post" enctype="multipart/form-data">

                <input type="hidden" name="nospam:blank" value="" />

                <p><label for="gallery_title">[[%sekug.title]]
                    <span class="error">[[+error.gallery_title]]</span>
                </label>[[!sekfancybox? &link=`titlemodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%sekug.title.gallery]]` &text=`[[%sekug.title.gallery.desc]]`]]
                    <input type="text" name="gallery_title" id="gallery_title" class="ui-widget ui-widget-content ui-corner-all" value="[[+gallery_title]]" required/></p>

                <p><label for="gallery_description">[[%sekug.description]]
                    <span class="error">[[+error.gallery_description]]</span>
                </label>[[!sekfancybox? &link=`descriptionmodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%sekug.description.gallery]]` &text=`[[%sekug.description.gallery.desc]]`]]
                    <textarea cols="55" rows="3" name="gallery_description" id="gallery_description" class="ui-widget ui-widget-content ui-corner-all" value="[[+gallery_description]]">[[+gallery_description]]</textarea></p>

                <h3>[[%sekug.gallery.optional.settings]]</h3>
                <img src="[[+gallery_cover_url]]" alt="[[+gallery_title]]">
                <input type="hidden" name="gallery_cover" value="[[+gallery_cover]]" />
                <p><label for="upload_image">[[%sekug.gallery.cover]]
                    <span class="error">[[+error.album_parent]]</span>
                </label> <br />
                    <input type="file" name="upload_image" id="upload_image" class="ui-widget ui-widget-content ui-corner-all" size="40" value="" /></p>

                <p><input type="submit" id="button" name="submit" value="[[%sekug.gallery.update]]" /></p>

        </form>
    </div>
    <div id="sekug_side">
        <div class="sekug_description">
            <h2>[[+gallery_title]]</h2>
            <p>[[+gallery_description]]</p>
            <p><img src="[[+gallery_cover_url]]" alt="[[+gallery_title]]"></p>
            <p>[[+album_count]] [[%sekug.desc.albumsinthisgallery]]</p>
        </div>
        [[!navigation]]
    </div>
</div>