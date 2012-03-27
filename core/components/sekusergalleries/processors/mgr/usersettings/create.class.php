<?php
 /**
 * User Galleries
 *
 * Copyright 2012 by Stephen Smith <ssmith@seknetsolutions.com>
 *
 * sekUserGalleries is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * sekUserGalleries is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * sekUserGalleries; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package sekusergalleries
 */

class sekugUserSettingsCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'sekugUserSettings';
    public $languageTopics = array('sekugusergalleries:default');
    public $objectType = 'sekug.usersettings';
 
    public function beforeSave() {
		$this->object->set('gallery_user',$this->getProperty('gallery_user'));
        $user = $this->getProperty('gallery_user');
 
        if (empty($user)) {
            $this->addFieldError('gallery_user',$this->modx->lexicon('sekug.user.err.ns'));
        } 
		else if ($this->doesAlreadyExist(array('gallery_user' => $user))) {
            $this->addFieldError('gallery_user',$this->modx->lexicon('sekug.user.err.ae'));
        }
        
		return parent::beforeSave();
    }
}
return 'sekugUserSettingsCreateProcessor';