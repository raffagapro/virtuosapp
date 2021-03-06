<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadImagesController;
use App\Models\Chat;
use App\Models\Homework;
use App\Models\Role;
use App\Models\StudentHomework;
use App\Models\User;
use App\Services\PurgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends UploadImagesController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sa.index');
    }

    public function testIndex()
    {
        return view('sa.test');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function testUpload(Request $request)
    {
        $validated = $request->validate([
            'testfile'=>'required|mimes:jpeg,png,pdf,doc,ppt,pptx,xlx,xlsx,docx,zip|max:4000',
        ]);
        $params = [
            "testfile" => "",
            "homeworkId" => $request->homeworkId,
        ];
        $params = $this->uploadHWFile($request, $params, "tHomework", "testfile");
        $url = Storage::disk('s3')->url($params["testfile"]);
        // dd($url);
        return back()->with(compact('url'));
    }
    public function delImage(){
        // Storage::disk('s3')->delete('tHomework/El_Post_De_Test_IIHAgosto2021_-_29_Aug.pdf');
        Storage::disk('s3')->delete(parse_url('https://virtuousapp.s3.us-east-2.amazonaws.com/tHomework/El_Post_De_Test_camiplant.JPEG'));
        $url = 'https://virtuousapp.s3.us-east-2.amazonaws.com/tHomework/El_Post_De_Test_camiplant.JPEG';
        return back()->with(compact('url'));
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
        //
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newRole(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nombre' => 'required|max:255',
        ]);
        Role::create([
            'name' => $request->nombre,
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'modNombre' => 'required|max:255',
        ]);
        $role = Role::findOrFail($id);
        // dd($role, $request->modNombre);
        $role->name = $request->modNombre;
        $role->save();
        return back();
        
    }

    public function roleGrabber(Request $request){
        $role = Role::findOrFail($request->roleId);
        return $role;
    }

    /**
     * Update the specified resource in storage.
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
    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return back();
    }

    public function purgeChats()
    {
        $chats = Chat::all();
        foreach ($chats as $c) {
            $user1 = User::where('id', $c->user1)->first();
            $user2 = User::where('id', $c->user2)->first();
            if (!$user1 || !$user2) {
                foreach ($c->chatMessages() as $cm) {
                    $cm->delete();
                }
                $c->delete();
            }
        }
        $status = 'Los chats han sido purgados.';
        return back()->with(compact('status'));
    }

    public function purgeHomeworks()
    {
        $homeworks = Homework::all();
        foreach ($homeworks as $hw) {
            if ($hw->student > 0) {
                $student = User::where('id', $hw->student)->first();
                if (!$student) {
                    $purge = new PurgeService();
                    $purge->purgeIndvHomework($hw);
                }
            }
        }
        $status = 'Las tareas han sido han sido purgadas.';
        return back()->with(compact('status'));
    }
}
