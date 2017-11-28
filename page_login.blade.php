<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset = "UTF-8">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script> <!-- jQuery -->

<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style>
    

    div.container {
        width: 100%;
        border: 1px solid gray;
    }

    header, footer {
        padding: 1em;
        color: white;
        background-color: black;
        clear: left;
        text-align: center;
    }

    nav {
        float: left;
        max-width: 160px;
        margin: 0;
        padding: 1em;
    }

    nav ul {
        list-style-type: none;
        padding: 0;
    }

    nav ul a {
        text-decoration: none;
    }

    nav ul button{
        text-decoration: none;
    }

    article {
        margin-left: 170px;
        border-left: 1px solid gray;
        padding: 32px;
        overflow: hidden;
    }
    
    
</style>
<script>
    function login() {
        var username = $("#username").val();
        var password = $("#password").val();
        var url = "/api/login?username=" + username + "&password=" + password;
        $.get(url, function(data, status){
        		console.log(data);
        		//var obj1 = JSON.parse(data);
        		
            if(data.err == 0){
                window.location.href="member";
            }
            else{	
                $("#login_error").show();
                hide_alert = window.setTimeout(showModal,5000);
   				$("#login_error").html(data['errmsg']);
                //console.log(data['errmsg']);
            }
        });
    }
    
        function showhide() {
            var bbs = document.getElementById('section2');
            if (bbs.style.display === 'none') {
                bbs.style.display = 'block';
            } else {
                bbs.style.display = 'none';
            }
        }

  function register(){ //TODO reviwe 2017-9-26
      var username_reg = $("#name_reg").val();
      var password_reg = $("#password_reg").val();
      var url1 = "/api/register?username="+username_reg+"&password="+ password_reg;
      	$.get(url1, function(data,status){
               //var obj2 = JSON.parse(data);
               if(data.err == 0){
                   alert('Registration successful，please login');//成功
               }else{
                   alert('registration fail');
               }
           })
      };

    function showModal(){
        $("#login_error").hide();
    	   	
    }
</script>
</head>

<body>



	<form class="form-horizontal">
		<div id="login">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">用户名:</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="username"
						placeholder="用户名">
				</div>
			</div>

			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">密码:</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password"
						placeholder="密码">
					<div class="alert alert-danger" role="alert" id="login_error" style="display:none; margin-top:10px"></div>
					<button type="button" class="btn btn-default" onclick="showhide()" style="float: right">显示/隐藏用户注册</button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label> <input type="checkbox"> 记住我
						</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-default" onclick="login()">登录</button>
				</div>
			</div>
		</div>
				
        
        	<div id="section2">
        		<hr>
        		<strong> </strong><br>
        		<div class="form-group">
        			<label for="inputEmail3" class="col-sm-2 control-label">用户注册: </label>
        			<div class="col-sm-10">
        				<input type='email' class="form-control" name='name_reg'
        					id='name_reg' maxlength="50" /> <br>
        			</div>
        		</div>
        
        		<div class="form-group">
        			<label for="inputEmail3" class="col-sm-2 control-label">密码:</label>
        			<div class="col-sm-10">
        				<input type='email' class="form-control" name='password_reg'
        					id='password_reg' maxlength='50' /> <br>
        			</div>
        		</div>
        
        		<div class="form-group">
        			<div class="col-sm-offset-2 col-sm-10">
        				<p id="register_error" style="color: red"></p>
        				<input type='button' value='提交' class="btn btn-default"
        					onclick="register()">
        			</div>
        		</div>
        	</div>

	</form>

	<!--  <label>用户登录</label><br>
    用户名:
      <input type="text" name="username" id="username"> <br> 
    密码  : 
    <input type="password" name="password" id="password"> <br>  
    <input type="button" value="登录" onclick="login()">  
    <p id="login_error"></p> 
    <button onclick="showhide()">显示/隐藏用户注册</button> 
	</div>
	<hr>  
	<div id="section2">
    <strong></strong><br>
    <label >用户注册: </label>
    <input type='text' name='name_reg' id='name_reg' maxlength="50"/> <br>
    <label >密码:</label>
    <input type='password' name='password_reg' id='password_reg' maxlength='50'/> <br>
    <p id="register_error" style="color:red"></p>
    <input type='button' value='提交' onclick="register()">
    
	</div> -->
	
</body>
</html>
