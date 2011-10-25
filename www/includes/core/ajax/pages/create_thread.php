<?php

$json->response->page = new StdClass;

$json->response->page->id             = 10;
$json->response->page->page_title     = 'Create Thread in <a href="/' . $topic->slug . '">' . $topic->name . '</a>';
$json->response->page->document_title = 'Create Thread in ' . $topic->name;
$json->response->page->path           = '/' . $topic->slug . '/create';

$json->response->breadcrumb = new Breadcrumb;
$json->response->breadcrumb->addItem('Topics', '/topics');
$json->response->breadcrumb->addItem($topic->name, '/' . $topic->slug);
$json->response->breadcrumb->addItem('Create Thread', '/' . $topic->slug . '/create');

$json->response->topic = new StdClass;
$json->response->topic->id   = $topic->id;
$json->response->topic->name = $topic->name;
$json->response->topic->slug = $topic->slug;
