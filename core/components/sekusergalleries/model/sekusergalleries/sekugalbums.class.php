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

class sekugAlbums extends xPDOSimpleObject {
    public function save($cacheFlag= null) {
        if ($this->isNew()) {
            $this->set('createdon','NOW');
        } else {
            $this->set('editedon','NOW');
        }
        if ($this->isNew() && !$this->get('album_user')) {
            if (!empty($this->xpdo->user) && $this->xpdo->user instanceof modUser) {
                if ($this->xpdo->user->isAuthenticated()) {
                    $this->set('album_user',$this->xpdo->user->get('id'));
                }
            }
        }
        if($this->get('private')!=1){
            $this->set('private',0);
        }
        $saved= parent :: save($cacheFlag);
        return $saved;
    }
}