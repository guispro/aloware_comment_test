<?php

  namespace App\Services;

  use Illuminate\Support\Facades\DB;

  class GetCommentsServices {
    public function get() {
      $data = DB::select('select id, name, message, parent_id, level, has_reply from comments');
      $comments = $this->getComments($data, 0, []);
      return $comments;
    }
    
    private function getComments(array $data, int $level, array $comments, int $parent_id = 0) {
      
      foreach($data as $comment) {
        if($comment->level == $level && $comment->parent_id === $parent_id) {
            if($comment->has_reply) {
                $comment->comments = $this->getComments($data, $level+1, [], $comment->id);
            }else{
                $comment->comments = [];
            }
            array_push($comments, [
                'id' => $comment->id,
                'name' => $comment->name,
                'message' => $comment->message,
                'comments' => $comment->comments
            ]);
        }
      }
      return $comments;
    }
  }