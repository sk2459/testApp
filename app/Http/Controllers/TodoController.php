<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;  // 追記
use Auth;    //追記

class TodoController extends Controller
{
    // ここから追記
    private $todo;  //要は、Todoクラスをインスタンス化したものが入っている

    public function __construct(Todo $instanceClass)  //要は、Todoクラスをインスタンス化したものが入っている
    {
        $this->middleware('auth');    //警備員的なやつ。sessionをみて、ログインしとるかしてないか見とる。
        $this->todo = $instanceClass;
    }
    // ここまで追記

    /**
     * Display a listing of the resource.
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo->getByUserId(Auth::id());
        // $todos = $this->todo->all();  // 追記
        // dd($todos);
        // var_dump($todos);
        // exit;
        // dd(['index' => 1]);
        // dd(compact('todos'));
        // dd(view('todo.index', compact('todos')));
        return view('todo.index', compact('todos'));  // 編集　view 表示させたいbladeファイルの名前  viewの返り値はviewインスタンス
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('todo.create');  // 追記
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)   //メそッどインジェクションとは、インスタンス化するララベルの機能
    {
        // var_dump($request);
        $input = $request->all();  //allメソッド　formから送られてきた値(postで送られてきたもの)が取得できるメソッド
        $input['user_id'] = Auth::id();  
        // dd($input);
        $this->todo->fill($input)->save();  //fillメソッドの返り値は、todoインスタンス。 
        // dd(fill($this->todo->fill($input)->save());
        // dd(redirect()->to('todo'));
        // dd(redirect());
        // dd($this->todo->fill($input));
        return redirect()->to('todo');  //redirectの帰り血は、Redirectorインスタンス     toの返り値は、RedirectResponseインスタンス　
    }

    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $todo = $this->todo->find($id);  // 追記   //$idのレコードを全部持ってきて、modelオブジェクト(todoインスタンス)の形で返している。
        // dd($todo);
        // exit;
        return view('todo.edit', compact('todo'));  // 追記   //viewはcontrollerやwebのディレクトリで、第一引数に入れたURLのページにとべる。（ドメイン無視）
    }                                                        //compactは変数を１つ受け渡す時に使う関数。連想配列の形にしている。

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        // dd($input);
        $this->todo->find($id)->fill($input)->save();
        // dd( $this->todo->find($id)->fill($input)->save());
        // dd($this->todo->find($id));
        return redirect()->to('todo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->todo->find($id)->delete();

        return redirect()->to('todo');
    }
}
