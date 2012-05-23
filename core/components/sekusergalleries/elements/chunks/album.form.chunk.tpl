<div id="sekUserGallery">
    <div id="sekug_content">
        <h2>[[%sekug.album.manage]]</h2>
        <form class="form" action="[[~[[*id]]]]" method="post">
            <input type="hidden" name="nospam:blank" value="" />
            <input type="hidden" name="album_id" value="[[+album_id]]" />
            [[!easytabs? &cssFile=`[[+css_url]]album.form.eastytabs.css` &tabContent=`
                [{"tab_id":"primary","tab_name":"[[%sekug.settings.primary]]","tab_content":"$album.form.primary"},
                {"tab_id":"optional","tab_name":"[[%sekug.settings.optional]]","tab_content":"$album.form.optional"}]
            `]]
            <input type="submit" name="submit" value="[[%sekug.album.save]]" />
        </form>
    </div>
    <div id="sekug_side">
        <div class="sekug_description">
            <h2>[[+album_title]]</h2>
            <p>[[+album_description]]</p>
            <h4>[[%sekug.keywords]]</h4>
            <p>[[+album_keywords]]</p>
            [[+item_count:gt=``:then=`<p>[[+item_count]] items in this album.</p>`:else=``]]
        </div>
        [[!navigation? &album_id=`[[+album_id]]`]]
    </div>
</div>