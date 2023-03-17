<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Note;
class NotesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
    //Add new note 
    
    //Show notes

    public function show_notes(Request $request){

        //###### auth user logout function start
        $Authorization = $request->header('Authorization');
        if (!$Authorization) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $noter = User::where('Authorization', $Authorization)->first();
        if (!$noter) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        //###### auth logout function end
       
       
       $details = DB::table('notes')
       ->join('users', 'notes.user_id', '=', 'users.user_id')
       ->select('notes.id','users.first_name','users.last_name','notes.title','notes.importance','notes.content')
       ->get();
       $notes= [];
       foreach ($details as $data) {
           $notes[] = [
               'id'=>$data->id,
               'first_name'=>$data->first_name,
               'last_name'=>$data->last_name,
               'title'=>$data->title,
               'importance'=>$data->importance,
               'content'=>$data->content,
               // add more fields as needed
           ];
            }
            //return $notes;
            return response()->json([
               'My notes' => $notes
           ]); 
   }//done with test ddd 

   //##################
   
   //Add new note 
   
   public function add_notes(Request $request)
   {
        //###### auth user logout function start
        $Authorization = $request->header('Authorization');
        if (!$Authorization) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $noter =  User::where('Authorization', $Authorization)->first();
        
        if (!$noter) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        //###### auth logout function end

       $request->validate([
           'title' => 'required',
           'importance' => 'required',
           'content' => 'required',
       ]);
       $user_id = $noter->user_id;
       $data = new Note([
           'user_id'=> $user_id,
           'title'=> $request->title,
           'importance'=>$request->importance,
           'content'=> $request->content,
                       
       ]);
       
       $data->save();

       //return redirect()->back();
      return response()->json([
               'Note added successfuly'
           ]); 
   } //done with test ddd 
   
   
   //################

   //Edit Delete N Notes
   
   public function update_notes(Request $request){

       //###### auth user logout function start
       $Authorization = $request->header('Authorization');
       if (!$Authorization) {
           return response()->json(['error' => 'Unauthorized'], 401);
       }
       $noter =  User::where('Authorization', $Authorization)->first();
       
       if (!$noter) {
           return response()->json(['error' => 'Invalid token'], 401);
       }
       //###### auth logout function end
       $update_data = array();
       
       if ($request->filled('title')) {
           $update_data['title'] = $request->title;
       }
       if ($request->filled('importance')) {
           $update_data['importance'] = $request->importance;
       }
       if ($request->filled('content')) {
           $update_data['content'] = $request->content;
       }
  
       DB::table('notes')->where('id', $request->id)->update($update_data);
       return response()->json([
           'Note edited successfuly'
       ]);
  
   }

   public function delete_notes(Request $request){

        //###### auth user logout function start
        $Authorization = $request->header('Authorization');
        if (!$Authorization) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $noter =  User::where('Authorization', $Authorization)->first();
        
        if (!$noter) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        //###### auth logout function end

       DB::table('notes')->where('id',$request->id)->delete();
       //DB::table('notes')->truncate();
       return response()->json([
           'Note deleted successfuly'
       ]); 
   }//done with test ddd  

   //####################
   //****************************** */

}
