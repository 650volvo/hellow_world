<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public function welcome()
	{
	    return view('welcome');
	}
	public function test_function() {
	    
	    $test1 = "mercedes";
	    //dd ($test1);
	    Log::debug('test');
	    
	    return Response::json(['err'=>1, 'errmsg'=>"eeef"]);
	    
	    //$users = DB::table('commentboard')->select('entrytime', 'ID')->get();
	    //print_r ($users);
	}
	
	public function page_login(){
	    return view('page_login');
	}
	
	public function page_member(){
	       $userid = Session::get('userid', 1);
	       echo $userid;
	       if(empty($userid)){
	           //exit ('not logged in');
	       }
	    return view('page_member');
	}
	
	public function login(){
        $username = Request::input('username');
        $password = Request::input('password');
        if(empty($username) || empty($password)){
            $errmsg5 = ['err'=>2, 'errmsg'=>'用户名或密码是空=null!!'];
            Return Response::json($errmsg5);
        }
            $data = DB::select("select * from login where username ='$username'");
            if (empty($data)){
                $ret= ['err'=>1, 'errmsg'=>'用户名未找到1'];
            }else{
                $row = $data[0];
                if ($row->password == $password){
                    $ret = ['err'=>0, 'errmsg'=>'success'];
                    session(['userid'=>$row->userid]);
                    session(['username'=>$row->username]);
                    Session::put('userid',$row->userid);
                }else{
                    $ret = ['err'=>1, 'errmsg'=>'密码错误'];
                }
            }
            return Response::json($ret);
	   }
	
	public function register(){
	    $username_reg = Request::input('username_reg');
	    $password_reg = Request::input('password_reg');
	    echo $username_reg;
	    $data = DB::select("select * from login where username ='$username_reg'");
	    $ret = ['err'=>1,'errmsg'=>'unknown'];
	    if(!empty($data)){ //$data 值是 true or false
	        $data2 = DB::table('login')->insert(['username'=>$username_reg,'password'=>$password_reg]);
	        if($data2){
	            $ret = ['err'=>0,'errmsg'=>'Success'];    
	        }else{
	            $ret = ['err'=>1,'errmsg'=>'注册失败'];
	        }
	    }else{
	        $ret = ['err'=>1,'errmsg'=>'Username already exist'];
	    }
	    return Response::json($ret);
	}
	
	public function recordlist(){
	    $session_1 = Session::get('userid',1);   //开始session
	    if(empty($session_1)){                            //判断userid是否被设定
	        return ['err'=>1, 'errmsg'=>'用户没登陆_not logged in'];      //返回错误信息
	    }
	    //var_dump($session_1);
	    $data = DB::table('commentboard')->where('userid',$session_1)->get();
	    $records = [];             //定义一个空数组
	    $ret = ['err'=>0, 'data'=>['records'=>$data]];
	    return $ret;
	}
	
	public function add_comment(){              //not finished 10-30
	    $title = Request::input('title','');
	    $comment = Request::input('comment','');
	    $userid_add = Session::get('userid', 0);
	    $name1 = Session::get('username','');
	    $time2 = date("Y-m-d H:i:s");
	    
	    $data = DB::table('commentboard')->insert(['title'=>$title,'comment'=>$comment,
	           'userid'=>$userid_add,'name'=>$name1,'entrytime'=>$time2,'file_upload'=>'']);
	    
	    if(!empty($data)){
	        $ret = ['err'=>0, 'errmsg'=>'success'];  //返回 true 提示成功
	        //$ret['log']['insert_id'] = $data;
	    }else{
	        $ret = ['err'=>1, 'errmsg'=>'unable to insert into Mysql'];  // 返回false 提示失败
	    }
	        return $ret;  //输出提示值
	}
	
	public function edit_add_comment(){    //Nov-8 edit button selection
        	$userid_edit_add_comment = Session::get('userid',1);
        	if(empty($userid_edit_add_comment)){
        	    exit(json_encode(['err'=>3, 'errmsg'=>"user doesn't exist"]));
        	}
        	$title1 = Request::input('edit_title');
        	$comment1 = Request::input('edit_comment');
        	$ID1 = Request::input('edit_ID');
        	$ret = [];
        	
        	try{
        	$data = DB::table('commentboard')->where('userid',$userid_edit_add_comment)->
        	       update(['title'=>$title1,'comment'=>$comment1]);  //session现在存不上。
        	}catch(\Exception $e){
        	    echo 'db error:'.$e->getMessage();
        	}
        	
        echo $title1."<br/>";
        echo $comment1."<br/>";
        echo $userid_edit_add_comment;
        	if ($data){     
        	    $ret['err'] = 0;     
        	}else{
        	    $ret['err'] = 1;     
        	}
        	return Response::json($ret);
	}
	
	public function get_comment(){
	    $id = Request::input('id');
	    if(empty($id)){
	        return ['err'=>1,'errmsg'=>'record doesnt exist'];
	    }
	    $data_1 = DB::table('commentboard')->where('ID',$id)->first();
	    if($data_1){
	        $ret = ['err'=>0, 'data'=>['record'=>$data_1]];
	        return view('page_comment',['record'=>$data_1]);
	    }else{
	        return Response::json(['err'=>1, 'errmsg'=>'找不到文章']);
	    }
	}
	
	public function api_get_comment(){
	    $id = Request::input('id');
	    if(empty($id)){
	        return ['err'=>1,'errmsg'=>'record doesnt exist'];
	    }
	    //$userid4 = Session::get['userid'];
	    $data_1 = DB::table('commentboard')->where('ID',$id)->first();
	    if($data_1){
	        $ret = ['err'=>0, 'data'=>['record'=>$data_1]];
	        
	        return Response::json($ret);
	    }else{
	        return Response::json(['err'=>1, 'errmsg'=>'找不到文章']);
	    }
	}
	
}