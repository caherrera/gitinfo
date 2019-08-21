# GitInfo a Symfony Console application to obtaining git information about a folder

[![Build Status](https://travis-ci.org/caherrera/gitinfo.svg?branch=master)](https://travis-ci.org/caherrera/gitinfo)

[![Latest Stable Version](https://poser.pugx.org/caherrera/gitinfo/v/stable)](https://packagist.org/packages/caherrera/gitinfo)
[![Total Downloads](https://poser.pugx.org/caherrera/gitinfo/downloads)](https://packagist.org/packages/caherrera/gitinfo)
[![Latest Unstable Version](https://poser.pugx.org/caherrera/gitinfo/v/unstable)](https://packagist.org/packages/caherrera/gitinfo)
[![License](https://poser.pugx.org/caherrera/gitinfo/license)](https://packagist.org/packages/caherrera/gitinfo)
[![composer.lock](https://poser.pugx.org/caherrera/gitinfo/composerlock)](https://packagist.org/packages/caherrera/gitinfo)

This package provides an console application to obtain git information about a folder

## Zero-config use

If you don't need any custom completion behaviour, you can simply add the completion command to your application:

1. Install `caherrera/gitinfo` using [composer](https://getcomposer.org/) by running:
   ```
   $ composer global require caherrera/gitinfo
   ```

## How it works
for run type this command in any console

```bash
$ ~/vendor/caherrera/gitinfo/console [/path/to/scan]
```

### Example
```bash
$ ~/vendor/caherrera/gitinfo/console $(pwd)
{"commit":"a2986ed961f6aa628a647df9e8f04892c38480f3","hash":"a2986ed","created":"2019-08-21 19:21:45","author":"Carlos Herrera","email":"carlos.herrera@viajesfalabella.com","repository":"git@github.com:caherrera\/gitinfo.git","status":"[{\"file\":\"M\",\"status\":\"\"},{\"file\":\"M\",\"status\":\"\"}]","branch":"master","tag":"1.0.1","project":"gitinfo"}
```
this command will return a in json format
