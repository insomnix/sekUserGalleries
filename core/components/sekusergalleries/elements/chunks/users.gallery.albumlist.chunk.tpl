<li>
<ul>
<li><h5><a href="[[+album_url]]">[[+album_title]]</a></h5></li>
<li><a href="[[+album_url]]"><img src="[[+thumb]]" alt="[[+album_title]]" /></a></li>
<li>[[+album_description]]</li>
[[+private:eg=`1`:then=`<li>[[%sekug.album.private]]</li>`:else=``]]
[[+password:gt=``:then=`<li>[[%sekug.album.passwordprotected]]</li>`:else=``]]
[[+manage_items_url:gt=``:then=`<li><a class="altimglink" href="[[+manage_items_url]]">[[%sekug.media.manage]]</a></li>`:else=``]]
[[+update_album_url:gt=``:then=`<li><a class="altimglink" href="[[+update_album_url]]">[[%sekug.album.edit]]</a></li>`:else=``]]
[[+delete_album_url:gt=``:then=`<li><a class="altimglink" href="[[+delete_album_url]]">[[%sekug.album.delete]]</a></li>`:else=``]]
</ul>
</li>
[[-
[[+active_from:gt=``:then=`<li>[[%sekug.active.from]] : [[+active_from:strtotime:date=`%m/%d/%Y`]]</li>`:else=``]]
[[+active_to:gt=``:then=`<li>[[%sekug.active.to]] : [[+active_to:strtotime:date=`%m/%d/%Y`]]</li>`:else=``]]
[[+createdon:gt=``:then=`<li>[[%sekug.createdon]] : [[+createdon:strtotime:date=`%m/%d/%Y`]]</li>`:else=``]]
[[+editedon:gt=``:then=`<li>[[%sekug.editedon]] : [[+editedon:strtotime:date=`%m/%d/%Y`]]</li>`:else=``]]
]]