<?php
$config = array();

$config['db'] = array(
  'host' => 'localhost',
  'user' => 'mingdatrade',
  'passwd' => 'trade@mingDA123',
  'name' => 'lplussize',
);
$config['routers'] = array(
  'index' => 'default/seotag',
  'paymentc' => 'product/paymentc',
  'user/panel' => 'user/home',
  'new-arrivals.html' => 'product/browse/++recommend-new-arrivals++++1.html',
  'recommended.html' => 'product/browse/++recommend-recommended++++1.html',
  'hot-products.html' => 'product/browse/++recommend-hot-products++++1.html',
  'discounted.html' => 'product/browse/++recommend-discounted++++1.html',
  'newslist' =>'article/list/news',
  'faqslist' =>'article/list/faq',
  'tag-a' => 'default/seotags/A',
  'tag-b' => 'default/seotags/B',
  'tag-c' => 'default/seotags/C',
  'tag-d' => 'default/seotags/D',
  'tag-e' => 'default/seotags/E',
  'tag-f' => 'default/seotags/F',
  'tag-g' => 'default/seotags/G',
  'tag-h' => 'default/seotags/H',
  'tag-i' => 'default/seotags/I',
  'tag-j' => 'default/seotags/J',
  'tag-k' => 'default/seotags/K',
  'tag-l' => 'default/seotags/L',
  'tag-m' => 'default/seotags/M',
  'tag-n' => 'default/seotags/N',
  'tag-o' => 'default/seotags/O',
  'tag-p' => 'default/seotags/P',
  'tag-q' => 'default/seotags/Q',
  'tag-r' => 'default/seotags/R',
  'tag-s' => 'default/seotags/S',
  'tag-t' => 'default/seotags/T',
  'tag-u' => 'default/seotags/U',
  'tag-v' => 'default/seotags/V',
  'tag-w' => 'default/seotags/W',
  'tag-x' => 'default/seotags/X',
  'tag-y' => 'default/seotags/Y',
  'tag-z' => 'default/seotags/Z',
  'tag-0-9' => 'default/seotags/0-9',
);

$config['dynamicRouters'] = array(
  't/' => 'browse/++tag-',
  'browse/all/' => 'browse/all++++++',
);

$config['categoryRouter'] = array(
  'tag-' => 't/',
  '++tag-' => 't/',
  'all++++++' => 'browse/all/',
  'recommend-' => '',
);

$config['order.startnumber'] = 120;

$config['debug'] = false;
$config['template'] = 'lingerie-plussize.net';
$config['sphinx.index'] ='LPLUSSIZE';
$config['compress'] = false;
