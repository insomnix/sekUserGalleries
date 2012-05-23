<?php
$xpdo_meta_map['sekugFavorites']= array (
  'package' => 'sekusergalleries',
  'table' => 'sekug_favorites',
  'fields' => 
  array (
    'user_id' => 0,
    'item_id' => 0,
  ),
  'fieldMeta' => 
  array (
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'item_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'aggregates' => 
  array (
    'modUser' => 
    array (
      'class' => 'modUser',
      'local' => 'gallery_user',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'sekugAlbumItems' => 
    array (
      'class' => 'sekugAlbumItems',
      'local' => 'item_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
