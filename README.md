<p align="center">
  <img src="./admin/views/images/logo.png" width=100 />
</p>

<p align="center"><b>emlog</b></p>
<p align="center">Lightweight blog and CMS website building system</p>

<p align="center">
<a href="https://github.com/emlog/emlog/releases"><img alt="GitHub release" src="https://img.shields.io/github/release/emlog/emlog.svg?style=flat-square&include_prereleases" /></a>
<a href="https://github.com/emlog/emlog/commits"><img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/emlog/emlog.svg?style=flat-square" /></a>

## Overview

- Markdown support
- Multi-user role management
- Flexible labeling and classification
- Multimedia Resource Management
- Full SEO support
- Built-in API
- Rich template themes
- Pluggable extension ecosystem
- Native AI support

## Official website

https://www.emlog.net

## Requirements

* PHP5.6、PHP7、PHP8，PHP7.4 and above is recommended
* MySQL5.6 or later, or MariaDB 10.3 or later
* Recommended server environments:Linux + nginx
* Recommended server: Cloud server, such as: [Aliyun ECS](https://www.aliyun.com/daily-act/ecs/activity_selection?userCode=n4ts9qpa)，[Rainyun - KVM](https://www.rainyun.com/MzI2NDkz_)
* Server management panel software recommended：[Bt panel](https://www.bt.cn/u/N0UABa) （support[Deploy emlog with one click](install_bt.md)）
* Browsers recommend: Chrome、Edge

## Regular installation

1. [Downloading the emlog](https://www.emlog.net/download), Upload all the unzipped files to the web root directory of the server, or directly upload the zip installation package and unzip it online.
2. In the browser to visit the site domain name, the program will automatically jump to the installation page, follow the prompts to install.
3. The installation process will not create the database, you need to create it in advance, click "Install emlog!", the installation is successful.

## How to install when emlog is installed

1. Backup site database and site root directory
2. Download the source code and decompress it locally
3. Delete the "init. php" file in the root directory of the domain name, upload the "init. php" file that was just extracted locally
4. Delete the "admin" and "include" folder under the root directory of the site, upload the directory with the same name that was just extracted locally to the root directory of the site
5. Delete the "content/plugins/tpl_options" and "content/plugins/tips" folders under the root directory of the site, the "content/plugins/tpl_options" and "content/plugins/tips" folders that have just been locally extracted are uploaded
6. Delete the "content/templates/default" folder under the root directory of the site, upload the "content/templates/default" folder that was just extracted locally
7. Clean CDN cache and local browser cache

## Other ways to Install

- [Bt panel one click deployment](/install/install_bt.md)
- [1Panel deployment](/install/install_1panel.md)
- [docker deployment](/install/install_docker.md)
- [Soft routing iStoreOS system deployment](https://www.bilibili.com/video/BV1mHpjeGEDu)

## Rapid deployment with docker

To quickly start emlog, use the emlog/emlog:pro-latest-php7.4-apache mirror.The image contains the latest version of emlog, Apache services, and the necessary extensions, but not MySQL, which requires additional installation and database creation.

```bash
$ docker run --name emlog-pro -p 8080:80 -d emlog/emlog:pro-latest-php7.4-apache
```

## docker-compose

1. cp config.sample.php config.php
2. docker network create emlog_network
3. docker-compose up -d
4. http://localhost:8080

## License Agreement

The license under which the Emlog software is released is the Free Software Foundation's GP Lv3 (or later)：[LICENSE](/license.txt)
