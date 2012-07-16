<?php
$xpdo_meta_map['sekugAlbums']= array (
  'package' => 'sekusergalleries',
  'table' => 'sekug_albums',
  'fields' => 
  array (
    'album_user' => 0,
    'album_title' => '',
    'album_description' => '',
    'album_keywords' => '',
    'album_cover' => 0,
    'album_parent' => 0,
    'active_from' => NULL,
    'active_to' => NULL,
    'private' => 0,
    'password' => NULL,
    'createdon' => '0000-00-00 00:00:00',
    'editedon' => '0000-00-00 00:00:00',
    'extended' => NULL,
  ),
  'fieldMeta' => 
  array (
    'album_user' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'album_title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'album_description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'album_keywords' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'album_cover' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'album_parent' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'active_from' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'active_to' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'private' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
    ),
    'password' => 
    array (
      'dbtype' => 'varchar(100)',
      'phptype' => 'string',
      'null' => true,
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
    'extended' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'json',
      'null' => true,
    ),
  ),
  'aggregates' => 
  array (
    'modUser' => 
    array (
      'class' => 'modUser',
      'local' => 'album_user',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'sekugUserSettings' => 
    array (
      'class' => 'sekugUserSettings',
      'local' => 'album_user',
      'foreign' => 'gallery_user',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'composites' => 
  array (
    'sekugAlbumItems' => 
    array (
      'class' => 'sekugAlbumItems',
      'local' => 'id',
      'foreign' => 'album_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
