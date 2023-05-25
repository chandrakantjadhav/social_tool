<?php

namespace App\Http\Controllers;

use App\Models\User;
use File;
use Image;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getUserByUsername($id)
    {
        return User::with('profile')->whereid($id)->firstOrFail();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd('inside');
        $posts = auth()->user()->posts;
        return view('back.profile', compact('posts'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.posts.create');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        // dd($request);
        if($request->has('image')){
            $this->uploadImage($request);
        }
        $request->user()->posts()->create($request->post());

        return redirect()->route('posts.index')->with('message', 'Post created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        try {
            $userData = $this->getUserByUsername($id);
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
        $user = ['user' => $userData , 'response_msg'=> $request->input('response_msg') ];
        return view('back.profile')->with($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('back.posts.edit', compact('post'));
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
        
        // dd($id);
        // $currentUser = \Auth::user();
        $user = User::findOrFail($id);
        // $user = $this->getUserByUsername($user->email);
        $input = $request->only('name', 'contact_number', 'biography', 'personal_interest','avatar' ,'avatar_status');
        
        $rules = [];
        $fullnameRules = $numberRules = $additionalRules = array();


        if ($request->has('name')){
            if($user->name !== $request->input('name')){
                $fullnameRules = [
                    'name' => 'required|max:55',
                ];
            }
        }


        if ($request->has('contact_number')) {
            if ($user->contact_number !== $request->input('contact_number')) {
                    $numberRules = [
                        'contact_number' => 'required|string|min:8|max:11',
                    ];
            }
        }

        if(($request->has('personal_interest')) or ($request->has('biography') )){
            $additionalRules = [
                'biography' => 'nullable|string|max:255',
                'personal_interest'  => 'nullable|string|max:255',
            ];
        }

        $rules = array_merge($fullnameRules, $numberRules, $additionalRules);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // sanitize input to prevent sql injection 
        $user->name = ($request->has('name')) ? strip_tags($request->input('name')) :  $user->name ;
        $user->biography = ($request->has('biography')) ? strip_tags($request->input('biography')) :  $user->biography ;
        $user->personal_interest = ($request->has('personal_interest')) ? strip_tags($request->input('personal_interest')) :  $user->personal_interest ;
        $user->contact_number = ($request->has('contact_number')) ? strip_tags($request->input('contact_number')) :  $user->contact_number ;
        $user->avatar_status = ($request->has('avatar_status')) ? strip_tags($request->input('avatar_status')) :  $user->avatar_status ;
        $user->save();
        return redirect('profile/'.$user->id)->with('success', trans('profile.updateAccountSuccess'));
        // return back()->with('message', 'Post updated successfully');
    }

    public function updateAvatar(Request $request, User $user)
    {
        // the update method, only fire its events when the update happens directly on the model,
        // so we will use save directly on modal instead of mass assignment
        if ($request->hasFile('file')) {
            $currentUser = \Auth::user();
            $avatar = $request->file('file');
            $filename = 'avatar.'.$avatar->getClientOriginalExtension();
            $save_path = public_path('images').'/profile/'.$currentUser->id.'/avatar/';
            $path = $save_path.$filename;
            $public_path = '/images/profile/'.$currentUser->id.'/avatar/'.$filename;

            // Make the user a folder and set permissions
            File::makeDirectory($save_path, $mode = 0755, true, true);

            // Save the file to the server
            Image::make($avatar)->resize(80, 80)->save($save_path.$filename);

            // Save the public image path
            $currentUser->avatar = $public_path;
            $currentUser->avatar_status = 1;
            $currentUser->save();

            return response()->json(['path' => $path], 200);
        } else {
            return response()->json(false, 200);
        }
    }


     public function userProfileAvatar($id, $image)
    {
        return Image::make(public_path('images').'/profile/'.$id.'/avatar/'.$image)->response();
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return back();
    }

    public function uploadImage($request){
        $image = $request->file('image');
        $imageName = time().$image->getClientOriginalName();
        // add the new file 
        $image->move(public_path('images'),$imageName);
        $request->merge(['image' => $imageName]);
        // dd($request);
    }



    public function updateUserPassword(Request $request, $id)
    {
        // dd($id);
        $currentUser = \Auth::user();
        $user = User::findOrFail($id);
        $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';
        // dd($id);
        $newPass = Hash::make($request->input('password'));
        if ($request->has('password') && $request->has('password_confirmation') ){
            if($newPass !== $user->password){
                $validator = Validator::make($request->all(), [
                    'password' => ['required', 'regex:'.$pattern],
                ]);
            }else{
                return redirect('profile/'.$user->id)->with('response_msg', 'Password does not match with requirement');
            }
        }
        
      
        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->withErrors($validator)->withInput();
        }
        
        $user->password = $newPass;
        $user->save();

        return redirect('profile/'.$user->id)->with('response_msg', trans('profile.updatePWSuccess'));
    }
}
