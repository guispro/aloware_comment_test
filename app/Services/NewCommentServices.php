<?php

  namespace App\Services;
  
  use Illuminate\Support\Facades\DB;

  class NewCommentServices {
    public function create(string $name, string $message) {
      $comments = [ $name, $message, 0, 0, false ];
      // DB::insert('insert into comments (name, message, parent_id, level, has_reply) values (?, ?, ?, ?, ?)', $comments);
      return DB::insert('insert into comments (name, message, parent_id, level, has_reply) values (?, ?, ?, ?, ?)', $comments);
    }
  }