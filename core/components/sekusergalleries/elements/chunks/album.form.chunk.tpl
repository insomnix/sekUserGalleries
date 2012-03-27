<div id="sekUserGallery">
    <div id="sekug_content">
        <h2>[[%sekug.album.manage]]</h2>
        <form class="form" action="[[~[[*id]]]]" method="post">
            <input type="hidden" name="nospam:blank" value="" />
            <input type="hidden" name="album_id" value="[[+album_id]]" />

            <label for="album_title">[[%sekug.title]]
                <span class="error">[[+error.album_title]]</span>
            </label>[[!sekfancybox? &link=`titlemodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%sekug.title.album]]` &text=`[[%sekug.title.album.desc]]`]] <br />
            <input type="text" name="album_title" id="album_title" value="[[+album_title]]" required/><br />

            <label for="album_description">[[%sekug.description]]
                <span class="error">[[+error.album_description]]</span>
            </label>[[!sekfancybox? &link=`descriptionmodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%sekug.description.album]]` &text=`[[%sekug.description.album.desc]]`]] <br />
            <textarea cols="55" rows="3" name="album_description" id="album_description" value="[[+album_description]]">[[+album_description]]</textarea><br />

            <label for="album_keywords">[[%sekug.keywords]]
                <span class="error">[[+error.album_keywords]]</span>
            </label>[[!sekfancybox? &link=`keywordsmodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%sekug.keywords.album]]` &text=`[[%sekug.keywords.album.desc]]`]] <br />
            <textarea cols="55" rows="2" name="album_keywords" id="album_keywords" value="[[+album_keywords]]">[[+album_keywords]]</textarea><br />

            <h3>[[%sekug.album.optional.settings]]</h3>
            <label for="album_cover">[[%sekug.coverimage]]
                <span class="error">[[+error.album_cover]]</span>
            </label>[[!sekfancybox? &link=`covermodal` &linktext=`<img width='20' height='20' src="[[+question_image]]" />` &header=`[[%sekug.coverimage]]` &text=`[[%sekug.coverimage.desc]]`]] <br />
            <select style="width:[[+thumbcomboboxwidth]]px;" name="album_cover" id="album_cover" class="mydds" name="myimge">
                [[!album.items.combolist? &value=`[[+album_cover]]` ]]
            </select>
            <br />

            <label for="active_from">[[%sekug.active.from.date]]
                <span class="error">[[+error.active_from]]</span>
            </label>[[!sekfancybox? &link=`activefrommodal` &linktext=`<img width='20' height='20' src="[[+question_image]]" />` &header=`[[%sekug.active.from.date]]` &text=`[[%sekug.active.from.desc]]`]] <br />
            <input type="date" name="active_from" id="active_from" class="datepicker" value="[[+active_from:strtotime:date=`%m/%d/%Y`]]" /><br />

            <label for="active_to">[[%sekug.active.to.date]]
                <span class="error">[[+error.active_to]]</span>
            </label>[[!sekfancybox? &link=`activetomodal` &linktext=`<img width='20' height='20' src="[[+question_image]]" />` &header=`[[%sekug.active.to.date]]` &text=`[[%sekug.active.to.desc]]`]]<br />
            <input type="date" name="active_to" id="active_to" class="datepicker" value="[[+active_to:strtotime:date=`%m/%d/%Y`]]" /><br />

            <label for="private"><input type="checkbox" value="1" id="private" name="private"[[!+private:eq=`1`:then=` checked = "true"`]]> [[%sekug.private.only]]</label> [[!sekfancybox? &link=`privatemodal` &linktext=`<img width='20' height='20' src="[[+question_image]]" />` &header=`[[%sekug.private.viewing]]` &text=`[[%sekug.private.desc]]`]] <br />

            <label for="password">[[%password]]
                <span class="error">[[+error.password]]</span>
            </label>[[!sekfancybox? &link=`passwordmodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%password]]` &text=`[[%sekug.password.desc]]`]] <br />
            <input type="text" name="password" id="password" value="[[+password]]" /><br />

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