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

/**
 * Find info on permissions
 *
 * @package sekusergalleries
 */
class sekugPermissions {
    /**
     * A reference to the modX instance
     * @var modX $modx
     */
    public $modx;
    /**
     * A reference to the sekUserGalleries instance
     * @var sekUserGalleries $sekug
     */
    public $sekug;
    /**
     * A configuration array
     * @var array $config
     */
    public $config = array();

    /**
     * @param sekUserGalleries $sekug
     * @param array $config
     */
    function __construct(sekUserGalleries &$sekug,array $config = array()) {
        $this->sekug =& $sekug;
        $this->modx =& $sekug->modx;
        $this->config = array_merge($this->config,$config);
    }

    public function isMember(){
        $userid = $this->modx->user->get('id');
        $c = $this->modx->newQuery('sekugGroupSettings');
        $c->innerJoin ('modUserGroupMember','UserGroupMember',array(
            '`UserGroupMember`.`user_group` = `sekugGroupSettings`.`usergroup`'
        ));
        $c->where(array(
            'UserGroupMember.member' => $userid
        ));
        $levels = $this->modx->getCollection('sekugGroupSettings', $c);
        if($levels != null){
            return true;
        } else {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[sekUserGalleries] unable to grant permissions to '.$this->modx->user->get('username'));
            return false;
        }
    }

    public function getSpaceAlloted(sekugDirectory $directory,$hard_break = false){
        $userid = $this->modx->user->get('id');
        $c = $this->modx->newQuery('sekugGroupSettings');
        $c->innerJoin ('modUserGroupMember','UserGroupMember',array(
            '`UserGroupMember`.`user_group` = `sekugGroupSettings`.`usergroup`',
            '`UserGroupMember`.`role` = `sekugGroupSettings`.`userrole`'
        ));
        $c->where(array(
            'UserGroupMember.member' => $userid
        ));
        if($hard_break){
            $c->where(array(
                'level' => 'Hard'
            ));
        }
        $c->sortby('level','ASC');
        $levels = $this->modx->getCollection('sekugGroupSettings', $c);
        if($levels != null){
            foreach ($levels as $level) {
                $levelArray = $level->toArray();
                $levelArray['bytes'] = $directory->raw_bytes($levelArray['amount'],$levelArray['unit']);
                $space[] = $levelArray;
            }
            return $space;
        }
        return 0;
    }

}