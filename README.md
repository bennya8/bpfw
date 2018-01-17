#api_js_sdk

## SDK依赖

```
npm install axios -S
```

## 手动引入

拷贝DiggmeSdk.js到项目任意目录，支持AMD/CMD/Window全局加载方式

```
// CMD
var sdk = require('PATH/DiggmeSdk');
var appKey = 'APP_KEY';
var appServerUrl = 'http://apidev.diggme.cn/api/v1';
var client = new DiggmeSdk(appKey,appServerUrl);
```

```
// AMD
require(['DiggmeSdk'],function(sdk){
    var appKey = 'APP_KEY';
    var appServerUrl = 'http://apidev.diggme.cn/api/v1';
    var client = new DiggmeSdk(appKey,appServerUrl);
});
```

```
// Window全局
<script src="PATH/axios.js"></script>
<script src="PATH/DiggmeSdk.js"></script>
<script>
    var appKey = 'APP_KEY';
    var appServerUrl = 'http://apidev.diggme.cn/api/v1';
    var client = new DiggmeSdk(appKey,appServerUrl);
</script>
```
