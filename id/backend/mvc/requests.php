<?php

/*
|------------------------------------------------------------------------------
| Pendaftar Permintaan
|------------------------------------------------------------------------------
|
| Di sini adalah tempat Anda mendaftarkan permintaan untuk website atau aplikasi
| yang Anda buat. Syntax yang benar untuk mendaftarkannya adalah sebagai berikut :
|
| *pisahkan dengan spasi
| --Mengarah ke Controller:
| $this->url('RequestMethod URI @ControllerName::ControllerMethod');
|
| --Mengarah langsung ke View:
| $this->url('RequestMethod URI @(ViewName)');
|
*/
$this->url('GET / @Example::index');
