<div id="sekUserGallery">
    <div id="sekug_content">
        <ul class="image-container">
            [[+item_list]]
        </ul>
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
