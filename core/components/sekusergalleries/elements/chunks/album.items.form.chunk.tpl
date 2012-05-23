<div id="sekUserGallery">
    <div id="sekug_content">
        <form id="fileupload" action="[[+album_upload_url]]" method="POST" enctype="multipart/form-data">
            <div class="row fileupload-buttonbar">
                <div class="span">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button">
                        <span><i class="icon-plus icon-white"></i> [[%sekug.addfiles...]]</span>
                        <input type="file" name="files[]" multiple>
                    </span>

                    <button type="submit" class="btn btn-primary start">
                        <i class="icon-upload icon-white"></i> [[%sekug.upload.start]]
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <i class="icon-ban-circle icon-white"></i> [[%sekug.upload.cancel]]
                    </button>
                    <button type="button" class="btn btn-danger delete">
                        <i class="icon-trash icon-white"></i> [[%sekug.delete]]
                    </button>

                    <input type="checkbox" class="toggle">
                </div>
                <div class="span4">
                    <!-- The global progress bar -->
                    <div class="progress progress-success progress-striped active fade">
                        <div class="bar" style="width:0%;"></div>
                    </div>
                </div>
                <div class="span">
                    <a href="[[+update_album_url]]#optional" class="btn">[[%sekug.settings.additional]]</a>
                    <a href="[[+my_gallery_url]]" class="btn">[[%sekug.gallery.backto]]</a>
                </div>
            </div>
            <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
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
<!-- gallery-loader is the loading animation container -->
<div id="gallery-loader"></div>