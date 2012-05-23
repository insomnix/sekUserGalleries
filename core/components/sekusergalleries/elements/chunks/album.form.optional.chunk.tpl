<label for="album_cover">[[%sekug.coverimage]]
<span class="error">[[+error.album_cover]]</span>
</label>[[!sekfancybox? &link=`covermodal` &linktext=`<img width='20' height='20' src="[[+question_image]]" />` &header=`[[%sekug.coverimage]]` &text=`[[%sekug.coverimage.desc]]`]] <br />
<select style="width:[[+thumbcomboboxwidth]]px;" name="album_cover" id="album_cover" class="mydds ui-widget ui-widget-content ui-corner-all" name="myimge">
[[!album.items.combolist? &value=`[[+album_cover]]` ]]
</select>
<br />

<label for="active_from">[[%sekug.active.from.date]]
<span class="error">[[+error.active_from]]</span>
</label>[[!sekfancybox? &link=`activefrommodal` &linktext=`<img width='20' height='20' src="[[+question_image]]" />` &header=`[[%sekug.active.from.date]]` &text=`[[%sekug.active.from.desc]]`]] <br />
[[!input.datepicker? &input_id=`active_from` &name=`active_from` &value=`[[+active_from:strtotime:date=`%m/%d/%Y`]]`]]
<br />

<label for="active_to">[[%sekug.active.to.date]]
<span class="error">[[+error.active_to]]</span>
</label>[[!sekfancybox? &link=`activetomodal` &linktext=`<img width='20' height='20' src="[[+question_image]]" />` &header=`[[%sekug.active.to.date]]` &text=`[[%sekug.active.to.desc]]`]]<br />
[[!input.datepicker? &input_id=`active_to` &name=`active_to` &value=`[[+active_to:strtotime:date=`%m/%d/%Y`]]`]]
<br />

<label for="private"><input type="checkbox" value="1" id="private" name="private"[[!+private:eq=`1`:then=` checked = "true"`]]> [[%sekug.private.only]]</label> [[!sekfancybox? &link=`privatemodal` &linktext=`<img width='20' height='20' src="[[+question_image]]" />` &header=`[[%sekug.private.viewing]]` &text=`[[%sekug.private.desc]]`]] <br />

<label for="password">[[%password]]
<span class="error">[[+error.password]]</span>
</label>[[!sekfancybox? &link=`passwordmodal` &linktext=`<img width='20' height='20'  src="[[+question_image]]" />` &header=`[[%password]]` &text=`[[%sekug.password.desc]]`]] <br />
<input type="text" name="password" id="password" value="[[+password]]" /><br />

