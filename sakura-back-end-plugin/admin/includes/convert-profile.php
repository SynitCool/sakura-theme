<?php

function convert_profile_picture($profile_picture_url) {
    if ($profile_picture_url == "no-profile-picture") {
        return "https://i.pinimg.com/originals/ca/52/e6/ca52e6e168595f767c2121a68cc227b0.jpg";
    }

    return $profile_picture_url;
}

function convert_post_pictures($post_pictures_url) {
    if ($post_pictures_url == "no-post-pictures") {
        return [];
    }

    return $post_pictures_url;
}