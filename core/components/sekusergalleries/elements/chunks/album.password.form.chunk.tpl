<div id="sekUserGallery">
    <div id="sekug_content">
        <h2>[[%sekug.album.password]]</h2>
        <form class="form" action="[[+album_url]]" method="post">
            <input type="hidden" name="nospam:blank" value="" />
            <input type="hidden" name="album_id" value="[[+album_id]]" />

            <label for="password">[[%password]]
                <span class="error">[[+error.password]]</span>
            </label>
            <input type="password" name="password" id="password" value="" />

            <input type="submit" name="submit" value="[[%sekug.album.view]]" />
        </form>
    </div>
    <div id="sekug_side">
        [[!navigation]]
    </div>
</div>