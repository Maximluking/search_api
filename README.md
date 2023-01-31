<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Search-api. Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    modules/             contains frontend modules
      api/               contains api module
        config/          contains api module configurations
        controllers/     contains api controllers
        models/          contains api models        
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

<h2>Installation</h2>
<ul>
  <li>git clone git@github.com:eczahid/Address_API.git</li>
  <li><p>If you do not have <a href="https://getcomposer.org/">Composer</a>, follow the <a href="https://github.com/yiisoft/yii2/blob/master/docs/guide/start-installation.md#installing-via-composer">instructions</a> in the Installing Yii section of the definitive guide to install it.</p></li>
  <li><p>With Composer installed, you can then install the application using the following commands <code>composer install</code></p></li>
  <li><p>After that run <code>php init</code> and set your environment to <code>production</code> or to <code>development</code> by interactive in a console terminal. You can use no interactive command <code>php init --env=Development --overwrite=All --delete=All</code> for development environment or <code>php init --env=Production --overwrite=All --delete=All</code> for production</p></li>
  <li><p>Create a new mysql or mariadb(better) database and adjust the components['db'] configuration in common/config/main-local.php accordingly.</p></li>
  <li><p>Open a console terminal, apply migrations with command <code>php yii migrate</code></p></li>
  <li><p>Restore table <code>address</code> with data dump by command <code>mysql -u root -p DATABASE_NAME < PATH_TO_YOUR_SQL_DUMP</code> use sql dump from <code>backup/address_processed.sql</code>, another dump address_origin.sql is origin dump from xml file</p></li>
  <li><p>Add admin if you need it. Open a console terminal, apply creating an administrator with command <code>php yii auth/add-admin -l=YOURLOGIN -e=YOUREMAIL -p=YOURPASSWORD</code> or if you like more complete syntax <code>php yii auth/add-admin --login=YOURLOGIN --email=YOUREMAIL --password=YOURPASSWORD</code></p></li>
</ul>
<h3>Installing sphinx on Ubuntu</h3>
<ul>
  <li><code>sudo apt-get install sphinxsearch</code></li>
  <li>setup database params in first section of project sphinx config <code>backup/sphinx.conf</code> and <code>common/config/main.php</code> too in sphinx section</li>
  <li><p>Copy sphinx config from project backup directory to directory <code>/etc/sphinxsearch/</code> on your OS</p></li>
  <li><p>Copy <code>backend/wordforms.txt</code> to <code>/usr/local/share/sphinx/wordforms/</code> directory or another(setup this params in sphinx.conf) </p></li>
  <li><p><code>sudo sed -i 's/START=no/START=yes/g' /etc/default/sphinxsearch</code></p></li>
  <li><p><code>sudo indexer --all</code> for creation indexes -- command for indexing when sphinx is Off</p></li>
  <li><p><code>sudo systemctl restart sphinxsearch.service</code> or <code>sudo systemctl start sphinxsearch.service</code></p></li>
  <li><p>You can add next command to cron for schedule indexing<code>@hourly /usr/bin/indexer --rotate --config /etc/sphinxsearch/sphinx.conf --all</code></p></li>
  <li><p>Use <code>sudo indexer --all --rotate</code> for reindexing when sphinx is On</p></li>
</ul>
