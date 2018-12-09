/**
 * Public JavaScript(公用JS函数)
 * @author Lycan
 * @date 2018-10-15
 */

/*
 * 获取url中对应参数的值
 * @author Lycan
 * @date 2018-10-15
 * @example：
 *     http://localhost/index.html?id=123
 *     id = f_get_url_param('id'); return 123;
 * @param name
 * @returns {*}
 */
function f_get_url_param(name) {
    let regex = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); // 构造一个含有目标参数的正则表达式对象
    let r = window.location.search.substr(1).match(regex); // 匹配目标参数
    if (r != null) return unescape(r[2]); return null; // 返回参数值
}

/*
 * 检测是否为手机号码
 * @author Lycan
 * @date 2018-10-15
 * @param v
 * @returns {boolean}
 */
function f_verify_phone(v) {
    let regex = /^1\d{10}$/; // 正则式
    return regex.test(v); // 验证：true-正确；false-错误
}

/*
 * 检测是否为邮箱
 * @author Lycan
 * @date 2018-10-15
 * @param v
 * @returns {boolean}
 */
function f_verify_email(v) {
    let regex = /^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i; // 正则式
    return regex.test(v); // 验证：true-正确；false-错误
}