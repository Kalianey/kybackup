<?php


KY::getRoute()->addRoute('/', 'home', 'home', 'index');
KY::getRoute()->addRoute('/job', 'job.index', 'job', 'index');
KY::getRoute()->addRoute('/job/add', 'job.add', 'job', 'add');
KY::getRoute()->addRoute('/job/add/save', 'job.add.save', 'job', 'addSave');
KY::getRoute()->addRoute('/job/delete/:id', 'job.delete', 'job', 'delete');
KY::getRoute()->addRoute('/job/run/:id', 'job.run', 'job', 'run');
KY::getRoute()->addRoute('/job/curl-backup/:id', 'job.curlbackup', 'job', 'curlBackup');

KY::getRoute()->addRoute('/db', 'db.index', 'db', 'index');
KY::getRoute()->addRoute('/db/delete/:id', 'db.delete', 'db', 'delete');
KY::getRoute()->addRoute('/db/add', 'db.add', 'db', 'addForm');
KY::getRoute()->addRoute('/db/add/showtables', 'db.add.showtables', 'db', 'addShowTables');
KY::getRoute()->addRoute('/db/add/save', 'db.add.save', 'db', 'addSave');

KY::getRoute()->addRoute('/path', 'path.index', 'path', 'index');
KY::getRoute()->addRoute('/path/add', 'path.add', 'path', 'addForm');
KY::getRoute()->addRoute('/path/add/showfiles', 'path.add.showfiles', 'path', 'addShowFiles');
KY::getRoute()->addRoute('/path/add/save', 'path.add.save', 'path', 'addSave');
KY::getRoute()->addRoute('/path/delete/:id', 'path.delete', 'path', 'delete');