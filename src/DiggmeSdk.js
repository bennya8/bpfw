;/**
 * Diggme JS SDK
 * @version 1.0.0
 * @author develop@diggme.cn
 * @created 2017-04-26
 * @modified 2017-04-26
 */
(function () {

    /**
     * constructor
     * @param appKey
     * @param serverUrl
     * @constructor
     */
    var DiggmeSdk = function (appKey, serverUrl) {
        this.appKey = appKey;
        this.serverUrl = serverUrl;
        this.headerAuth = true;

        this.axios = typeof require === 'function'
            ? require('axios')
            : window.axios;

        let axios = this.axios;
        if (!axios) {
            throw new Error('[axios] dependency cannot locate')
        }

        axios.defaults.headers.common = {
            'Accept': 'application/json'
        };

        if (this.headerAuth) {
            axios.interceptors.request.use(function (config) {
                config.headers['Authorization'] = localStorage.getItem('accessToken') || '';
                config.headers['Authorization-User'] = localStorage.getItem('userToken') || '';
                return config;
            });
        } else {
            axios.defaults.headers.common = {};
            axios.interceptors.request.use(function (config) {
                if (!config.params) {
                    config.params = {};
                }
                config.params.access_token = localStorage.getItem('accessToken') || '';
                config.params.user_token = localStorage.getItem('userToken') || '';
                return config;
            });
        }
    };

    /**
     * Promise请求封装
     * @param url
     * @param params
     * @param method
     * @returns {Promise<any>}
     */
    DiggmeSdk.prototype.request = function (url, params, method) {
        var _this = this;
        method = method || 'GET'

        if (method === 'POST') {
            return new Promise(function (resolve, reject) {
                _this.axios.post(_this.serverUrl + url, params).then(function (response) {
                    resolve(response);
                }).catch(function (error) {
                    reject(error);
                });
            });
        } else {
            return new Promise(function (resolve, reject) {
                _this.axios.get(_this.serverUrl + url, params).then(function (response) {
                    resolve(response);
                }).catch(function (error) {
                    reject(error);
                });
            });
        }
    }

    /*********************************************************
     * Oauth 授权
     *********************************************************/

    /**
     * 根据获取token获取的code(异步请求)
     * @remark 请确保获取code后, 并写入到asset
     */
    DiggmeSdk.prototype.getAccessTokenByCode = function (code) {
        var _this = this;
        return _this.request('open/token', {
            params: {
                'grant_type': 'authorize_code',
                'app_key': _this.appKey,
                'code': code
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
     * Channel 渠道
     *********************************************************/

    /**
     * 渠道测试分类
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestCategory = function () {
        var _this = this;
        return _this.request('/channel/test/category/list');
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
        return _this.request('/channel/test/list', {
            params: {
                size: size || 20,
                page: page || 1,
                category_id: categoryId > 0 ? categoryId : 0
            }
        });
    };

    /**
     * 渠道测试详情
     * @param testId
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestDetail = function (testId) {
        var _this = this;
        return _this.request('/channel/test/detail', {
            params: {
                test_id: testId || 0
            }
        });
    };

    /**
     * 渠道测试报告
     * @param testId
     * @param inCode
     */
    DiggmeSdk.prototype.getChannelTestReport = function (testId, inCode) {
        var _this = this;
        return _this.request('/channel/test/report', {
            params: {
                test_id: testId || 0,
                in_code: inCode || ''
            }
        });
    };

    /**
     * 查询订单状态
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestCodeStatus = function (testId, inCode) {
        var _this = this;
        return _this.request('/channel/test/codeStatus', {
            params: {
                test_id: testId || 0,
                in_code: inCode || ''
            }
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
        return _this.request('/channel/test/question', {
            params: {
                test_id: testId || 0,
                role_id: roleId || 0,
                part_id: partId || 0,
                in_code: inCode || ''
            }
        });
    };

    /**
     * 提交问卷结果
     * @param testId
     * @param inCode
     * @param choices
     * @returns {Promise}
     */
    DiggmeSdk.prototype.postChannelTestUserResult = function (testId, inCode, choices) {
        var _this = this;
        return _this.request('/channel/test/result', {
            test_id: testId || 0,
            in_code: inCode || '',
            choices: choices
        }, 'POST');
    };

    /**
     * 获取问卷人口信息列表
     * @param testId
     * @param inCode
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestInfoList = function (testId, inCode) {
        var _this = this;
        return _this.request('/channel/test/info/list', {
            params: {
                'test_id': testId || 0,
                'in_code': inCode || ''
            }
        });
    };

    /**
     * 提交问卷人口信息
     * @param testId
     * @param inCode
     * @param setting
     * @param roleId
     * @returns {Promise}
     */
    DiggmeSdk.prototype.postChannelTestUserInfo = function (testId, inCode, setting, roleId) {
        var _this = this;
        return _this.request('/channel/test/info', {
            'test_id': testId || 0,
            'in_code': inCode || '',
            'setting': setting || '',
            'role_id': roleId || 0
        }, 'POST');
    };

    /**
     * 获取推荐测试
     * @param page
     * @param size
     * @returns {Promise}
     */
    DiggmeSdk.prototype.getChannelTestRecommendList = function (page, size) {
        var _this = this;
        return _this.request('/channel/test/recommend/list', {
            params: {
                'page': page || 1,
                'size': size || 2
            }
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
     * 是否HTTPS请求
     * @returns boolean
     */
    function isHttps() {
        return document.location.protocol === 'https:';
    }

})();