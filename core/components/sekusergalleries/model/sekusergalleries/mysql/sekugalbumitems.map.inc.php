<?php
$xpdo_meta_map['sekugAlbumItems']= array (
  'package' => 'sekusergalleries',
  'table' => 'sekug_albumitems',
  'fields' => 
  array (
    'album_id' => 0,
    'item_title' => '',
    'item_description' => '',
    'file_datetime' => NULL,
    'file_name' => '',
    'file_ext' => '',
    'file_ext_resize' => '',
    'createdon' => '0000-00-00 00:00:00',
    'editedon' => '0000-00-00 00:00:00',
  ),
  'fieldMeta' => 
  array (
    'album_id' => 
    array (
      'dbtype' => 'int',
      'attributes' => 'unsigned',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'item_title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'item_description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'file_datetime' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'file_name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'file_ext' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '10',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'file_ext_resize' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '10',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'createdon' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => '0000-00-00 00:00:00',
    ),
    'editedon' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => '0000-00-00 00:00:00',
    ),
  ),
  'aggregates' => 
  array (
    'sekugAlbums' => 
    array (
      'class' => 'sekugAlbums',
      'local' => 'album_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
