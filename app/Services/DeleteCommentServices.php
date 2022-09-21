<?php
 
  namespace App\Services;

  use Illuminate\Support\Facades\DB;

  class DeleteCommentServices {
    public function deleteComment(int $id) {
      $comment = $this->getComment($id);
      if(!$comment) {
        throw new \Exception("Error Processing Request", 404);
      }
      if($comment->has_reply) {
        throw new \Exception("Error Processing Request", 500);
      }
      if(!$this->setReplyFalse($comment->parent_id)) {
        throw new \Exception("Error Processing Request", 500);
      }
      DB::delete('delete from comments where id = ?', [$id]);
      return true;
    }

    private function getComment(int $id) {
      $data = DB::select('select id, name, message, parent_id, level, has_reply from comments where id = ?', [$id]);
      if(count($data) > 0) {
        return $data[0];
      }
      return false;
    }

    private function setReplyFalse(int $id) {
      if($id > 0) {
        DB::update('update comments set has_reply = ? where id = ?', [false, $id]);
        return true;
      }
      return false;
    }
  }