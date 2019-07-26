var LyitePackage = function () {};
LyitePackage.isString = function (v) { // 字符串?
    return Object.prototype.toString.call(v).slice(8, -1) === 'String'
};
LyitePackage.isNumber = function (v) { // 数字?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Number'
};
LyitePackage.isBoolean = function (v) { // boolean?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Boolean'
};
LyitePackage.isFunction = function (v) { // 函数?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Function'
};
LyitePackage.isNull = function (v) { // null?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Null'
};
LyitePackage.isUndefined = function (v) { // undefined?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Undefined'
};
LyitePackage.isObject = function (v) { // object?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Object'
};
LyitePackage.isArray = function (v) { // array?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Array'
};
LyitePackage.isDate = function (v) { // 时间?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Date'
};
LyitePackage.isRegExp = function (v) { // 正则?
    return Object.prototype.toString.call(v).slice(8, -1) === 'RegExp'
};
LyitePackage.isError = function (v) { // 错误对象?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Error'
};
LyitePackage.isSymbol = function (v) { // Symbol函数?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Symbol'
};
LyitePackage.isPromise = function (v) { // Promise对象?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Promise'
};
LyitePackage.isSet = function (v) { // set对象?
    return Object.prototype.toString.call(v).slice(8, -1) === 'Set'
};
LyitePackage.isFalse = function (v) {
    if (!v || v === 'null' || v === 'undefined' || v === 'false' || v === 'NaN')
        return true;
    return false
};
LyitePackage.isTrue = function (v) {
    return !this.isFalse(v)
};
LyitePackage.isIos = function () {
    var u = navigator.userAgent;
    if (u.indexOf('iPhone') > -1) {
        return true
    } else if (u.indexOf('iPad') > -1) {
        return false
    } else if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {
        return false
    } else if (u.indexOf('Windows Phone') > -1) {
        return false
    } else {
        return false
    }
};
LyitePackage.isPC = function () {
    var u = navigator.userAgent;
    var agents = ['Android', 'iPhone', 'SymbianOS', 'Windows Phone', 'iPad', 'iPod'];
    var flag = true, len = agents.length;
    for (var i = 0; i < len; i++) {
        if (u.indexOf(agents[i]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
};
LyitePackage.browserType = function () {
    var u = navigator.userAgent; // 取得浏览器的userAgent字符串
    var isOpera = u.indexOf('Opera') > -1; // opera浏览器
    var isIE = u.indexOf('compatible') > -1 && u.indexOf('MSIE') > -1 && !isOpera; // IE浏览器
    var isIE11 = u.indexOf('Trident') > -1 && u.indexOf('rv:11.0') > -1; // IE11
    var isEdge = u.indexOf('Edge') > -1 && !isIE; // edge浏览器
    var isFF = u.indexOf('Firefox') > -1; // 火狐浏览器
    var isSafari = u.indexOf('Safari') > -1 && u.indexOf('Chrome') === -1; // Safari浏览器
    var isChrome = u.indexOf('Chrome') > -1 && u.indexOf('Safari') > -1; // Chrome浏览器

    if (isIE) {
        var reIE = new RegExp('MSIE (\\d+\\.\\d+);');
        reIE.test(u);
        var fIEVersion = parseFloat(RegExp["$1"]);
        switch (fIEVersion) {
            case 7: return 'IE7';
            case 8: return 'IE8';
            case 9: return 'IE9';
            case 10: return 'IE10';
            default : return 'IE7以下';
        }
    }

    if (isIE11) return 'IE11';
    if (isEdge) return 'Edge';
    if (isFF) return 'Firefox';
    if (isOpera) return 'Opera';
    if (isSafari) return 'Safari';
    if (isChrome) return 'Chrome';
};
LyitePackage.checkStr = function (v, t) {
    switch (t) {
        case 'phone': return /^1[3|4|5|6|7|8|9][0-9]{9}$/.test(v);
        case 'tel': return /^(0\d{2,3}-\d{7,8})(-\d{1,4})$/.test(v);
        case 'card': return /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(v);
        case 'pwd': return /^[a-zA-Z]\w{5,17}$/.test(v);
        case 'postal': return /^[1-9]\d{5}(?!\d)/.test(v);
        case 'QQ': return /^[1-9][0-9]{4,9}$/.test(v);
        case 'email': return /^[\w-]+(\.[w-]+)*@[\w-]+(\.[\w-]+)+$/.test(v);
        case 'money': return /^\d*(?:\.\d{0,2})?$/.test(v);
        case 'url': return /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/.test(v);
        case 'IP': return /((?:(?:25[0-5]|2[0-4]\\d|[01]?\\d?\\d)\\.){3}(?:25[0-5]|2[0-4]\\d|[01]?\\d?\\d))/.test(v);
        case 'date': return /^(\d{4})\-(\d{2})\-(\d{2}) (\d{2})(?:\:\d{2}|:(\d{2}):(\d{2}))$/.test(v) || /^(\d{4})\-(\d{2})\-(\d{2})$/.test(v);
        case 'number': return /^[0-9]+$/.test(v);
        case 'english': return /^[a-zA-Z]+$/.test(v);
        case 'chinese': return /^[\u4E00-\u9FA5]+$/.test(v);
        case 'lower': return /^[a-z]+$/.test(v);
        case 'upper': return /^[A-Z]+$/.test(v);
        case 'html': return /<("[^"]*"|'[^']*'|[^'">])*>/.test(v);
        default : return true;
    }
};
LyitePackage.isCardId = function (v) {
    if (!/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(v)) {
        return false // 您输入的身份证长度或格式错误
    }

    var city = {
        11:'北京',12:'天津',13:'河北',14:'山西',15:'内蒙古',21:'辽林',22:'吉林',23:'黑龙江',31:'上海',32:'江苏',
        33:'浙江',34:'安徽',35:'福建',36:'江西',37:'山东',41:'河南',42:'湖北',43:'湖南',44:'广东',45:'广西',
        46:'海南',50:'重庆',51:'四川',52:'贵州',53:'云南',54:'西藏',61:'陕西',62:'甘肃',63:'青海',64:'宁夏',
        65:'新疆',71:'台湾',81:'香港',82:'澳门',91:'国外'
    };
    if (!city[parseInt(v.substr(0,2))]) {
        return false // 您的身份证地区非法
    }

    var birthday = (v.substr(6, 4) + '-' +
        Number(v.substr(10, 2)) + '-' +
        Number(v.substr(12, 2))).replace(/-/g,'/'),
        d = new Date(birthday);
    if (birthday !== (d.getFullYear() + '/' + (d.getMonth() + 1) + '/' + d.getDate())) {
        return false; // 身份证上的出生日期非法
    }

    // 身份证号码校验
    var sum = 0,
        weights = [7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2],
        codes = '10X98765432';
    for (var i = 0; i < v.length - 1; i++) {
        sum += v[i] * weights[i]
    }
    var last = codes[sum % 11]; // 计算出来的最后一位身份证号码
    if (v[v.length-1] != last) {
        return false; // 您输入的身份证号非法
    }

    return true;
};

// +-----------------------------------------------------------------------------------------------
// |-----------------------------------------------------------------------------------------------
// |---------------------------------------------- Date -------------------------------------------
// |-----------------------------------------------------------------------------------------------
// +-----------------------------------------------------------------------------------------------

/**
 * 格式化时间
 * @param time 时间
 * @param cFormat 格式
 * @return {string|null}
 *
 * @example LyitePackage.formatTime('2019-7-7', '{y}/{m}/{d} {h}:{i}:{s}') -> 2019/07/07 00:00:00
 */
LyitePackage.formatTime = function (time, cFormat) {
    if (arguments.length === 0) return null;
    if ((time + '').length === 10) {
        time = +time * 10
    }

    var format = cFormat || '{y}-{m}-{d} {h}:{i}:{z}', date;
    date = typeof time === 'object' ? time : new Date(time);

    var formatObj = {
        y: date.getFullYear(),
        m: date.getMonth() + 1,
        d: date.getDate(),
        h: date.getHours(),
        i: date.getMinutes(),
        s: date.getSeconds(),
        a: date.getDay()
    };
    var time_str = format.replace(/{(y|m|d|h|i|s|a)+}/g, (result, key) => {
        var value = formatObj[key];
        if (key === 'a') return ['一','二','三','四','五','六','日'][value-1]
        if (result.length > 0 && value < 10) {
            value = '0' + value;
        }

        return value || 0;
    });

    return time_str;
};

/**
 * 返回指定长度的月份集合
 * @param time 时间
 * @param len 长度
 * @param direction 方向：1-前几个月；2-后几个月；3-前后几个月（默认）
 * @return {*}
 *
 * @example LyitePackage.getMonths('2019-7-7', 6, 1) -> ['2019-7','2019-6','2019-5','2019-4','2019-3','2019-2','2019-1']
 */
LyitePackage.getMonths = function (time, len, direction) {
    var mm = new Date(time).getMonth(),
        yy = new Date(time).getFullYear(),
        directions = isNaN(direction) ? 3 : direction,
        index = mm;
    var cutMonth = function (index) {
        if (index <= len && index >= -len) {
            return directions === 1 ? formatPre(index).concat(cutMonth(++index)) :
                   directions === 2 ? formatNext(index).concat(cutMonth(++index)) :
                                      formatCurr(index).concat(cutMonth(++index));
        }
        return []
    };
    var formatNext = function (i) {
        var y = Math.floor(i/12), m = i%12;
        return [yy+y+'-'+(m+1)]
    };
    var formatPre = function (i) {
        var y = Math.ceil(i/12), m = i%12;
        m = m === 0 ? 12 : m;
        return [yy-y+'-'+(13-m)]
    };
    var formatCurr = function (i) {
        var y = Math.floor(i/12), yNext = Math.ceil(i/12), m = i%12, mNext = m === 0 ? 12 : m;
        return [yy-yNext+'-'+(13-mNext),yy+y+'-'+(m+1)]
    };

    // 数组去重
    var unique = function (arr) {
        if (Array.hasOwnProperty('from')) {
            return Array.from(new Set(arr));
        } else {
            var n = {}, r = [];
            for (var i = 0; i < arr.length; i++) {
                if (!n[arr[i]]) {
                    n[arr[i]] = true;
                    r.push(arr[i]);
                }
            }

            return r;
        }
    };

    return directions !== 3 ? cutMonth(index) : unique(cutMonth(index).sort(function (t1, t2) {
        return new Date(t1).getTime() - new Date(t2).getTime()
    }));
};

/**
 * 返回指定长度的天数集合
 * @param time 时间
 * @param len 长度
 * @param direction 方向：1-前几天；2-后几天；3-前后几天（默认）
 * @return {*[]}
 *
 * @example LyitePackage.getDays('2019-7-7', 3, 2) -> ["2019-7-7", "2019-7-8", "2019-7-7", "2019-7-10"]
 */
LyitePackage.getDays = function(time, len, direction) {
    var tt = new Date(time);

    var getDay = function (day) {
        var t = new Date(time);
        t.setDate(t.getDate() + day);
        var m = t.getMonth()+1;

        return t.getFullYear() + '-' + m + '-' + t.getDate()
    };

    var arr = [];
    if (direction === 1) {
        for (var i = 1; i <= len; i++) {
            arr.unshift(getDay(-i))
        }
    } else if (direction === 2) {
        for (var i = 1; i <= len; i++) {
            arr.push(getDay(i))
        }
    } else {
        for (var i = 1; i <= len; i++) {
            arr.unshift(getDay(-i))
        }

        arr.push(tt.getFullYear()+'-'+(tt.getMonth()+1)+'-'+tt.getDate());
        for (var i = 1; i <= len; i++) {
            arr.push(getDay(i))
        }
    }

    return direction === 1 ? arr.concat([tt.getFullYear() + '-' + (tt.getMonth()+1) + '-' + tt.getDate()]) :
           direction === 2 ? [tt.getFullYear() + '-' + (tt.getMonth()+1) + '-' + tt.getDate()].concat(arr) : arr
};


/**
 * 秒数 转 时分秒
 * @param  s 秒数
 * @return {String}
 *
 * @example LyitePackage.formatHMS(3610) -> 1h0m10s
 */
LyitePackage.formatHMS = function(s) {
    var str = '';
    if (s > 3600) {
        str = Math.floor(s/3600) + 'h' + Math.floor(s%3600/60) + 'm' + s%60 + 's';
    } else if (s > 60) {
        str = Math.floor(s/60) + 'm' + s%60 + 's';
    } else {
        str = s%60 + 's';
    }

    return str
};

/**
 * 获取某月有多少天
 * @param time 时间 2019-7-7
 * @return {number}
 */
LyitePackage.getMonthDays = function(time) {
    var date = new Date(time);
    var year = date.getFullYear(), mouth = date.getMonth() + 1, days;

    // 当月份为二月时，根据闰年还是非闰年判断天数
    if (mouth == 2) {
        days = (year%4==0 && year%100==0 && year%400==0) || (year%4==0 && year%100!=0) ? 28 : 29
    } else if (mouth == 1 || mouth == 3 || mouth == 5 || mouth == 7 || mouth == 8 || mouth == 10 || mouth == 12) {
        // 月份为：1,3,5,7,8,10,12 时，为大月.则天数为31；
        days = 31
    } else {
        // 其他月份，天数为：30.
        days = 30
    }

    return days
};

/**
 * 获取某年有多少天
 * @param time 2019-7-7
 * @return {number}
 */
LyitePackage.getYearOfDay = function(time) {
    var firstDayYear = this.getFirstDayOfYear(time);
    var lastDayYear = this.getLastDayOfYear(time);
    var numSecond = (new Date(lastDayYear).getTime() - new Date(firstDayYear).getTime())/1000;

    return Math.ceil(numSecond/(24*3600));
};

/**
 * 获取某年的第一天
 * @param time 2019-7-7
 * @return {string}
 */
LyitePackage.getFirstDayOfYear = function(time) {
    var year = new Date(time).getFullYear();
    return year + "-01-01 00:00:00";
};

/**
 * 获取某年最后一天
 * @param time 2019-7-7
 * @return {string}
 */
LyitePackage.getLastDayOfYear = function(time) {
    var year = new Date(time).getFullYear();
    return year + "-12-31 23:59:59";
};

/**
 * 获取某个日期是当年中的第几天
 * @param time 2019-7-7
 * @return {number}
 */
LyitePackage.getDayOfYear = function(time) {
    var firstDayYear = this.getFirstDayOfYear(time);
    var numSecond = (new Date(time).getTime() - new Date(firstDayYear).getTime())/1000;

    return Math.ceil(numSecond/(24*3600));
};

/**
 * 获取某个日期在这一年的第几周
 * @param time 2019-7-7
 * @return {number}
 */
LyitePackage.getDayOfYearWeek = function(time) {
    var numDays = this.getDayOfYear(time);
    return Math.ceil(numDays / 7);
};

// +-----------------------------------------------------------------------------------------------
// |-----------------------------------------------------------------------------------------------
// |---------------------------------------------- Array ------------------------------------------
// |-----------------------------------------------------------------------------------------------
// +-----------------------------------------------------------------------------------------------

/**
 * 判断一个元素是否在数组中
 * @param val 元素
 * @param arr 数组
 * @return {boolean}
 */
LyitePackage.contains = function(val, arr) {
    return arr.indexOf(val) !== -1;
};

/**
 * 遍历数组
 * @param arr 数组
 * @param fn 回调函数
 */
LyitePackage.each = function(arr, fn) {
    fn = fn || Function;
    var a = [], args = Array.prototype.slice.call(arguments, 1);
    for (var i = 0, j = arr.length; i < j; i++) {
        var res = fn.apply(arr, [arr[i], i].concat(args));
        if (res != null) a.push(res);
    }
};

/**
 * 映射
 * @param arr 数组
 * @param fn 回调函数
 * @param thisObj this指向
 * @return {Array}
 */
LyitePackage.map = function(arr, fn, thisObj) {
    var scope = thisObj || window, a = [];
    for (var i = 0, j = arr.length; i < j; ++i) {
        var res = fn.call(scope, arr[i], i, this);
        if(res != null) a.push(res);
    }

    return a;
};

/**
 * 排序
 * @param arr 数组
 * @param type 排序方式：1-从小到大（默认）；2-从大到小；3-随机
 * @return {*}
 */
LyitePackage.sort = function(arr, type) {
    type = type ? type : 1;
    return arr.sort((a, b) => {
        switch(type) {
            case 1:return a - b;
            case 2:return b - a;
            case 3:return Math.random() - 0.5;
            default:return arr;
        }
    })
};

/**
 * 去重
 * @param arr
 * @return {*[]|Array}
 */
LyitePackage.unique = function(arr) {
    if (Array.hasOwnProperty('from')) {
        return Array.from(new Set(arr));
    } else {
        var n = {},r = [];
        for (var i = 0, j = arr.length; i < j; i++) {
            if (!n[arr[i]]) {
                n[arr[i]] = true;
                r.push(arr[i]);
            }
        }

        return r;
        /*
        注：此处并不能区分 int类型2 和 string类型'2'，但能减少用indexOf带来的性能
        var r = [], NaNBol = true;
        for (var i = 0, j = arr.length; i < j; i++) {
            if (arr[i] !== arr[i]) {
                if (NaNBol && r.indexOf(arr[i]) === -1) {
                    r.push(arr[i]);
                    NaNBol = false;
                }
            } else {
                if(r.indexOf(arr[i]) === -1)
                    r.push(arr[i]);
            }
        }

        return r;
        */
    }
};

/**
 * 并集
 * @param arr1
 * @param arr2
 * @return {*[]|Array}
 */
LyitePackage.union = function(arr1, arr2) {
    var newArr = arr1.concat(arr2);
    return this.unique(newArr);
};

/**
 * 交集
 * @param arr1
 * @param arr2
 * @return {Array}
 */
LyitePackage.intersect = function(arr1, arr2) {
    var _this = this;
    arr1 = _this.unique(arr1);

    return _this.map(arr1, function(v) {
        return _this.contains(v, arr2) ? v : null;
    });
};

/**
 * 删除元素
 * @param arr
 * @param ele
 * @return {*}
 */
LyitePackage.remove = function(arr, ele) {
    var index = arr.indexOf(ele);
    if (index > -1) {
        arr.splice(index, 1);
    }

    return arr;
};

/**
 * 将类数组转换为数组
 * @param ary
 * @return {T[]}
 */
LyitePackage.formArray = function(ary) {
    return  Array.isArray(ary) ? ary : Array.prototype.slice.call(ary);
};

/**
 * 最大值
 * @param arr
 * @return {number}
 */
LyitePackage.max = function(arr) {
    return Math.max.apply(null, arr);
};

/**
 * 最小值
 * @param arr
 * @return {number}
 */
LyitePackage.min = function(arr) {
    return Math.min.apply(null, arr);
};

/**
 * 求和
 * @param arr
 * @return {*}
 */
LyitePackage.sum = function(arr) {
    return arr.reduce((pre, cur) => {
        return pre + cur;
    });
};

/**
 * 平均值
 * @param arr
 * @return {number}
 */
LyitePackage.avg = function(arr) {
    return this.sum(arr)/arr.length
};

// +-----------------------------------------------------------------------------------------------
// |-----------------------------------------------------------------------------------------------
// |---------------------------------------------- String -----------------------------------------
// |-----------------------------------------------------------------------------------------------
// +-----------------------------------------------------------------------------------------------

/**
 * 去除空格
 * @param str
 * @param type 方式：1-所有空格（默认）；2-前后空格；3-前空格；4-后空格
 * @return {void | string | never | string | *|*}
 */
LyitePackage.trim = function(str, type) {
    type = type || 1;
    switch (type) {
        case 1: return str.replace(/\s+/g, "");
        case 2: return str.replace(/(^\s*)|(\s*$)/g, "");
        case 3: return str.replace(/(^\s*)/g, "");
        case 4: return str.replace(/(\s*$)/g, "");
        default: return str;
    }
};

/**
 * @param  {str}
 * @param  {type}
 *       type:  1-首字母大写  2-首字母小写  3-大小写转换  4-全部大写  5-全部小写
 * @return {String}
 */
/**
 * 字符转换
 * @param str
 * @param type：1-首字母大写；2-首字母小写；3-大小写转换；4-全部大写（默认）；5-全部小写
 * @return {string|void | string | never | string | *|*}
 */
LyitePackage.changeCase = function(str, type) {
    type = type || 4;
    switch (type) {
        case 1:
            return str.replace(/\b\w+\b/g, function (word) {
                return word.substring(0, 1).toUpperCase() + word.substring(1).toLowerCase();
            });
        case 2:
            return str.replace(/\b\w+\b/g, function (word) {
                return word.substring(0, 1).toLowerCase() + word.substring(1).toUpperCase();
            });
        case 3:
            return str.split('').map(function(word){
                return /[a-z]/.test(word) ? word.toUpperCase() : word.toLowerCase();
            }).join('');
        case 4:
            return str.toUpperCase();
        case 5:
            return str.toLowerCase();
        default:
            return str;
    }
};

/**
 * 密码强度
 * @param str
 * @return {number}
 */
LyitePackage.checkPwd = function(str) {
    var Lv = 0;
    if (str.length < 6) return Lv;
    if (/[0-9]/.test(str)) Lv++;
    if (/[a-z]/.test(str)) Lv++;
    if (/[A-Z]/.test(str)) Lv++;
    if (/[\.|-|_]/.test(str)) Lv++;

    return Lv;
};

/**
 * 过滤 html 代码(把 <> 转换)
 * @param str
 * @return {string}
 */
LyitePackage.filterTag = function(str) {
    str = str.replace(/&/ig, "&amp;");
    str = str.replace(/</ig, "&lt;");
    str = str.replace(/>/ig, "&gt;");
    str = str.replace(" ", " ");

    return str;
};

// +-----------------------------------------------------------------------------------------------
// |-----------------------------------------------------------------------------------------------
// |---------------------------------------------- Other ------------------------------------------
// |-----------------------------------------------------------------------------------------------
// +-----------------------------------------------------------------------------------------------

/**
 * 获取url中对应参数的值
 * @param v
 * @return {string|null}
 *
 * @example http://domain/index.html?id=123 LyitePackage.getUrlParam('id') -> 123
 */
LyitePackage.getUrlParam = function(v) {
    var regex = new RegExp("(^|&)"+ v +"=([^&]*)(&|$)"); // 构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(regex); // 匹配目标参数
    if (r != null) return unescape(r[2]); return null; // 返回参数值
};

// File End
