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
 
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('sekusergalleries.core_path',null,$modx->getOption('core_path').'components/sekusergalleries/').'model/';
            $modx->addPackage('sekusergalleries',$modelPath);
 
            $manager = $modx->getManager();
 			
			// list all the tables to create and resolve to on install
            $manager->createObjectContainer('sekugGroupSettings');
            $manager->createObjectContainer('sekugUserSettings');
            $manager->createObjectContainer('sekugAlbums');
            $manager->createObjectContainer('sekugAlbumItems');
            $manager->createObjectContainer('sekugImageSizes');
            $manager->createObjectContainer('sekugMimeTypes');
            $manager->createObjectContainer('sekugReportAbuse');

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;