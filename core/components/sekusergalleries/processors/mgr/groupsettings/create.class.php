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

class sekugGroupSettingsCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'sekugGroupSettings';
    public $languageTopics = array('sekusergalleries:default');
    public $objectType = 'sekug.groupsettings';
 
    public function beforeSave() {
        $usergroup = $this->getProperty('usergroup');
        $userrole = $this->getProperty('userrole');
        $amount = $this->getProperty('amount');
        $unit = $this->getProperty('unit');
		
        if (empty($usergroup)) {
            $this->addFieldError('usergroup',$this->modx->lexicon('sekug.usergroup.err.ns'));
        } 
        if (empty($userrole)) {
            $this->addFieldError('userrole',$this->modx->lexicon('sekug.userrole.err.ns'));
        }
		if (empty($amount)) {
            $this->addFieldError('amount',$this->modx->lexicon('sekug.amount.err.ns'));
        } 
        if (empty($unit)) {
            $this->addFieldError('unit',$this->modx->lexicon('sekug.unit.err.ns'));
        } 

/*		else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('album_title',$this->modx->lexicon('doodles.doodle_err_ae'));
        }
*/        
		return parent::beforeSave();
    }
}
return 'sekugGroupSettingsCreateProcessor';