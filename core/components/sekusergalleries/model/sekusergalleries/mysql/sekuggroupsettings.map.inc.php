<?php
$xpdo_meta_map['sekugGroupSettings']= array (
  'package' => 'sekusergalleries',
  'table' => 'sekug_groupsettings',
  'fields' => 
  array (
    'usergroup' => 0,
    'userrole' => 0,
    'amount' => 0,
    'unit' => 'MiB',
    'level' => 'Soft',
    'private' => 0,
  ),
  'fieldMeta' => 
  array (
    'usergroup' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'userrole' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'amount' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '3',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'unit' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'MiB\',\'GiB\',\'TiB\',\'PiB\',\'EiB\',\'ZiB\',\'YiB\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'MiB',
    ),
    'level' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'Soft\',\'Hard\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Soft',
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
  ),
  'aggregates' => 
  array (
    'modUserGroup' => 
    array (
      'class' => 'modUserGroup',
      'local' => 'usergroup',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'modUserGroupRole' => 
    array (
      'class' => 'modUserGroupRole',
      'local' => 'userrole',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
