<?php

    $inline  = '$(".dropdown-toggle").dropdown();';
    $inline .= '$(".tooltips").tooltip();';

    Assets::add_js( $inline, 'inline' );
?>
<!doctype html>
<html>
  
  <head>
    <title><?php echo isset($page_title) ? $page_title .' : ' : ''; ?> <?php if (class_exists('Settings_lib')) e(settings_item('site.title')); else echo 'Bonfire'; ?></title>
    <meta name="viewport" content="width=device-width" charset="utf-8">
    <link rel="stylesheet" href="<?php echo css_path();?>bootstrap.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo css_path();?>font.css">
    <style>
      header, p, h3, h4, a, button, input, body {
        font-family:'JF Flat Regular', Sans-Serif;
      }
      /* regular */
      hr {
        border:1px solid #F3F3F3;
      }
    </style>
    <style type="text/css">
      body {
        padding-top: 50px;
        padding-bottom: 20px;
      }
      .btn {
        margin-left: 5px;
      }
      
    </style>

  </head>
  
<body>
