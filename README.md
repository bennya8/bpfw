#BPFW 2.0 lightweight php framework

## 前言
利用业余时间，把之前挖了的坑慢慢填上，别看框架小，能实现功能还是挺多的！@.@ 接下来就开始尝试用Zend API把框架实现。

项目目前由[Benny](http://www.wiicode.net) @ (www.wiicode.net) 开发、更新及维护。

E-mail : benny_a8@live.com

## 框架简述
* 使用PHP5.3命名空间特性开发，充分体现自动加载特性
* 引入依赖DI和IoC编程思想，模块组件解耦
* 引入AOP切面编程思想，支持Event调度
* 模块化开发，充分体现HMVC思想，方便维护
* 支持3种路由模式，queryinfo，pathinfo，rewrite
* 缓存组件，支持File，Memcached，Redis适配器
* 数据库组件，支持MySQL，MySQLi，PDO适配器
* （增加数据库集群支持，终于可以连接多个数据库示例，随意切换CRUD）
* 几个实用小助手类
* i18n 组件

## 框架目录
  * Application (应用目录)
    * Common (公用常量，函数，助手类)
    * Config (应用配置)
    * Event (事件钩子)
    * Model (表模型)
    * Module (模块目录)
      * Site (模块名，默认Site)
        * Controller (模块控制器)
        * View (模块视图)
      * ...
    * Vendor (第三方组件目录)
    * i18n (应用语言包)
  * Framework (框架目录)
    * Cache (缓存组件)
    * Core (核心组件)
    * Database (数据库组件)
    * Event (系统事件钩子)
    * Extend (系统扩展类)
    * Helper (系统助手类)
    * i18n (系统语言包)
    * Session (Session组件)
    * Vendor (第三方组件目录)
  * Public (应用入口)
  * Runtime (系统缓存目录)

## BUG汇报地址
(https://github.com/bennya8/bpfw/issues)

## 待更新
* （Restful控制器，方便写API接口）
* （CacheModel，利用Redis HSET构建数据模型）

## 代码格式化
严格按照Zend2标准进行格式化，提高代码可阅读性

## 版本历史
