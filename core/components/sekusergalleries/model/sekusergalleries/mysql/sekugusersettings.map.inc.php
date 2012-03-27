<?php
$xpdo_meta_map['sekugUserSettings']= array (
  'package' => 'sekusergalleries',
  'table' => 'sekug_usersettings',
  'fields' => 
  array (
    'gallery_user' => 0,
    'gallery_title' => '',
    'gallery_description' => '',
    'gallery_cover' => '',
    'private' => 0,
    'password' => NULL,
  ),
  'fieldMeta' => 
  array (
    'gallery_user' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'pk',
    ),
    'gallery_title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'gallery_description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'gallery_cover' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
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
  ),
  'indexes' => 
  array (
    'PRIMARY' => 
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => true,
      'columns' => 
      array (
        'gallery_user' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
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
    'sekugAlbums' => 
    array (
      'class' => 'sekugAlbums',
      'local' => 'gallery_user',
      'foreign' => 'album_user',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
