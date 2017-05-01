<?php

class comment_class {
    
    private $comment_id;
    private $comment_text;
    private $comment_date;
    private $member_id;
    private $post_id;
    
    function __construct($comment_id, $comment_text, $comment_date, $member_id, $post_id) {
        $this->comment_id = $comment_id;
        $this->comment_text = $comment_text;
        $this->comment_date = $comment_date;
        $this->member_id = $member_id;
        $this->post_id = $post_id;
    }

    function getComment_id() {
        return $this->comment_id;
    }

    function getComment_text() {
        return $this->comment_text;
    }

    function getComment_date() {
        return $this->comment_date;
    }

    function getMember_id() {
        return $this->member_id;
    }

    function getPost_id() {
        return $this->post_id;
    }

    function setComment_id($comment_id) {
        $this->comment_id = $comment_id;
    }

    function setComment_text($comment_text) {
        $this->comment_text = $comment_text;
    }

    function setComment_date($comment_date) {
        $this->comment_date = $comment_date;
    }

    function setMember_id($member_id) {
        $this->member_id = $member_id;
    }

    function setPost_id($post_id) {
        $this->post_id = $post_id;
    }


}
