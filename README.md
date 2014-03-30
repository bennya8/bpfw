BPFW 2.0 框架
=====================

## 框架简述
使用PHP5.3命名空间特性开发，不再支持5.3以下版本，鉴于PHP6目前已经暂停开发，5.3 ～ 5.5基本上是目前应用最广泛的PHP版本，直接用上命名空间这特性开发也不失为一个好选择
使用AOP切面编程方式，添加 Behavor
使用Observer模式，添加到 Plugin ? Widget? 未定
Vendor组件，暂内置2个第三方组件（smarty，templatelite)，还有一些Helper 助手类库
多实例Database ，i18n翻译组件，Cache缓存
验证模型，自动填充，控制器分组，模块，组件
初步目录结构

Framework
/Behavior/ 行为
/Cache/ 缓存组件
/Common/ 系统公用文件
/Core/ 框架核心
/Database/ 数据库组件
/i18n/ 国际化组件
/Plugin/ 插件
/Widget/ 挂件

项目目前由[Benny](http://www.wiicode.net) @ (www.wiicode.net) 开发、更新及维护。

E-mail : benny_a8@live.com 

欢迎申请合作者身份共同维护，或用Pull Request进行更新改进。

## BUG汇报地址
(https://github.com/bennya8/bpfw/issues)

## 代码格式化
严格按照Zend2标准进行格式化，提高代码可阅读性

## 版本历史
