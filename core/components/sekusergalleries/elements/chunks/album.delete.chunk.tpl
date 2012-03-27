<div id="sekUserGallery">
    <div id="sekug_content">
        <h2>[[%sekug.album.delete]]</h2>
        <form class="form" action="[[~[[*id]]]]" method="post">
            <input type="hidden" name="nospam:blank" value="" />
            <input type="hidden" name="album_id" value="[[+album_id]]" />
            <input type="hidden" name="action" value="del" />
            <p>Are you sure you want to delete your album [[+album_title]]?</p>
            <p>This will also delete all images in the album.</p>

            <input type="submit" name="submit" value="[[%sekug.album.delete]]" />
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