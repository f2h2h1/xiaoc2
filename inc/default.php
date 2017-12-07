<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>嗨云</title>
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="//cdn.bootcss.com/photoswipe/4.1.1/photoswipe.min.css" rel="stylesheet">
        <link href="//cdn.bootcss.com/photoswipe/4.1.1/default-skin/default-skin.min.css" rel="stylesheet">
        <style>
            #uploader {
                background-size: cover;
                background-position: center;
                width:100%;
                height:200px;
                background-image: url("http://i1.piimg.com/501024/f77b7937dd3ef2e2.jpg");
                color: #FFF;
                line-height: 230px;
                text-align: center;
                font-size: 2.5em;
            }
            #selectpicture {
                position: absolute;
                top: 50px;
                color: #FFF;
                opacity: 0;
                background-size: cover;
                background-position: center;
                width: 100%;
                height: 230px;
            }
            .my-gallery {
                width: 96%;
                float: left;
                margin-left: 6px;

            }
            .my-gallery img {
                width: 100%;
                height: auto;
            }
            .my-gallery figure {
                display: block;
                float: left;
                margin: 0 5px 5px 0;
            }
            .my-gallery div {
                width: 78px;
                height: 78px;
                background-size: cover;
            }
            .glyphicon-remove-circle:before {
                z-index:99;
                color: #FFFFFF;
                font-size: 13px;
                background-color: rgb(255, 118, 118);
                border-radius: 56px;
                float: left;
            }
            #progressBar,#progressBarAll {
                width: 90%;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row  navbar-fixed-top" style="background-color: #CCC;">
                <nav class="navbar navbar-inverse navbar-top" role="navigation" style="margin-bottom: 0px">
                    <div class="">
                        <a class="navbar-brand" style="margin-left: 13px;font-size:27px;padding:15px 8px" href="">嗨云</a>
                        <script type="text/javascript">window._MM_HS=+new Date</script>
                    </div>
                    <!--<div class="" style="margin-right: 10px;float: right;">
                        <a class="navbar-brand" style="font-size:8px;padding:15px 8px" href="">常见问题</a>
                        <a class="navbar-brand" style="font-size:8px;padding:15px 8px" href="">服务条款</a>
                        <a class="navbar-brand" style="font-size:8px;padding:15px 8px" href="">联系我们</a>
                    </div>-->
                </nav>
            </div>
        </div>
        <div class="container-fluid" style="padding-top:50px">
            <div class="row" >
                <div id="uploader" style="">
                    <span>  </span>
                    <input type="file" accept="image/*" multiple="multiple" name="file" id="selectpicture" onchange="selectPicture(this)">
                </div>
            </div>
            <div class="row">
                <br>
                <div class="my-gallery" id="waitUpload">

                </div>
                <!--<button class="btn btn-primary btn-lg" onClick="enabled_upload_toast()">开始演示模态框</button>-->
            </div>
        </div>
        <footer>
            <hr>
            <div class="container">
                <p class="text-center">嗨云   版权所有   粤ICP备15022995号-2</p>
            </div>
        </footer>
        <!-- Root element of PhotoSwipe. Must have class pswp. -->
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
            <!-- Background of PhotoSwipe. It's a separate element as animating opacity is faster than rgba(). -->
            <div class="pswp__bg"></div>
            <!-- Slides wrapper with overflow:hidden. -->
            <div class="pswp__scroll-wrap">
                <!-- Container that holds slides. PhotoSwipe keeps only 3 of them in the DOM to save memory.Don't modify these 3 pswp__item elements, data is added later on. -->
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>
                <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                <div class="pswp__ui pswp__ui--hidden">
                    <div class="pswp__top-bar" style="display:none">
                        <!--  Controls are self-explanatory. Order can be changed. -->
                        <div class="pswp__counter"></div>
                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                        <button class="pswp__button pswp__button--share" title="Share"></button>
                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                        <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                        <!-- element will get class pswp__preloader--active when preloader is running -->
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div>
                    </div>
                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 上传模态框（Modal） -->
        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="disabled_upload_toast()">×</button>-->
                        <h4 class="modal-title" id="uploadModalLabel">
                            上传中（上传期间请勿关闭页面）
                        </h4>
                    </div>
                    <div class="modal-body">
                        <span id="uploadPictureName"></span>
                        <br>
                        <progress id="progressBar" value="0" max="100"></progress>&nbsp;<span id="percentage">0%</span>
                        <br>
                        <span id="successUploadPictureNumber">0</span>/<span id="uploadPictureNumber">0</span>
                        <br>
                        <progress id="progressBarAll" value="0" max="100"></progress>&nbsp;<span id="percentageAll">0%</span>
                    </div>
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-default" disabled="disabled" data-dismiss="modal" onClick="disabled_upload_toast()">关闭</button>-->
                        <!--<button type="button" class="btn btn-primary" disabled="disabled" onClick="disabled_upload_toast()">提交更改</button>-->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <!-- 删除模态框（Modal） -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteModalLabel">
                            删除中（删除期间请勿关闭页面）
                        </h4>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <div class="modal-backdrop fade in" id="loadingToast" style="display: none;" onClick="disabled_upload_toast()"></div>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script>
            wx.config({
                debug: false,
                appId: '<?php echo $wechatJssdk['appId']?>',
                timestamp: '<?php echo $wechatJssdk['timestamp']?>',
                nonceStr: '<?php echo $wechatJssdk['nonceStr']?>',
                signature: '<?php echo $wechatJssdk['signature']?>',
                jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'hideMenuItems',
                'showMenuItems',
                'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem',
                'hideOptionMenu',
                'showOptionMenu',
                ]
            });

            var wechatShare = {
                title:'<?php echo $wechatShare['title'];?>',
                desc:'<?php echo $wechatShare['desc'];?>',
                likn:'<?php echo $wechatShare['link'];?>',
                imgurl:'<?php echo $wechatShare['imgurl'];?>',
            };

            wx.ready(function () {
                wx.hideAllNonBaseMenuItem();
                wx.hideOptionMenu();
                wx.showMenuItems({
                    menuList: [
                        'menuItem:share:timeline',
                        'menuItem:share:appMessage'
                    ]
                });
                wx.onMenuShareTimeline({
                    title: wechatShare.title, // 分享标题
                    link: wechatShare.link, // 分享链接
                    imgUrl: wechatShare.imgurl, // 分享图标
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert("分享成功");
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
                wx.onMenuShareAppMessage({
                    title: wechatShare.title, // 分享标题
                    desc: wechatShare.desc, // 分享描述
                    link: wechatShare.link, // 分享链接
                    imgUrl: wechatShare.imgurl, // 分享图标
                    type: '', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert("分享成功");
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });
            });
            wx.error(function (res) {
                //alert(res.errMsg);
            });
        </script>
        <script src="//cdn.bootcss.com/photoswipe/4.1.1/photoswipe.min.js"></script>
        <script src="//cdn.bootcss.com/photoswipe/4.1.1/photoswipe-ui-default.min.js"></script>
        <script>
            var url = "?ajax";

            loadPicture();
            //载入图片
            function loadPicture() {

                var loadFalsedCount = 0;

                loading();

                function loading() {
                    var dataInfo;

                    var form = new FormData();
                    var xmlhttp = new XMLHttpRequest();

                    form.append("state", "load");

                    xmlhttp.open("post", url, true);
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            var str = xmlhttp.responseText;
                            if (str != null) {
                                var data = getJsonFromString(str);
                                if (data) {
                                    if (data['state']) {
                                        if (data['state'] == "1") {
                                            if (data['msg'] == "" ||
                                                data['msg'] == "[]" ||
                                                data['msg'] == "null" ||
                                                data['msg'] == null) {return;}
                                            data = getJsonFromString(data['msg']);
                                            if (data) {
                                                data = data.reverse();

                                                for (var i = 0;i < data.length;i++) {

                                                    for(var key in data[i]){}
                                                    dataInfo = (data[i][key]);

                                                    if (key && dataInfo['t_url'] && dataInfo['s_url'] && dataInfo['width'] && dataInfo['height']) {
                                                        var figure = insertPhotoSwipeElement(key, dataInfo['t_url'], dataInfo['s_url'], dataInfo['width'], dataInfo['height']);

                                                        var waitUpload = document.getElementById("waitUpload");
                                                        waitUpload.appendChild(figure);
                                                    } else {
                                                        continue;
                                                    }
                                                }
                                            } else {
                                                loadFalsed(6);
                                                return;
                                            }
                                        } else {
                                            loadFalsed(5);
                                            return;
                                        }
                                    } else {
                                        loadFalsed(4);
                                        return;
                                    }
                                } else {
                                    loadFalsed(3);
                                    return;
                                }
                            } else {
                                loadFalsed(2);
                                return;
                            }
                        } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                            loadFalsed(1, xmlhttp.status);
                            return;
                        }
                    }
                    xmlhttp.send(form);
                }
                //载入失败
                function loadFalsed(e, httpcode) {
                    loadFalsedCount++;
                    if (loadFalsedCount < 10) {
                        loading();
                    } else {
                        alert("载入失败\ncode:"+e+" "+httpcode);
                    }
                }
            }
            //选择图片
            function selectPicture(file) {
                if (file.files) {
                    var uploadPictureObject = new Array();
                    if (file.files.length <= 100) {
                        var uploadPictureObjectCount = 0;
                        for (var i = 0; i < file.files.length; i++) {
                            var fileObj = file.files[i]; // js 获取文件对象

                            if ("image/png" != fileObj.type && "image/jpeg" != fileObj.type && "image/gif" != fileObj.type) {
                                //document.getElementById("selectpicture").value = "";
                                //alert("图片的格式必须为png或者jpg或者jpeg格式！");
                                //return;
                                continue;
                            }
                            if (((fileObj.size / 1024) /1024) > 10) {
                                //document.getElementById("selectpicture").value = "";
                                //alert("图片不得大于10M！");
                                //return;
                                continue;
                            }
                            uploadPictureObject[uploadPictureObjectCount] = file.files[i];
                            uploadPictureObjectCount++;
                        }
                        writeObj(uploadPictureObject)
                        if (uploadPictureObject.length >= 1) {
                            uploadPicture(uploadPictureObject);
                        }
                    } else {
                        document.getElementById("selectpicture").value = "";
                        alert("每次最多上传一百张图片");
                        return;
                    }
                }
            }
            //上传图片
            function uploadPicture(fileObj) {
                var countUpload = 0;
                var timestamp = new Date().getTime();
                enabled_upload_toast();

                document.getElementById("uploadModalLabel").innerHTML = "上传中（上传期间请勿关闭页面）";

                document.getElementById("uploadPictureNumber").innerHTML = fileObj.length;

                var successUploadPictureNumber = 0;

                var progressBarAll = document.getElementById("progressBarAll");
                var percentageDivAll = document.getElementById("percentageAll");
                var progressBar = document.getElementById("progressBar");
                var percentageDiv = document.getElementById("percentage");

                progressBarAll.max = fileObj.length;

                var progressAnimationTag;

                upload();

                function upload() {
                    if (countUpload < fileObj.length) {

                        document.getElementById("uploadPictureName").innerHTML = fileObj[countUpload].name;

                        var form = new FormData();
                        var xmlhttp = new XMLHttpRequest();

                        form.append("file[]", fileObj[countUpload]);
                        form.append("state", "updata");
                        form.append("timestamp2", timestamp);

                        xmlhttp.open("post", url, true);

                        xmlhttp.upload.addEventListener("progress", progressFunction, false);
                        xmlhttp.onreadystatechange = function() {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                var str = xmlhttp.responseText;
                                //writeObj(str)
                                if (str != null) {
                                    var data = getJsonFromString(str);
                                    writeObj(data);
                                    if (data) {
                                        if (data['state']) {
                                            if (data['state'] == "1") {
                                                data = getJsonFromString(data['msg']);
                                                if (data) {
                                                    for(var key in data){}
                                                    dataInfo = (data[key]);
                                                    //console.log(key);
                                                    //writeObj(data);
                                                    if (key && dataInfo['t_url'] && dataInfo['s_url'] && dataInfo['width'] && dataInfo['height']) {
                                                        var figure = insertPhotoSwipeElement(key, dataInfo['t_url'], dataInfo['s_url'], dataInfo['width'], dataInfo['height']);

                                                        var waitUpload = document.getElementById("waitUpload");
                                                        waitUpload.insertBefore(figure, waitUpload.childNodes[0]);

                                                        countUpload++;

                                                        document.getElementById("successUploadPictureNumber").innerHTML = countUpload;


                                                        progressBarAll.value = countUpload;
                                                        percentageDivAll.innerHTML = Math.round(countUpload / fileObj.length * 100) + "%";

                                                        if (progressAnimationTag) {
                                                            clearInterval(progressAnimationTag);
                                                            progressBar.value = progressBar.max;
                                                            percentageDiv.innerHTML = "100%";
                                                        }

                                                        timestamp = new Date().getTime();
                                                        upload();
                                                        //alert("上传成功");
                                                    } else {
                                                        uploadFailed(7);
                                                        return;
                                                    }
                                                } else {
                                                    uploadFailed(6);
                                                    return;
                                                }
                                            } else {
                                                uploadFailed(5);
                                                return;
                                            }
                                        } else {
                                            uploadFailed(4);
                                            return;
                                        }
                                    } else {
                                        uploadFailed(3);
                                        return;
                                    }
                                } else {
                                    uploadFailed(2);
                                    return;
                                }
                            } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                                uploadFailed(1);
                                return;
                            }
                        }
                        xmlhttp.send(form);
                    } else {
                        if (progressAnimationTag) clearInterval(progressAnimationTag);
                        
                        document.getElementById("uploadModalLabel").innerHTML = "上传完成";
                        document.getElementById("selectpicture").value = "";
                        alert("上传完成");
                        progressBarAll.value = 0;
                        percentageDivAll.innerHTML = "0%";
                        document.getElementById("successUploadPictureNumber").innerHTML = 0;
                        disabled_upload_toast();
                        return;
                    }
                }
                //上传失败
                function uploadFailed(e) {
                    if (progressAnimationTag) clearTimeout(progressAnimationTag);
                    document.getElementById("uploadModalLabel").innerHTML = "上传失败，请稍后再试...";
                    document.getElementById("selectpicture").value = "";
                    alert("上传失败，请稍后再试\ncode:"+e);
                    disabled_upload_toast();
                }
                //上传进度条
                function progressFunction(evt) {
                    if (evt.lengthComputable) {
                        progressBar.max = evt.total;
                        progressBar.value = evt.loaded/2;
                        percentageDiv.innerHTML = Math.round((evt.loaded / evt.total * 100)/2) + "%";
                        if (evt.loaded == evt.total) {
                            //console.log("total:"+evt.total);
                            //console.log("progressBar.max:"+progressBar.max);
                            
                            progressBar.max = 100;
                            progressBar.value = 50;
                            progressBarDivValue = "50%";
                            progressAnimationTag = setInterval(progressAnimation, 1000);
                        }
                    }
                    //console.log(progressBar.value);
                }
                function progressAnimation() {
                    var progressBarValue = progressBar.value + 1;
                    var progressBarDivValue = progressBarValue + "%";
                    if (progressBarDivValue >= 99 || progressBarValue >= progressBar.max) {
                        progressBarDivValue = "99%";
                        clearInterval(progressAnimationTag);
                    }
                    progressBar.value = progressBarValue;
                    percentageDiv.innerHTML = progressBarDivValue;
                }
            }

            //删除图片
            function deletePicture(obj, evt) {
                var ev = window.event || evt;
                ev.stopPropagation();
                ev.preventDefault();
                if (confirm("确认要把此图片删除吗？") == true) {
                    enabled_delete_toast();

                    var form = new FormData();
                    var xmlhttp = new XMLHttpRequest();

                    form.append("state", "delete");
                    form.append("pictureIndex", obj.getAttribute('picture-index'));

                    xmlhttp.open("post", url, true);

                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            var str = xmlhttp.responseText;
                            
                            if (str != null) {
                                var data = getJsonFromString(str);
                                writeObj(data);
                                if (data) {
                                    if (data['state']) {
                                        if (data['state'] == "1") {
                                            document.getElementById("waitUpload").removeChild(obj.parentNode.parentNode.parentNode);

                                            alert('删除成功');
                                            disabled_delete_toast();
                                        } else {
                                            alert("删除失败，请稍后再试\ncode:5");
                                            disabled_delete_toast();
                                            return;
                                        }
                                    } else {
                                        alert("删除失败，请稍后再试\ncode:4");
                                        disabled_delete_toast();
                                        return;
                                    }
                                } else {
                                    alert("删除失败，请稍后再试\ncode:3");
                                    disabled_delete_toast();
                                    return;
                                }
                            } else {
                                alert("删除失败，请稍后再试\ncode:2");
                                disabled_delete_toast();
                                return;
                            }
                        } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {

                            alert("删除失败，请稍后再试\ncode:1");
                            disabled_delete_toast();
                            return;
                        }
                    }
                    xmlhttp.send(form);
                }
            }
            //插入PhotoSwipe节点
            function insertPhotoSwipeElement(key, t_url, s_url, width, height) {
                var span = document.createElement("span");
                span.className = "glyphicon glyphicon-remove-circle";
                span.setAttribute("onclick", "deletePicture(this);");
                span.setAttribute('picture-index', key);

                var div = document.createElement("div");
                div.style.backgroundImage = "url('" + t_url + "')";
                div.appendChild(span);

                var a = document.createElement("a");
                a.setAttribute('href', s_url);
                a.setAttribute('itemprop', "contentUrl");
                a.setAttribute('data-size', width + "x" + height);
                a.appendChild(div);

                var figure = document.createElement("figure");
                figure.setAttribute('itemprop', "associatedMedia");
                figure.appendChild(a);

                return figure;
            }
            //上传模态框
            function enabled_upload_toast() {
                document.getElementById('loadingToast').style.display = 'block';
                var uploadModal = document.getElementById('uploadModal');
                uploadModal.style.display = 'block';
                uploadModal.className = "modal fade in";
            }
            function disabled_upload_toast() {
                document.getElementById('loadingToast').style.display = 'none';
                var uploadModal = document.getElementById('uploadModal');
                uploadModal.style.display = 'none';
                uploadModal.className = "modal fade";
            }
            //删除模态框
            function enabled_delete_toast() {
                document.getElementById('loadingToast').style.display = 'block';
                var deleteModal = document.getElementById('deleteModal');
                deleteModal.style.display = 'block';
                deleteModal.className = "modal fade in";
            }
            function disabled_delete_toast() {
                document.getElementById('loadingToast').style.display = 'none';
                var deleteModal = document.getElementById('deleteModal');
                deleteModal.style.display = 'none';
                deleteModal.className = "modal fade";
            }
            //把字符串转换成json对象
            function getJsonFromString(str) {
                try {
                    return JSON.parse(str);
                } catch(err) {
                    return false;
                }
            }
            //打印对象用的函数
            function writeObj(obj) {
                var description = "";
                for (var i in obj) {
                    var property = obj[i];
                    description += i + " = " + property + "\n";
                }
                console.log(description);
            }
        </script>
        <script src="http://7xopbl.com1.z0.glb.clouddn.com/init-photoswipe-fromdom.js"></script>
        <script type="text/javascript"> window._MM_CID="383",window._MM_TP="pc",function(t){t.JSMON={_head_end:+new Date,_head_start:t._MM_HS||0,_customer_id:t._MM_CID,_part2_url:"http://s1.mmtrix.com/jm/v1/"+t._MM_CID+"/p.js",_part2_expire_minutes:60,_tp:t._MM_TP,_time_stamps:{},_fs_marks:[],_waiting_list:t._MM_WL&&t._MM_WL.split(",")||[],_mark:function(t){this._time_stamps[t]=+new Date},mark:function(t,e){var n,a=+e||+new Date,i=this._time_stamps,o=this._waiting_list,d=[];for((!i[t]||i[t]<a)&&(i[t]=a),n=o.length-1;n>=0;n--)o[n]!==t&&d.push(o[n]);d.length<o.length&&(this._waiting_list=d,this.goahead&&this.goahead())} },"test"===t.JSMON._customer_id&&(t.JSMON._part2_url="http://127.0.0.1:8080/p.js");var e=function(t,e){var n=!1,a=!0,i=t.document,o=i.documentElement,d=!!i.addEventListener,r=d?"addEventListener":"attachEvent",s=d?"removeEventListener":"detachEvent",_=d?"":"on",c=function(a){("readystatechange"!=a.type||/complete|interactive/.test(i.readyState))&&(a.type&&("load"==a.type?t:i)[s](_+a.type,c,!1),!n&&(n=!0)&&e.call(t,a.type||a))},l=function(){try{o.doScroll("left")}catch(t){return void setTimeout(l,50)}c("poll")};if("complete"==i.readyState)e.call(t,"lazy");else{if(!d&&o.doScroll){try{a=!t.frameElement}catch(m){}a&&l()}i[r](_+"DOMContentLoaded",c,!1),i[r](_+"readystatechange",c,!1),t[r](_+"load",c,!1)} };e(t,function(){window.JSMON&&window.JSMON._mark&&window.JSMON._mark("_dc2");var t,e,n,a,i,o=window,d=o.document,r=d.getElementsByTagName("img"),s=d.getElementsByTagName("IFRAME");for(i=function(){o.JSMON._fs_marks.push({img:this,time:+new Date}),this.removeEventListener?this.removeEventListener("load",i,!1):this.detachEvent&&this.detachEvent("IFRAME"===this.nodeName?"onload":"onreadystatechange",i)},t=0,e=r.length;e>t;t++)n=r[t],n.addEventListener?!n.complete&&n.addEventListener("load",i,!1):n.attachEvent&&n.attachEvent("onreadystatechange",function(){"complete"==n.readyState&&i.call(n)});for(t=0,e=s.length;e>t;t++)a=s[t],a.addEventListener?a.addEventListener("load",i,!1):a.attachEvent&&a.attachEvent("onload",function(){i.call(a)})});var n=function(){window.JSMON&&window.JSMON._mark&&window.JSMON._mark("_lt"),setTimeout(function(){var t,e=document.createElement("script"),n=window.JSMON;e.type="text/javascript",t=n._part2_url,e.src=t,document.getElementsByTagName("body")[0].appendChild(e)},0)};document.addEventListener?t.addEventListener("load",n,!1):t.attachEvent("onload",n)}(window); </script>
        <script type="text/javascript" src="http://tajs.qq.com/stats?sId=59009555" charset="UTF-8"></script>
    </body>
</html>