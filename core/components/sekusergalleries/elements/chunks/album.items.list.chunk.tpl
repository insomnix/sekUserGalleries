<li>
<ul>
<li>[[+primary_image:isequalto=``:then=`<img src="[[+thumbnail_image]]" alt="[[+item_title]]" />`:else=`
    [[!sekfancybox?
    &type=`media`
    &mousewheel=`1`
    &thumbnailhelper=`1`
    &group=`album`
    &title=`[[+item_title]]`
    &linktext=`<div class="" id="productImageWrapID_[[+id]]"><img src="[[+thumbnail_image]]" alt="[[+item_title]]" /></div>`
    &link=`[[+primary_image]]`]]
    `]]</li>
<li><h5>[[+item_title]]</h5></li>
<li>[[+item_description]]</li>
<li>[[!sekfancybox?
    &type=`document`
    &linktext=`Image Details`
    &link=`[[+image_info_url]]`]] </li>
[[+alt_images]]
[[+add_favorite_url:gt=``:then=`
<li><div class="favorite_link">
    <a href="[[+add_favorite_url]]" id="item_[[+id]]" onClick="return false;">
        [[%sekug.favorites.add]]
    </a>
</div></li>`:else=``]]
</ul>
