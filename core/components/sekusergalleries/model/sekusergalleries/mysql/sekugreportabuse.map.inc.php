<?php
$xpdo_meta_map['sekugReportAbuse']= array (
  'package' => 'sekusergalleries',
  'table' => 'sekug_reportabuse',
  'fields' => 
  array (
    'item_type' => 'Item',
    'item_id' => 0,
    'description' => '',
    'postedon' => '0000-00-00 00:00:00',
    'resolved' => 0,
    'notes' => '',
  ),
  'fieldMeta' => 
  array (
    'item_type' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'Album\',\'Item\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Item',
    ),
    'item_id' => 
    array (
      'dbtype' => 'int',
      'attributes' => 'unsigned',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'postedon' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => '0000-00-00 00:00:00',
    ),
    'resolved' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
    ),
    'notes' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
);
