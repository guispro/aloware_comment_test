<?php

  namespace App\Services;

  use Illuminate\Support\Facades\DB;

  class UpdateCommentServices {
    public function updateComment(int $id, string $message) {
      $comment = $this->getComment($id);
      if(!$comment) {
        throw new \Exception("Error Processing Request", 404);
      }
      if($comment->message !== $message) {
        DB::update('update comments set message = ? where id = ?', [$message, $id]);
      }
      return true;
    }

    private function getComment(int $id) {
      $data = DB::select('select id, name, message, parent_id, level, has_reply from comments where id = ?', [$id]);
      if(count($data) > 0) {
        return $data[0];
      }
      return false;
    }
  }