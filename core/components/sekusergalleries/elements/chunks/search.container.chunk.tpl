<div id="sekUserGallery">
    <div id="sekug_content">
        <form class="form" action="[[~[[*id]]]]" method="post">
            <fieldset>
                <input type="hidden" name="nospam:blank" value="" />

                <input type="text" name="search" id="search" class="text" value="[[+search]]" />

                <input type="submit" id="button" name="submit" value="[[%sekug.search]]" />
            </fieldset>
        </form>

        <ul class="image-container">

            [[+items]]
        </ul>

        <p>Total of [[+count]] albums.</p>
    </div>
    <div id="sekug_side">
        [[!navigation]]
    </div>
</div>