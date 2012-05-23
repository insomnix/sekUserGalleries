<ul class="nav">
    [[+search_albums_url:gt=``:then=`<li><a href="[[+search_albums_url]]">[[%sekug.album.search]]</a></li>`:else=``]]
    [[+my_favorites_url:gt=``:then=`<li><a href="[[+my_favorites_url]]">[[%sekug.favorites.view.my]]</a></li>`:else=``]]
    [[+browse_galleries_url:gt=``:then=`<li><a href="[[+browse_galleries_url]]">[[%sekug.gallery.browse]]</a></li>`:else=``]]
    [[+my_gallery_url:gt=``:then=`<li><a href="[[+my_gallery_url]]">[[%sekug.gallery.view.my]]</a></li>`:else=``]]
    [[+edit_gallery_url:gt=``:then=`<li><a href="[[+edit_gallery_url]]">[[%sekug.gallery.edit.settings]]</a></li>`:else=``]]
    [[+create_album_url:gt=``:then=`<li><a href="[[+create_album_url]]">[[%sekug.album.create]]</a></li>`:else=``]]
    [[+album_id:gt=``:then=`
    [[+manage_items_url:gt=``:then=`<li><a href="[[+manage_items_url]]">[[%sekug.media.manage]]</a></li>`:else=``]]
    [[+update_album_url:gt=``:then=`<li><a href="[[+update_album_url]]">[[%sekug.album.edit]]</a></li>`:else=``]]
    [[+delete_album_url:gt=``:then=`<li><a href="[[+delete_album_url]]">[[%sekug.album.delete]]</a></li>`:else=``]]
    `:else=``]]
    [[+directory_stats_url:gt=``:then=`<li><a href="[[+directory_stats_url]]">[[%sekug.directory.statistics]]</a></li>`:else=``]]
</ul>
[[!favorites.panel]]