[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://israelguido.com.br)

How to install Aye Zamora Banner in your Magento2

> copy all files in order to Magento in app/code

After enter code bellow:
```sh
$ bin/magento setup:di:compile
$ bin/magento cache:clean
$ bin/magento setup:static-content-deploy -f
```

> Administration in:
 - [Store] [Configuration] [Aye Zamora Banner] [Configuration] 