<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json([
            'status' => 200,
            'students' => $students,
        ]);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json([
            'status' => 200,
            'student' => $student,
        ]);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => 'User Deleted Successfully',
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'course'=> 'required|max:191',
            'email'=> 'required|email|max:191',
            'phone'=> 'required|numeric|min:10|max:10',
        ]);

        if($validator->fails()){
            return response()->json([
                'validate_err' => $validator->messages(),
            ]);
        }
        else
        {
            $student = new Student;
            $student->name = $request->input('name');
            $student->course = $request->input('course');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->save();

            return response()->json([
                'status' => 200,
                'message' => 'User Added Successfully!',
            ]);
        }

        
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'course'=> 'required|max:191',
            'email'=> 'required|email|max:191',
            'phone'=> 'required|numeric|min:10',
        ]);

        $student = Student::find($id);
        if($student){
            $student->name = $request->input('name');
            $student->course = $request->input('course');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');

            if($validator->fails()){
                return response()->json([
                    'validate_err' => $validator->messages(),
                    'status' => 400,
                ]);
            }
            else
            {
                $student->update();

                return response()->json([
                'status' => 200,
                'message' => 'User Updated Successfully!',
                ]); 
            } 
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'User does not exist!',
            ]);
        }
    }
}
