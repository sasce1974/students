<?php

namespace App\Http\Controllers;

use App\Board;
use App\Grade;
use App\User;
use Illuminate\Http\Request;
use SimpleXMLElement;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $grades = $user->grades;
        //return view()
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
     * @param User $user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($id, Request $request)
    {
        $user = User::findOrFail($id);

        if($user->grades->count() === 4) return back()->with('error', 'Students can have maximum 4 grades');

        $request->validate([
            'grade'=>'numeric|required'
        ]);

        $user->grades()->create(['grade'=>$request->grade]);

        return back()->with('success', "Grade inserted");

    }

    public function export(Board $board){
        $users = $board->users;
        $data = array();

        for ($i=0; $i<count($users); $i++ ){
            $grades = $users[$i]->grades;
            $average = $grades->average('grade');
            $data[$i]['user']['id'] = $users[$i]->id;
            $data[$i]['user']['name'] = $users[$i]->name;
            $data[$i]['grades'] = $grades ?  $grades->toArray() : "";
            $data[$i]['average'] = $average;

            if($users[$i]->board->id === 1){
                $data[$i]['final result'] = ($grades->average('grade') < 7) ?
                    'Failed' : 'Passed';
            }else{
                $data[$i]['final result'] = ($grades->count() > 2 &&
                    $users[$i]->grades->max('grade') >= 8) ?
                    'Passed' : 'Failed';
            }

            if($users[$i]->board->id === 1){
                return json_encode($data);
            }else{
                return $this->arrayToXML($data);
            }

        }


    }


    private function arrayToXML(array $data){

        function array_to_xml( $data, &$xml_data ) {
            foreach( $data as $key => $value ) {
                if( is_array($value) ) {
                    if( is_numeric($key) ){
                        $key = 'item'.$key;
                    }
                    $subnode = $xml_data->addChild($key);
                    array_to_xml($value, $subnode);
                } else {
                    $xml_data->addChild("$key",htmlspecialchars("$value"));
                }
            }
        }

        $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

        array_to_xml($data,$xml_data);

        return $xml_data;

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($user_id, $id)
    {
        $user = User::findOrFail($user_id);

        $user->grades->where('id', $id)->first()->delete();

        return back()->with('success', 'Grade deleted');

    }
}
