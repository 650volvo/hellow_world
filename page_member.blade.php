<?php
        $id = session('userid', '');   //Original file, works fine!
?>
<!DOCTYPE html>
<html>
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
         <div id="record_list">
         </div>
         <div id="menu_list">
           <label>用户功能菜单: </label>
              <table>
                 <tr>
                     <td><p onclick="showthis()">添加留言</p></td>
                 </tr>
                 <tr>
                    <td>用户留言</td>
                 </tr>
                  <tr>
                    <td> <button>退出登录</button></td>
                  </tr>
                </table>
          </div>
                <nav>
                <div id="comment_list" style="top:100px;left:100px;right:100px;bottom:100px;background:white;
                            padding:20px;border:3px solid gray; display: none; position:fixed">
                    <p>添加内容</p>
                        标题:<input type="text" name="title" id="title"> <br>
                         <!-- 留言:<input type="text" name="name" id="inputname"> <br>    要取的值-->
                        留言:<br><textarea name="comment" rows="4" cols="25" id="comment"> </textarea><br>
                        添加上传文件<br><input type="file" name="file_upload" id="file_upload"><br>
                        <input type="hidden" name="time" id="time" value="" /><br>
                    <p id="record_error"></p>
                    <button onclick="hidethis()" id="hide_p1">隐藏</button>
                    <button onclick="add_comment()" >提交</button>
                </div>
                
                <div id="get_comment" style="top:100px;left:100px;right:100px;bottom:100px;background:white;
                			         padding:20px;border:3px solid gray; display: none; position:fixed">	
                			<button onclick="$('#get_comment').hide()">Hide</button>
                			
                			<div id="comment_content">
                			
                			</div>																			>
                </div>
                
                <div id="edit_comment" style="top:100px;left:100px;right:100px;bottom:100px;background:white;padding:20px;border:3px solid gray; display: none; position:fixed">
                    <p>编辑内容</p>
                        标题:<input type="text" name="title" id="input_edit_title"> <br>
                        留言:<br><textarea name="comment" rows="4" cols="25" id="input_edit_comment"> </textarea><br>
                        <input type="hidden" id="input_comment_id" /><br>
                    <p id="record_error"></p>
                    <button onclick="$('#edit_comment').hide()" id="hide_p1">隐藏</button>
                    <button onclick="edit_add_comment()" >提交</button> 
                    
                </div>
                </nav>
                <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
                
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
    			html += '<table>';
            html += '<div>' + "title:  "+ record.title + '</div>';       //   输出记录中 name 的值
            //html += '<tr id="' + record.title + '">'; 
            html += '<div>' + "comment:  "+ record.comment + '</div>';        //输出记录中 comment的值
            html += '<div>' + "entrytime: "+ record.entrytime + '</div>';             //输出记录中 entrytime的值
            html += '<div>' + "ID: "+ record.ID + '</div>';              //输出记录中 ID的值
            html += '<div>' + "userid: "+ record.userid + '</div>';  
            html += '<button onclick="delete_comment('+record.ID+')">delete</button>';	     //输出记录中 userid的值
            html += '<button onclick="edit_get_comment('+record.ID+')">Edit</button>';
            html += '<button onclick="get_comment('+record.ID+')">Display</button>'; 
            html += '<a href="/comment?id='+record_id+'">Record_id</a>';
            html += '</table>';
            html += '<br>';	
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
	
	$.get(url,function(json,status){
		if (json.err == 0){
			$("#input_edit_title").val(json.data.record.title);
			$("#input_edit_comment").val(json.data.record.comment);
			$("#input_comment_id").val(json.data.record.ID);
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
