PJ 2 说明文档
==========
[TOC]

### 个人信息
*****
姓名：朱亦文<br>
学号：19302010075

[我的GitHub地址](https://github.com/Elaine1908/)


### 项目完成情况
****

#### 0.前后端交互
为了更好地实现前后端交互，提高代码可读性与功能性，本项目在大部分页面上实现了前后端代码分离。
引入jquery，通过ajax前后端发送与接收消息。

#### 1.页面制作
**·Home**

1.首页展示的轮播图是从数据库中**随机挑选**展示的；下面的六张图通过showFav.php获取收藏数最多的六张图。
>具体sql："SELECT ImageID, Count(travelimagefavor.UID) AS NumFavor, PATH, Title, Description  
 FROM travelimage JOIN travelimagefavor ON travelimagefavor.ImageID=travelimage.ImageID
 GROUP BY travelimagefavor.ImageID 
 ORDER BY NumFavor DESC";
>其中DESC为降序排列，JOIN实现两张表格合并
  
  
2.刷新功能：引入jquery，在header部分插入如下代码

        $(document).ready(function(){
            $("#refresh").click(function(){
                document.getElementById("collection").innerHTML='';
                $("#collection").load("refresh.php",function(responseTxt,statusTxt,xhr){
                    if(statusTxt=="success")
                        alert("refreshed!");
                    if(statusTxt=="error")
                        alert("Error: "+xhr.status+": "+xhr.statusText);
                });
            });
        });
  
  点击按钮，触发事件，从refresh.php中拉取数据后返回至html中
  >本页的收藏图展示，后面的search页面搜索/myfavorite展示等均通过这种方式实现


3.导航栏：在myAccount.php中通过`isset($_COOKIE['username'])`判断登陆情况正确展示/隐藏下拉菜单，html头部ajax引入
>所有页面的导航栏均由这种方法实现


**·Browser**

1.实现5种不同筛选方式。其中热门部分择取数据库中出现次数最多的几个城市/国家/内容，将对应数据加入超链接的url中，使用get方法即可获取相应的名值对。

2.二级联动：从数据库中拉取所有的国家，再由js数组进行联动显示

3.实现分页


**·Search**

1.本页面使用了jQuery EasyUI（一个基于 jQuery 的框架）完成搜索表单提交页面局部刷新的功能

2.搜索结果中与输入相匹配的文字段会有高亮提示


**·Details**

1.正确显示图片收藏数、名称、描述等基本信息；若描述/名称为空，则为unknown

2.用户未登录点击收藏，则会有登陆提示，跳转至login界面


**·My photos & My favorites**

可正确删除/修改图片；若无图片展示，则有相应提示


**·Upload**

用户未填充表单时发出提示并转回原界面，提交成功后，跳转至myPhotos


**·Log in & Sign up**

1.注册：用户名以字母开头，由5-20位数字/下划线/字母/.组成；弱密码定义为0-6位数字或字母。

2.由于用户可使用邮箱/用户名两种方式登录，因此在其他地方的php中增加了一条正则表达式判断cookie，以确认登陆方式
，从而正确获取uid
  
  
#### 2.困难
1.php正则表达式 报错：preg_match(): No ending delimiter '^' found

解决方法：在正则首末加上“/”

2.页面跳转时cookie失效：cookie存在路径问题，可以访问同级/下级目录，但不可访问上级

3.sql语句中的单引号 `UserName = '$_COOKIE[username]'`害人不浅
  
  
#### 3.Bonus
**·框架**

在SEARCH页面中，我使用了jQuery EasyUI完成表单搜索功能，
easyui是一个基于jQuery的框架，它提供了建立现代化的具有交互性的 javascript 应用的必要的功能，
使用起来较为方便。


#### 4.建议

助教们辛苦了！


