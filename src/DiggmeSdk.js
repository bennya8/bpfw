;/**
 * Diggme JS SDK
 * @version 1.0.0
 * @author develop@diggme.cn
 * @created 2017-04-26
 * @modified 2017-04-26
 */
(function () {

    var axios = typeof require === 'function'
        ? require('axios')
        : window.axios;

    if (!axios) {
        throw new Error('[axios] dependency cannot locate')
    }

    /**
     * constructor
     * @param appKey
     * @param serverUrl
     * @constructor
     */
    var DiggmeSdk = function (appKey, serverUrl) {
        this.appKey = appKey;
        this.serverUrl = serverUrl;

        if (!appKey || !serverUrl) {
            throw new Error('[DiggmeSdk] app_key or server_url cannot empty');
        }

        axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        };
        axios.interceptors.request.use(function (config) {
            config.headers['Authorization'] = localStorage.getItem('accessToken') || '';
            return config;
        });
    };

    /*********************************************************
     * Oauth 授权
     *********************************************************/

    /**
     * 根据获取token获取的code(异步请求)
     * @remark 请确保获取code后, 并写入到asset
     */
    DiggmeSdk.prototype.getAccessTokenByCode = function (code) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + 'open/token', {
                params: {
                    'grant_type': 'authorize_code',
                    'app_key': _this.appKey,
                    'code': code
                }
            }).then(function (response) {
                if (response.data.http_status === 200) {
                    localStorage.setItem('accessToken', response.data.data.access_token);
                    localStorage.setItem('accessTokenExpire', response.data.data.expire_in);
                }
                resolve(response);
            }).catch(function (error) {
                reject(error);
            });
        });
    };

    /**
     * 根据获取token获取的code(同步请求)
     * @remark 请确保获取code后, 并写入到asset
     */
    DiggmeSdk.prototype.getAccessTokenByCodeOnSync = function (code) {
        var _this = this;
        syncAjax({
            method: 'get',
            url: _this.serverUrl + 'open/token',
            data: {
                'grant_type': 'authorize_code',
                'app_key': _this.appKey,
                'code': code
            },
            success: function (response) {
                if (response.http_status === 200) {
                    localStorage.setItem('accessToken', response.data.access_token);
                    localStorage.setItem('accessTokenExpire', response.data.expire_in);
                }
                return response;
            },
            error: function (error) {
                return false;
            }
        });
    };

    /**
     * 跳转token授权页面
     * @param redirectUrl
     */
    DiggmeSdk.prototype.getAccessTokenOauthUrl = function (redirectUrl) {
        var queryString =
            'grant_type=authorize_code' +
            '&scope=base' +
            '&app_key=' + this.appKey +
            '&redirect_url=' + encodeURI(redirectUrl);
        window.location.replace(this.serverUrl + 'open/oauth?' + queryString)
    };

    /*********************************************************
     * Test 测试
     *********************************************************/

    /**
     * 渠道测试分类
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestCategory = function () {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + '/channel/test/category/list').then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 渠道测试列表
     * @param categoryId
     * @param page
     * @param size
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestList = function (categoryId, page, size) {
        var _this = this;
        var params = {};
        params.page = page || 1;
        params.size = size || 20;

        if (categoryId > 0) {
            params.category_id = categoryId;
        }
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + '/channel/test/list', {
                params: params
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 渠道测试详情
     * @param testId
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestDetail = function (testId) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + '/channel/test/detail', {
                params: {
                    test_id: testId || 0
                }
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 渠道测试报告
     * @param testId
     * @param inCode
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestReport = function (testId, inCode) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + '/channel/test/report', {
                params: {
                    test_id: testId || 0,
                    in_code: inCode || ''
                }
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 查询订单状态
     * @param testId
     * @param inCode
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestCodeStatus = function (testId, inCode) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + '/channel/test/codeStatus', {
                params: {
                    test_id: testId || 0,
                    in_code: inCode || ''
                }
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 获取问题列表
     * @param testId
     * @param inCode
     * @param roleId
     * @param partId
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestQuestion = function (testId, inCode, roleId, partId) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + '/channel/test/question', {
                params: {
                    test_id: testId || 0,
                    role_id: roleId || 0,
                    part_id: partId || 0,
                    in_code: inCode || ''
                }
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 提交测试结果
     * @param testId
     * @param inCode
     * @param choices
     * @returns {Promise}
     */
    DiggmeSdk.prototype.postChannelTestUserResult = function (testId, inCode, choices) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.post(_this.serverUrl + '/channel/test/result', {
                test_id: testId || 0,
                in_code: inCode || '',
                choices: choices
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 获取测试信息列表
     */
    DiggmeSdk.prototype.getChannelTestInfoList = function (testId, inCode) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + '/channel/test/info/list', {
                params: {
                    'test_id': testId || 0,
                    'in_code': inCode || ''
                }
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 提交测试信息
     * @param testId
     * @param inCode
     * @param setting
     * @param roleId
     * @returns {Promise}
     */
    DiggmeSdk.prototype.postChannelTestUserInfo = function (testId, inCode, setting, roleId) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.post(_this.serverUrl + '/channel/test/info', {
                'test_id': testId || 0,
                'in_code': inCode || '',
                'setting': setting || '',
                'role_id': roleId || 0
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    /**
     * 获取推荐测试
     * @param page
     * @param size
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestRecommendList = function (page, size) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            axios.get(_this.serverUrl + '/channel/test/recommend/list', {
                params: {
                    'page': page || 1,
                    'size': size || 2
                }
            }).then(function (response) {
                resolve(response);
            }).catch(function (error) {
                reject(error);
            })
        });
    };

    if (typeof module.exports === "object") {
        module.exports = DiggmeSdk
    } else if (typeof define === "function" && define.amd) {
        define([], function () {
            return DiggmeSdk
        })
    } else if (window.Vue) {
        window.DiggmeSdk = DiggmeSdk;
    }

    /**
     * 同步Ajax函数
     * @param {*} opts
     */
    function syncAjax(opts) {
        var defaults = {
            method: 'GET',
            url: '',
            data: '',
            async: false,
            cache: false,
            contentType: 'application/json',
            success: function () {
            },
            error: function () {
            }
        };
        for (var key in opts) {
            defaults[key] = opts[key];
        }
        if (typeof defaults.data === 'object') {
            var str = '';
            for (var key in defaults.data) {
                value = defaults.data[key];
                if (defaults.data[key].indexOf('&') !== -1) value = defaults.data[key].replace(/&/g, escape('&'));
                if (key.indexOf('&') !== -1) key = key.replace(/&/g, escape('&'));
                str += key + '=' + value + '&';
            }
            defaults.data = str.substring(0, str.length - 1);
        }
        defaults.method = defaults.method.toUpperCase();
        defaults.cache = defaults.cache ? '' : '&' + new Date().getTime();
        if (defaults.method === 'GET' && (defaults.data || defaults.cache)) defaults.url += '?' + defaults.data + defaults.cache;
        var oXhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        oXhr.open(defaults.method, defaults.url, defaults.async);
        if (defaults.method === 'GET') {
            oXhr.send(null);
        } else {
            oXhr.setRequestHeader("Content-type", defaults.contentType);
            oXhr.send(defaults.data);
        }
        if (defaults.async) {
            oXhr.onreadystatechange = function () {
                if (oXhr.readyState === 4 && oXhr.status === 200) {
                    defaults.success.call(oXhr, JSON.parse(oXhr.responseText));
                } else {
                    defaults.error(oXhr.statusText);
                }
            };
        } else {
            if (oXhr.readyState === 4 && oXhr.status === 200) {
                defaults.success.call(oXhr, JSON.parse(oXhr.responseText));
            } else {
                defaults.error(oXhr.statusText);
            }
        }
    }

})();