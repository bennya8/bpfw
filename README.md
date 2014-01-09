BPFW 框架
=====================

## 框架简述
BPFW是遵从MVC架构和纯OOP风格开发的轻量级PHP框架，出于深入学习框架架构目的而编写，日后会不断更新改进，不断完善功能。

项目目前由[Benny](http://www.i3code.org) @ (www.i3code.org) 开发、更新及维护。

E-mail : benny_a8@live.com 

欢迎申请合作者身份共同维护，或用Pull Request进行更新改进。

## 在线文档
(http://www.i3code.org/bpfw-php-doc)

## BUG汇报地址
(https://github.com/bennya8/i3code_bpfw/issues)

## 代码格式化
严格按照Zend2标准进行格式化，提高代码可阅读性

## 编码规范

所有变量、属性、函数、方法名均使用驼峰法命名。

类名均为首字母大写标识，

如：IndexAction.class.php

静态方法名首字母均用大写标识。

如：static function ReadFile();

私有属性、私有静态变量名前已加 _ (下划线) 作为标识。

如：private static $_PrivateProperty / private static function $_PrivateMethod();

私有方法、私有静态方法名前已加 _ (下划线) 作为标识。

普通变量、普通函数，如：$isTest  /  function checkIsTest();

## 版本历史

Build 1.0.0 r410 2013-04-22

a) 使用PHP5中SPL的动态加载特性，减少重复引入类文件带来的系统开销

b) 使用工厂模式和单例模式，减少创建对象时的系统开销，支持多种数据库驱动

c) 内置3套模板引擎，Smarty、Template Lite、原生PHP模板引擎，支持多皮肤切换

d) 地址栏PATHINFO模式，令SEO优化更友好

e) 支持百度BAE环境数据库

f) 引入了Bootstrap前端框架

## 已通过测试环境

a) PC Windows 7 | PHP 5.3.13 / Apache 2.2.22/ MySQL 5.5.42

b) Virtual-Machine Cent OS 6.3 | PHP 5.3.3 / Apache 2.2.15 / MySQL 5.1.67

c) MBP OSX 10.8.3 | PHP 5.4.4 / Apache 2.2.22 / MySQL 5.5.25

d) VHOST-ZAPSERVER343 Windows NT 5.2 | PHP 5.2.17 / Microsoft-IIS 6.0 / MySQL5.0+

e) VHOST-TGBUSER | PHP 5.2.10 / Microsoft-IIS 6.0 / MySQL5.0+

## 性能测试

硬件环境：
Macbook Pro 2011 Early
CPU: i5 2415M 2.3Ghz
内存: 8GB 1333Mhz
系统盘: Sandisk 128GB SSD (MAMP环境)
数据盘: Hitachi 320GB HDD (wwwroot挂载数据盘) 
操作系统: 10.9.1 Mavericks
PHP环境：Apache/2.2.2 (Unix) PHP/5.4.4 MySQL 5.5.25
测试参数：ab -c 10 -n 1000 http://localhost/github_bpfw/index.php

Server Software:        Apache/2.2.22
Server Hostname:        localhost
Server Port:            80

Document Path:          /github_bpfw/index.php
Document Length:        20 bytes

Concurrency Level:      10
Time taken for tests:   1.188 seconds
Complete requests:      1000
Failed requests:        0
Write errors:           0
Total transferred:      241000 bytes
HTML transferred:       20000 bytes
Requests per second:    841.49 [#/sec] (mean)
Time per request:       11.884 [ms] (mean)
Time per request:       1.188 [ms] (mean, across all concurrent requests)
Transfer rate:          198.05 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.7      0       6
Processing:     4   12  18.9      8     254
Waiting:        3   11  18.8      8     254
Total:          4   12  18.9      8     255

Percentage of the requests served within a certain time (ms)
  50%      8
  66%      9
  75%     10
  80%     11
  90%     17
  95%     23
  98%     69
  99%    133
 100%    255 (longest request)

## 关于框架命名
就是英语中Benny Production of Framework的缩写！意义重大！：）