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

class sekugImageSizes extends xPDOSimpleObject {

    public function save($cacheFlag= null) {
        //if ($this->isNew()) {
        //}

        if($this->get('watermark_location')==''){
            $this->set('watermark_location','Center');
        }

        if($this->get('watermark_font')==''){
            $this->set('watermark_font','Arial');
        }

        if($this->get('watermark_text_color')==''){
            $this->set('watermark_text_color','0,0,0');
        }

        if($this->get('watermark_brightness')=='' || !is_numeric($this->get('watermark_brightness'))){
            $this->set('watermark_brightness',50);
        }elseif($this->get('watermark_brightness')>100){
            $this->set('watermark_brightness',100);
        }elseif($this->get('watermark_brightness')<1){
            $this->set('watermark_brightness',1);
        }

        if($this->get('image_quality')=='' || !is_numeric($this->get('image_quality'))){
            $this->set('image_quality',90);
        }elseif($this->get('image_quality')>100){
            $this->set('image_quality',100);
        }elseif($this->get('image_quality')<1){
            $this->set('image_quality',1);
        }

        if($this->get('watermark_font_size')=='' || !is_numeric($this->get('watermark_font_size'))){
            $this->set('watermark_font_size',14);
        }elseif($this->get('watermark_font_size')<6){
            $this->set('watermark_font_size',6);
        }

        $saved= parent :: save($cacheFlag);
        return $saved;
    }
}