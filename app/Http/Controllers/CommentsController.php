<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewCommentServices;
use App\Services\GetCommentsServices;
use App\Services\ReplyCommentServices;
use App\Services\DeleteCommentServices;
use App\Services\UpdateCommentServices;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function index()
    {
        try {
            $comments = (new GetCommentsServices)->get();
            return response()->json([
                'status' => 200,
                'data' => $comments
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'status' => $th->getCode(),
                'error' => $th->getMessage()
            ]);
        }
    }

    public function new(Request $request)
    {
        
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'message' => 'required'
            ]);
     
            if ($validator->fails()) {
                throw new \Exception('Missing arguments', 1);
                
            }
            $response = (new NewCommentServices)->create($request->name, $request->message);
            return response()->json([
                'created' => true,
                'response' => $response,
                'status' => 200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getCode(),
                'error' => $th->getMessage()
            ]);
        }
    }

    public function reply(Request $request, int $id) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'message' => 'required'
            ]);
     
            if ($validator->fails()) {
                throw new \Exception('Missing arguments', 1);
            }
            $response = (new ReplyCommentServices)->reply($id, $request->name, $request->message, $id);
            return response()->json([
                'created' => true,
                'response' => $response,
                'status' => 200,
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'status' => $th->getCode(),
                'error' => $th->getMessage()
            ]);
        }   
    }

    public function update(Request $request, int $id) {
        try {
            $response = (new UpdateCommentServices)->updateComment($id, $request->message);
            return response()->json([
                'updated' => 'OK',
                'response' => $response,
                'status' => 200,
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'status' => $th->getCode(),
                'error' => $th->getMessage()
            ]);
        }
    }

    public function delete(int $id) {
        try {
            $response = (new DeleteCommentServices)->deleteComment($id);
            return response()->json([
                'deleted' => 'OK',
                'response' => $response,
                'status' => 200,
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'status' => $th->getCode(),
                'error' => $th->getMessage()
            ]);
        }
    }
}
