<?php
$xpdo_meta_map['sekugImageSizes']= array (
  'package' => 'sekusergalleries',
  'table' => 'sekug_imagesizes',
  'fields' => 
  array (
    'name' => '',
    'description' => '',
    'max_width' => 0,
    'max_height' => 0,
    'image_quality' => 90,
    'watermark_image' => '',
    'watermark_brightness' => 50,
    'watermark_text' => '',
    'watermark_text_color' => '',
    'watermark_font' => 'Arial',
    'watermark_font_size' => 14,
    'watermark_location' => 'Center',
    'primary' => 0,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'max_width' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'max_height' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'image_quality' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '3',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 90,
    ),
    'watermark_image' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'watermark_brightness' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '3',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 50,
    ),
    'watermark_text' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'watermark_text_color' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '12',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'watermark_font' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Arial',
    ),
    'watermark_font_size' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '3',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 14,
    ),
    'watermark_location' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'NorthWest\',\'North\',\'NorthEast\',\'West\',\'Center\',\'East\',\'SouthWest\',\'South\',\'SouthEast\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Center',
    ),
    'primary' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
    ),
  ),
);
