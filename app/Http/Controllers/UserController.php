<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //declare rules for authentication

    // priviledges for admin is set to 1
    private $priviledges = 1;

    public function rules()
    {
        return [
            'name' => 'required|max:45',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'age' => 'required|integer',
            'phone' => 'required|max:11',
        ];
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate user requests
        $rules = $this->rules();
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],400);
        }
        else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'age' => $request->age,
                'phone' => $request->phone,
                'priviledges' => $this->priviledges
            ]);

            $token = $user->createToken('myapp')->accessToken;

            return response()->json(['token' => $token,'user' => $user], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //show the Auth users profile
        // attached to the response headers must append the users token
        return response()->json(['user' => auth()->user()], 200);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // login the user
    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('myapp')->accessToken;
            return response()->json(['token' => $token,'user' => auth()->user()], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
