/*
 * 判断是通过什么浏览器打开的网址，需要执行的事件待完善 TODO
 * mobile：ios浏览器、android浏览器、微信浏览器等
 * PC：PC端浏览器
 * @author Lycan LycanCoder@gmail.com
 * @date 2019/03/09
 */
function browserInfo(pc = "", android = "", ios = "", weChat = "") {
    var browser = {
        version: function () {
            var u = navigator.userAgent,
                app = navigator.appVersion;
            return { // 移动终端浏览器版本信息
                trident: u.indexOf("Trident") > -1, // IE内核
                presto: u.indexOf("Presto") > -1, // opera内核
                webKit: u.indexOf("AppleWebKit") > -1, // 苹果、谷歌内核
                gecko: u.indexOf("Gecko") > -1 && u.indexOf("KHTML") == -1, // 火狐内核
                mobile: !!u.match(/AppleWebKit.*Mobile.*/), // 是否为移动终端
                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), // ios终端
                android: u.indexOf("Android") > -1 || u.indexOf("Linux") > -1, // android终端或uc浏览器
                iPhone: u.indexOf("iPhone") > -1, // 是否为iPhone或者QQHD浏览器
                iPad: u.indexOf("iPad") > -1, // 是否为iPad
                webApp: u.indexOf("Safari") == -1, // 是否为web应用程序，没有头部与底部
            };
        } (),
        language: (navigator.browserLanguage || navigator.language).toLowerCase()
    };

    if (browser.version.mobile) { // 判断是否是移动设备打开
        var ua = navigator.userAgent.toLowerCase(); // 获取判断用的对象
        if (ua.match(/MicroMessenger/i) == "micromessenger") {
            // TODO 在微信中打开
            weChat == "" ? browserDefault() : weChat();
        } else if (ua.match(/WeiBo/i) == "weibo") {
            // TODO 在新浪微博客户端打开
            alert("新浪微博客户端");
        } else if (ua.match(/QQ/i) == "qq") {
            // TODO 在QQ空间打开
            alert("QQ空间");
        } else if (browser.version.ios) {
            // TODO 在IOS浏览器打开
            ios == "" ? browserDefault() : ios();
        } else if(browser.version.android){
            // TODO 在安卓浏览器打开
            android == "" ? browserDefault() : android();
        } else {
            // TODO 移动端其他浏览器
            alert("移动设备");
        }
    } else { // 否则就是PC浏览器打开
        pc == "" ? browserDefault() : pc();
    }
}

function browserDefault() {
    // TODO
    console.log("判断浏览器类型执行默认方法");
}