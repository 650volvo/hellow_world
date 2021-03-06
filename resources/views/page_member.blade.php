<?php
        $id = session('userid', '');  //testing the new format
?>
<!DOCTYPE html>
<html>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script
	src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"
	integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
	crossorigin="anonymous"></script>
<link rel="stylesheet"
	href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
	crossorigin="anonymous">
<link rel="stylesheet"
	href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
	crossorigin="anonymous">
	
    <style>
        div.comment_list {     
            width: 100%;
            border: 1px solid gray;
        }
        nav {
            float: left;
            max-width: 160px;
            margin: 0;
            padding: 1em;
        }
    </style>
    <body>
	<div class="row">
		
		<div id="menu_list" class="col-md-2">
			<label>用户功能菜单: </label>
			<table class="table" >
				<tr>
					<td><p onclick="showthis()">添加留言</p></td>
				</tr>
				<tr>
					<td>用户留言</td>
				</tr>
				<tr>
					<td>
						<button>退出登录</button>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="record_list" class="col-md-6 table-responsive"></div>
		
	</div>
		<nav>
			<div id="comment_list"
				style="top: 100px; left: 100px; right: 100px; bottom: 100px; background: white; padding: 20px; border: 3px solid gray; display: none; position: fixed">
				<p>添加内容</p>
				标题:<input type="text" name="title" id="title"> <br>
				<!-- 留言:<input type="text" name="name" id="inputname"> <br>    要取的值-->
				留言:<br>
				<textarea name="comment" rows="4" cols="25" id="comment"> </textarea>
				<br> 添加上传文件<br>
				<input type="file" name="file_upload" id="file_upload"><br> <input
					type="hidden" name="time" id="time" value="" /><br>
				<p id="record_error"></p>
				<button onclick="hidethis()" id="hide_p1">隐藏</button>
				<button onclick="add_comment()">提交</button>
			</div>

			<div id="get_comment"
				style="top: 100px; left: 100px; right: 100px; bottom: 100px; background: white; padding: 20px; border: 3px solid gray; display: none; position: fixed">
				<button onclick="$('#get_comment').hide()">Hide</button>

				<div id="comment_content"></div>
			</div>

			<div id="edit_comment"
				style="top: 100px; left: 100px; right: 100px; bottom: 100px; background: white; padding: 20px; border: 3px solid gray; display: none; position: fixed">
				<p>编辑内容</p>
				标题:<input type="text" name="title" id="input_edit_title"> <br> 留言:<br>
				<textarea name="comment" rows="4" cols="25" id="input_edit_comment"> </textarea>
				<br> <input type="hidden" id="input_comment_id" /><br>
				<p id="record_error"></p>
				<button onclick="$('#edit_comment').hide()" id="hide_p1">隐藏</button>
				<button onclick="edit_add_comment()">提交</button>

			</div>
		</nav>
		

		<script>		
function record_list(){    							//定义添加留言函数
    var url = "/api/recordlist";  						//建立接口
    $.getJSON(url,function(json,status){			
       if(json.err == 0){                         			//obj3没有错误提示
        														//console.log(obj3["data"]["records"]);//打印出obj3中data 下的 records
        var html = "";         					 			//设定一个空变量 定义名称html
        for (var i = 0; i < json.data.records.length; i++){   // 设定循环条件，当i 值小于记录长度时，遍历
            var record = json.data.records[i];     			 // 定义 record 值是 对象的值.
            var record_id = json.data.records[i].ID;
            // html += '<div class=table-bordered>'; 
            html += '<table class="table table-bordered">'; //
            html += '<tr id="tr_'+record.ID+'>';
            html += 	'<td>Title:</td><td class="title">' + record.title + '</td>';			//Need to keep working on 2017-11-10 5:59
            html += '</tr>';
            html += '<tr >';
            html += '<td>Comment:</td> <td class="comment">'+ record.comment + '</td>';  
            html += '</tr>'; 
            html += '<tr>';
            html += '<td>Entrytime:</td><td class="entrytime">' +  record.entrytime + '</td>';   
            html += '</tr>';        											   //输出记录中 entrytime的值
            html += '<tr>';
            html += '<td>ID:</td><td class="ID">' + record.ID + '</td>';
            html += '</tr>';	 
            
            //html += '</div>'; 
        
            // html += '<div>' + "ID: "+ record.ID + '</div>';             		 //输出记录中 ID的值
            //html += '<div>' + "userid: "+ record.userid + '</div>';  
            html += '<tr>';
            html += '<td>';
            html += '<button onclick="delete_comment('+record.ID+')">delete</button>';	   
            html += '</td>';
            html += '<td>';
            html += '<button onclick="edit_get_comment('+record.ID+')">Edit</button>';
            html += '</td>';
            html += '<td>';
            html += '<button onclick="get_comment('+record.ID+')">Display</button>'; 
            html += '</td>';
            html += '<td>';
            html += '<a href="/comment?id='+record_id+'">Record_id</a>';
            html += '</td>';
            html += '</tr>';
            html += '<\n>';	
            html += '</table>';
        }   
        $("#record_list").html(html);		//将元素 record_list 的值改为遍历后的数据表的值
        }else{
        $("#record_error").html(json.errmsg);		// 显示错误信息 errmsg
        }
    	});
}
record_list();



function add_comment(){   			 // 定义添加留言函数    //TODO reviwe 2017-9-26
	var title = $("#title").val();
    var comment = $("#comment").val();
    var url = "/api/add_comment?title="+encodeURIComponent(title)+"&comment="+encodeURIComponent(comment);  // 创建添加留言函数端口
    	$.get(url,function(json,status){
        	if (json.err == 0){	
              alert('添加成功');	
          }else{ 
              alert('添加失败'+json.errmsg);	
              if(json.err == 3){ 
					window.location.href="login";	
          	  }
          }
       });
}

function edit_add_comment(){
	var edit_title = $("#input_edit_title").val();
	var edit_comment = $("#input_edit_comment").val();
	var edit_ID = $("#input_comment_id").val();
	var url = "/api/edit_add_comment?edit_title="+encodeURIComponent(edit_title) +
		"&edit_comment="+encodeURIComponent(edit_comment)+"&edit_id="+encodeURIComponent(edit_ID);
	
	$.get(url,function(json,status){
		if (json.err == 0){
			alert('更新成功');
		}else{
			alert('更新失败'+json.errmsg);
		}
	});
}

function delete_comment(id){
 	var url = "/api/delete_comment?oo="+encodeURIComponent(id);
 	$.get(url,function(json,status){
 	 	if (json.err == 0){
 	 	 		alert('删除成功');
 	 	}else{
 	 	 	alert('删除失败'+json.errmsg);
 	 	 	if(json.err == 3){
 	 	 	 	window.location.href = "member";
 	 	 	}
 	 	}
});
}

function get_comment(id){
	$('#comment_content').load('/comment?id='+id);
	$('#get_comment').show();
}

function edit_get_comment(id){
	$("#edit_comment").show();
	var url = "/api/get_comment?id="+encodeURIComponent(id);
	var title = $("#title").val();
    var comment = $("#comment").val();
	
	$.get(url,function(json,status){
		if (json.err == 0){
			$('#tr_'+id+'.title').html(title);
			$('#tr_'+id+'.comment').html(comment);
		
		}else{
			alert('编辑失败');
		}
	});
}

function showthis(){   // 定义函数showthis
   	$('#comment_list').show();
}

function hidethis(){ //定义函数 hidethis
  	$('#comment_list').hide();
}        
    </script>
</body>

    </html>
<?
?>