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
$success = true;
if ($object) {
    $pluginid= $object->get('id');
    if ($pluginid > 0) {
        $events = array();
        switch ($options[xPDOTransport::PACKAGE_ACTION]) {
            case xPDOTransport::ACTION_INSTALL:
            case xPDOTransport::ACTION_UPGRADE:
                if (isset($options['activatePluginWeb']) && !empty($options['activatePluginWeb'])) {
                    $events[] = 'OnWebLogin';
                }
                if (!empty($events)) {
                    foreach ($events as $eventName) {
                        $event = $object->xpdo->getObject('modEvent',array('name' => $eventName));
                        if ($event) {
                            $pluginEvent = $object->xpdo->getObject('modPluginEvent',array(
                                'pluginid' => $pluginid,
                                'event' => $event->get('name'),
                            ));
                            if (!$pluginEvent) {
                                $pluginEvent= $object->xpdo->newObject('modPluginEvent');
                                $pluginEvent->set('pluginid', $pluginid);
                                $pluginEvent->set('event', $event->get('name'));
                                $pluginEvent->set('priority', 0);
                                $pluginEvent->set('propertyset', 0);
                                $success= $pluginEvent->save();
                            }
                        }
                        unset($event,$pluginEvent);
                    }
                    unset($events,$eventName);
                }
                break;
            case xPDOTransport::ACTION_UNINSTALL: break;
        }
    }
}

return $success;