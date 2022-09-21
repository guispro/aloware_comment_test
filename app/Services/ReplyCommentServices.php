<?php

  namespace App\Services;

  use Illuminate\Support\Facades\DB;

  class ReplyCommentServices {
    public function reply(int $id, string $name, string $message) {
      $parent = $this->getComment($id);
      if(!$parent) {
          throw new \Exception("Error Processing Request", 404);
      }

      if(!$this->setReplyTrue($parent->id)) {
          throw new \Exception("Error Processing Request", 500);
      }

      $comment = [
          $name,
          $message,
          ($parent->level < 2 )? $parent->id: $parent->parent_id,
          ($parent->level < 2 )? $parent->level + 1: 2,
          false,
      ];
      
      return DB::insert('insert into comments (name, message, parent_id, level, has_reply) values (?, ?, ?, ?, ?)', $comment);
    }

    private function getComment(int $id) {
      $data = DB::select('select id, name, message, parent_id, level, has_reply from comments where id = ?', [$id]);
      if(count($data) > 0) {
        return $data[0];
      }
      return false;
    }

    private function setReplyTrue(int $id) {
      if($id > 0) {
        DB::update('update comments set has_reply = ? where id = ?', [true, $id]);
        return true;
      }
      return false;
    }
  }