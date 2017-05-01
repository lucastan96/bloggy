<?php

class post_class {

    private $post_id;
    private $post_title;
    private $post_content;
    private $post_image;
    private $post_date;
    private $post_tags;
    private $member_id;
    
    function __construct($post_id, $post_title, $post_content, $post_image, $post_date, $post_tags, $member_id) {
        $this->post_id = $post_id;
        $this->post_title = $post_title;
        $this->post_content = $post_content;
        $this->post_image = $post_image;
        $this->post_date = $post_date;
        $this->post_tags = $post_tags;
        $this->member_id = $member_id;
    }

    function getPost_id() {
        return $this->post_id;
    }

    function getPost_title() {
        return $this->post_title;
    }

    function getPost_content() {
        return $this->post_content;
    }

    function getPost_image() {
        return $this->post_image;
    }

    function getPost_date() {
        return $this->post_date;
    }

    function getPost_tags() {
        return $this->post_tags;
    }

    function getMember_id() {
        return $this->member_id;
    }

    function setPost_id($post_id) {
        $this->post_id = $post_id;
    }

    function setPost_title($post_title) {
        $this->post_title = $post_title;
    }

    function setPost_content($post_content) {
        $this->post_content = $post_content;
    }

    function setPost_image($post_image) {
        $this->post_image = $post_image;
    }

    function setPost_date($post_date) {
        $this->post_date = $post_date;
    }

    function setPost_tags($post_tags) {
        $this->post_tags = $post_tags;
    }

    function setMember_id($member_id) {
        $this->member_id = $member_id;
    }


}
